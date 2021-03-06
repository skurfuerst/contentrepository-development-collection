<?php
namespace Neos\EventSourcedNeosAdjustments\Domain\Context\Domain\Event;

/*
 * This file is part of the Neos.Neos package.
 *
 * (c) Contributors of the Neos Project - www.neos.io
 *
 * This package is Open Source Software. For the full copyright and license
 * information, please view the LICENSE file which was distributed with this
 * source code.
 */

use Neos\EventSourcing\Event\EventInterface;
use Neos\EventSourcedNeosAdjustments\Domain\ValueObject\SchemeHostPort;
use Neos\EventSourcedContentRepository\Domain\ValueObject\NodeName;

final class DomainWasAdded implements EventInterface
{
    /**
     * @var NodeName
     */
    private $siteNodeName;

    /**
     * @var SchemeHostPort
     */
    private $schemeHostPort;

    /**
     * ActivateDomain constructor.
     * @param NodeName $siteNodeName
     * @param SchemeHostPort $schemeHostPort
     */
    public function __construct(NodeName $siteNodeName, SchemeHostPort $schemeHostPort)
    {
        $this->siteNodeName = $siteNodeName;
        $this->schemeHostPort = $schemeHostPort;
    }

    /**
     * @return NodeName
     */
    public function getSiteNodeName(): NodeName
    {
        return $this->siteNodeName;
    }

    /**
     * @return SchemeHostPort
     */
    public function getSchemeHostPort(): SchemeHostPort
    {
        return $this->schemeHostPort;
    }
}
