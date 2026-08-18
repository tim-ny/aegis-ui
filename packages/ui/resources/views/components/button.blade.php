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
    $c = $component ?? null;
    $tag = $c ? $c->resolveTag() : (($href !== null || $as === 'a') ? 'a' : $as);
    $isDisabledOrLoading = $disabled || $loading;
    $btnClasses = $unstyled ? '' : ($c ? $c->classes() : 'ui-btn ui-btn--solid ui-btn--md ui-btn--primary');
    $btnType = $c ? $c->resolveType() : ($tag === 'button' ? $type : null);
    $btnTarget = $c ? $c->resolveTarget() : ($tag === 'a' ? ($external ? '_blank' : $target) : null);
    $btnSize = $c ? $c->size : 'md';
@endphp

<{{ $tag }}
    {{ $attributes->merge([
        'class'         => $btnClasses,
        'disabled'      => ($tag === 'button' && $isDisabledOrLoading) ? 'disabled' : null,
        'aria-disabled' => ($tag === 'a' && $isDisabledOrLoading) ? 'true' : null,
        'aria-busy'     => $loading ? 'true' : null,
        'type'          => $btnType,
        'href'          => ($tag === 'a' && !$isDisabledOrLoading) ? $href : null,
        'target'        => $btnTarget,
        'rel'           => ($tag === 'a' && $external) ? 'noopener noreferrer' : null,
    ]) }}
>
    @if($loading)
        <x-spinner :size="$btnSize === 'xl' ? 'md' : 'sm'" aria-hidden="true" />
    @elseif($leadingIcon)
        <x-icon :name="$leadingIcon" size="sm" aria-hidden="true" class="ui-btn__icon ui-btn__icon--leading" />
    @endif

    <span class="ui-btn__label">{{ $slot }}</span>

    @if($trailingIcon && !$loading)
        <x-icon :name="$trailingIcon" size="sm" aria-hidden="true" class="ui-btn__icon ui-btn__icon--trailing" />
    @endif
</{{ $tag }}>
