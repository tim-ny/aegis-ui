<?php

namespace Aegis\Ui\Components;

use Illuminate\View\Component;

abstract class BaseComponent extends Component
{
    /**
     * Must return the config key for this component, e.g. 'button'.
     * Used to resolve defaults from config/aegis-ui.php.
     */
    abstract protected static function componentConfigKey(): string;

    /**
     * Resolve a prop default via:
     * 1. inline prop (handled by Blade before this runs)
     * 2. published config/aegis-ui.php
     * 3. package fallback
     */
    protected function resolveDefault(string $component, string $prop, mixed $fallback): mixed
    {
        return config("aegis-ui.defaults.{$component}.{$prop}", $fallback);
    }

    /**
     * Validate all props. Call in mount() or render().
     * Each Concern adds its own validateX() method.
     */
    protected function validate(): void
    {
        if (method_exists($this, 'validateSize'))    $this->validateSize();
        if (method_exists($this, 'validateVariant')) $this->validateVariant();
        if (method_exists($this, 'validateColor'))   $this->validateColor();
        if (method_exists($this, 'validateRadius'))  $this->validateRadius();
    }

    /**
     * Merge multiple class arrays into a single string.
     * Accepts null values — they are ignored.
     */
    protected function classNames(mixed ...$classes): string
    {
        return collect($classes)
            ->flatten()
            ->filter()
            ->implode(' ');
    }
}
