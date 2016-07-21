<?php
/**
 * Created by PhpStorm.
 * User: m_tanguay
 * Date: 12/23/2015
 * Time: 12:42 PM
 */

namespace BrownPaperTickets;

use BrownPaperTickets\APIv2\Request\Request;
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

    public function __construct(Client $client = null)
    {
        $this->setClient($client);
        $this->setLogger($client->getLogger());
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

    public function call(Request $request, $params = [])
    {
        if (null !== $this->client) {
            return $this->client->call($request, $params);
        }

        return null;
    }
}