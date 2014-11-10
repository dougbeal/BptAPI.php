<?php
/**
 *   Copyright (c) 2014 Brown Paper Tickets
 *
 *  Permission is hereby granted, free of charge, to any person obtaining a copy
 *  of this software and associated documentation files (the "Software"), to deal
 *  in the Software without restriction, including without limitation the rights
 *  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 *  copies of the Software, and to permit persons to whom the Software is
 *  furnished to do so, subject to the following conditions:
 *
 *  The above copyright notice and this permission notice shall be included in
 *  all copies or substantial portions of the Software.
 *
 *  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 *  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 *  FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 *  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 *  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 *  OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 *  THE SOFTWARE.
 *
 *  @category License
 *  @package  BptAPI
 *  @author   Chandler Blum <chandler@brownpapertickets.com>
 *  @license  GPLv2 <https://www.gnu.org/licenses/gpl-2.0.html>
 *  @link     Link
 **/

namespace BrownPaperTickets\APIv2;

class EventInfo extends BptAPI
{
    /**
     * Get events.
     *
     * @param string  $userName  The Brown Paper Tickets username.
     *                           Must be listed in Authorized Accounts
     * @param integer $eventID   Pass in the eventID if you wish to only
     *                           get info for that specific event.
     * @param boolean $getDates  Whether or not to get the Dates
     * @param boolean $getPrices Whether or not to get the Prices
     *
     * @return array  $events An array of events information.
     */
    public function getEvents(
        $userName = null,
        $eventID = null,
        $getDates = false,
        $getPrices = false
    ) {
        $apiOptions = array(
            'endpoint' => 'eventlist'
        );

        if (isset($userName)) {
            $apiOptions['client'] = $userName;
        }

        if (isset($eventID)) {

            $apiOptions['event_id'] = $eventID;
        }

        $apiResults = $this->callAPI($apiOptions);

        $eventsXML = $this->parseXML($apiResults);

        if (isset($eventsXML['error'])) {
            $events[] = $eventsXML;
            return $events;
        }

        $events = array();

        foreach ($eventsXML->event as $event) {

            $eventID = $event->event_id;

            $singleEvent = array(
                'id'=> (integer) $eventID,
                'title'=> (string) $event->title,
                'live'=> $this->convertToBool($event->live),
                'address1'=> (string) $event->e_address1,
                'address2'=>(string) $event->e_address2,
                'city'=> (string) $event->e_city,
                'state'=> (string) $event->e_state,
                'zip'=> (string) $event->e_zip,
                'shortDescription'=> (string) $event->description,
                'fullDescription'=> (string) $event->e_description
            );

            if ($getDates === true || $getDates === 'true') {

                $singleEvent['dates'] = $this->getDates($eventID, '', $getPrices);
            }

            $events[] = $singleEvent;
        }

        return $events;
    }
    /**
     * Get the dates.
     *
     * @param integer $eventID   The ID of the event
     * @param integer $dateID    The ID of the date.
     * @param boolean $getPrices Whether or not to get the Prices
     *
     * @return array  $sales An array of sales information.
     */
    public function getDates(
        $eventID,
        $dateID = null,
        $getPrices = false
    ) {

        $apiOptions = array(
            'endpoint' => 'datelist',
            'event_id' => $eventID
        );

        if (isset($dateID)) {
            $apiOptions['date_id'] = $dateID;
        }

        $apiResults = $this->callAPI($apiOptions);

        $datesXML = $this->parseXML($apiResults);

        if (isset($datesXML['error'])) {
            return $datesXML;
        }

        $dates = array();

        foreach ($datesXML->date as $date) {

            $dateID = $date->date_id;

            $singleDate = array(
                'id'=> (integer) $dateID,
                'dateStart'=> (string) $date->datestart,
                'dateEnd'=> (string) $date->dateend,
                'timeStart'=> (string) $date->timestart,
                'timeEnd'=> (string) $date->timeend,
                'live'=> (boolean) $this->convertToBool($date->live),
                'available'=> (integer) $date->date_available
            );

            if ($getPrices === true || $getPrices === 'true') {

                $singleDate['prices'] = $this->getPrices($eventID, $dateID);
            }

            $dates[] = $singleDate;

        }

        if (count($dates) > 1) {

            $dates = $this->sortByKey($dates, 'dateStart');
            return $dates;

        } else {
            return $dates;
        }
    }

    /**
     * Get a the prices for a date.
     *
     * @param integer $eventID The ID of the Event
     * @param integer $dateID  The ID of the date
     *
     * @return array  $dates An array of dates.
     */
    public function getPrices($eventID, $dateID)
    {

        $apiOptions = array(
            'endpoint' => 'pricelist',
            'event_id' => $eventID,
            'date_id' => $dateID
        );

        $apiResults = $this->callAPI($apiOptions);

        $priceXML = $this->parseXML($apiResults);

        if (isset($priceXML['error'])) {
            return $priceXML;
        }

        $prices = array();

        foreach ($priceXML->price as $price) {

            $single_price = array(
                'id'=> (integer) $price->price_id,
                'name'=> (string) $price->name,
                'value'=> (float) $price->value,
                'serviceFee'=> (float) $price->service_fee,
                'venueFee'=> (float) $price->venue_fee,
                'live'=> (boolean) $this->convertToBool($price->live),
            );

            $prices[] = $single_price;
        }

        if (count($prices) > 1) {
            $prices = $this->sortByKey($prices, 'name');

            return $prices;

        } else {

            return $prices;
        }
    }

    /**
     * This will return an array with entries for each image attached to an event.
     * Each entry has the following fields: large, medium, small with urls  to
     * the corresponding image size.
     *
     * @param  integer $eventID The ID of the event you want the images for.
     * @return array
     */

    public function getEventImages($eventID)
    {
        $ch = curl_init();

        $url = 'https://www.brownpapertickets.com/eventimages.rss?e_number=' . $eventID;

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSLVERSION, 3);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $apiResponse = curl_exec($ch);

        curl_close($ch);

        $xml = $this->parseXML($apiResponse);

        $images = array();

        if (!isset($xml->channel->item)) {
            return array('error' => 'No images found.');
        }


        foreach ($xml->channel->item as $item) {

            if (isset($item->description)) {
                $description = (string) $item->description;
                if ($description === 'The specified event could not be found.') {
                    return array('error' => 'Invalid event.');
                }
            }

            $bpt = $item->children('http://www.brownpapertickets.com/bpt.html');

            $image = array(
                'large' => ($bpt->image_large ? (string) $bpt->image_large : false),
                'medium' => ($bpt->image_medium ? (string) $bpt->image_medium : false),
                'small' => ($bpt->image_small ? (string) $bpt->image_small : false),
            );

            array_push($images, $image);

        }

        return $images;
    }
}
