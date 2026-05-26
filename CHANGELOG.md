# Changelog

## [7.0.0](https://github.com/Dropelikeit/PriceCalculator/compare/marcel-strahl/price-calculator-v6.0.0...marcel-strahl/price-calculator-v7.0.0) (2026-05-26)


### ⚠ BREAKING CHANGES

* Remove PHP 8.1 and add PHP 8.5 support. ([#30](https://github.com/Dropelikeit/PriceCalculator/issues/30))

### Features

* add Release Please configuration for automated releases ([f0e7bb7](https://github.com/Dropelikeit/PriceCalculator/commit/f0e7bb75d923b0171b2a6dca0a6272ddf1a732d8))
* Remove PHP 8.1 and add PHP 8.5 support. ([#30](https://github.com/Dropelikeit/PriceCalculator/issues/30)) ([5f16c84](https://github.com/Dropelikeit/PriceCalculator/commit/5f16c8411af527604cce7a8b567eadd47198c874))

## Changelog

This Changelog refers to all changes since v6.0.0
***

## v7.0.0
+ Breaking change: removed PHP 8.1 support. The package now requires PHP >= 8.2.
+ Reworked GitHub Actions CI to use a consolidated matrix workflow for PHP 8.2, 8.3, 8.4 and 8.5.
+ Added release automation that writes the calculated SemVer version into `composer.json` before creating the matching git tag.
+ Added Dependabot updates and auto-merge automation for supported dependency updates.
+ Added automatic PR labeling based on changed areas and file types.

## v6.0.0
+ Upgrade of dependencies, removed PHP 8.0 support.
+ Modernize code
+ Adding PHP mess detector
+ Restructure GitHub workflow actions.

## v5.0.1
+ Upgrade of dependencies, removal of PHPStan as I focused more on Psalm.
+ All test classes are now final and use attributes instead of annotations.
+ Using InfectionPHP to check the effectiveness of the test set (100% coverage and MSI score).
+ Improvement of the calculation logic in Discount calculator.

## v5.0.0
* All Calculator classes return new price entities as a result.
* PriceCalculator Facade has `PriceCalculatorInterface` as return type.
* VatCalculator allows classes that implement `PriceCalculatorInterface` instead of the concrete PriceCalculator class.
* Vat and Price entity now has a private constructor and is initialized by a new `static` create method.
* The `ConverterFactory` class uses `match` instead of `switch`.
* Fixed unwanted forced order in the VAT calculation (for more details see [Upgrade to 5.0 Guide](UPGRADE-5.0.md))
