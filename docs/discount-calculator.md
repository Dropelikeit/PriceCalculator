### Documentation
* [Back To Root](../readme.md)
* [Price Calculator](price-calculator.md)
* [VAT Calculator](vat-calculator.md)
* [Unit Converter](unit-converter.md)
* [Entities](entities.md)
* [Price Formatter](price-formatter.md)

# Discount Calculator

The Discount Calculator will be added to easy calculating discounts.
The Discount Calculator has two methods:
* calculateDiscountFromTotal
* calculateDiscountPriceFromTotal

### How to use the Discount Calculator class

The Discount Calculator has no facade like the Price Calculator, because it has no dependencies itself.
You can easily create an instance of this class:
```php
<?php

$calculator = new \MarcelStrahl\PriceCalculator\Service\DiscountCalculator();
```

Please note that all calculator functions require and return the following price object:
```php
<?php

$price = new \MarcelStrahl\PriceCalculator\Helpers\Entity\Price();
```
---
### Usage
If you want the total price (included discount), you must use the following method:
```php
<?php

use MarcelStrahl\PriceCalculator\Service\DiscountCalculator;
use MarcelStrahl\PriceCalculator\Helpers\Entity\Price;
use MarcelStrahl\PriceCalculator\Helpers\Entity\Discount;

$calculator = new DiscountCalculator();

$totalPrice = Price::create(2000); // 20.00 €
$discount = new Discount(50.0); // 50 %

$result = $calculator->calculateDiscountFromTotal($totalPrice, $discount);

var_dump($result->getPrice()); // 10.00 €
```

If you want only the discounted price, you use following method:
```php
<?php

use MarcelStrahl\PriceCalculator\Service\DiscountCalculator;
use MarcelStrahl\PriceCalculator\Helpers\Entity\Price;
use MarcelStrahl\PriceCalculator\Helpers\Entity\Discount;

$calculator = new DiscountCalculator();

$totalPrice = Price::create(2000); // 20.00 €
$discount = new Discount(50.0); // 50 %

$result = $calculator->calculateDiscountPriceFromTotal($totalPrice, $discount);

var_dump($result->getPrice()); // 10.00 €
```

**Hint for all functions:** When the result is 0 or lower, than the Discount Calculator will not be thrown an exception. The result is simple 0.