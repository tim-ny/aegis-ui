<?php
/**
 * @component  Alert
 * @type       Blade
 * @tag        <x-alert />
 * @props      variant, size, color, title, icon, dismissible, block, unstyled
 * @slots      $slot, $title, $icon
 * @decisions  Resolves fallback icon automatically per color theme if no icon prop is passed.
 *             Role defaults to "alert" for danger/warning and "status" for primary/success/neutral.
 */

namespace Aegis\Ui\Components;

use Aegis\Ui\Concerns\HasSize;
use Aegis\Ui\Concerns\HasVariant;
use Aegis\Ui\Concerns\HasColor;
use Aegis\Ui\Concerns\HasIcon;

class Alert extends BaseComponent
{
    use HasSize, HasVariant, HasColor, HasIcon;

    protected static function componentConfigKey(): string
    {
        return 'alert';
    }

    protected array $allowedVariants = ['soft', 'outline', 'solid', 'ghost'];
    protected array $allowedSizes = ['sm', 'md', 'lg'];

    public function __construct(
        public string   $variant     = 'soft',
        public string   $size        = 'md',
        public string   $color       = 'primary',
        public ?string  $title       = null,
        public ?string  $icon        = null,
        public ?string  $leadingIcon = null,
        public bool     $dismissible = false,
        public bool     $block       = false,
        public bool     $unstyled    = false,
    ) {
        $this->size    = $this->resolveDefault('alert', 'size', $size);
        $this->variant = $this->resolveDefault('alert', 'variant', $variant);
        $this->color   = $this->resolveDefault('alert', 'color', $color);
    }

    public function resolveIcon(): ?string
    {
        $targetIcon = $this->icon ?? $this->leadingIcon;

        if ($targetIcon === 'none' || $targetIcon === 'false') {
            return null;
        }

        if ($targetIcon) {
            return $targetIcon;
        }

        return match ($this->color) {
            'danger'  => 'alert-circle',
            'warning' => 'alert-triangle',
            'success' => 'circle-check',
            'primary' => 'info-circle',
            default   => 'info-circle',
        };
    }

    public function resolveRole(): string
    {
        return in_array($this->color, ['danger', 'warning'], true) ? 'alert' : 'status';
    }

    public function classes(): string
    {
        $this->validate();

        return $this->classNames(
            'ui-alert',
            "ui-alert--{$this->variant}",
            "ui-alert--{$this->size}",
            "ui-alert--{$this->color}",
            $this->block ? 'ui-alert--block' : null,
        );
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('ui::components.alert');
    }
}
