<?php
/**
 * @component  Checkbox
 * @type       Blade
 * @tag        <x-checkbox />
 * @props      label, hint, error, valid, required, readonly, disabled, checked, value, indeterminate, size, color, radius, block, id, name, unstyled, wireModel, wireModelModifier
 * @slots      $slot
 * @decisions  Inline label layout — the label sits to the right of the control, not above it.
 *             Uses a visually hidden native input with a styled box + SVG checkmark driven by
 *             the :checked / :indeterminate pseudo-classes, so state updates need no re-render.
 *             Indeterminate is applied via Alpine (x-init), not the HTML attribute.
 *             radius levels: none, xs, sm, md, lg, full (default sm). When the $slot is
 *             non-empty (or block="true"), the label renders as a full-width selectable card
 *             wrapping arbitrary content, checked styling via the same :checked pseudo-class.
 */

namespace Aegis\Ui\Components;

use Aegis\Ui\Concerns\HasSize;
use Aegis\Ui\Concerns\HasColor;
use Aegis\Ui\Concerns\HasValidation;
use Aegis\Ui\Concerns\InteractsWithWire;

class Checkbox extends BaseComponent
{
    use HasSize, HasColor, HasValidation, InteractsWithWire;

    protected static function componentConfigKey(): string
    {
        return 'checkbox';
    }

    protected array $allowedRadii = ['none', 'xs', 'sm', 'md', 'lg', 'full'];

    public function __construct(
        public bool     $checked          = false,
        public ?string  $value            = null,
        public bool     $indeterminate    = false,
        public bool     $disabled         = false,
        public bool     $block            = false,
        public bool     $unstyled         = false,
        public string   $size             = 'md',
        public string   $color            = 'primary',
        public string   $radius           = 'sm',
        public ?string  $label            = null,
        public ?string  $hint             = null,
        public ?string  $error            = null,
        public bool     $valid            = false,
        public bool     $readonly         = false,
        public bool     $required         = false,
        public ?string  $id               = null,
        public ?string  $name             = null,
        public ?string  $wireModel        = null,
        public ?string  $wireModelModifier = null,
    ) {
        $this->size   = $this->resolveDefault('checkbox', 'size', $size);
        $this->color  = $this->resolveDefault('checkbox', 'color', $color);
        $this->radius = $this->resolveDefault('checkbox', 'radius', $radius);
        $this->bootHasValidation();
    }

    public function validateRadius(): void
    {
        if (! in_array($this->radius, $this->allowedRadii, true)) {
            throw new \InvalidArgumentException(
                sprintf(
                    '[%s] Invalid radius "%s". Allowed: %s.',
                    class_basename(static::class),
                    $this->radius,
                    implode(', ', $this->allowedRadii)
                )
            );
        }
    }

    public function classes(): string
    {
        $this->validate();

        return $this->classNames(
            'ui-checkbox',
            "ui-checkbox--{$this->size}",
            "ui-checkbox--{$this->color}",
            "ui-checkbox--radius-{$this->radius}",
            $this->block   ? 'ui-checkbox--block'   : null,
            $this->disabled ? 'ui-checkbox--disabled' : null,
            $this->readonly ? 'ui-checkbox--readonly' : null,
        );
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('ui::components.checkbox');
    }
}
