<?php
/**
 *  The MIT License (MIT)
 *
 *  Copyright (c) 2014 Brown Paper Tickets
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
 *  @license  MIT <http://mit-license.org/>
 *  @link     https://github.com/BrownPaperTickets/BptAPI.php
 **/

namespace BrownPaperTickets\APIv2;

/**
 * This class contains all the methods necessary to purchase tickets through the API.
 */
class ManageCart extends BptAPI
{

    /**
     * Whether or not to require credit card info.
     * @var boolean
     */
    protected $requireCreditCard = false;

    /**
     * Whether or not to require Will Call names.
     * @var boolean
     */
    protected $requireWillCallNames = false;

    /**
     * The first step of the manage cart API calls. Simply returns
     * a cart ID string.
     *
     * @return string|array The Cart ID or an Array containing
     * the error from the BPT API.
     */
    public function getCartID()
    {
        $apiOptions = array(
            'endpoint' => 'cart',
            'stage' => 1
        );

        $cartXML = $this->parseXML($this->callAPI($apiOptions));

        if (isset($cartXML['error'])) {
            $this->setError('getCartID', $cartXML['error']);
            return false;
        }

        return (string) $cartXML->cart_id;
    }


     /**
     * Add Prices to the cart.
     * @todo Really figure out a decent way of accomplishing this.
     *
     * @param array $params An array with all the price info.
     * 
     * ### $params array
     * | parameter | type   | description |
     * |-----------|--------|-------------|
     * | `cartID`  | string | The ID of the cart these prices will go into.|
     * | `prices`  | array  | An array of prices with pricing info. The array key should be the price ID. |
     *
     * ### $prices array
     * | parameter | type | description |
     * |-----------|------|-------------|
     * | `shippingMethod` | integer | An integer representing shipping method*
     * | `quantity` | integer | the number of tickets you wish to add. |
     * | `affiliateID` | integer | Optional. If you wish to earn a commision, add the affiliate ID. |
     *
     *
     * __Shipping Method Info__
     *
     * 1 - Physical Tickets
     *
     * 2 - Will Call
     *
     * 3 - Print at Home
     *
     * ### Example:
     * ```
     * $prices = array(
     *     '12345' => array(
     *         'shippingMethod' => 1,
     *         'quantity' => 2,
     *     ),
     *     '12346' => array(
     *         'shippingMethod' => 3,
     *         'quantity' => 3
     *     )
     * );
     *
     * $cart = array(
     *     'cartID' => 'Some Cart ID string',
     *     'prices' => $prices;
     * );
     * ```
     * ManageCart->addPricesToCart()
     * @return  array Returns either a success or error message array.
     */

    public function addPrices($params)
    {

        $addPricesError = false;
        $allowedShipping = array(1, 2, 3);

        $apiOptions = array(
            'endpoint' => 'cart',
            'stage' => 2,
            'cart_id' => $params['cartID'],
        );

        if (isset($params['affiliateID'])) {
            $apiOptions['ref'] = $params['affiliateID'];
        }

        $addPrices = array(
            'result' => '',
            'cartID' => $params['cartID']
        );


        foreach ($params['prices'] as $priceID => $values) {

            if ($values['quantity'] === 0 || $values['quantity'] === '0') {
                $addPricesError = true;
                $addSinglePrice['priceID'] = $priceID;
                $addSinglePrice['result'] = 'fail';
                $addSinglePrice['status'] = 'No quantity set';
                $addPrices['pricesNotAdded'][] = $addSinglePrice;
                continue;
            }
            if (!in_array($values['shippingMethod'], $allowedShipping)) {
                $addPricesError = true;
                $addSinglePrice['priceID'] = $priceID;
                $addSinglePrice['result'] = 'fail';
                $addSinglePrice['status'] = 'Invalid shipping method.';
                $addPrices['pricesNotAdded'][] = $addSinglePrice;
                continue;
            }

            $apiOptions['price_id'] = $priceID;
            $apiOptions['shipping'] = $values['shippingMethod'];
            $apiOptions['quantity'] = $values['quantity'];

            $addPricesXML = $this->parseXML($this->callAPI($apiOptions));

            $addSinglePrice = array(
                'result' => 'success',
                'priceID' => $priceID,
                'quantity' => $apiOptions['quantity'],
                'shipping' => $apiOptions['shipping'],
                'status' => 'Price has been added.'
            );

            if (isset($addPricesXML['error'])) {
                $addPricesError = true;
                $addSinglePrice['result'] = 'fail';
                $addSinglePrice['status'] = $addPricesXML['error'];
                $addPrices['pricesNotAdded'][] = $addSinglePrice;

            } else {
                $addPrices['result'] = 'success.';
                $addPrices['message'] = 'All Prices were added.';
                $addPrices['cartValue'] = (integer) $addPricesXML->val;
                $addPrices['pricesAdded'][] = $addSinglePrice;

            }

        }

        if ($addPricesError) {
            $addPrices['error'] = 'Error';
            $addPrices['result'] = 'Failed to add prices.';
            $addPrices['message'] = 'Some prices could not be added.';
        }

        if (!isset($addPrices['pricesAdded'])) {
            $addPrices['result'] = 'Failed to add prices.';
            $addPrices['message'] = 'Could not add prices.';
        }

        return $addPrices;
    }

