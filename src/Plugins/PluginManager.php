<?php

namespace ColorlibHQ\AdminLte\Plugins;

class PluginManager
{
    /**
     * @var array<string, array<string, mixed>>
     */
    protected array $config;

    /**
     * @var array<string, bool>
     */
    protected array $enabled = [];

    /**
     * @param  array<string, array<string, mixed>>  $config
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    public function enable(string $plugin): self
    {
        if ($this->has($plugin)) {
            $this->enabled[$plugin] = true;
        }

        return $this;
    }

    public function disable(string $plugin): self
    {
        unset($this->enabled[$plugin]);

        return $this;
    }

    public function isEnabled(string $plugin): bool
    {
        if (isset($this->enabled[$plugin])) {
            return $this->enabled[$plugin];
        }

        return $this->config[$plugin]['enabled'] ?? false;
    }

    public function has(string $plugin): bool
    {
        return isset($this->config[$plugin]);
    }

    public function getCss(string $plugin): ?string
    {
        if (! $this->isEnabled($plugin)) {
            return null;
        }

        return $this->config[$plugin]['css'] ?? null;
    }

    public function getJs(string $plugin): ?string
    {
        if (! $this->isEnabled($plugin)) {
            return null;
        }

        return $this->config[$plugin]['js'] ?? null;
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function getEnabledPlugins(): array
    {
        $enabled = [];
        foreach (array_keys($this->config) as $plugin) {
            if ($this->isEnabled($plugin)) {
                $enabled[$plugin] = $this->config[$plugin];
            }
        }

        return $enabled;
    }

    /**
     * Render <link> tags for every enabled plugin's CSS (string or array).
     */
    public function renderStyles(): string
    {
        $out = '';
        foreach (array_keys($this->getEnabledPlugins()) as $plugin) {
            foreach ((array) ($this->config[$plugin]['css'] ?? []) as $css) {
                $out .= '<link rel="stylesheet" href="'.asset($css).'">'.PHP_EOL;
            }
        }

        return $out;
    }

    /**
     * Render <script> tags for every enabled plugin's JS (string or array).
     */
    public function renderScripts(): string
    {
        $out = '';
        foreach (array_keys($this->getEnabledPlugins()) as $plugin) {
            foreach ((array) ($this->config[$plugin]['js'] ?? []) as $js) {
                $out .= '<script src="'.asset($js).'"></script>'.PHP_EOL;
            }
        }

        return $out;
    }
}
