<?php
namespace Neos\EventSourcedContentRepository\Domain\Context\NodeAggregate;

/*
 * This file is part of the Neos.ContentRepository package.
 *
 * (c) Contributors of the Neos Project - www.neos.io
 *
 * This package is Open Source Software. For the full copyright and license
 * information, please view the LICENSE file which was distributed with this
 * source code.
 */

use Neos\Cache\CacheAwareInterface;
use Neos\EventSourcedContentRepository\Domain\Projection\Content\RootNodeIdentifiers;
use Neos\EventSourcedContentRepository\Domain\ValueObject\NodeName;
use Neos\EventSourcedContentRepository\Utility;
use Ramsey\Uuid\Uuid;

/**
 * A node aggregate identifier is a externally referenceable identifier of a node aggregate.
 */
final class NodeAggregateIdentifier implements \JsonSerializable, CacheAwareInterface
{
    /**
     * A preg pattern to match against node aggregate identifiers
     */
    const PATTERN = '/^([a-z0-9\-]{1,255})$/';

    /**
     * @var string
     */
    private $identifier;

    /**
     * NodeAggregateIdentifier constructor.
     *
     * @param string $existingIdentifier
     */
    public function __construct(string $existingIdentifier = null)
    {
        if ($existingIdentifier !== null) {
            $this->setIdentifier($existingIdentifier);
        } else {
            $this->setIdentifier((string)Uuid::uuid4());
        }
    }

    /**
     * @param string $identifier
     */
    private function setIdentifier(string $identifier)
    {
        if (!preg_match(self::PATTERN, $identifier)) {
            throw new \InvalidArgumentException('Invalid node aggregate identifier "' . $identifier . '" (a node aggregate identifier must only contain lowercase characters, numbers and the "-" sign).', 1505840197862);
        }
        $this->identifier = $identifier;
    }

    /**
     * @param string $identifier
     * @return static
     */
    public static function fromString(string $identifier)
    {
        return new NodeAggregateIdentifier($identifier);
    }

    /**
     * @param NodeName $childNodeName
     * @param NodeAggregateIdentifier $nodeAggregateIdentifier
     * @return static
     */
    public static function forAutoCreatedChildNode(NodeName $childNodeName, NodeAggregateIdentifier $nodeAggregateIdentifier): NodeAggregateIdentifier
    {
        return new NodeAggregateIdentifier(Utility::buildAutoCreatedChildNodeIdentifier((string)$childNodeName, (string)$nodeAggregateIdentifier));
    }

    /**
     * @return string
     */
    public function jsonSerialize()
    {
        return $this->identifier;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->identifier;
    }

    /**
     * @return string
     */
    public function getCacheEntryIdentifier(): string
    {
        return $this->identifier;
    }

    public function isRoot(): bool
    {
        return $this === RootNodeIdentifiers::rootNodeAggregateIdentifier();
    }
}
