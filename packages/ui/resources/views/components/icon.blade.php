{{--
    @component  Icon
    @tag        <x-icon name="arrow-right" size="md" />
    @props      (see src/Components/Icon.php)
--}}
@props([
    'name',
    'size'  => 'md',
    'color' => null,
    'label' => null,
])

@php
    $c = $component ?? null;
    $iconName = $c ? $c->name : (preg_replace('/^(ti-|tabler-)/i', '', $name ?? ''));
    $isDecorative = $c ? $c->isDecorative() : (empty($label) || $label === 'none');
    $sizeClass = $c ? $c->sizeClass() : 'ui-icon--' . ($size ?? 'md');
    $ariaAttrs = $isDecorative
        ? ['aria-hidden' => 'true', 'focusable' => 'false']
        : ['aria-label'  => $label,  'role'       => 'img'];
@endphp

<x-dynamic-component
    :component="'tabler-' . $iconName"
    {{ $attributes->merge(array_merge($ariaAttrs, [
        'class' => 'ui-icon ' . $sizeClass . ($color ? " text-{$color}" : ''),
    ])) }}
/>
