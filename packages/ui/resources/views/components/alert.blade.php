{{--
    @component  Alert
    @tag        <x-alert />
    @props      (see src/Components/Alert.php)
--}}
@props([
    'variant'     => 'soft',
    'size'        => 'md',
    'color'       => 'primary',
    'title'       => null,
    'icon'        => null,
    'leadingIcon' => null,
    'dismissible' => false,
    'block'       => false,
    'unstyled'    => false,
])

@php
    $resolvedIcon = $component->resolveIcon();
@endphp

<div
    @if($dismissible) x-data="{ show: true }" x-show="show" x-transition.opacity @endif
    {{ $attributes->merge([
        'class' => $unstyled ? '' : $component->classes(),
        'role'  => $component->resolveRole(),
    ]) }}
>
    @if($resolvedIcon)
        <div class="ui-alert__icon" aria-hidden="true">
            <x-icon :name="$resolvedIcon" size="md" />
        </div>
    @endif

    <div class="ui-alert__body">
        @if(isset($titleSlot) || $title)
            <h5 class="ui-alert__title">{{ $titleSlot ?? $title }}</h5>
        @endif
        @if($slot->isNotEmpty())
            <div class="ui-alert__message">{{ $slot }}</div>
        @endif
    </div>

    @if($dismissible)
        <button
            type="button"
            class="ui-alert__dismiss"
            @click="show = false"
            aria-label="Dismiss alert"
        >
            <x-icon name="x" size="sm" aria-hidden="true" />
        </button>
    @endif
</div>
