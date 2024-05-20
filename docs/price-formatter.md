### Documentation
* [Back To Root](../readme.md)
* [Price Calculator](price-calculator.md)
* [VAT Calculator](vat-calculator.md)
* [Discount Calculator](discount-calculator.md)
* [Unit Converter](unit-converter.md)
* [Entities](entities.md)

# Price Formatter

As an addition to round out this library, this library has a price formatter.

Use of price formatter:
```php
<?php

use MarcelStrahl\PriceCalculator\Helpers\View\PriceFormatter;

$decimals = 2;
$decPoint = ',';
$thousands = '.';
$currency = '€';

$formatter = new PriceFormatter($decimals, $decPoint, $thousands, $currency);

$formatter->formatPrice(12.5);
```

The price formatter accepts only floats and is thus decapsulated from the price object.
In order to enter a value from a price object into the price formatter, the CentToEuro converter is usually required. A shortened example follows.

```php
<?php

use MarcelStrahl\PriceCalculator\Contracts\Factory\ConverterFactoryInterface;use MarcelStrahl\PriceCalculator\Facade\UnitConverter;use MarcelStrahl\PriceCalculator\Helpers\Entity\Price;use MarcelStrahl\PriceCalculator\Helpers\View\PriceFormatter;

$calculatedResultInCent = Price::create(1010);

$converter = UnitConverter::getConverter()->convert(ConverterFactoryInterface::CENT_TO_EURO);

$calculatedResultInEuro = $converter->convert($calculatedResultInCent)

$decimals = 2;
$decPoint = ',';
$thousands = '.';
$currency = '€';

$formatter = new PriceFormatter($decimals, $decPoint, $thousands, $currency);

$formattedPrice = $formatter->formatPrice($calculatedResultInEuro);

var_dump($formattedPrice); // 10,10 €
```