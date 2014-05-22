<?php

namespace BrownPaperTickets\APIv2;

class AccountInfo extends BptAPI
{
      ///////////////////////////////
    // Account Information Calls //
    ///////////////////////////////

    /**
     * Get the Account information
     *
     * @param string $username The username of the account
     *                          must be authorized. Required.
     *
     * @return array
     */
    public function getAccount($username)
    {
        $apiOptions = array(
            'endpoint' => 'viewaccount',
            'account' => $username
        );

        $apiResults = $this->callAPI($apiOptions);

        $accountXML = $this->parseXML($apiResults);

        if (isset($accountXML['error'])) {
            return $accountXML;
        }

        $account = array(
            'id' => $accountXML->client_id,
            'name' => $accountXML->c_client_name,
            'firstName' => $accountXML->c_fname,
            'lastName' => $accountXML->c_lname,
            'address' => $accountXML->c_address,
            'city' => $accountXML->c_city,
            'state' => $accountXML->c_state,
            'zip' => $accountXML->c_zip,
            'phone' => $accountXML->c_phone,
            'email' => $accountXML->c_email,
            'nameForChecks' => $accountXML->c_name_for_checks
        );

        return $account;
    }
}
