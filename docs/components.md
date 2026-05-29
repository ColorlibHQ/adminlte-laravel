# Components Reference

AdminLTE 4 for Laravel ships **40 Blade components** built on Bootstrap 5.3 and vanilla JS. Every component is registered under the `adminlte-` prefix and used with Laravel's component tag syntax:

```blade
<x-adminlte-card title="Hello">Body content</x-adminlte-card>
```

The alias after the prefix matches the registration map in `src/AdminLteServiceProvider.php` (e.g. the `card` alias → `<x-adminlte-card>`). Constructor parameters become tag attributes; array/`mixed` parameters accept a bound PHP value (`:attr="$value"`). Slots are passed as inner content (`$slot`) or as named slots (`<x-slot name="footer">…</x-slot>`).

Components are grouped into three categories: **Widget**, **Form**, and **Tool**. Tool and plugin-backed form components automatically enable their underlying JS library through the `PluginManager`; load the assets in your layout with the `@pluginStyles` / `@pluginScripts` directives.

---

## Widget components

### Card — `<x-adminlte-card>`

A Bootstrap card with optional header, tools, theming, and collapse/remove/maximize controls.

**Props**

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `title` | `?string` | `null` | Header title text |
| `icon` | `?string` | `null` | Bootstrap Icons class shown before the title |
| `theme` | `?string` | `null` | Color theme (`primary`, `success`, `warning`, `danger`, `info`, …) |
| `outline` | `bool` | `false` | Render the theme as a top outline border |
| `collapsible` | `bool` | `false` | Add the collapse toggle button |
| `collapsed` | `bool` | `false` | Start collapsed |
| `removable` | `bool` | `false` | Add the remove (close) button |
| `maximizable` | `bool` | `false` | Add the maximize button |
| `bodyClass` | `?string` | `null` | Extra classes for `.card-body` |
| `headerClass` | `?string` | `null` | Extra classes for `.card-header` |
| `footerClass` | `?string` | `null` | Extra classes for `.card-footer` |

*Helpers:* `cardClass()` builds the wrapper classes from `theme`/`outline`; `hasTools()` decides whether the toolbar renders (driven by `collapsible`, `removable`, `maximizable`).

**Slots:** `$slot` (card body), `tools` (header toolbar buttons), `footer` (card footer).

**Example**

```blade
<x-adminlte-card title="Sales" icon="bi bi-graph-up" theme="primary" collapsible>
    <x-slot name="tools">
        <button class="btn btn-sm">Export</button>
    </x-slot>

    Monthly revenue chart goes here.

    <x-slot name="footer">Updated 2 minutes ago</x-slot>
</x-adminlte-card>
```

---

### InfoBox — `<x-adminlte-info-box>`

A compact stat box with an icon, value, label, and optional progress bar.

**Props**

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `title` | `?string` | `null` | Label above the value |
| `text` | `?string` | `null` | The value/number displayed |
| `icon` | `?string` | `null` | Bootstrap Icons class |
| `theme` | `?string` | `null` | Theme for the icon area (`text-bg-{theme}`) |
| `iconTheme` | `?string` | `null` | Overrides the icon color independently |
| `progress` | `?string` | `null` | Progress value `0`–`100` (renders a bar) |
| `progressText` | `?string` | `null` | Caption shown under the progress bar |

*Helpers:* `iconClass()` resolves the icon background from `theme`/`iconTheme`.

**Slots:** `$slot` (optional extra content).

**Example**

```blade
<x-adminlte-info-box title="Bookmarks" text="41,410" icon="bi bi-bookmark"
    theme="info" progress="70" progressText="70% increase in 30 days" />
```

---

### SmallBox — `<x-adminlte-small-box>`

A large colored KPI box with a value, label, icon, and "more info" link.

