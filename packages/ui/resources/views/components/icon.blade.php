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
    $ariaAttrs = $component->isDecorative()
        ? ['aria-hidden' => 'true', 'focusable' => 'false']
        : ['aria-label'  => $label,  'role'       => 'img'];
@endphp

<x-dynamic-component
    :component="'tabler-' . $component->name"
    {{ $attributes->merge(array_merge($ariaAttrs, [
        'class' => 'ui-icon ' . $component->sizeClass() . ($color ? " text-{$color}" : ''),
    ])) }}
/>
