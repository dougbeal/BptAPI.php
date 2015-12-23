<?php
/**
 * Created by PhpStorm.
 * User: m_tanguay
 * Date: 12/23/2015
 * Time: 12:42 PM
 */

namespace BrownPaperTickets;

use Monolog\Logger;
use Psr\Log\LoggerInterface;

class Api
{
    /**
     * The api client to make api calls to the server
     * @var BrownPaperTickets/Client
     */
    private $client;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Retreives a fully configured client instance base on configurations
     */
    public static function instance()
    {
        return new static(new Client(), new Logger());
    }

    public function __construct(Client $client = null, LoggerInterface $logger = null)
    {
        $this->setClient($client);
        $this->setLogger($logger);
    }

    /**
     * Sets the api client
     *
     * @param Client|null $client
     */
    public function setClient(Client $client = null)
    {
        $this->client = $client;
    }

    /**
     * Sets the logger
     *
     * @param LoggerInterface|null $logger
     */
    public function setLogger(LoggerInterface $logger = null)
    {
        $this->logger = $logger;
    }

    public function call($endpoint, $params = [])
    {
        if (null !== $this->client) {
            return $this->client->call($endpoint, $params);
        }

        return null;
    }
}