### Documentation
* [Back To Root](../readme.md)
* [Price Calculator](price-calculator.md)
* [VAT Calculator](vat-calculator.md)
* [Discount Calculator](discount-calculator.md)
* [Unit Converter](unit-converter.md)
* [Entities](entities.md)
* [Price Formatter](price-formatter.md)

# Entities
This page gives a general overview of the entities (DTOs) used in this library.

---

### Price
The Price object will be used from all calculators to get prices into a method and return the result of calculating as an object.
See also [Price Calculator](price-calculator.md)

### Discount
The Discount object will be only used by the Discount Calculator. It will be used to get discount values into a method.
See also [Discount Calculator](discount-calculator.md)

### VAT
The VAT object is used only by the VAT calculator.  The VAT object is necessary to create an instance of the VAT calculator. 
Unlike the discount, which is always added to a method, the VAT object is passed only once via constructor, since constant 
passing of the information is usually not necessary.
See also [VAT Calculator](vat-calculator.md)

---
**Hint**: All entities are immutables.