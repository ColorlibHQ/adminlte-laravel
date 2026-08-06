/**
 * AdminLTE 4 + Bootstrap 5 entry point.
 *
 * Published by `php artisan adminlte:install`. Add this file to your
 * vite.config.js input array, then `npm run dev` / `npm run build`.
 */

// Bootstrap (provides dropdowns, modals, tooltips, offcanvas, etc.)
import 'bootstrap'

// OverlayScrollbars — AdminLTE uses it for the sidebar scroller (optional)
import { OverlayScrollbars } from 'overlayscrollbars'

// AdminLTE plugins (PushMenu, Treeview, CardWidget, FullScreen, DirectChat,
// Layout, accessibility). The data-lte-* API is wired on DOMContentLoaded.
import 'admin-lte'

/**
 * Initialise an optional plugin only when its global is present.
 * Plugin libraries (ApexCharts, jsVectorMap, FullCalendar, Sortable,
 * Flatpickr, Tom Select, Tabulator, Quill) are loaded lazily via the
 * @pluginScripts directive as global <script> tags, so we feature-detect
 * before touching them.
 */
function whenReady(fn) {
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', fn)
  } else {
    fn()
  }
}

function parseConfig(el, attr) {
  const raw = el.getAttribute(attr)
  if (!raw) return {}
  try {
    return JSON.parse(raw)
  } catch (e) {
    console.warn('AdminLTE: invalid JSON in', attr, e)
    return {}
  }
}

// --- ApexCharts ------------------------------------------------------------
function initCharts() {
  if (typeof window.ApexCharts === 'undefined') return
  document.querySelectorAll('[data-apexchart]').forEach((el) => {
    if (el.dataset.apexchartReady) return
    const config = parseConfig(el, 'data-apexchart-config')
    try {
      new window.ApexCharts(el, config).render()
      el.dataset.apexchartReady = 'true'
    } catch (e) {
      console.warn('AdminLTE: ApexCharts init failed (check the chart config)', e)
    }
  })
}

// --- jsVectorMap -----------------------------------------------------------
function initVectorMaps() {
  if (typeof window.jsVectorMap === 'undefined') return
  document.querySelectorAll('[data-jsvectormap]').forEach((el) => {
    if (el.dataset.jsvectormapReady || !el.id) return
    const config = parseConfig(el, 'data-jsvectormap-config')
    try {
      new window.jsVectorMap({ selector: '#' + el.id, ...config })
      el.dataset.jsvectormapReady = 'true'
    } catch (e) {
      console.warn('AdminLTE: jsVectorMap init failed (is the map data file loaded?)', e)
    }
  })
}

// --- FullCalendar ----------------------------------------------------------
function initCalendars() {
  if (typeof window.FullCalendar === 'undefined') return
  document.querySelectorAll('[data-fullcalendar]').forEach((el) => {
    if (el.dataset.fullcalendarReady) return
    const config = parseConfig(el, 'data-fullcalendar-config')
    new window.FullCalendar.Calendar(el, config).render()
    el.dataset.fullcalendarReady = 'true'
  })
}

// --- SortableJS (generic lists + kanban boards) ----------------------------
function initSortables() {
  if (typeof window.Sortable === 'undefined') return

  // Generic sortable lists — items in the same group can be dragged between lists.
  document.querySelectorAll('[data-sortable]').forEach((el) => {
    if (el.dataset.sortableReady) return
    const options = parseConfig(el, 'data-sortable-options')
    window.Sortable.create(el, { animation: 150, ...options })
    el.dataset.sortableReady = 'true'
  })

  // Kanban boards — every lane shares one group so cards move between lanes.
  document.querySelectorAll('[data-sortable-kanban]').forEach((board) => {
    board.querySelectorAll('[data-sortable-group]').forEach((lane) => {
      if (lane.dataset.sortableReady) return
      window.Sortable.create(lane, {
        group: 'kanban-' + (board.id || 'board'),
        animation: 150,
      })
      lane.dataset.sortableReady = 'true'
    })
  })
}

