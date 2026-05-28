<?php

namespace ColorlibHQ\AdminLte\Plugins;

class PluginManager
{
    protected array $config;

    protected array $enabled = [];

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
}
