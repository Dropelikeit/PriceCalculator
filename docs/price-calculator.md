# Price Calculator

The price calculator class is the base of this package and is used by the other calculator e.g. vat calculator.
The price calculator comes with four methods.
+ Addition
+ Subtraction
* Multiplication
* Division

### How to use the price calculator class
This class has a Facade to easily using the price calculator.

If you want using the facade to initialize the price calculator, you can using follow example.
```php
<?php

use MarcelStrahl\PriceCalculator\Facade\PriceCalculator as PriceCalculatorFacade;

$calculator = PriceCalculatorFacade::getPriceCalculator();
```

Without using the facade, you can initialize as every class the calculator.
```php
<?php

use MarcelStrahl\PriceCalculator\PriceCalculator;

$calculator = new MarcelStrahl\PriceCalculator\PriceCalculator();
```

Please aware that all functions of calculator need and return the following price object:
```php
$price = new \MarcelStrahl\PriceCalculator\Helpers\Entity\Price();
```



