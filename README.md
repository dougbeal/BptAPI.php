# Brown Paper Tickets PHP API
[![Build Status](https://img.shields.io/travis/brownpapertickets/BptAPI.php.svg?style=flat-square)](https://travis-ci.org/brownpapertickets/BptAPI.php) [![Packagist](https://img.shields.io/packagist/v/brown-paper-tickets/bpt-api.svg?style=flat-square)](https://packagist.org/packages/brown-paper-tickets/bpt-api) [![License MIT](http://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](LICENSE)

The BptAPI library consists of a set of classes that enable you to easily interact with the [Brown Paper Tickets API](http://www.brownpapertickets.com/apidocs/index.html).

Since this library is still in early development, method names will possibly change.
See [CHANGELOG](CHANGELOG.md) for more information on any breaking changes.

## Install
Via Composer:
`$ composer require brown-paper-tickets/bpt-api`.

(This will also install Monolog\Monolog as a dev dependency, if you don't need Monolog, add the `--no-dev` flag to composer.)

## Usage  
See [Usage.md](Usage.md) for a brief intro. You can also checkout the [api-example](https://www.github.com/brownpapertickets/api-example) app for a more complete example.

## Options

Currently there are three options that you can set: `debug`, `logErrors` and `logger`.

You can set them either by passing in an `$options` array as the second argument when you instantiate the classes or by using the `setOption()` method.`

| option | type | description |
|-------|------|-------------|
| logger | PSR-3 Logger Interface | If you want to make use of a logger (like Monolog), you can pass it in with this option.
| debug | boolean | If debug is set to true, all errors will be logged as well as all the raw API call url's and responses.
| logErrors | boolean | If set to true, all API errors will be logged to the object's `errors` array. If you have set a logger, they will also be logged there as well.|

For example:
```php
$logger = new \Monolog\Logger('logger');

$logger->pushHandler(new \Monolog\Handler\StreamHandler(__DIR__ . '/app.log', $logger::DEBUG));

$options = array(
    'logger' => $logger,
    'debug' => true,
    'logErrors' => true,
);
$info = new EventInfo(DEV_ID, $options);
```

`$info->setOption('logger', $logger);`

## The Classes and Methods

The library contains the following classes:
* [AccountInfo](#accountinfo)
* [CartInfo](#cartinfo)
* [EventInfo](#eventinfo)
* [ManageCart](#managecart)
* [ManageEvent](#manageevent)
* [SalesInfo](#salesinfo)

### AccountInfo
The AccountInfo class has a single method that will return info about the specified user.

#### getAccount($username)
Authorization Required: __Yes__

| Arguments | Description | Required |
|-----------|-------------|---------------|
|`$username`  |The user name of the account that you wish to get info on.| Yes |

__Returns__
This will return an array with the following fields:

| Field | Type | Description |
|-------|------|-------------|
| `id` | Integer | The producer ID |
| `username` | String | The producer's username.|
| `firstName` | String | First name |
| `lastName` | String | Last name |
| `address` | String | The address|
| `city` | String | City |
| `zip` | String | Zip Code |
| `phone` | Integer | Phone |
| `email` | String | Email |
| `nameForCheck` | String | The name that checks will be made out to. |

### CartInfo
Documentation Coming (View Source!)

### EventInfo
Authorization Required: __No__
The EventInfo class provides methods that allow you to obtain event data.

#####getEvents

| Arguments | Description | Required | Default |
|-----------|-------------|----------|---------|
| `$username` |The user name of the account that you wish to get info on. If not given, will return a ALL active BPT events and will probably break. | No | `null` |
| `$eventID` | If passed, will only return the information for that event | No | `null` |
| `$getDates` | Whether or not to also get a list of dates. | No | `false` |
| `getPrices` | Whether or not to also get a list of prices. | No | `false` |

__Returns__

This method returns an array of event arrays that contain the following fields:

| Field | Type | Description |
|-------|------|-------------|
| `id` | Integer | The event ID. |
| `title` | string | Title of the Event. |
| `live` | boolean | Whether or not the event is live. |
| `address1` | string | Event's address 1. |
| `address2` | string | Event's address 2. |
| `city` | string | Event's abbreviated state. |
| `zip` | string | Event's zip/postal code. |
| `shortDescription | string | Event's short description. |
| `fullDescription | string | Event's full description. |
| `phone` | string | Event's phone number. |
| `web` | string | Event's website. |
| `contactName` | string | Contact's name. |
| `contactPhone` | string | Contact's phone. |
| `contactAddress1` | string | Contact's address 1. |
| `contactAddress2` | string | Contact's address 2. |
| `contactCity` | string | Contact's city. |
| `contactState` | string | Contact's state. |
| `contactCountry` | string | Contact's country. |
| `contactZip` | string | Contact's zip/postal code. |
| `contactEmail` | string | Contact's email |


### ManageCart

Some methods will return a results array with two fields. The first is `success` which is a bolean indicating whether or not it failed and a `message` field explaining why.

#### initCart($cartID = null, $createdAt = null)
Starts a new cart session with Brown Paper Tickets. You can also pass in an existing `cartID` and the time it was `createdAt`. If the cart has expired it will return a results array with `success` set to `false`.

If successful, it will return a results array with `success` set to `true` as well as a `cartID` and `cartCreatedAt` field.

__Returns__
The newly created `cartID`. This cart will expire after 15 minutes.


#### isExpired()
Determines whether or not the `cartID` has expired.

#### getCartId()

__Returns__
The `cartID`.


#### setAffiliateID($affiliateID)

Pass your affiliate ID if you want to earn a commission on the sale.

#### setPrices($prices)
Set the prices to send to the cart. Will return the set prices.
This does not update the actual cart (use `sendPrices()` for that).

This will throw out any prices with an invalid shipping method and will determine
whether or not will call names need to be required when adding shipping info.

Pass in an array of prices IDs. Each Price ID value should be set to an array
with the following fields:

| parameter | type | description |
|-----------|------|-------------|
| `shippingMethod` | integer | An integer representing shipping method*
| `quantity` | integer | the number of tickets you wish to add. |
| `affiliateID` | integer | Optional. If you wish to earn a commision, add the affiliate ID. |

*Shipping Methods 1 for Physical, 2 for Will Call, 3 for Print at Home.

```php
$prices = array(
    '12345' => array(
        'shippingMethod' => 1,
        'quantity' => 2,
    ),
    '12346' => array(
        'shippingMethod' => 3,
        'quantity' => 3
    )
);
```

Returns an array of the set prices.

#### removePrices($prices)
Pass in an array of price IDs and it will remove the price IDs passed from the set prices. This does not update the actual cart (use `sendPrices()` for that).

__Returns__
An array of the set prices.

#### sendPrices()
Send the prices to the cart via the API.

Returns the results array.

#### getPrices()
Returns the prices set.

#### getValue()
Returns the current value of the cart as it was set when adding prices.
Note: When the class sets the value, it will determine whether or not certain fields are required for the billing info. See `setShipping()` for more info.

#### setShipping($shipping)
Pass in an array of shipping information.

| field | notes |
|-------|-------|
| firstName | |
| lastName | |
| address | |
| address2 | |
| city | |
| state | |
| zip | |
| country | Values include "United States" and "Canada". |

If you have selected tickets that require Will Call names, you can pass in a different name using the `willCallFirstName` and `willCallLastName` fields. Otherwise it will default to using the first and last name fields for will call names.

#### setBilling($billing)
Pass in an array of billing information.

Always pass these fields:

| field | notes |
|-------|-------|
| firstName | |
| lastName | |

When the cart's value is greather than 0, you must also include the following fields. If you do not, then the cart will return the results array with the message ""

| field | notes |
|-------|-------|
| address | |
| address2 | |
| city | |
| state | |
| zip | |
| email | |
| phone | |
| country | Values include "United States" and "Canada". |
| type | Credit card type. Must be "Visa", "Mastercard", "Discover" or "Amex" |
| number | Credit card number. Must be a string |
| expMonth | Expiration month. |
| expYear | Expriration year. |
| cvv2 | Credit card verification code |

Returns a results array.

#### sendBilling()
Sends the billing information to the cart.

Once this has been called and is successful, you will no longer be able to `sendPrices()`, `sendShipping()` or `sendBilling()`.

Returns a results array with the following fields:

| field | notes |
|-------|-------|
| success | boolean |
| message | A description of the results |
| ticketUrl | If successful and this shipping method was chosen, a link to the print-at-home tickets |
| cartID | the ID of the cart ID |
| receiptURL | If successful, a URL to the order's receipt on BPT. |

#### getReceipt()
Returns the results received by the `sendBilling()` method.

### SalesInfo
Documentation Coming (View Source!)

## Latest Changes

(See [CHANGELOG](CHANGELOG.md) for full set of changes)
### v0.15.0

* Added ability to capture all requests sent to the API and the raw response. Add `'debug' => true` to the `options` arrays upon instantiation or use `setOption('debug', true)`.
* Added `setLogger()` method that accepts a PSR-3 compatible logger (i.e. [Monolog](https://github.com/Seldaek/monolog)). You can also pass it in in the `options` array when instantiating.

### v0.14.2

* Fixed issue with the order field in getPrices.

### v0.14.1

* Fixed issue that caused the API to reject requests.

## License
The MIT License (MIT)

Copyright (c) 2015 Brown Paper Tickets

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
