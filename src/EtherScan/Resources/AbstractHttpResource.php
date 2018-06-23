<?php

namespace EtherScan\Resources;

/**
 * Class AbstractHttpResource
 *
 * @package EtherScan\Resources
 *
 * Base class for modules
 */
abstract class AbstractHttpResource
{
    public const RESOURCE_TX = 'tx';
    public const RESOURCE_ADDRESS = 'address';
    public const RESOURCE_API = 'api';

    protected $prefix;

    /**
     *
     * @var ApiConnector
     */
    protected $apiConnector;

    /**
     * AbstractHttpResource constructor.
     *
     * @param ApiConnector $apiConnector
     * @param string       $prefix
     */
    public function __construct(ApiConnector $apiConnector, string $prefix)
    {
        $this->apiConnector = $apiConnector;
        $this->prefix = $prefix;
    }
}
