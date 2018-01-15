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

### Example
```
$vat = 19; // Value added tax in Germany
$total = 0;
$price = 300; // cent
$priceCalculator = new PriceCalculator($vat);
$amount = $priceCalculator->addPrice($total, $price); // amount in cent

// If you want to calculate the price including sales tax, use the following method.
$amount = $priceCalculator->calculatePriceWithSalesTax($amount);

// convert to Euro
$amount = (float)$priceCalculator->calculateCentToEuro($amount);
    
$formatter = new PriceFormatter();
echo $formatter->formatPrice($amount, 2, ',', '.', '€');    
```