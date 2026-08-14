<?php
/**
 * @component  FormField
 * @type       Blade
 * @tag        <x-form-field />
 * @props      label, hint, error, valid, required, id, name, unstyled
 * @slots      $slot, $label, $hint, $error
 * @decisions  Wrapper component for grouping label, input control, and feedback text.
 */

namespace Aegis\Ui\Components;

use Aegis\Ui\Concerns\HasValidation;

class FormField extends BaseComponent
{
    use HasValidation;

    protected static function componentConfigKey(): string
    {
        return 'form-field';
    }

    public function __construct(
        public ?string $label    = null,
        public ?string $hint     = null,
        public ?string $error    = null,
        public bool    $valid    = false,
        public bool    $required = false,
        public bool    $readonly = false,
        public ?string $id       = null,
        public ?string $name     = null,
        public bool    $unstyled = false,
    ) {
        $this->bootHasValidation();
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('ui::components.form-field');
    }
}
