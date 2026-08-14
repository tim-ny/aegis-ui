{{--
    @component  Input
    @tag        <x-input />
    @props      (see src/Components/Input.php)
--}}
@props([
    'type'         => 'text',
    'label'        => null,
    'hint'         => null,
    'error'        => null,
    'valid'        => false,
    'required'     => false,
    'readonly'     => false,
    'disabled'     => false,
    'loading'      => false,
    'block'        => false,
    'id'           => null,
    'name'         => null,
    'placeholder'  => null,
    'autocomplete' => null,
    'autofocus'    => false,
    'maxlength'    => null,
    'leadingIcon'  => null,
    'trailingIcon' => null,
    'unstyled'     => false,
    'wireModel'    => null,
])

<div class="{{ $unstyled ? '' : 'ui-form-field ' . $component->validationClass() }}">

    {{-- Label --}}
    @if($label ?? false)
        <label for="{{ $component->id }}" class="ui-form-field__label">
            {{ $label }}
            @if($required)
                <span class="ui-form-field__required" aria-hidden="true">*</span>
            @endif
        </label>
    @endif

    {{-- Input wrapper --}}
    <div
        class="ui-input__wrapper"
        @if($type === 'password') x-data="{ showPassword: false }" @endif
    >
        @if($leadingIcon)
            <div class="ui-input__leading" aria-hidden="true">
                <x-icon :name="$leadingIcon" size="sm" />
            </div>
        @endif

        <input
            @if($type === 'password') :type="showPassword ? 'text' : 'password'" @else type="{{ $type }}" @endif
            {{ $attributes->merge([
                'id'            => $component->id,
                'name'          => $component->name,
                'placeholder'   => $placeholder,
                'autocomplete'  => $autocomplete,
                'autofocus'     => $autofocus ? 'autofocus' : null,
                'maxlength'     => $maxlength,
                'readonly'      => $readonly ? 'readonly' : null,
                'disabled'      => ($disabled || $loading) ? 'disabled' : null,
                'required'      => $required ? 'required' : null,
                'aria-required' => $required ? 'true' : null,
                'aria-invalid'  => $component->hasError() ? 'true' : null,
                'aria-busy'     => $loading ? 'true' : null,
                'aria-describedby' => $component->describedById(),
                'class'         => $unstyled ? '' : $component->classes(),
            ]) }}
            @if($wireModel)
                {{ $component->wireModelAttribute() }}
                wire:loading.attr="aria-busy"
                wire:target="{{ $wireModel }}"
            @endif
        />

        {{-- Trailing slot / icons / spinners / password toggle --}}
        <div class="ui-input__trailing">
            @if($loading)
                <x-spinner size="xs" aria-hidden="true" />
            @elseif($wireModel)
                <span wire:loading wire:target="{{ $wireModel }}">
                    <x-spinner size="xs" aria-hidden="true" />
                </span>
                <span wire:loading.remove wire:target="{{ $wireModel }}">
                    @if($component->hasError())
                        <x-icon name="alert-circle" size="sm" class="ui-input__trailing-icon--error" aria-hidden="true" />
                    @elseif($component->isValid())
                        <x-icon name="circle-check" size="sm" class="ui-input__trailing-icon--valid" aria-hidden="true" />
                    @elseif($type === 'password')
                        <button
                            type="button"
                            class="ui-input__password-toggle"
                            @click="showPassword = !showPassword"
                            :aria-label="showPassword ? 'Hide password' : 'Show password'"
                            tabindex="-1"
                        >
                            <template x-if="showPassword">
                                <x-icon name="eye-off" size="sm" aria-hidden="true" />
                            </template>
                            <template x-if="!showPassword">
                                <x-icon name="eye" size="sm" aria-hidden="true" />
                            </template>
                        </button>
                    @elseif($trailingIcon)
                        <x-icon :name="$trailingIcon" size="sm" aria-hidden="true" />
                    @endif
                </span>
            @else
                @if($component->hasError())
                    <x-icon name="alert-circle" size="sm" class="ui-input__trailing-icon--error" aria-hidden="true" />
                @elseif($component->isValid())
                    <x-icon name="circle-check" size="sm" class="ui-input__trailing-icon--valid" aria-hidden="true" />
                @elseif($type === 'password')
                    <button
                        type="button"
                        class="ui-input__password-toggle"
                        @click="showPassword = !showPassword"
                        :aria-label="showPassword ? 'Hide password' : 'Show password'"
                        tabindex="-1"
                    >
                        <template x-if="showPassword">
                            <x-icon name="eye-off" size="sm" aria-hidden="true" />
                        </template>
                        <template x-if="!showPassword">
                            <x-icon name="eye" size="sm" aria-hidden="true" />
                        </template>
                    </button>
                @elseif($trailingIcon)
                    <x-icon :name="$trailingIcon" size="sm" aria-hidden="true" />
                @endif
            @endif
        </div>
    </div>

    {{-- Feedback (error or hint) --}}
    @if($component->feedbackText())
        <p
            id="{{ $component->id }}-feedback"
            class="ui-form-field__feedback {{ $component->feedbackClass() }}"
            @if($component->hasError()) role="alert" aria-live="polite" @endif
        >
            {{ $component->feedbackText() }}
        </p>
    @endif

</div>