**Props**

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `title` | `?string` | `null` | The big number/value |
| `text` | `?string` | `null` | The label under the value |
| `icon` | `?string` | `null` | Bootstrap Icons class |
| `theme` | `string` | `'primary'` | Background theme (`text-bg-{theme}`) |
| `url` | `?string` | `null` | Link target for the footer |
| `urlText` | `?string` | `'More info'` | Footer link text |

**Slots:** none (content is driven by props).

**Example**

```blade
<x-adminlte-small-box title="150" text="New Orders" icon="bi bi-bag"
    theme="success" url="/orders" urlText="View all" />
```

---

### Alert — `<x-adminlte-alert>`

A themed, optionally dismissable Bootstrap alert.

**Props**

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `theme` | `string` | `'info'` | Alert theme (`success`, `warning`, `danger`, …) |
| `title` | `?string` | `null` | Bold title text |
| `icon` | `?string` | `null` | Bootstrap Icons class |
| `dismissable` | `bool` | `false` | Render a close button |

**Slots:** `$slot` (alert body).

**Example**

```blade
<x-adminlte-alert theme="success" icon="bi bi-check-circle" title="Saved!" dismissable>
    Your changes were stored successfully.
</x-adminlte-alert>
```

---

### Callout — `<x-adminlte-callout>`

A bordered callout box for highlighted notes.

**Props**

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `theme` | `string` | `'info'` | Callout theme |
| `title` | `?string` | `null` | Heading text |
| `icon` | `?string` | `null` | Bootstrap Icons class |

**Slots:** `$slot` (callout body).

**Example**

```blade
<x-adminlte-callout theme="warning" title="Heads up">
    This action cannot be undone.
</x-adminlte-callout>
```

---

### Progress — `<x-adminlte-progress>`

A single Bootstrap progress bar.

**Props**

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `value` | `int\|string` | `0` | Progress percentage |
| `theme` | `string` | `'primary'` | Bar color theme |
| `striped` | `bool` | `false` | Striped style |
| `animated` | `bool` | `false` | Animate the stripes |
| `height` | `?string` | `null` | CSS height (e.g. `8px`) |
| `showLabel` | `bool` | `false` | Show the percentage label inside the bar |

*Helpers:* `barClass()` composes the bar classes from `theme`/`striped`/`animated`.

**Slots:** none.

**Example**

```blade
<x-adminlte-progress :value="65" theme="success" striped animated showLabel height="12px" />
```

---

### ProgressGroup — `<x-adminlte-progress-group>`

A labeled progress bar with a value/max readout.

**Props**

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `label` | `string` | — (required) | Label text above the bar |
| `value` | `int` | — (required) | Current value |
| `color` | `string` | `'primary'` | Bar color theme |
| `max` | `?int` | `100` | Maximum value |
| `showPercentage` | `bool` | `true` | Show the computed percentage |

*Helpers:* `percentage()` computes `value / max * 100`.

**Slots:** none.

**Example**

```blade
<x-adminlte-progress-group label="Add Products to Cart" :value="160" :max="200" color="info" />
```

---

### Timeline — `<x-adminlte-timeline>`

A vertical timeline rendered from an array of events.

**Props**

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `items` | `array` | `[]` | Timeline entries (see keys below) |
| `class` | `?string` | `null` | Extra wrapper classes |

Each item supports: `title`, `body`, `icon`, `icon_bg` (theme), `url`, `footer`.

**Slots:** none (data-driven).

**Example**

```blade
<x-adminlte-timeline :items="[
    ['icon' => 'bi bi-envelope', 'icon_bg' => 'primary', 'title' => 'New email', 'body' => 'You have 3 unread messages.'],
    ['icon' => 'bi bi-gear', 'icon_bg' => 'success', 'title' => 'Settings updated'],
]" />
```

---

### DescriptionBlock — `<x-adminlte-description-block>`

A titled block with optional text and a definition list of key/value items.

