### Documentation
* [Back To Root](../readme.md)
* [Price Calculator](price-calculator.md)
* [VAT Calculator](vat-calculator.md)
* [Discount Calculator](discount-calculator.md)
* [Unit Converter](unit-converter.md)
* [Entities](entities.md)
* [Price Formatter](price-formatter.md)

# Vat Calculator

The Vat Calculator will be added to easy calculating VAT.
The VAT Calculator has three methods:
* calculatePriceWithSalesTax
* calculateSalesTaxFromTotalPrice
* calculateNetPriceFromGrossPrice

### How to use the VAT Calculator class

This class has a facade for easy use of the VAT Calculator.

If you want to use the facade to initialize the VAT Calculator, you can use the following example.
```php
<?php
use MarcelStrahl\PriceCalculator\Facade\VatCalculator as VatCalculatorFacade;

$calculator = VatCalculatorFacade::getVatCalculator(19);
```

Without using the facade, you can initialize the calculator like any class.
```php
<?php

use MarcelStrahl\PriceCalculator\Helpers\Entity\Vat;
use MarcelStrahl\PriceCalculator\Service\VatCalculator;
use MarcelStrahl\PriceCalculator\Facade\PriceCalculator as PriceCalculatorFacade;

$calculator = new VatCalculator(Vat::create(19), PriceCalculatorFacade::getPriceCalculator());
```

Please note that all calculator functions require and return the following price object:
```php
<?php
use MarcelStrahl\PriceCalculator\Helpers\Entity\Price;

$price = Price();
```

### Usage

----

Calculate the gross price from net price, by using the following method:
```php
<?php
use MarcelStrahl\PriceCalculator\Helpers\Entity\Price;
use MarcelStrahl\PriceCalculator\Facade\VatCalculator as VatCalculatorFacade;
use function var_dump;

$calculator = VatCalculatorFacade::getVatCalculator(19);

$price = Price::create(1000); // 10.00 €

$totalPrice = $calculator->calculatePriceWithSalesTax($price);

var_dump($totalPrice->getPrice()); // 11.90 €
```

Calculate only vat price from gross price, by using the following method:
```php
<?php
use MarcelStrahl\PriceCalculator\Helpers\Entity\Price;
use MarcelStrahl\PriceCalculator\Facade\VatCalculator as VatCalculatorFacade;
use function var_dump;

$calculator = VatCalculatorFacade::getVatCalculator(19);

$price = Price::create(1190); // 11.90 €

$totalPrice = $calculator->calculateSalesTaxFromTotalPrice($price);

var_dump($totalPrice->getPrice()); // 1.90 €
```

Calculate the net price from gross price, by using the following method:
```php
<?php
use MarcelStrahl\PriceCalculator\Helpers\Entity\Price;
use MarcelStrahl\PriceCalculator\Facade\VatCalculator as VatCalculatorFacade;
use function var_dump;

$calculator = VatCalculatorFacade::getVatCalculator(19);

$price = Price::create(1190); // 11.90 €

$totalPrice = $calculator->calculateNetPriceFromGrossPrice($price);

var_dump($totalPrice->getPrice()); // 10.00 €
```