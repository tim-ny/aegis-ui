<?php
/**
 * @component  Button
 * @type       Blade
 * @tag        <x-button />
 * @props      variant, size, color, as, type, href, target, external, disabled, loading, leadingIcon, trailingIcon, unstyled, wireModel
 * @slots      $slot, $loadingIndicator
 * @decisions  Polymorphic root element tag. If href is set or as="a", root element resolves to "a".
 *             When href is present with disabled or loading state, aria-disabled="true" is set and href is omitted.
 */

namespace Aegis\Ui\Components;

use Aegis\Ui\Concerns\HasSize;
use Aegis\Ui\Concerns\HasVariant;
use Aegis\Ui\Concerns\HasColor;
use Aegis\Ui\Concerns\HasIcon;
use Aegis\Ui\Concerns\InteractsWithWire;

class Button extends BaseComponent
{
    use HasSize, HasVariant, HasColor, HasIcon, InteractsWithWire;

    protected static function componentConfigKey(): string
    {
        return 'button';
    }

    protected array $allowedVariants = ['solid', 'outline', 'ghost', 'soft'];

    public function __construct(
        public string   $variant      = 'solid',
        public string   $size         = 'md',
        public string   $color        = 'primary',
        public string   $as           = 'button',
        public string   $type         = 'button',
        public ?string  $href         = null,
        public ?string  $target       = null,
        public bool     $external     = false,
        public bool     $disabled     = false,
        public bool     $loading      = false,
        public bool     $block        = false,
        public ?string  $leadingIcon  = null,
        public ?string  $trailingIcon = null,
        public bool     $unstyled     = false,
        public ?string  $wireModel    = null,
    ) {
        $this->size    = $this->resolveDefault('button', 'size', $size);
        $this->variant = $this->resolveDefault('button', 'variant', $variant);
        $this->color   = $this->resolveDefault('button', 'color', $color);

        if ($this->href !== null && $this->as === 'button') {
            $this->as = 'a';
        }
    }

    public function resolveTag(): string
    {
        if ($this->href !== null || $this->as === 'a') {
            return 'a';
        }

        return $this->as;
    }

    public function resolveType(): ?string
    {
        return $this->resolveTag() === 'button' ? $this->type : null;
    }

    public function resolveTarget(): ?string
    {
        if ($this->resolveTag() !== 'a') {
            return null;
        }

        if ($this->external) {
            return '_blank';
        }

        return $this->target;
    }

    public function classes(): string
    {
        $this->validate();

        return $this->classNames(
            'ui-btn',
            "ui-btn--{$this->variant}",
            "ui-btn--{$this->size}",
            "ui-btn--{$this->color}",
            $this->block    ? 'ui-btn--block'    : null,
            $this->loading  ? 'ui-btn--loading'  : null,
            $this->disabled ? 'ui-btn--disabled' : null,
        );
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('ui::components.button');
    }
}