**Props**

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `title` | `string` | — (required) | Block heading |
| `text` | `?string` | `null` | Muted description paragraph |
| `items` | `array` | `[]` | Associative `label => value` pairs rendered as `<dl>` |
| `class` | `?string` | `null` | Extra wrapper classes |

**Slots:** none.

**Example**

```blade
<x-adminlte-description-block title="$1,200" text="Total revenue"
    :items="['Orders' => 35, 'Refunds' => 2]" />
```

---

### ProfileCard — `<x-adminlte-profile-card>`

A user profile card with avatar, name, title, description, and social links.

**Props**

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `name` | `string` | — (required) | Person's name |
| `title` | `?string` | `null` | Role/subtitle |
| `image` | `?string` | `null` | Avatar image URL |
| `imageAlt` | `?string` | `null` | Avatar `alt` text |
| `socials` | `array` | `[]` | Social links: `icon`, `url`, `color` |
| `description` | `?string` | `null` | Bio text |
| `class` | `?string` | `null` | Extra wrapper classes |

**Slots:** `$slot` (extra content below the card body).

**Example**

```blade
<x-adminlte-profile-card name="Jane Doe" title="Lead Designer" image="/img/jane.jpg"
    description="10 years in product design."
    :socials="[['icon' => 'bi bi-twitter', 'url' => '#', 'color' => 'info']]" />
```

---

### Ratings — `<x-adminlte-ratings>`

A star rating display (read-only by default).

**Props**

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `value` | `int` | — (required) | Number of filled stars |
| `max` | `int` | `5` | Total stars |
| `color` | `string` | `'warning'` | Star color theme |
| `readonly` | `bool` | `true` | Display-only vs. interactive |
| `class` | `?string` | `null` | Extra wrapper classes |

*Helpers:* `stars()` returns the per-star filled/empty state array.

**Slots:** none.

**Example**

```blade
<x-adminlte-ratings :value="4" :max="5" color="warning" />
```

---

### NavNotifications — `<x-adminlte-nav-notifications>`

A navbar dropdown listing notifications with a badge count.

**Props**

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `notifications` | `array` | `[]` | Items: `icon`, `title`, `time`, `url` |
| `badgeColor` | `?string` | `'danger'` | Count badge theme |

**Slots:** none.

**Example**

```blade
<x-adminlte-nav-notifications badge-color="danger" :notifications="[
    ['icon' => 'bi bi-envelope', 'title' => '4 new messages', 'time' => '3 mins', 'url' => '#'],
]" />
```

---

### NavMessages — `<x-adminlte-nav-messages>`

A navbar dropdown listing messages with sender avatars.

**Props**

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `messages` | `array` | `[]` | Items: `from`, `image`, `text`, `url` |
| `badgeColor` | `?string` | `'info'` | Count badge theme |

**Slots:** none.

**Example**

```blade
<x-adminlte-nav-messages :messages="[
    ['from' => 'Brad Diesel', 'image' => '/img/b.jpg', 'text' => 'Call me when you can', 'url' => '#'],
]" />
```

---

### NavTasks — `<x-adminlte-nav-tasks>`

A navbar dropdown listing tasks with progress bars.

**Props**

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `tasks` | `array` | `[]` | Items: `title`, `progress`, `color`, `url` |
| `badgeColor` | `?string` | `'warning'` | Count badge theme |

**Slots:** none.

**Example**

```blade
<x-adminlte-nav-tasks :tasks="[
    ['title' => 'Design template', 'progress' => 80, 'color' => 'primary', 'url' => '#'],
]" />
```

---

### DirectChat — `<x-adminlte-direct-chat>`

A chat-style message panel rendered from an array of messages.

**Props**

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `items` | `array` | `[]` | Messages: `message`, `avatar`, `is_own` (bool) |
| `title` | `?string` | `null` | Panel header title |
| `class` | `?string` | `null` | Extra wrapper classes |

**Slots:** `$slot` (footer/input area below the messages).

**Example**

