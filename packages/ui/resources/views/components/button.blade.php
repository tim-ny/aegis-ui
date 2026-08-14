{{--
    @component  Button
    @tag        <x-button />
    @props      (see src/Components/Button.php)
--}}
@props([
    'as'           => 'button',
    'type'         => 'button',
    'href'         => null,
    'target'       => null,
    'external'     => false,
    'loading'      => false,
    'disabled'     => false,
    'block'        => false,
    'unstyled'     => false,
    'leadingIcon'  => null,
    'trailingIcon' => null,
])

@php
    $tag = $component->resolveTag();
    $isDisabledOrLoading = $disabled || $loading;
@endphp

<{{ $tag }}
    {{ $attributes->merge([
        'class'         => $unstyled ? '' : $component->classes(),
        'disabled'      => ($tag === 'button' && $isDisabledOrLoading) ? 'disabled' : null,
        'aria-disabled' => ($tag === 'a' && $isDisabledOrLoading) ? 'true' : null,
        'aria-busy'     => $loading ? 'true' : null,
        'type'          => $component->resolveType(),
        'href'          => ($tag === 'a' && !$isDisabledOrLoading) ? $href : null,
        'target'        => $component->resolveTarget(),
        'rel'           => ($tag === 'a' && $external) ? 'noopener noreferrer' : null,
    ]) }}
>
    @if($loading)
        <x-spinner :size="$component->size === 'xl' ? 'md' : 'sm'" aria-hidden="true" />
    @elseif($leadingIcon)
        <x-icon :name="$leadingIcon" size="sm" aria-hidden="true" class="ui-btn__icon ui-btn__icon--leading" />
    @endif

    <span class="ui-btn__label">{{ $slot }}</span>

    @if($trailingIcon && !$loading)
        <x-icon :name="$trailingIcon" size="sm" aria-hidden="true" class="ui-btn__icon ui-btn__icon--trailing" />
    @endif
</{{ $tag }}>
