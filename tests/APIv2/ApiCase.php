<?php
/**
 * Created by PhpStorm.
 * User: m_tanguay
 * Date: 12/23/2015
 * Time: 10:23 AM
 */

namespace BrownPaperTicketsTests\APIv2;

abstract class ApiCase extends \PHPUnit_Framework_TestCase
{
    private $apiKey;

    /**
     * Sets up the api key from the configuration for all api requests
     */
    public function setUp()
    {
        $config = require('config/api.php');

        $this->apiKey = $config['api_key'];
    }

    /**
     * Returns the currently used api key.
     *
     * @return string   The api key
     */
    protected function getApiKey()
    {
        return $this->apiKey;
    }
}