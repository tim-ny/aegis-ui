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

@php
    $c = $component ?? null;
    $inputId = $c ? $c->id : ($id ?? ($label ? 'ui-' . \Illuminate\Support\Str::slug($label) : 'ui-' . uniqid()));
    $inputName = $c ? $c->name : ($name ?? $inputId);
    $hasErr = $c ? $c->hasError() : !empty($error);
    $isVld = $c ? $c->isValid() : ($valid && !$hasErr);
    $feedbackTxt = $c ? $c->feedbackText() : ($error ?? $hint ?? null);
    $validationCls = $c ? $c->validationClass() : ($hasErr ? 'ui-field--error' : ($isVld ? 'ui-field--valid' : ($readonly ? 'ui-field--readonly' : '')));
    $feedbackCls = $c ? $c->feedbackClass() : ($hasErr ? 'ui-field__feedback--error' : 'ui-field__feedback--hint');
    $describedBy = $c ? $c->describedById() : ($feedbackTxt ? "{$inputId}-feedback" : null);
    $inputClasses = $unstyled ? '' : ($c ? $c->classes() : 'ui-input ui-input--outline ui-input--md ui-input--primary');
@endphp

<div class="{{ $unstyled ? '' : 'ui-form-field ' . $validationCls }}">

    {{-- Label --}}
    @if($label ?? false)
        <label for="{{ $inputId }}" class="ui-form-field__label">
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
                'id'            => $inputId,
                'name'          => $inputName,
                'placeholder'   => $placeholder,
                'autocomplete'  => $autocomplete,
                'autofocus'     => $autofocus ? 'autofocus' : null,
                'maxlength'     => $maxlength,
                'readonly'      => $readonly ? 'readonly' : null,
                'disabled'      => ($disabled || $loading) ? 'disabled' : null,
                'required'      => $required ? 'required' : null,
                'aria-required' => $required ? 'true' : null,
                'aria-invalid'  => $hasErr ? 'true' : null,
                'aria-busy'     => $loading ? 'true' : null,
                'aria-describedby' => $describedBy,
                'class'         => $inputClasses,
            ]) }}
            @if($wireModel)
                {{ $c ? $c->wireModelAttribute() : "wire:model.lazy=\"{$wireModel}\"" }}
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
                    @if($hasErr)
                        <x-icon name="alert-circle" size="sm" class="ui-input__trailing-icon--error" aria-hidden="true" />
                    @elseif($isVld)
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
                @if($hasErr)
                    <x-icon name="alert-circle" size="sm" class="ui-input__trailing-icon--error" aria-hidden="true" />
                @elseif($isVld)
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
    @if($feedbackTxt)
        <p
            id="{{ $inputId }}-feedback"
            class="ui-form-field__feedback {{ $feedbackCls }}"
            @if($hasErr) role="alert" aria-live="polite" @endif
        >
            {{ $feedbackTxt }}
        </p>
    @endif

</div>
