/*!
 * AdminLTE for Laravel: Chart.js theme preset (MIT)
 * https://github.com/ColorlibHQ/adminlte-laravel
 *
 * Copied to public/vendor/adminlte/js/charts.js by `php artisan adminlte:install`
 * and loaded right after Chart.js by the `chartjs` plugin. It:
 *
 *  - themes Chart.defaults from the page's Bootstrap / AdminLTE CSS variables
 *    (font, text, gridlines, tooltips, legend, rounded bars, smooth lines);
 *  - re-themes every chart when the colour mode or text direction changes;
 *  - renders every <x-adminlte-chart> on the page ([data-adminlte-chart]);
 *  - exposes window.AdminLteCharts for hand-written charts:
 *      AdminLteCharts.create(elOrSelector, chartJsConfig)
 *      AdminLteCharts.sparkline(elOrSelector, [numbers], { color, fill, tooltip })
 *      AdminLteCharts.color('var(--bs-primary)')  -> resolved colour string
 *      AdminLteCharts.alpha(color, 0.3)           -> rgba() string
 *      AdminLteCharts.palette(i)                  -> i-th theme colour
 *
 * Colours given as 'var(--bs-…)' strings stay live: they are re-read from the
 * stylesheet on every update, so they follow dark mode and custom themes.
 */
