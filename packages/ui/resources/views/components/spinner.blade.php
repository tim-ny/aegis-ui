{{--
    @component  Spinner
    @tag        <x-spinner size="md" label="Loading" />
    @props      (see src/Components/Spinner.php)
--}}
@props(['size' => 'md', 'color' => null, 'label' => 'Loading', 'icon' => null])

@php
    $spinnerClasses = 'ui-spinner ' . $component->sizeClass() . ($component->color ? " text-{$component->color}" : '');
@endphp

@if($component->usesTablerIcon())
    <x-dynamic-component
        :component="'tabler-' . $component->resolveIcon()"
        {{ $attributes->merge([
            'class'      => $spinnerClasses,
            'role'       => 'status',
            'aria-label' => $component->label,
        ]) }}
    />
@else
    <svg
        {{ $attributes->merge([
            'class'      => $spinnerClasses,
            'role'       => 'status',
            'aria-label' => $component->label,
        ]) }}
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
    >
        <circle
            class="ui-spinner__track"
            cx="12" cy="12" r="10"
            stroke="currentColor"
            stroke-width="3"
        />
        <path
            class="ui-spinner__head"
            fill="currentColor"
            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"
        />
    </svg>
@endif
