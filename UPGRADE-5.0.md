# UPGRADE FROM 4.x to 5.0

### Breaking Changes:

*Vat*-Class:

* The constructor is now private and the setter has been removed.
  The class has a static create method to initialize an object,
  the tax as an integer is a required argument of the create method.

Usage now:
```php 
<?php
$vat = \MarcelStrahl\PriceCalculator\Helpers\Entity\Vat::create(19);
```

*Converter*-Factory

+ Replace `switch` with `match`.

*Price*-Class:

* The constructor is now private, 
  so you have to use the `public static function create` with an integer as argument.
```php
<?php
   
$price = \MarcelStrahl\PriceCalculator\Helpers\Entity\Price::create(20050); // 200,50 €
```
*VatCalculator error*

If you do not call methods in a certain order, you often get incorrectly calculated results. This problem has been fixed in
v5.0 now fixed. The reason for this problem was that some methods in vat calculate manipulate the specified `$total` argument.

The bug before v5.0:
```php
$vatCalculator = \MarcelStrahl\PriceCalculator\Facade\VatCalculator::getVatCalculator(19);

$totalGrossPrice = new \MarcelStrahl\PriceCalculator\Helpers\Entity\Price();
$totalGrossPrice->setPrice($enquiry->total);

$netPrice = $vatCalculator->calculateNetPriceFromGrossPrice($totalGrossPrice)->getPrice(); // Changes value of $totalGrossPrice by PriceCalculator::subPrice();
// TotalGrossPrice has the same value as netPrice.
$vatTotal = $vatCalculator->calculateSalesTaxFromTotalPrice($totalGrossPrice)->getPrice();
```

In v5.0 this problem has now been fixed by initializing a new price object in the `subPrice` method of the PriceCalculator class.

*PriceCalculator Facade*

The return type of the `PriceCalculator::getPriceCalculator()` has been changed from concrete class to interface.

*VatCalculator*

The constructor allows a class that implements the `PriceCalculatorInterface` for more flexibility and clean dependency details.

*DiscountCalculator* / *VatCalculator* / *PriceCalculator*

The calculators return a new price entity instead to of overwriting the `$total` argument.
