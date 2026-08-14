{{--
    @component  FormField
    @tag        <x-form-field label="Label" error="Error message" required />
    @props      (see src/Components/FormField.php)
--}}
@props([
    'label'    => null,
    'hint'     => null,
    'error'    => null,
    'valid'    => false,
    'required' => false,
    'readonly' => false,
    'id'       => null,
    'name'     => null,
    'unstyled' => false,
])

<div {{ $attributes->merge(['class' => $unstyled ? '' : 'ui-form-field ' . $component->validationClass()]) }}>

    {{-- Label --}}
    @if(isset($labelSlot) || ($label ?? false))
        <label for="{{ $component->id }}" class="ui-form-field__label">
            {{ $labelSlot ?? $label }}
            @if($required)
                <span class="ui-form-field__required" aria-hidden="true">*</span>
            @endif
        </label>
    @endif

    {{-- Slot (Input control) --}}
    {{ $slot }}

    {{-- Feedback (error or hint) --}}
    @if(isset($errorSlot) || isset($hintSlot) || $component->feedbackText())
        <p
            id="{{ $component->id }}-feedback"
            class="ui-form-field__feedback {{ $component->feedbackClass() }}"
            @if($component->hasError() || isset($errorSlot)) role="alert" aria-live="polite" @endif
        >
            {{ $errorSlot ?? $hintSlot ?? $component->feedbackText() }}
        </p>
    @endif

</div>
