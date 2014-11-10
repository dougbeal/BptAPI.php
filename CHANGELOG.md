# Changelog

## v0.10.6
* __New Method__
    * `EventInfo->getEventImages()` - Added ability to get URLs to an event's 
    images.

## v0.10.5
* __Breaking Changes__
    * `ManageCart->addPricesToCart()` - Fixed issue where adding a
    price with no quantity to the cart would still pass through the
    rest of the loop. If you passed in quantities of 0 to remove prices
    from the cart, use the new method `removePricesFromCart()`.

* __New Method__ 
    * `ManageCart->removePricesFromCart()` - You only need to pass in
    an array of price IDs.