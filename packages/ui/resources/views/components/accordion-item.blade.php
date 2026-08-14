{{--
    @component  AccordionItem
    @tag        <x-accordion-item title="Item Title" />
    @props      (see src/Components/AccordionItem.php)
--}}
@props([
    'title'       => null,
    'id'          => null,
    'leadingIcon' => null,
    'disabled'    => false,
    'unstyled'    => false,
])

@php
    $itemId = $component->id;
@endphp

<div
    {{ $attributes->merge([
        'class' => $unstyled ? '' : $component->classes(),
    ]) }}
>
    <button
        type="button"
        @click="!{{ $disabled ? 'true' : 'false' }} && toggle('{{ $itemId }}')"
        :aria-expanded="isOpen('{{ $itemId }}')"
        aria-controls="{{ $itemId }}-panel"
        id="{{ $itemId }}-trigger"
        @if($disabled) disabled aria-disabled="true" @endif
        class="{{ $unstyled ? '' : 'ui-accordion__trigger' }}"
    >
        <span class="ui-accordion__trigger-left">
            @if($leadingIcon)
                <x-icon :name="$leadingIcon" size="sm" class="ui-accordion__icon--leading" aria-hidden="true" />
            @endif
            <span class="ui-accordion__title">{{ $titleSlot ?? $title }}</span>
        </span>

        <x-icon
            name="chevron-down"
            size="sm"
            class="ui-accordion__chevron"
            ::class="{ 'ui-accordion__chevron--open': isOpen('{{ $itemId }}') }"
            aria-hidden="true"
        />
    </button>

    <div
        x-show="isOpen('{{ $itemId }}')"
        x-collapse
        x-cloak
        id="{{ $itemId }}-panel"
        role="region"
        aria-labelledby="{{ $itemId }}-trigger"
        class="{{ $unstyled ? '' : 'ui-accordion__panel' }}"
    >
        <div class="ui-accordion__content">
            {{ $slot }}
        </div>
    </div>
</div>
