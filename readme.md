<style>
    red { background: red; padding: 1%; }
    green { background-color: green; padding: 1%; }

    tr:nth-child(1) { background: green; }
    tr:nth-child(2), tr:nth-child(3)  { background: red; }
</style>

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

The Price Calculator is designed to simplify the calculation of gross and net prices in cents to euro and euro to cent.
Our package is 100% tested!
We will gladly accept your corrections and improvements via a pull request. Please always add testing!

You are also welcome to use the Issue Tracker to set bugs, improvements or upgrade requests.

### Installation

```bash
composer require marcel-strahl/price-calculator 
```
### Supported PHP Versions
|  PHP  | Package Version |
|:-----:|:---------------:|
| ^8.0  |      v5.x.x     |
| ^7.4  |     v4.x.x      |
| <^7.4 |    <=v3.x.x     | 

<green>&nbsp;</green> = Current supported version.
<red>&nbsp;</red> = No longer supported.

### Documentation

* [Price Calculator](docs/price-calculator.md)
* [VAT Calculator](docs/vat-calculator.md)
* [Discount Calculator](docs/discount-calculator.md)
* [Unit Converter](docs/unit-converter.md)
* [Entities](docs/entities.md)
* [Price Formatter](docs/price-formatter.md)

**The current version >= 4.0 can only be used with PHP 7.4 and higher, because the TypeHint for class properties was added.**

*If 7.4 is not or cannot be used, you need a version <= 4.0.*