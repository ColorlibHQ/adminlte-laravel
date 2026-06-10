@php
    use ColorlibHQ\AdminLte\Menu\MenuItemHelper;

    // Flatten the sidebar menu into a searchable list of leaf links.
    $flatten = function (array $items, array $trail = []) use (&$flatten) {
        $out = [];
        foreach ($items as $item) {
            if (MenuItemHelper::isHeader($item)) {
                continue;
            }
            $text = $item['text'] ?? null;
            if (MenuItemHelper::isSubmenu($item)) {
                $childTrail = $text ? array_merge($trail, [$text]) : $trail;
                $out = array_merge($out, $flatten($item['submenu'], $childTrail));

                continue;
            }
            $href = $item['href'] ?? ($item['url'] ?? '#');
            if (! $text || $href === '#' || $href === '') {
                continue;
            }
            $out[] = [
                'text' => $text,
                'href' => $href,
                'icon' => $item['icon'] ?? 'bi bi-arrow-right-short',
                'group' => implode(' › ', $trail),
            ];
        }

        return $out;
    };

    $paletteItems = $flatten(app('adminlte')->menu('sidebar'));
@endphp

<div id="adminlteCommandPalette" class="adminlte-cmdk" role="dialog" aria-modal="true" aria-label="{{ __('adminlte.search') }}" hidden>
    <div class="adminlte-cmdk__backdrop" data-cmdk-close></div>
    <div class="adminlte-cmdk__dialog card shadow-lg">
        <div class="input-group input-group-lg border-bottom">
            <span class="input-group-text bg-transparent border-0"><i class="bi bi-search" aria-hidden="true"></i></span>
            <input type="text" id="adminlteCommandPaletteInput" class="form-control border-0 shadow-none"
                   placeholder="{{ __('adminlte.search') }}…" autocomplete="off" aria-label="{{ __('adminlte.search') }}"
                   role="combobox" aria-expanded="true" aria-controls="adminlteCommandPaletteResults" aria-autocomplete="list">
            <span class="input-group-text bg-transparent border-0">
                <kbd class="small bg-body-secondary text-body-secondary border rounded px-1">Esc</kbd>
            </span>
        </div>
        <ul id="adminlteCommandPaletteResults" class="list-group list-group-flush adminlte-cmdk__results" role="listbox"></ul>
        <div class="adminlte-cmdk__empty text-muted small p-3 text-center d-none">{{ __('adminlte.no_results') }}</div>
    </div>
</div>

@once
{{-- Styles are emitted inline here (not via @push('css')) because this partial
     renders in the <body>, after the head's @stack('css') has already output. --}}
<style>
    .adminlte-cmdk { position: fixed; inset: 0; z-index: 2050; display: flex; justify-content: center;
        align-items: flex-start; padding: 12vh 1rem 1rem; }
    .adminlte-cmdk[hidden] { display: none; }
    .adminlte-cmdk__backdrop { position: absolute; inset: 0; background: rgba(0,0,0,.5); backdrop-filter: blur(2px); }
    .adminlte-cmdk__dialog { position: relative; width: min(640px, 94vw); max-height: 70vh; overflow: hidden;
        display: flex; flex-direction: column; }
    .adminlte-cmdk__results { overflow-y: auto; }
    .adminlte-cmdk__results .list-group-item { cursor: pointer; display: flex; align-items: center; gap: .5rem; }
    .adminlte-cmdk__results .list-group-item small { margin-left: auto; opacity: .65; }

    /* Unified search pill in the navbar */
    .adminlte-search-trigger { --bs-btn-border-color: var(--bs-border-color); line-height: 1.6; }
    .adminlte-search-trigger:hover { background: var(--bs-tertiary-bg); }
    .adminlte-search-trigger kbd { background: var(--bs-tertiary-bg); color: var(--bs-secondary-color);
        font-family: inherit; font-size: .75rem; }
</style>

@push('js')
<script>
(function () {
    const items = @json($paletteItems);
    const root = document.getElementById('adminlteCommandPalette');
    if (!root) return;
    const input = document.getElementById('adminlteCommandPaletteInput');
    const list = document.getElementById('adminlteCommandPaletteResults');
    const empty = root.querySelector('.adminlte-cmdk__empty');
    let active = 0, filtered = [];

    const render = () => {
        list.innerHTML = '';
        empty.classList.toggle('d-none', filtered.length > 0);
        filtered.forEach((it, i) => {
            const li = document.createElement('li');
            li.className = 'list-group-item list-group-item-action' + (i === active ? ' active' : '');
            li.id = 'adminlteCmdkOption' + i;
            li.setAttribute('role', 'option');
            li.setAttribute('aria-selected', i === active ? 'true' : 'false');
            const icon = document.createElement('i');
            icon.className = it.icon;
            icon.setAttribute('aria-hidden', 'true');
            const text = document.createElement('span');
            text.textContent = it.text;
            li.append(icon, text);
            if (it.group) {
                const group = document.createElement('small');
                group.textContent = it.group;
                li.append(group);
            }
            li.addEventListener('click', () => go(i));
            li.addEventListener('mousemove', () => { active = i; paint(); });
            list.appendChild(li);
        });
        paint();
    };
    const paint = () => {
        [...list.children].forEach((li, i) => {
            li.classList.toggle('active', i === active);
            li.setAttribute('aria-selected', i === active ? 'true' : 'false');
        });
        const el = list.children[active];
        if (el) {
            el.scrollIntoView({ block: 'nearest' });
            input.setAttribute('aria-activedescendant', el.id);
        } else {
            input.removeAttribute('aria-activedescendant');
        }
    };
    const filter = (q) => {
        q = (q || '').trim().toLowerCase();
        filtered = q ? items.filter(it =>
            it.text.toLowerCase().includes(q) || (it.group && it.group.toLowerCase().includes(q))
        ) : items.slice();
        active = 0; render();
    };
    const go = (i) => {
        const it = filtered[i];
        if (it && it.href) window.location.href = it.href;
    };
    const open = () => {
        root.hidden = false;
        input.value = ''; filter('');
        setTimeout(() => input.focus(), 20);
    };
    const close = () => { root.hidden = true; };
    const isOpen = () => !root.hidden;

    document.querySelectorAll('[data-adminlte-search]').forEach(el =>
        el.addEventListener('click', e => { e.preventDefault(); open(); }));
    root.querySelectorAll('[data-cmdk-close]').forEach(el => el.addEventListener('click', close));
    input.addEventListener('input', () => filter(input.value));

    document.addEventListener('keydown', (e) => {
        if ((e.metaKey || e.ctrlKey) && e.key.toLowerCase() === 'k') {
            e.preventDefault(); isOpen() ? close() : open(); return;
        }
        if (!isOpen()) return;
        if (e.key === 'Escape') { e.preventDefault(); close(); }
        else if (e.key === 'ArrowDown') { e.preventDefault(); active = Math.min(active + 1, filtered.length - 1); paint(); }
        else if (e.key === 'ArrowUp') { e.preventDefault(); active = Math.max(active - 1, 0); paint(); }
        else if (e.key === 'Enter') { e.preventDefault(); go(active); }
    });
})();
</script>
@endpush
@endonce
