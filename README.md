# Brown Paper Tickets PHP API Wrapper
[![Build Status](https://img.shields.io/travis/brownpapertickets/BptAPI.php.svg?style=flat-square)](https://travis-ci.org/brownpapertickets/BptAPI.php)

The BptAPI library consists of a set of classes that enable you to easily interact with the [Brown Paper Tickets API](http://www.brownpapertickets.com/apidocs/index.html).

Since this library is still in early development, method names will possibly change.
See CHANGELOG for more information on any breaking changes.

## Usage

After installing the library (either through composer or by dropping the files into your own project), you'll want to first initialize the class that contains the methods you want to use. Everytime you intialize a class, you need to pass in your Brown Paper Tickets Developer ID.

For Example, to get a listing of events under a specific account, you'd use the [EventInfo](#eventinfo) class.

```php
$eventInfo = new EventInfo('Your Developer ID');
```

That will give you access to all of that class' methods.

To obtain an array containing all of the producer's events, we'd invoke the `getEvents` method. The get events method takes a total of four arguments:

| Arguments | Type | Required | Description |
|-----------|------|----------|-------------|
| `$username` | String  | No | The event producer whos events you wish to get |
| `$eventID`  | Integer | No | An Event ID if you want to get info on a particular Event |
| `$getDates` | Boolean | No | Pass `true` if you want to get a list of dates belonging to the event. Defaults to `false`|
| `$getPrices`| Boolean | No | Pass `true` if you want to get a list of prices belogning to each Date. Defaults to `false`|

```php
$events = $eventInfo->getEvents('some user name' null, true, true);
 ```
This would return an associative array with all of the event info along with dates and prices:

```php

Array
(
[0] => Array
    (
        [id] => 443322
        [title] => Test Event
        [live] => 1
        [address1] => Brown Paper Tickets
        [address2] => 220 Nickerson St
        [city] => Seattle
        [state] => WA
        [zip] => 98103
        [shortDescription] => This is a short description.
        [fullDescription] => This is the full description. Much fuller! Lots more to say! OMG!

Use the Full Description to describe your event as completely as possible. It's common to list performers or presenters along with a short bio for each. Additional details, such as a description of the expected activities, help create interest for potential attendees and can greatly increase attendance. This is your chance to create a verbal picture of your event!
        [dates] => Array
            (
                [0] => Array
                    (
                        [id] => 880781
                        [dateStart] => 2016-08-12
                        [dateEnd] => 2016-08-12
                        [timeStart] => 7:30
                        [timeEnd] => 0:00
                        [live] => 1
                        [available] => 10000
                        [prices] => Array
                            (
                                [0] => Array
                                    (
                                        [id] => 2517973
                                        [name] => Assigned
                                        [value] => 0
                                        [serviceFee] => 0
                                        [venueFee] => 0
                                        [live] => 1
                                    )

                                [1] => Array
                                    (
                                        [id] => 2517972
                                        [name] => General
                                        [value] => 0
                                        [serviceFee] => 0
                                        [venueFee] => 0
                                        [live] => 1
                                    )

                                [2] => Array
                                    (
                                        [id] => 2524714
                                        [name] => SUPER PRICEY
                                        [value] => 25
                                        [serviceFee] => 1.87
                                        [venueFee] => 0
                                        [live] => 1
                                    )

                            )

                    )

                [1] => Array
                    (
                        [id] => 882531
                        [dateStart] => 2016-12-13
                        [dateEnd] => 2016-12-13
                        [timeStart] => 14:00
                        [timeEnd] => 17:00
                        [live] => 
                        [available] => 10000
                        [prices] => Array
                            (
                                [0] => Array
                                    (
                                        [id] => 2524713
                                        [name] => SUPER PRICEY
                                        [value] => 25
                                        [serviceFee] => 1.87
                                        [venueFee] => 0
                                        [live] => 
                                    )

                            )

                    )

            )

    )

[1] => Array
    (
        [id] => 445143
        [title] => Another Test Event!
        [live] => 1
        [address1] => Tannhauser Gate
        [address2] => Alpha Orion
        [city] => Orion
        [state] => WA
        [zip] => 98107
        [shortDescription] => Unicorn Origami
        [fullDescription] => I've... seen things you people wouldn't believe... [laughs] Attack ships on fire off the shoulder of Orion. I watched c-beams glitter in the dark near the Tannhäuser Gate. All those... moments... will be lost in time, like [coughs] tears... in... rain. Time... to die...

&lt;img src="http://upload.wikimedia.org/wikipedia/en/1/1f/Tears_In_Rain.png" /&gt;
        [dates] => Array
            (
                [0] => Array
                    (
                        [id] => 881908
                        [dateStart] => 2017-08-14
                        [dateEnd] => 2017-08-15
                        [timeStart] => 13:00
                        [timeEnd] => 0:00
                        [live] => 1
                        [available] => 10000
                        [prices] => Array
                            (
                                [0] => Array
                                    (
                                        [id] => 2522667
                                        [name] => Assinged
                                        [value] => 1
                                        [serviceFee] => 1.03
                                        [venueFee] => 0
                                        [live] => 1
                                    )

                                [1] => Array
                                    (
                                        [id] => 2522647
                                        [name] => General
                                        [value] => 10
                                        [serviceFee] => 1.34
                                        [venueFee] => 0
                                        [live] => 1
                                    )

                            )

                    )

                [1] => Array
                    (
                        [id] => 881916
                        [dateStart] => 2018-08-12
                        [dateEnd] => 2018-08-12
                        [timeStart] => 19:00
                        [timeEnd] => 0:00
                        [live] => 1
                        [available] => 10000
                        [prices] => Array
                            (
                                [0] => Array
                                    (
                                        [id] => 2522668
                                        [name] => Assinged
                                        [value] => 1
                                        [serviceFee] => 1.03
                                        [venueFee] => 0
                                        [live] => 1
                                    )

                            )

                    )

            )

    )

)
```
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
Documentation Coming (View Source!)

### ManageEvent
Documentation Coming (View Source!)

### SalesInfo
Documentation Coming (View Source!)



## Changelog

* 8.4.2014 - Cast sales info to proper data types. Added sales test.
* 6.3.2014 - Cleaned up some of the tests.
* Fixed some variable name typos. Fixed issue with dates/prices being wrapped in an array when it is already being returned as an array.
* April 14, 2014: Intitial commit. Due to error, this commit is gone. At this point, most endpoints have been added. Unit test coverages is about 60% I'd say.

## License
The MIT License (MIT)

Copyright (c) 2014 Brown Paper Tickets

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