```blade
<x-adminlte-direct-chat title="Support" :items="[
    ['message' => 'Hi there!', 'avatar' => '/img/u.jpg', 'is_own' => false],
    ['message' => 'How can I help?', 'avatar' => '/img/me.jpg', 'is_own' => true],
]" />
```

---

### Toast — `<x-adminlte-toast>`

A Bootstrap toast notification.

**Props**

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `title` | `?string` | `null` | Toast header title |
| `position` | `string` | `'top-end'` | Screen corner (`top-end`, `bottom-start`, …) |
| `autohide` | `bool` | `true` | Auto-dismiss after `delay` |
| `delay` | `int` | `5000` | Auto-hide delay in ms |
| `theme` | `string` | `'primary'` | Header theme |
| `icon` | `?string` | `null` | Bootstrap Icons class |
| `id` | `?string` | auto | Element id (auto-generated if omitted) |
| `class` | `?string` | `null` | Extra wrapper classes |

**Slots:** `$slot` (toast body).

**Example**

```blade
<x-adminlte-toast title="Notice" theme="success" icon="bi bi-check" :delay="4000">
    Your profile was updated.
</x-adminlte-toast>
```

---

### Tabs — `<x-adminlte-tabs>`

A tab container; wrap one or more `<x-adminlte-tab>` children.

**Props**

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `variant` | `string` | `'tabs'` | `tabs` or `pills` style |
| `justified` | `bool` | `false` | Equal-width justified nav |
| `fill` | `bool` | `false` | Fill available width |
| `class` | `?string` | `null` | Extra wrapper classes |

**Slots:** `$slot` (the `<x-adminlte-tab>` children).

### Tab — `<x-adminlte-tab>`

A single tab pane inside a `<x-adminlte-tabs>` group.

**Props**

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `title` | `string` | — (required) | Tab label |
| `id` | `?string` | auto | Pane id |
| `active` | `bool` | `false` | Mark this tab active |
| `icon` | `?string` | `null` | Bootstrap Icons class on the tab |
| `class` | `?string` | `null` | Extra pane classes |

**Slots:** `$slot` (tab pane content).

**Example**

```blade
<x-adminlte-tabs variant="pills" justified>
    <x-adminlte-tab title="Overview" icon="bi bi-grid" active>Overview content</x-adminlte-tab>
    <x-adminlte-tab title="Details">Details content</x-adminlte-tab>
</x-adminlte-tabs>
```

---

### Accordion — `<x-adminlte-accordion>`

A Bootstrap accordion container; wrap one or more `<x-adminlte-accordion-item>` children.

