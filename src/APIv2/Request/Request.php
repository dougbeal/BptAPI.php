<?php

namespace BrownPaperTickets\APIv2\Request;

abstract class Request
{
    /**
     * The required fields for this request
     *
     * @var array
     */
    protected $requiredParams = [];

    /**
     * @var array
     */
    protected $params = [];

    public function __construct()
    {
        $this->setRequiredParams();
    }

    abstract protected function setRequiredParams();
}