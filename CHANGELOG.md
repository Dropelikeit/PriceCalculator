# Changelog

This Changelog refers to all changes since v5.0.0
***

# v5.0.0
* All Calculator classes return new price entities as a result.
* PriceCalculator Facade has `PriceCalculatorInterface` as return type.
* VatCalculator allows classes that implement `PriceCalculatorInterface` instead of the concrete PriceCalculator class.
* Vat and Price entity now has a private constructor and is initialized by a new `static` create method.
* The `ConverterFactory` class uses `match` instead of `switch`.
* Fixed unwanted forced order in the VAT calculation (for more details see [Upgrade to 5.0 Guide](UPGRADE-5.0.md))
