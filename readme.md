### Price calculator

[![Build Status](https://travis-ci.org/Dropelikeit/PriceCalculator.svg?branch=master)](https://travis-ci.org/Dropelikeit/PriceCalculator)
[![Coverage Status](https://coveralls.io/repos/github/Dropelikeit/PriceCalculator/badge.svg?branch=master)](https://coveralls.io/github/Dropelikeit/PriceCalculator?branch=master)
[![Monthly Downloads](https://poser.pugx.org/marcel-strahl/price-calculator/d/monthly)](https://packagist.org/packages/marcel-strahl/price-calculator)
[![Daily Downloads](https://poser.pugx.org/marcel-strahl/price-calculator/d/daily)](https://packagist.org/packages/marcel-strahl/price-calculator)
[![Total Downloads](https://poser.pugx.org/marcel-strahl/price-calculator/downloads)](https://packagist.org/packages/marcel-strahl/price-calculator)
[![Latest Stable Version](https://poser.pugx.org/marcel-strahl/price-calculator/v/stable)](https://packagist.org/packages/marcel-strahl/price-calculator)
[![Latest Unstable Version](https://poser.pugx.org/marcel-strahl/price-calculator/v/unstable)](https://packagist.org/packages/marcel-strahl/price-calculator)
[![License](https://poser.pugx.org/marcel-strahl/price-calculator/license)](https://packagist.org/packages/marcel-strahl/price-calculator)
[![composer.lock](https://poser.pugx.org/marcel-strahl/price-calculator/composerlock)](https://packagist.org/packages/marcel-strahl/price-calculator)

The price calculator is designed to simplify the calculation of gross and net prices in cents to euro and euro to cent. Price calculations for other currencies are currently being planned.
Our package is 100% tested!
We will gladly accept your corrections and improvements via a pull request. Please always add testing!

You are also welcome to use the Issue Tracker to set bugs, improvements or upgrade requests.

### Installation

``` composer require marcel-strahl/price-calculator ```

### How to use

If you want to use our price calculator, you can instantiate an instance of the price calculator via the price calculator facade from version 2.1.

```php
<?php
    use MarcelStrahl\PriceCalculator\Facade\PriceCalculator;
    
    $vat = 19;
    $priceCalculator = PriceCalculator::getPriceCalculator($vat);
```

In versions older than 2.1, you must instantiate the price calculator itself and add the dependencies.

```php
<?php

use MarcelStrahl\PriceCalculator\PriceCalculator;
use MarcelStrahl\PriceCalculator\Helpers\Entity\Vat;
    
$vat = new Vat();
$vat->setVat(19);        
$priceCalculator = new PriceCalculator($vat);
```

The price calculator can add prices

```php
<?php

use MarcelStrahl\PriceCalculator\PriceCalculator;
use MarcelStrahl\PriceCalculator\Helpers\Entity\Vat;
    
$total = 0;
$add = 100;

$vat = new Vat();
$vat->setVat(19);        
$priceCalculator = new PriceCalculator($vat);

// Total: 100
$total = $priceCalculator->addPrice($total, $add);
```

Subtracting prices is made possible by the following method:

```php
<?php

use MarcelStrahl\PriceCalculator\PriceCalculator;
use MarcelStrahl\PriceCalculator\Helpers\Entity\Vat;
    
$total = 200;
$sub = 100;

$vat = new Vat();
$vat->setVat(19);        
$priceCalculator = new PriceCalculator($vat);

// Total: 100
$total = $priceCalculator->subPrice($total, $sub);
```

You can also multiply prices by a number (integer).

```php
<?php

use MarcelStrahl\PriceCalculator\PriceCalculator;
use MarcelStrahl\PriceCalculator\Helpers\Entity\Vat;
    
$price = 200;
$amount = 2;

$vat = new Vat();
$vat->setVat(19);        
$priceCalculator = new PriceCalculator($vat);

// Total: 100
$total = $priceCalculator->mulPrice($amount, 200);
```

With the following code you can calculate the VAT:

```php
<?php

use MarcelStrahl\PriceCalculator\PriceCalculator;
use MarcelStrahl\PriceCalculator\Helpers\Entity\Vat;
    
$total = 200.50;

$vat = new Vat();
$vat->setVat(19);        
$priceCalculator = new PriceCalculator($vat);

$vatPrice = $priceCalculator->calculateSalesTaxFromTotalPrice($total);
```

The following example shows how to calculate the net price using the gross price.

```php
<?php

use MarcelStrahl\PriceCalculator\PriceCalculator;
use MarcelStrahl\PriceCalculator\Helpers\Entity\Vat;
    
$total = 200.50;

$vat = new Vat();
$vat->setVat(19);        
$priceCalculator = new PriceCalculator($vat);

$vatPrice = $priceCalculator->calculateNetPriceFromGrossPrice($total);
```

Or the gross price is determined using the net price

```php
<?php

use MarcelStrahl\PriceCalculator\PriceCalculator;
use MarcelStrahl\PriceCalculator\Helpers\Entity\Vat;
    
$netPrice = 15.50;

$vat = new Vat();
$vat->setVat(19);        
$priceCalculator = new PriceCalculator($vat);

$vatPrice = $priceCalculator->calculatePriceWithSalesTax($netPrice);
```
In another example you can see the functions of the price calculator.
A price is calculated, converted from cents to euros and the total sum is formatted.

```php
<?php
    use MarcelStrahl\PriceCalculator\PriceCalculator;
    use MarcelStrahl\PriceCalculator\Helpers\Entity\Vat;
    use MarcelStrahl\PriceCalculator\Helpers\View\PriceFormatter;
    use MarcelStrahl\PriceCalculator\Factory\Converter as UnitFactory;
    use MarcelStrahl\PriceCalculator\UnitConverter;
    
    $vat = new Vat();
    $total = 0;
    $price = 300; // cent
    $priceCalculator = new PriceCalculator($vat);
    $priceCalculator->setVat(19); // Value added tax in Germany
    $amount = $priceCalculator->addPrice($total, $price); // amount in cent
    
    // If you want to calculate the price including sales tax, use the following method.
    $amount = $priceCalculator->calculatePriceWithSalesTax($amount);
    
    // Add price
    $total = (float)$priceCalculator->addPrice($total, $amount);
    
    $factory = new UnitFactory();
    $unitConveter = new UnitConverter($factory);
    
    // Get cent to euro converter
    $conveter = $unitConveter->convert(UnitFactory::CENT_TO_EURO);
    $total = $conveter->convert($total);
    
    $formatter = new PriceFormatter(2, ',', '.', '€');
    echo $formatter->formatPrice($total);    
```