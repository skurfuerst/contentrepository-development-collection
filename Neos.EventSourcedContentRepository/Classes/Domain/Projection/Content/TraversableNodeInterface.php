<?php
namespace Neos\EventSourcedContentRepository\Domain\Projection\Content;

/*
 * This file is part of the Neos.ContentRepository package.
 *
 * (c) Contributors of the Neos Project - www.neos.io
 *
 * This package is Open Source Software. For the full copyright and license
 * information, please view the LICENSE file which was distributed with this
 * source code.
 */

use Neos\EventSourcedContentRepository\Domain;
use Neos\EventSourcedContentRepository\Domain\Model\NodeType;
use Neos\EventSourcedContentRepository\Domain\ValueObject\NodeIdentifier;
use Neos\EventSourcedContentRepository\Domain\Context\ContentStream\ContentStreamIdentifier;
use Neos\ContentRepository\DimensionSpace\DimensionSpace\DimensionSpacePoint;
use Neos\EventSourcedContentRepository\Domain\Context\NodeAggregate\NodeAggregateIdentifier;
use Neos\EventSourcedContentRepository\Domain\ValueObject\NodeName;
use Neos\EventSourcedContentRepository\Domain\ValueObject\NodePath;
use Neos\EventSourcedContentRepository\Domain\ValueObject\NodeTypeConstraints;
use Neos\EventSourcedContentRepository\Domain\ValueObject\NodeTypeName;
use Neos\Cache\CacheAwareInterface;

/**
 * A convenience wrapper.
 *
 * Immutable. Read-only. With traversal operations.
 *
 * !! Reference resolving happens HERE!
 */
interface TraversableNodeInterface extends NodeInterface
{

    public function getSubgraph(): ContentSubgraphInterface;
    public function getContextParameters(): Domain\Context\Parameters\ContextParameters;

    public function getParent(): ?TraversableNodeInterface;

    public function getNodePath(): NodePath;

    public function findNamedChildNode(NodeName $nodeName): ?TraversableNodeInterface;

    /**
     * Returns all direct child nodes of this node.
     * If a node type is specified, only nodes of that type are returned.
     *
     * @param NodeTypeConstraints If specified, only nodes with that node type are considered
     * @param integer $limit An optional limit for the number of nodes to find. Added or removed nodes can still change the number nodes!
     * @param integer $offset An optional offset for the query
     * @return array<TraversableNodeInterface>|TraversableNodeInterface[] An array of nodes or an empty array if no child nodes matched
     * @api
     */
    public function getChildNodes(NodeTypeConstraints $nodeTypeConstraints = null, $limit = null, $offset = null);
}