    /**
     * Remove prices from a cart.
     * 
     * @param  array $params An array containing the cart ID and an array of Prices IDs.
     * @return array         The results array.
     *
     * | parameter | type   | description |
     * |-----------|--------|-------------|
     * | cartID    | string | The cart ID |
     * | prices    | array  | An array of price IDs to be removed |
     */
    public function removePrices($params)
    {
        $removePricesError = false;

        $apiOptions = array(
            'endpoint' => 'cart',
            'stage' => 2,
            'cart_id' => $params['cartID'],
        );

        $removePrices = array(
            'result' => '',
            'cartID' => $params['cartID']
        );

        foreach ($params['prices'] as $priceID => $values) {

            $apiOptions['price_id'] = $priceID;
            $apiOptions['quantity'] = 0;

            $apiResponse = $this->callAPI($apiOptions);

            $removePricesXML = $this->parseXML($apiResponse);

            $removeSinglePrice = array(
                'result' => 'success',
                'priceID' => $priceID,
                'status' => 'Price has been removed.'
            );

            if (isset($removePricesXML['error'])) {

                $removePricesError = true;

                $removeSinglePrice['result'] = 'fail';

                $removeSinglePrice['status'] = $removePricesXML['error'];

                unset($removeSinglePrice['message']);

                $removePrices['pricesNotRemoved'][] = $removeSinglePrice;

            } else {
                $removePrices['result'] = 'All prices sent have been removed.';
                $removePrices['cartValue'] = (integer) $removePricesXML->val;
                $removePrices['pricesRemoved'][] = $removeSinglePrice;
            }

        }

        if ($removePricesError) {
            $removePrices['error'] = 'Error';
            $removePrices['result'] = 'Failed to remove prices.';
            $removePrices['message'] = 'Some prices could not be removeed.';
        }

        if (!isset($removePrices['pricesRemoved'])) {
            $removePrices['result'] = 'Failed to remove prices.';
            $removePrices['message'] = 'No prices were sent with a quantity of 0.';
        }

        return $removePrices;
    }

    /**
     * Add shipping info to the cart.
     * @param array $params The shipping info.
     */
    public function addShipping($params)
    {

        $apiOptions = array(
            'endpoint' => 'cart',
            'stage' => 3,
            'cart_id' => $params['cartID'],
            'fname' => $params['shippingFirstName'],
            'lname' => $params['shippingLastName'],
            'address' => $params['shippingAddress'],
            'city' => $params['shippingCity'],
            'state' => $params['shippingState'],
            'zip' => $params['shippingZip'],
            'country' => $params['shippingCountry'],
        );

        if ($this->requireWillCallNames === true
            && (!isset($params['willCallFirstName'])
            || !isset($params['willCallLastName']))
        ) {

            return array(
                'result' => 'error',
                'message' => 'Will Call names are required.'
            );
        }
        if (isset($params['willCallFirstName'])) {
            $apiOptions['attendee_firstname'] = $params['willCallFirstName'];
        }

        if (isset($params['willCallLastName'])) {
            $apiOptions['attendee_lastname'] = $params['willCallLastName'];
        }

        $apiResponse = $this->callAPI($apiOptions);

        $shippingInfoXML = $this->parseXML($apiResponse);

        if (isset($shippingInfoXML['error'])) {
            $this->setError('addShippingInfoToCart', $shippingInfoXML['error']);
            return false;
        }

        $shippingInfo = array(
            'result' => (string) 'success',
            'message' => (string) 'Shipping method has been added.',
            'cartID' => (string) $params['cartID']
        );

        return $shippingInfo;
    }

    /**
     * Add billing info to the cart.
     * @param array $params The billing info.
     *
     */
    public function addBilling($params)
    {
        $apiOptions = array(
            'endpoint' => 'cart',
            'stage' => 4,
            'cart_id' => $params['cartID'],
            'type' => $params['ccType'],
            'number' => $params['ccNumber'],
            'exp_month' => $params['ccExpMonth'],
            'exp_year' => $params['ccExpYear'],
            'cvv2' => $params['ccCvv2'],
            'billing_fname' => $params['billingFirstName'],
            'billing_lname' => $params['billingLastName'],
            'billing_address' => $params['billingAddress'],
            'billing_city' => $params['billingCity'],
            'billing_state' => $params['billingState'],
            'billing_zip' => $params['billingZip'],
            'billing_country' => $params['billingCountry'],
            'email' => $params['email'],
            'phone' => $params['phone']
        );

        $billingInfoXML = $this->parseXML($this->callAPI($apiOptions));

        if (isset($billingInfoXML['error'])) {
            $this->setError('addBillingInfoToCart', $billingInfoXML['error']);
            return false;
        }

        $billingInfo = array(
            'result' => (string) 'success',
            'message' => (string) 'Purchase complete.',
            'cartID' => (string) $billingInfoXML->cart_id
        );

        return $billingInfo;
    }
}
