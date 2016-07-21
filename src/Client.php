<?php

namespace BrownPaperTickets;

use BrownPaperTickets\APIv2\Request\Request;
use Psr\Log\LoggerInterface;
use Symfony\Component\VarDumper\VarDumper;

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

    /**
     * @var LoggerInterface
     */
    private $logger;

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
    public function call(Request $request, $params = [])
    {
        $url = $this->buildUrl($request);
        
        $ch = $this->initCurl($url);

        $this->logger->debug(sprintf('API Call : %s', $url));
        $apiResponse = curl_exec($ch);
        $this->logger->debug(sprintf('API Response : %s', $apiResponse));

        curl_close($ch);

        return $apiResponse;
    }

    /**
     * @param array $configurations
     */
    protected function configure(array $configurations)
    {
        $this->baseUrl = (isset($configurations['base_url'])) ? $configurations['base_url'] : $this->baseUrl;
        $this->apiKey = (isset($configurations['api_key'])) ? $configurations['api_key'] : $this->apiKey;
    }

    public function setLogger(LoggerInterface $logger = null)
    {
        $this->logger = $logger;
    }

    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * Initialize curl for an api call
     *
     * @param $url
     * @return resource
     */
    protected function initCurl($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        return $ch;
    }

    /**
     * Formats the url to call
     *
     * @param Request $request
     * @return string
     */
    protected function buildUrl(Request $request)
    {
        $params = $request->getParams();
        $params['id'] = $this->apiKey;

        $urlParams = [];
        foreach ($params as $key => $value) {
            $urlParams[] = sprintf('%s=%s', $key, urlencode($value));
        }

        $url = $this->baseUrl . $request->getEndpoint() . '?' . implode('&', $urlParams);
        return $url;
    }
}