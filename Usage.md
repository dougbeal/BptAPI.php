# Usage

You'll want to first initialize the class that contains the methods you want to use. The class names mirror the [official API documentation](http://www.brownpapertickets.com/apidocs/index.html).

So if you were looking to get info on an event's sales, you'd use the `SalesInfo` class. Please note, the methods names are completely different (and hopefully easier to make use of). Every time you intialize a class, you need to pass in your Brown Paper Tickets Developer ID. You can also pass in an `$options` argument as the second parameter ([more about options](#setting-options)).

For Example, to get a listing of events under a specific account, you'd use the [EventInfo](README.md#eventinfo) class.

```php
$eventInfo = new EventInfo('Your Developer ID');
```

That will give you access to all of that class' methods.

To obtain an array containing all of the producer's events, we'd invoke the `getEvents` method. The get events method takes a total of four arguments:

| Arguments | Type | Required | Description |
|-----------|------|----------|-------------|
| `$username` | String  | No | The event producer whos events you wish to info on. |
| `$eventID`  | Integer | No | If you only want info on a single event, you can pass in it's ID. |
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