**Props**

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `id` | `?string` | auto | Accordion id (referenced by children's `parent`) |
| `flush` | `bool` | `false` | Borderless flush style |
| `alwaysOpen` | `bool` | `false` | Allow multiple panels open at once |
| `class` | `?string` | `null` | Extra wrapper classes |

**Slots:** `$slot` (accordion item children).

### AccordionItem — `<x-adminlte-accordion-item>`

A single collapsible panel inside an accordion.

**Props**

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `title` | `string` | — (required) | Panel header text |
| `parent` | `string` | — (required) | Parent accordion id |
| `id` | `?string` | auto | Panel id |
| `expanded` | `bool` | `false` | Start expanded |
| `class` | `?string` | `null` | Extra classes |

**Slots:** `$slot` (panel body).

**Example**

```blade
<x-adminlte-accordion id="faq" flush>
    <x-adminlte-accordion-item title="What is included?" parent="faq" expanded>
        Everything you need.
    </x-adminlte-accordion-item>
    <x-adminlte-accordion-item title="Refunds?" parent="faq">
        Within 30 days.
    </x-adminlte-accordion-item>
</x-adminlte-accordion>
```

---

### Breadcrumb — `<x-adminlte-breadcrumb>`

A breadcrumb trail rendered from an array of items.

**Props**

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `items` | `array` | `[]` | Items: `label`, `url`, `active` (bool) |
| `class` | `?string` | `null` | Extra wrapper classes |

**Slots:** `$slot` (optional trailing content).

**Example**

```blade
<x-adminlte-breadcrumb :items="[
    ['label' => 'Home', 'url' => '/'],
    ['label' => 'Settings', 'active' => true],
]" />
```

---

## Form components

All form inputs follow Laravel conventions: they read old input and validation errors from the named field automatically (helpers `dotName()`, `resolvedValue()`, `hasError()`, `errorMessage()`), and render Bootstrap validation feedback unless `disableFeedback` is set. The `fgroupClass` prop adds classes to the form-group wrapper.

### Input — `<x-adminlte-input>`

A labeled text input with optional input-group addons.

**Props**

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `name` | `string` | — (required) | Field name |
| `label` | `?string` | `null` | Field label |
| `type` | `string` | `'text'` | HTML input type |
| `id` | `?string` | auto | Element id (defaults from `name`) |
| `igroupSize` | `?string` | `null` | Input group size (`sm`, `lg`) |
| `fgroupClass` | `?string` | `null` | Form-group wrapper classes |
| `disableFeedback` | `bool` | `false` | Suppress validation feedback markup |

**Slots:** `$slot` and named slots for input-group prepend/append addons (see view).

**Example**

```blade
<x-adminlte-input name="email" label="Email address" type="email" placeholder="you@example.com" />
```

---

### InputSwitch — `<x-adminlte-input-switch>`

A Bootstrap toggle switch checkbox.

**Props**

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `name` | `string` | — (required) | Field name |
| `label` | `?string` | `null` | Switch label |
| `id` | `?string` | auto | Element id |
| `value` | `mixed` | `1` | Submitted value when checked |
| `checked` | `bool` | `false` | Initial checked state |
| `fgroupClass` | `?string` | `null` | Wrapper classes |
| `disableFeedback` | `bool` | `false` | Suppress validation feedback |

*Helpers:* `isChecked()` resolves the checked state from old input.

**Slots:** none.

**Example**

```blade
<x-adminlte-input-switch name="notifications" label="Email notifications" :checked="true" />
```

---

### InputColor — `<x-adminlte-input-color>`

A native color picker input.

**Props**

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `name` | `string` | — (required) | Field name |
| `label` | `?string` | `null` | Field label |
| `id` | `?string` | auto | Element id |
| `default` | `string` | `'#0d6efd'` | Default color value |
| `fgroupClass` | `?string` | `null` | Wrapper classes |
| `disableFeedback` | `bool` | `false` | Suppress validation feedback |

**Slots:** none.

**Example**

```blade
<x-adminlte-input-color name="brand_color" label="Brand color" default="#198754" />
```

---

### InputFile — `<x-adminlte-input-file>`

A file upload input supporting single or multiple files.

**Props**

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `name` | `string` | — (required) | Field name (becomes `name[]` when multiple) |
| `label` | `?string` | `null` | Field label |
| `id` | `?string` | auto | Element id |
| `multiple` | `bool` | `false` | Allow multiple files |
| `fgroupClass` | `?string` | `null` | Wrapper classes |
| `disableFeedback` | `bool` | `false` | Suppress validation feedback |

*Helpers:* `fieldName()` appends `[]` for multiple uploads.

**Slots:** none.

**Example**

```blade
<x-adminlte-input-file name="attachments" label="Attachments" multiple />
```

---

### Textarea — `<x-adminlte-textarea>`

A labeled textarea.

**Props**

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `name` | `string` | — (required) | Field name |
| `label` | `?string` | `null` | Field label |
| `id` | `?string` | auto | Element id |
| `fgroupClass` | `?string` | `null` | Wrapper classes |
| `disableFeedback` | `bool` | `false` | Suppress validation feedback |

**Slots:** `$slot` (textarea contents/value).

**Example**

```blade
<x-adminlte-textarea name="bio" label="About you" rows="4" />
```

---

### Select — `<x-adminlte-select>`

A labeled native select; pass `<option>` elements as the slot.

**Props**

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `name` | `string` | — (required) | Field name |
| `label` | `?string` | `null` | Field label |
| `id` | `?string` | auto | Element id |
| `fgroupClass` | `?string` | `null` | Wrapper classes |
| `disableFeedback` | `bool` | `false` | Suppress validation feedback |

**Slots:** `$slot` (the `<option>` elements).

**Example**

```blade
<x-adminlte-select name="country" label="Country">
    <option value="us">United States</option>
    <option value="de">Germany</option>
</x-adminlte-select>
```

---

### Button — `<x-adminlte-button>`

A themed Bootstrap button with optional icon and label.

**Props**

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `type` | `string` | `'button'` | `button`, `submit`, or `reset` |
| `theme` | `string` | `'primary'` | Color theme |
| `outline` | `bool` | `false` | Outline style |
| `size` | `?string` | `null` | `sm` or `lg` |
| `icon` | `?string` | `null` | Bootstrap Icons class |
| `label` | `?string` | `null` | Button text (alternative to slot) |

*Helpers:* `buttonClass()` composes classes from `theme`/`outline`/`size`.

**Slots:** `$slot` (button content, used when `label` is omitted).

**Example**

```blade
<x-adminlte-button type="submit" theme="success" icon="bi bi-save" label="Save changes" />
```

---

### InputFlatpickr — `<x-adminlte-input-flatpickr>` *(plugin: flatpickr)*

A date/time picker input backed by Flatpickr. Enables the `flatpickr` plugin automatically.

**Props**

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `name` | `string` | — (required) | Field name |
| `label` | `?string` | `null` | Field label |
| `type` | `string` | `'text'` | `date`, `time`, or `datetime` mode |
| `value` | `?string` | `null` | Initial value |
| `id` | `?string` | auto | Element id |
| `igroupSize` | `?string` | `null` | Input group size (`sm`, `lg`) |
| `fgroupClass` | `?string` | `null` | Wrapper classes |
| `disableFeedback` | `bool` | `false` | Suppress validation feedback |
| `placeholder` | `?string` | `null` | Placeholder text |
| `options` | `array` | `[]` | Extra Flatpickr config options |

*Helpers:* `flatpickrConfig()` serializes the JS config (sets `enableTime` for time/datetime).

**Slots:** none.

**Example**

```blade
<x-adminlte-input-flatpickr name="published_at" label="Publish date" type="datetime"
    :options="['minDate' => 'today']" />
```

---

### InputTomSelect — `<x-adminlte-input-tom-select>` *(plugin: tom_select)*

An enhanced select with search/tagging backed by Tom Select. Enables the `tom_select` plugin automatically.

**Props**

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `name` | `string` | — (required) | Field name |
| `label` | `?string` | `null` | Field label |
| `options` | `array` | `[]` | `value => label` choices |
| `value` | `mixed` | `null` | Selected value(s) |
| `id` | `?string` | auto | Element id |
| `multiple` | `bool` | `false` | Allow multiple selection |
| `searchable` | `bool` | `true` | Enable search |
| `placeholder` | `?string` | `null` | Placeholder text |
| `igroupSize` | `?string` | `null` | Input group size |
| `fgroupClass` | `?string` | `null` | Wrapper classes |
| `disableFeedback` | `bool` | `false` | Suppress validation feedback |
| `tomSelectOptions` | `array` | `[]` | Extra Tom Select config options |

*Helpers:* `tomSelectConfig()` serializes the JS config.

**Slots:** none.

**Example**

```blade
<x-adminlte-input-tom-select name="tags" label="Tags" multiple
    :options="['php' => 'PHP', 'js' => 'JavaScript', 'css' => 'CSS']" />
```

---

## Tool components

### Modal — `<x-adminlte-modal>`

A Bootstrap modal dialog.

**Props**

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `id` | `string` | — (required) | Modal element id (used by triggers) |
| `title` | `?string` | `null` | Header title |
| `size` | `?string` | `null` | `sm`, `lg`, or `xl` |
| `theme` | `?string` | `null` | Header background (`text-bg-{theme}`) |
| `staticBackdrop` | `bool` | `false` | Disable click-outside dismissal |
| `scrollable` | `bool` | `false` | Scrollable modal body |
| `centered` | `bool` | `false` | Vertically center the dialog |

*Helpers:* `dialogClass()` composes the dialog classes from `size`/`scrollable`/`centered`.

**Slots:** `$slot` (modal body), `footer` (modal footer).

**Example**

```blade
<x-adminlte-modal id="confirmModal" title="Confirm" size="lg" centered>
    Are you sure you want to continue?
    <x-slot name="footer">
        <button class="btn btn-primary" data-bs-dismiss="modal">Yes</button>
    </x-slot>
</x-adminlte-modal>
```

---

### Datatable — `<x-adminlte-datatable>` *(plugin: tabulator)*

An interactive data table backed by Tabulator. Enables the `tabulator` plugin automatically.

**Props**

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `id` | `?string` | auto | Table element id |
| `columns` | `array` | `[]` | Column definitions |
| `data` | `array` | `[]` | Inline row data |
| `apiUrl` | `?string` | `null` | Remote AJAX data source |
| `tabulatorOptions` | `array` | `[]` | Extra Tabulator config options |
| `class` | `?string` | `null` | Extra wrapper classes |

*Helpers:* `tabulatorConfig()` serializes the JS config from columns/data/apiUrl/options.

**Slots:** none.

**Example**

```blade
<x-adminlte-datatable
    :columns="[['title' => 'Name', 'field' => 'name'], ['title' => 'Email', 'field' => 'email']]"
    :data="[['name' => 'Jane', 'email' => 'jane@example.com']]" />
```

---

### Editor — `<x-adminlte-editor>` *(plugin: quill)*

A rich-text WYSIWYG editor backed by Quill. Enables the `quill` plugin automatically.

**Props**

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `name` | `string` | — (required) | Field name (hidden input holds HTML) |
| `label` | `?string` | `null` | Field label |
| `value` | `?string` | `null` | Initial HTML content |
| `id` | `?string` | auto | Element id |
| `quillOptions` | `array` | `[]` | Extra Quill config options |
| `fgroupClass` | `?string` | `null` | Wrapper classes |
| `disableFeedback` | `bool` | `false` | Suppress validation feedback |
| `placeholder` | `?string` | `null` | Placeholder text |

*Helpers:* `resolvedValue()` reads old input; `quillConfig()` serializes the JS config.

**Slots:** none.

**Example**

```blade
<x-adminlte-editor name="body" label="Article body" placeholder="Write here…" />
```

---

### Chart — `<x-adminlte-chart>` *(plugin: apexcharts)*

A chart backed by ApexCharts. Enables the `apexcharts` plugin automatically.

**Props**

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `type` | `string` | `'area'` | Chart type (`area`, `bar`, `line`, …) |
| `series` | `array` | `[]` | Data series |
| `categories` | `array` | `[]` | X-axis categories |
| `options` | `array` | `[]` | Extra ApexCharts config options |
| `id` | `?string` | auto | Chart element id |
| `height` | `string` | `'300px'` | Chart height |

*Helpers:* `chartConfig()` serializes the JS config.

**Slots:** none.

**Example**

```blade
<x-adminlte-chart type="bar"
    :series="[['name' => 'Sales', 'data' => [30, 40, 35, 50]]]"
    :categories="['Q1', 'Q2', 'Q3', 'Q4']" height="320px" />
```

---

### VectorMap — `<x-adminlte-vector-map>` *(plugin: jsvectormap)*

An interactive vector map backed by jsVectorMap. Enables the `jsvectormap` plugin automatically.

**Props**

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `map` | `string` | `'world_merc'` | Map name |
| `markers` | `array` | `[]` | Point markers |
| `regions` | `array` | `[]` | Region styling/data |
| `options` | `array` | `[]` | Extra jsVectorMap config options |
| `id` | `?string` | auto | Map element id |
| `height` | `string` | `'400px'` | Map height |

*Helpers:* `mapConfig()` serializes the JS config.

**Slots:** none.

**Example**

```blade
<x-adminlte-vector-map map="world_merc"
    :markers="[['name' => 'London', 'coords' => [51.5, -0.12]]]" height="450px" />
```

---

### Calendar — `<x-adminlte-calendar>` *(plugin: fullcalendar)*

An event calendar backed by FullCalendar. Enables the `fullcalendar` plugin automatically.

**Props**

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `events` | `array\|string` | `[]` | Event array or remote URL |
| `options` | `array` | `[]` | Extra FullCalendar config options |
| `id` | `?string` | auto | Calendar element id |
| `height` | `string` | `'500px'` | Calendar height |

*Helpers:* `calendarConfig()` serializes the JS config.

**Slots:** none.

**Example**

```blade
<x-adminlte-calendar :events="[
    ['title' => 'Launch', 'start' => '2026-06-01'],
]" height="600px" />
```

---

### Kanban — `<x-adminlte-kanban>` *(plugin: sortablejs)*

A drag-and-drop Kanban board backed by SortableJS. Enables the `sortablejs` plugin automatically.

**Props**

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `lanes` | `array` | `[]` | Lanes: `name`, `cards` (each `title`, `description`, `color`) |
| `options` | `array` | `[]` | Extra SortableJS config options |
| `class` | `?string` | `null` | Extra wrapper classes |

**Slots:** none.

**Example**

```blade
<x-adminlte-kanban :lanes="[
    ['name' => 'To Do', 'cards' => [['title' => 'Write docs', 'color' => 'primary']]],
    ['name' => 'Done', 'cards' => [['title' => 'Setup repo', 'color' => 'success']]],
]" />
```

---

### Sortable — `<x-adminlte-sortable>` *(plugin: sortablejs)*

A drag-and-drop sortable list backed by SortableJS. Enables the `sortablejs` plugin automatically.

**Props**

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `group` | `string` | `'shared'` | Sortable group name (for cross-list dragging) |
| `options` | `array` | `[]` | Extra SortableJS config options |
| `class` | `?string` | `null` | Extra wrapper classes |

**Slots:** `$slot` (the sortable list items).

**Example**

```blade
<x-adminlte-sortable group="tasks">
    <li class="list-group-item">Item 1</li>
    <li class="list-group-item">Item 2</li>
</x-adminlte-sortable>
```

---

### Wizard — `<x-adminlte-wizard>`

A multi-step form wizard container; wrap `<x-adminlte-wizard-step>` children.

**Props**

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `steps` | `int` | `3` | Total number of steps |
| `id` | `?string` | auto | Wizard element id |
| `class` | `?string` | `null` | Extra wrapper classes |

**Slots:** `$slot` (the `<x-adminlte-wizard-step>` children).

### WizardStep — `<x-adminlte-wizard-step>`

A single step pane inside a wizard.

**Props**

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `step` | `int` | — (required) | Step number (1-based) |
| `title` | `string` | — (required) | Step title |
| `class` | `?string` | `null` | Extra pane classes |

**Slots:** `$slot` (step content).

**Example**

```blade
<x-adminlte-wizard :steps="2">
    <x-adminlte-wizard-step :step="1" title="Account">
        <x-adminlte-input name="email" label="Email" />
    </x-adminlte-wizard-step>
    <x-adminlte-wizard-step :step="2" title="Confirm">
        Review and submit.
    </x-adminlte-wizard-step>
</x-adminlte-wizard>
```
