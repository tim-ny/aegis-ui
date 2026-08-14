<?php
/**
 * @component  AccordionItem
 * @type       Blade
 * @tag        <x-accordion-item />
 * @props      title, id, leadingIcon, disabled, unstyled
 * @slots      $slot, $title, $trigger, $icon
 * @decisions  Renders collapsible item. Uses Str::slug / uniqid for auto ID generation if not passed.
 */

namespace Aegis\Ui\Components;

use Illuminate\Support\Str;

class AccordionItem extends BaseComponent
{
    protected static function componentConfigKey(): string
    {
        return 'accordion-item';
    }

    public function __construct(
        public ?string $title       = null,
        public ?string $id          = null,
        public ?string $leadingIcon = null,
        public bool    $disabled    = false,
        public bool    $unstyled    = false,
    ) {
        if (! $this->id) {
            $this->id = $this->title ? 'ui-acc-' . Str::slug($this->title) : 'ui-acc-' . uniqid();
        }
    }

    public function classes(): string
    {
        return $this->classNames(
            'ui-accordion__item',
            $this->disabled ? 'ui-accordion__item--disabled' : null,
        );
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('ui::components.accordion-item');
    }
}
