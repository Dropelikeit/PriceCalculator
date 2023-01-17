### Documentation
* [Back To Root](../readme.md)
* [VAT Calculator](vat-calculator.md)
* [Discount Calculator](discount-calculator.md)
* [Unit Converter](unit-converter.md)
* [Entities](entities.md)
* [Price Formatter](price-formatter.md)

# Price Calculator

The Price Calculator class is the base of this package and is used by the other calculator e.g. VAT calculator.
The Price Calculator has four methods.
+ Addition
+ Subtraction
* Multiplication
* Division

### How to use the Price Calculator class
This class has a facade for easy use of the Price Calculator.

If you want to use the facade to initialize the Price Calculator, you can use the following example.
```php
<?php

use MarcelStrahl\PriceCalculator\Facade\PriceCalculator as PriceCalculatorFacade;

$calculator = PriceCalculatorFacade::getPriceCalculator();
```

Without using the facade, you can initialize the calculator like any class.
```php
<?php

use MarcelStrahl\PriceCalculator\PriceCalculator;

$calculator = new MarcelStrahl\PriceCalculator\PriceCalculator();
```

Please note that all calculator functions require and return the following price object:
```php
<?php

$price = new \MarcelStrahl\PriceCalculator\Helpers\Entity\Price();
```

### Usage

---

Use the Add method:
```php
use MarcelStrahl\PriceCalculator\Facade\PriceCalculator as PriceCalculatorFacade;
use MarcelStrahl\PriceCalculator\Helpers\Entity\Price;

use function var_dump;

$calculator = PriceCalculatorFacade::getPriceCalculator();

$priceLeft = Price::create(100);
$priceRight = Price::create(250);

$result = $calculator->addPrice($priceLeft, $priceRight);
 
var_dump($result->getPrice()); // 350
```

Use the Sub method:
```php
use MarcelStrahl\PriceCalculator\Facade\PriceCalculator as PriceCalculatorFacade;
use MarcelStrahl\PriceCalculator\Helpers\Entity\Price;

use function var_dump;

$calculator = PriceCalculatorFacade::getPriceCalculator();

$priceLeft = Price::create(250);
$priceRight = Price::create(100);

$result = $calculator->subPrice($priceLeft, $priceRight);
 
var_dump($result->getPrice()); // 150
```

Use the Mul method:
```php
use MarcelStrahl\PriceCalculator\Facade\PriceCalculator as PriceCalculatorFacade;
use MarcelStrahl\PriceCalculator\Helpers\Entity\Price;

use function var_dump;

$calculator = PriceCalculatorFacade::getPriceCalculator();

$priceLeft = Price::create(10);
$priceRight = Price::create(10);

$result = $calculator->mulPrice($priceLeft, $priceRight);
 
var_dump($result->getPrice()); // 100
```

Use the Div method:
```php
use MarcelStrahl\PriceCalculator\Facade\PriceCalculator as PriceCalculatorFacade;
use MarcelStrahl\PriceCalculator\Helpers\Entity\Price;

use function var_dump;

$calculator = PriceCalculatorFacade::getPriceCalculator();

$priceLeft = Price::create(10);
$priceRight = Price::create(10);

$result = $calculator->divPrice($priceLeft, $priceRight);
 
var_dump($result->getPrice()); // 1
```

**Hint for div and sub function:** When the result is 0 or lower, than the Price Calculator will not be thrown an exception. The result is simple 0.