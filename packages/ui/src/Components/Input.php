<?php
/**
 * @component  Input
 * @type       Blade
 * @tag        <x-input />
 * @props      type, variant, size, color, leadingIcon, trailingIcon, label, hint, error, valid, required, readonly, disabled, id, name, placeholder, autocomplete, autofocus, maxlength, unstyled, wireModel, wireModelModifier
 * @slots      none
 * @decisions  Supports variants [outline, soft, subtle, ghost, none]. When type="password",
 *             includes Alpine toggle for eye/eye-off visibility. Resolves defaults via config/aegis-ui.php.
 */

namespace Aegis\Ui\Components;

use Aegis\Ui\Concerns\HasSize;
use Aegis\Ui\Concerns\HasVariant;
use Aegis\Ui\Concerns\HasColor;
use Aegis\Ui\Concerns\HasIcon;
use Aegis\Ui\Concerns\HasValidation;
use Aegis\Ui\Concerns\InteractsWithWire;

class Input extends BaseComponent
{
    use HasSize, HasVariant, HasColor, HasIcon, HasValidation, InteractsWithWire;

    protected static function componentConfigKey(): string
    {
        return 'input';
    }

    protected array $allowedVariants = ['outline', 'soft', 'subtle', 'ghost', 'none'];

    public function __construct(
        public string   $type         = 'text',
        public string   $variant      = 'outline',
        public string   $size         = 'md',
        public string   $color        = 'primary',
        public ?string  $leadingIcon  = null,
        public ?string  $trailingIcon = null,
        public ?string  $label        = null,
        public ?string  $hint         = null,
        public ?string  $error        = null,
        public bool     $valid        = false,
        public bool     $required     = false,
        public bool     $readonly     = false,
        public bool     $disabled     = false,
        public bool     $loading      = false,
        public bool     $block        = false,
        public ?string  $id           = null,
        public ?string  $name         = null,
        public ?string  $placeholder  = null,
        public ?string  $autocomplete = null,
        public bool     $autofocus    = false,
        public ?int     $maxlength    = null,
        public bool     $unstyled     = false,
        public ?string  $wireModel    = null,
        public ?string  $wireModelModifier = null,
    ) {
        $this->size    = $this->resolveDefault('input', 'size', $size);
        $this->variant = $this->resolveDefault('input', 'variant', $variant);
        $this->color   = $this->resolveDefault('input', 'color', $color);
        $this->bootHasValidation();
    }

    public function classes(): string
    {
        $this->validate();

        return $this->classNames(
            'ui-input',
            "ui-input--{$this->variant}",
            "ui-input--{$this->size}",
            "ui-input--{$this->color}",
            $this->block    ? 'ui-input--block'    : null,
            $this->disabled ? 'ui-input--disabled' : null,
            $this->readonly ? 'ui-input--readonly' : null,
            $this->loading  ? 'ui-input--loading'  : null,
        );
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('ui::components.input');
    }
}
