<?php

namespace BrownPaperTickets;

class Client
{
    /**
     * The base URL used to make API calls.
     * @var string
     */
    private $baseUrl;

    /**
     * Your Brown Paper Tickets Developer ID
     * @var string
     */
    private $apiKey;

    public function __construct($configurations = [])
    {
        $this->configure($configurations);
    }

    /**
     * Make the call to the API using cURL.
     *
     * @param array $apiOptions an Array of parameters you wish to send to the API.
     * The first value must be the API endpoint
     *
     * @return object The xml returned by the API
     */
    public function call($endpoint, $params = [])
    {

        //$params = array_shift($apiOptions);
        $url = sprintf('%s%s?id=%s', $this->baseUrl, $endpoint, $this->apiKey);
        // $url = $this->baseURL.$endPoint.'?id='.$this->devID;

        // $this->setError('API Call', $url);

        foreach ($params as $key => $value) {
            $url = $url.'&'.$key.'='.urlencode($value);
        }

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $apiResponse = curl_exec($ch);

        // $this->setError('API Response', $apiResponse);

        curl_close($ch);

        return $apiResponse;
    }

    /**
     * @param array $configurations
     */
    protected function configure(array $configurations)
    {
        $this->baseUrl = (isset($configurations['base_url'])) ? : $configurations['base_url'];
        $this->apiKey = (isset($configurations['api_key'])) ? : $configurations['api_key'];
    }
}