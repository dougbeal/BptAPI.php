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

    /**
     * Error stack
     * @var array
     */
    protected $errors = [];

    public function __construct(array $params = [])
    {
        $this->setRequiredParams();
        $this->setParams($params);
    }

    public function setParams(array $params)
    {
        $this->params = $params;
    }

    public function getParams()
    {
        return $this->params;
    }

    abstract protected function setRequiredParams();
    abstract public function getEndpoint();

    /**
     * Verifies if all required keys are in the params
     *
     * @return bool
     */
    protected function validate()
    {
        foreach($this->requiredParams as $param => $value)
        {
            if (true === empty($this->params[$param])) {
                $this->errors[] = sprintf('Missing required field [%s]', $param);
            }
        }

        return (count($this->errors) === 0);
    }
}