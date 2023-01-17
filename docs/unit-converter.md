### Documentation
* [Back To Root](../readme.md)
* [Price Calculator](price-calculator.md)
* [VAT Calculator](vat-calculator.md)
* [Discount Calculator](discount-calculator.md)
* [Unit Converter](unit-converter.md)
* [Entities](entities.md)
* [Price Formatter](price-formatter.md)

# Unit Converter

The unit converter is a factory to create an adapter, for example to convert euro to cent or cent to euro.
The unit converter has a method:
* factorize

### How to use the unit converter class

This class has a facade for easy use of the unit converter.

Use with facade:
```php
use MarcelStrahl\PriceCalculator\Factory\ConverterFactoryInterface;
use MarcelStrahl\PriceCalculator\Facade\UnitConverter;

$converter = UnitConverter::getConverter();

$centToEuroConverter = $converter->convert(ConverterFactoryInterface::CENT_TO_EURO);
$euroToCentConverter = $converter->convert(ConverterFactoryInterface::EURO_TO_CENT);
```

Use without facade:
```php
use MarcelStrahl\PriceCalculator\Factory\ConverterFactoryInterface;
use MarcelStrahl\PriceCalculator\UnitConverter;
use MarcelStrahl\PriceCalculator\Factory\Converter;

$converter = new UnitConverter(new Converter());

$centToEuroConverter = $converter->convert(ConverterFactoryInterface::CENT_TO_EURO);
$euroToCentConverter = $converter->convert(ConverterFactoryInterface::EURO_TO_CENT);
```

If you want, you can change any class with your implementation. 
Only need to implemented one of the interfaces of this library.