(function () {
  'use strict'

  const Chart = window.Chart
  if (typeof Chart === 'undefined') {
    console.warn('AdminLTE: Chart.js is not loaded, so charts cannot render.')
    return
  }

  const root = document.documentElement
  const PALETTE = ['primary', 'teal', 'warning', 'pink', 'purple', 'info', 'danger', 'orange', 'cyan', 'secondary']
  const ARC_TYPES = ['pie', 'doughnut', 'polarArea']
  const COLOR_KEYS = [
    'backgroundColor',
    'borderColor',
    'hoverBackgroundColor',
    'hoverBorderColor',
    'pointBackgroundColor',
    'pointBorderColor',
    'pointHoverBackgroundColor',
    'pointHoverBorderColor',
  ]

  // --- colour helpers ---------------------------------------------------------

  function cssVar(name, fallback) {
    const value = getComputedStyle(root).getPropertyValue(name).trim()
    return value || fallback || ''
  }

  function isVar(value) {
    return typeof value === 'string' && value.trim().startsWith('var(')
  }

  /** Resolve 'var(--name, fallback)' to the current computed value. */
  function color(value) {
    if (!isVar(value)) return value
    const match = value.trim().match(/^var\(\s*(--[\w-]+)\s*(?:,\s*(.+))?\)$/)
    return match ? cssVar(match[1], match[2] ? color(match[2].trim()) : '') : value
  }

  const probe = document.createElement('canvas').getContext('2d')

  /** Any CSS colour -> rgba() with the given alpha multiplied in. */
  function alpha(value, a) {
    probe.fillStyle = '#000'
    probe.fillStyle = color(value)
    const parsed = probe.fillStyle
    if (parsed[0] === '#') {
      const n = parseInt(parsed.slice(1), 16)
      return `rgba(${(n >> 16) & 255}, ${(n >> 8) & 255}, ${n & 255}, ${a})`
    }
    const match = parsed.match(/rgba?\(([^)]+)\)/)
    if (!match) return parsed
    const [r, g, b, base = 1] = match[1].split(',').map((part) => parseFloat(part))
    return `rgba(${r}, ${g}, ${b}, ${base * a})`
  }

  function palette(index) {
    const name = PALETTE[(index || 0) % PALETTE.length]
    return cssVar(`--bs-${name}`, '#0d6efd')
  }

  /** Turn 'var(--…)' strings (or arrays of them) into scriptable options. */
  function live(value) {
    if (Array.isArray(value)) {
      return value.some(isVar) ? (ctx) => color(value[ctx.dataIndex % value.length]) : value
    }
    return isVar(value) ? () => color(value) : value
  }

  function valueOf(option, ctx) {
    return typeof option === 'function' ? option(ctx) : option
  }

  /** Vertical gradient under a line, fading from the series colour to transparent. */
  function gradient(base) {
    return (ctx) => {
      const c = valueOf(base, ctx)
      if (typeof c !== 'string') return c
      const { chart } = ctx
      const area = chart.chartArea
      if (!area || chart.config.type === 'radar') return alpha(c, 0.2)
      const fill = chart.ctx.createLinearGradient(0, area.top, 0, area.bottom)
      fill.addColorStop(0, alpha(c, 0.35))
      fill.addColorStop(1, alpha(c, 0))
      return fill
    }
  }

  // --- theme preset -----------------------------------------------------------

  function isRtl() {
    return (root.getAttribute('dir') || document.body?.getAttribute('dir') || '').toLowerCase() === 'rtl'
  }

  // Current theme colours. Scale colours are functions reading this object:
  // Chart.js copies scale defaults into each chart when it is created, so a
  // plain value would freeze a chart in the colour mode it was drawn in.
  const theme = {}
  const themed = (key) => () => theme[key]

  function applyTheme() {
    const d = Chart.defaults
    const surface = cssVar('--bs-body-bg', '#fff')
    const emphasis = cssVar('--bs-emphasis-color', '#000')
    const rtl = isRtl()

    theme.text = cssVar('--bs-secondary-color', '#6c757d')
    // Subtle gridlines.
    theme.grid = alpha(cssVar('--bs-border-color-translucent', 'rgba(0, 0, 0, 0.175)'), 0.6)
    theme.backdrop = alpha(surface, 0.75)

    d.font.family = cssVar('--bs-body-font-family', d.font.family)
    d.font.size = 12
    d.color = theme.text
    d.borderColor = theme.grid
    d.maintainAspectRatio = false

    d.elements.line.tension = 0.4
    d.elements.line.borderWidth = 2
    d.elements.point.radius = 0
    d.elements.point.hoverRadius = 4
    d.elements.point.hitRadius = 8
    d.elements.point.hoverBorderWidth = 2
    d.elements.bar.borderRadius = 4
    d.elements.arc.borderWidth = 2
    d.elements.arc.borderColor = surface

    d.set('scale', {
      border: { display: false },
      grid: { color: themed('grid') },
      ticks: { padding: 6, color: themed('text'), backdropColor: themed('backdrop') },
      title: { color: themed('text') },
    })
    d.set('scales.radialLinear', {
      angleLines: { color: themed('grid') },
      grid: { color: themed('grid') },
      pointLabels: { color: themed('text') },
      ticks: { color: themed('text'), backdropColor: themed('backdrop') },
      beginAtZero: true,
    })
    // No vertical grid on line/bar charts: the category axis draws no gridlines.
    d.set('scales.category', { grid: { display: false } })

    const legend = d.plugins.legend
    legend.rtl = rtl
    legend.position = 'bottom'
    legend.labels.usePointStyle = true
    legend.labels.pointStyle = 'circle'
    legend.labels.boxWidth = 8
    legend.labels.boxHeight = 8
    legend.labels.padding = 16

    // Same look as Bootstrap's own tooltips.
    const tooltip = d.plugins.tooltip
    tooltip.rtl = rtl
    tooltip.backgroundColor = alpha(emphasis, 0.9)
    tooltip.titleColor = surface
    tooltip.bodyColor = surface
    tooltip.footerColor = surface
    tooltip.borderWidth = 0
    tooltip.padding = 10
    tooltip.cornerRadius = 6
    tooltip.caretSize = 5
    tooltip.boxPadding = 4
    tooltip.usePointStyle = true
    tooltip.titleFont = { weight: '600' }

    // Line and bar tooltips list every series at the hovered index.
    ;['line', 'bar'].forEach((type) => {
      if (Chart.overrides[type]) {
        Chart.overrides[type].interaction = { mode: 'index', intersect: false }
      }
    })
  }

  // --- chart creation ---------------------------------------------------------

  /** Give every dataset theme-aware colours unless it brings its own. */
  function prepare(config) {
    const datasets = (config.data && config.data.datasets) || []
    datasets.forEach((ds) => {
      const type = ds.type || config.type
      COLOR_KEYS.forEach((key) => {
        if (ds[key] !== undefined) ds[key] = live(ds[key])
      })

      if (ARC_TYPES.includes(type)) {
        if (ds.backgroundColor === undefined) {
          ds.backgroundColor = type === 'polarArea'
            ? (ctx) => alpha(palette(ctx.dataIndex), 0.7)
            : (ctx) => palette(ctx.dataIndex)
        }
        return
      }

      const base = ds.borderColor !== undefined
        ? ds.borderColor
        : (type === 'bar' && ds.backgroundColor !== undefined ? ds.backgroundColor : (ctx) => palette(ctx.datasetIndex))

      if (type === 'radar') {
        if (ds.tension === undefined) ds.tension = 0
        if (ds.fill === undefined) ds.fill = true
      }

      if (ds.borderColor === undefined) ds.borderColor = base
      if (ds.backgroundColor === undefined) {
        if (type === 'line' || type === 'radar') {
          ds.backgroundColor = ds.fill ? gradient(base) : base
        } else if (type === 'scatter' || type === 'bubble') {
          ds.backgroundColor = (ctx) => alpha(valueOf(base, ctx), 0.5)
        } else {
          ds.backgroundColor = base
        }
      }
      if (type !== 'bar' && ds.pointBackgroundColor === undefined) ds.pointBackgroundColor = base
    })
    return config
  }

  function resolveTarget(target) {
    return typeof target === 'string' ? document.querySelector(target) : target
  }

  /**
   * Render a Chart.js config into a <canvas>, or into a container element
   * (a canvas is added to it). The container's height is the chart's height.
   */
  function create(target, config) {
    const el = resolveTarget(target)
    if (!el) return null

    let canvas = el
    if (el.tagName !== 'CANVAS') {
      canvas = el.querySelector(':scope > canvas')
      if (!canvas) {
        canvas = document.createElement('canvas')
        el.appendChild(canvas)
      }
      if (getComputedStyle(el).position === 'static') el.style.position = 'relative'
    }

    const existing = Chart.getChart(canvas)
    if (existing) existing.destroy()

    return new Chart(canvas, prepare(config))
  }

  /** A tiny axis-less chart for table cells and stat boxes. */
  function sparkline(target, data, opts) {
    const o = opts || {}
    return create(target, {
      type: o.type || 'line',
      data: {
        labels: data.map(() => ''),
        datasets: [
          {
            data,
            fill: Boolean(o.fill),
            borderColor: o.color,
            backgroundColor: o.fill && o.color ? () => alpha(o.color, o.fillOpacity ?? 0.3) : undefined,
            borderWidth: o.borderWidth ?? 2,
            tension: o.tension ?? 0.4,
          },
        ],
      },
      options: {
        animation: false,
        layout: { padding: 2 },
        plugins: {
          legend: { display: false },
          tooltip: o.tooltip
            ? { displayColors: false, callbacks: { title: () => '' } }
            : { enabled: false },
        },
        scales: {
          x: { display: false },
          y: { display: false, min: o.min, max: o.max },
        },
        elements: { point: { radius: 0, hoverRadius: o.tooltip ? 3 : 0 } },
      },
    })
  }

  /** Render every <x-adminlte-chart> under `scope` that isn't rendered yet. */
  function init(scope) {
    ;(scope || document).querySelectorAll('canvas[data-adminlte-chart]').forEach((canvas) => {
      if (Chart.getChart(canvas)) return
      let config
      try {
        config = JSON.parse(canvas.getAttribute('data-adminlte-chart-config') || '{}')
      } catch (e) {
        console.warn('AdminLTE: invalid JSON in data-adminlte-chart-config', e)
        return
      }
      try {
        create(canvas, config)
      } catch (e) {
        console.warn('AdminLTE: chart init failed (check the chart config)', e)
      }
    })
  }

  // --- live updates -----------------------------------------------------------

  function refresh() {
    applyTheme()
    Object.values(Chart.instances).forEach((chart) => chart.update('none'))
  }

  let queued = false
  function queueRefresh() {
    if (queued) return
    queued = true
    requestAnimationFrame(() => {
      queued = false
      refresh()
    })
  }

  // Colour mode toggle (light / dark / auto) and RTL flips.
  new MutationObserver(queueRefresh).observe(root, {
    attributes: true,
    attributeFilter: ['data-bs-theme', 'dir'],
  })

  // The web font may land after the first paint; redraw with it.
  if (document.fonts && document.fonts.ready) document.fonts.ready.then(queueRefresh)

  // Charts inside hidden tabs, modals and collapsed cards measure 0×0 until
  // shown. Chart.js watches its container, but resize explicitly as well.
  ;[
    'shown.bs.tab',
    'shown.bs.modal',
    'shown.bs.collapse',
    'shown.bs.offcanvas',
    'expanded.lte.card-widget',
    'maximized.lte.card-widget',
    'minimized.lte.card-widget',
  ].forEach((event) => {
    document.addEventListener(event, () => {
      Object.values(Chart.instances).forEach((chart) => chart.resize())
    })
  })

  applyTheme()

  window.AdminLteCharts = { create, sparkline, init, refresh, applyTheme, color, alpha, palette }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => init())
  } else {
    init()
  }
})()
