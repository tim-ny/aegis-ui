<?php
/**
 * @component  Accordion
 * @type       Blade
 * @tag        <x-accordion />
 * @props      multiple, variant, size, color, defaultOpen, block, unstyled
 * @slots      $slot
 * @decisions  Alpine.js root container component managing active item state,
 *             supporting both single-open and multi-open accordion modes.
 */

namespace Aegis\Ui\Components;

use Aegis\Ui\Concerns\HasSize;
use Aegis\Ui\Concerns\HasVariant;
use Aegis\Ui\Concerns\HasColor;

class Accordion extends BaseComponent
{
    use HasSize, HasVariant, HasColor;

    protected static function componentConfigKey(): string
    {
        return 'accordion';
    }

    public function __construct(
        public bool     $multiple    = false,
        string          $variant     = 'outline',
        string          $size        = 'md',
        string          $color       = 'neutral',
        public mixed    $defaultOpen = null,
        public bool     $block       = false,
        public bool     $unstyled    = false,
    ) {
        $this->allowedVariants = ['outline', 'soft', 'ghost', 'flush'];
        $this->allowedSizes = ['sm', 'md', 'lg'];

        $this->size    = $this->resolveDefault('accordion', 'size', $size, 'md');
        $this->variant = $this->resolveDefault('accordion', 'variant', $variant, 'outline');
        $this->color   = $this->resolveDefault('accordion', 'color', $color, 'neutral');
    }

    public function classes(): string
    {
        $this->validate();

        return $this->classNames(
            'ui-accordion',
            "ui-accordion--{$this->variant}",
            "ui-accordion--{$this->size}",
            "ui-accordion--{$this->color}",
            $this->block ? 'ui-accordion--block' : null,
        );
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('ui::components.accordion');
    }
}
