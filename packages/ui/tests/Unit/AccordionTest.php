<?php

namespace Aegis\Ui\Tests\Unit;

use Aegis\Ui\Components\Accordion;
use Aegis\Ui\Components\AccordionItem;
use InvalidArgumentException;

it('resolves outline neutral md classes by default for accordion', function () {
    $accordion = new Accordion();
    expect($accordion->classes())->toContain('ui-accordion', 'ui-accordion--outline', 'ui-accordion--md', 'ui-accordion--neutral');
});

it('supports outline soft ghost flush variants', function (string $variant) {
    $accordion = new Accordion(variant: $variant);
    expect($accordion->classes())->toContain("ui-accordion--{$variant}");
})->with(['outline', 'soft', 'ghost', 'flush']);

it('throws exception on invalid accordion variant', function () {
    expect(fn () => (new Accordion(variant: 'invalid'))->classes())->toThrow(InvalidArgumentException::class);
});

it('throws exception on invalid accordion size', function () {
    expect(fn () => (new Accordion(size: 'invalid'))->classes())->toThrow(InvalidArgumentException::class);
});

it('generates item id from title', function () {
    $item = new AccordionItem(title: 'What is Aegis UI');
    expect($item->id)->toBe('ui-acc-what-is-aegis-ui');
});