// --- Flatpickr (date/time pickers) -----------------------------------------
function initDatePickers() {
  if (typeof window.flatpickr === 'undefined') return
  document.querySelectorAll('[data-flatpickr]').forEach((el) => {
    if (el.dataset.flatpickrReady) return
    window.flatpickr(el, parseConfig(el, 'data-flatpickr-config'))
    el.dataset.flatpickrReady = 'true'
  })
}

// --- Tom Select (searchable selects) ---------------------------------------
function initTomSelects() {
  if (typeof window.TomSelect === 'undefined') return
  document.querySelectorAll('[data-tom-select]').forEach((el) => {
    if (el.dataset.tomSelectReady) return
    try {
      new window.TomSelect(el, parseConfig(el, 'data-tom-select-config'))
      el.dataset.tomSelectReady = 'true'
    } catch (e) {
      console.warn('AdminLTE: Tom Select init failed', e)
    }
  })
}

// --- Tabulator (data tables) ------------------------------------------------
function initDatatables() {
  if (typeof window.Tabulator === 'undefined') return
  document.querySelectorAll('[data-tabulator-config]').forEach((el) => {
    if (el.dataset.tabulatorReady) return
    try {
      new window.Tabulator(el, parseConfig(el, 'data-tabulator-config'))
      el.dataset.tabulatorReady = 'true'
    } catch (e) {
      console.warn('AdminLTE: Tabulator init failed (check the column/data config)', e)
    }
  })
}

// --- Quill (rich text editor) -----------------------------------------------
// The <x-adminlte-editor> component renders an empty div plus a hidden input
// that carries the value to the server. Quill owns the div; we mirror its HTML
// back into the input on every change so a normal form POST submits it.
function initEditors() {
  if (typeof window.Quill === 'undefined') return
  document.querySelectorAll('[data-quill]').forEach((el) => {
    if (el.dataset.quillReady) return

    const target = document.querySelector(el.getAttribute('data-quill-target'))
    let quill
    try {
      quill = new window.Quill(el, parseConfig(el, 'data-quill-config'))
    } catch (e) {
      console.warn('AdminLTE: Quill init failed', e)
      return
    }

    // Seed the editor with the current value (old input or the model's value).
    if (target && target.value) {
      quill.clipboard.dangerouslyPasteHTML(target.value)
    }

    if (target) {
      const sync = () => {
        // An empty Quill still reports '<p><br></p>'; store '' instead so
        // `required` and `nullable` validation behave as expected.
        target.value = quill.getText().trim() === '' ? '' : quill.root.innerHTML
      }
      quill.on('text-change', sync)
      // Catch programmatic changes that don't emit text-change.
      el.closest('form')?.addEventListener('submit', sync)
    }

    el.dataset.quillReady = 'true'
  })
}

// --- Sidebar treeview a11y --------------------------------------------------
// AdminLTE's Treeview toggles .menu-open on the <li>; mirror that state onto
// the toggle link's aria-expanded so screen readers track open/closed submenus.
function initTreeviewA11y() {
  const sidebar = document.querySelector('.app-sidebar')
  if (!sidebar || typeof MutationObserver === 'undefined') return
  const observer = new MutationObserver((mutations) => {
    mutations.forEach((m) => {
      const link = m.target.querySelector(':scope > a.nav-link[aria-expanded]')
      if (link) link.setAttribute('aria-expanded', m.target.classList.contains('menu-open') ? 'true' : 'false')
    })
  })
  sidebar.querySelectorAll('li.nav-item').forEach((li) => {
    if (li.querySelector(':scope > ul.nav-treeview')) {
      observer.observe(li, { attributes: true, attributeFilter: ['class'] })
    }
  })
}

whenReady(() => {
  // Wire OverlayScrollbars to the sidebar (matches the AdminLTE demo behaviour)
  const sidebar = document.querySelector('.sidebar-wrapper')
  if (sidebar && window.innerWidth > 992) {
    OverlayScrollbars(sidebar, {
      scrollbars: { theme: 'os-theme-light', autoHide: 'leave', clickScroll: true },
    })
  }

  initCharts()
  initVectorMaps()
  initCalendars()
  initSortables()
  initDatePickers()
  initTomSelects()
  initDatatables()
  initEditors()
  initTreeviewA11y()
})
