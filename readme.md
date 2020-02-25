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

```
composer require marcel-strahl/price-calculator 
```

**The current version >= 4.0 can only be used with PHP 7.4 and higher, because the TypeHint for class properties was added.**

*If 7.4 is not or cannot be used, you need a version <= 4.0.*

### How to use

If you want to use our price calculator, you can instantiate an instance of the price calculator via the price calculator facade from version 2.1.

```php
<?php
    use MarcelStrahl\PriceCalculator\Facade\PriceCalculator;
    $priceCalculator = PriceCalculator::getPriceCalculator();
```

In versions older than 2.1, you must instantiate the price calculator itself and add the dependencies.

```php
<?php

use MarcelStrahl\PriceCalculator\PriceCalculator;
use MarcelStrahl\PriceCalculator\Helpers\Entity\Vat;
           
$priceCalculator = new PriceCalculator();
```

The price calculator can add prices

```php
<?php

use MarcelStrahl\PriceCalculator\PriceCalculator;
use MarcelStrahl\PriceCalculator\Helpers\Entity\Price;
    
$total = new Price();
$total->setPrice(0);
$add = new Price();
$add->setPrice(100);

$priceCalculator = new PriceCalculator();

// Total: 100
$total = $priceCalculator->addPrice($total, $add);
```

Subtracting prices is made possible by the following method:

```php
<?php

use MarcelStrahl\PriceCalculator\PriceCalculator;
use MarcelStrahl\PriceCalculator\Helpers\Entity\Price;
    
$total = new Price();
$total->setPrice(0);
$sub = new Price();
$sub->setPrice(100);

$priceCalculator = new PriceCalculator();

// Total: 100
$total = $priceCalculator->subPrice($total, $sub);
```

You can also multiply prices by a number (integer).

```php
<?php

use MarcelStrahl\PriceCalculator\PriceCalculator;
use MarcelStrahl\PriceCalculator\Helpers\Entity\Price;
    
$price = new Price();
$price->setPrice(200);
$amount = new Price();
$amount->setPrice(2);
    
$priceCalculator = new PriceCalculator();

// Total: 100
$total = $priceCalculator->mulPrice($amount, $price);
```

With the following code you can calculate the VAT:

```php
<?php

use MarcelStrahl\PriceCalculator\PriceCalculator;
use MarcelStrahl\PriceCalculator\Helpers\Entity\Vat;
use MarcelStrahl\PriceCalculator\Helpers\Entity\Price;
use MarcelStrahl\PriceCalculator\Service\VatCalculator;

$total = new Price();
// This value is cent.
$total->setPrice(20050);

$vat = new Vat();
$vat->setVat(19);   
$vatCalculator = new VatCalculator($vat, new PriceCalculator());

$vatPrice = $vatCalculator->calculateSalesTaxFromTotalPrice($total);
```

The following example shows how to calculate the net price using the gross price.

```php
<?php

use MarcelStrahl\PriceCalculator\PriceCalculator;
use MarcelStrahl\PriceCalculator\Helpers\Entity\Vat;
use MarcelStrahl\PriceCalculator\Helpers\Entity\Price;
use MarcelStrahl\PriceCalculator\Service\VatCalculator;
    
$total = new Price();
$total->setPrice(20050);

$vat = new Vat();
$vat->setVat(19);        
$vatCalculator = new VatCalculator($vat, new PriceCalculator());

$vatPrice = $vatCalculator->calculateNetPriceFromGrossPrice($total);
```

Or the gross price is determined using the net price

```php
<?php

use MarcelStrahl\PriceCalculator\PriceCalculator;
use MarcelStrahl\PriceCalculator\Helpers\Entity\Vat;
use MarcelStrahl\PriceCalculator\Helpers\Entity\Price;
use MarcelStrahl\PriceCalculator\Service\VatCalculator;
                                                        
$total = new Price();
$total->setPrice(1550);

$vat = new Vat();
$vat->setVat(19);

$vatCalculator = new VatCalculator($vat, new PriceCalculator());

$vatPrice = $vatCalculator->calculatePriceWithSalesTax($total);
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
    use MarcelStrahl\PriceCalculator\Helpers\Entity\Price;
    use MarcelStrahl\PriceCalculator\Service\VatCalculator;
    
    $vat = new Vat();
    // Value added tax in Germany
    $vat->setVat(19);
    
    $total = new Price();
    $total->setPrice(0);
    $price = new Price();
    // Value is Cent
    $price->setPrice(300);
    
    $priceCalculator = new PriceCalculator();
    $vatCalculator = new VatCalculator($vat, $priceCalculator);
    $amount = $priceCalculator->addPrice($total, $price); // amount in cent
    
    // If you want to calculate the price including sales tax, use the following method.
    $amount = $vatCalculator->calculatePriceWithSalesTax($amount);
    
    // Add price
    $total = $priceCalculator->addPrice($total, $amount);
    
    $factory = new UnitFactory();
    $unitConverter = new UnitConverter($factory);
    
    // Get cent to euro converter
    $converter = $unitConverter->convert(UnitFactory::CENT_TO_EURO);
    $total = $converter->convert((float)$total->getPrice());
    
    $formatter = new PriceFormatter(2, ',', '.', '€');
    echo $formatter->formatPrice($total);    
```