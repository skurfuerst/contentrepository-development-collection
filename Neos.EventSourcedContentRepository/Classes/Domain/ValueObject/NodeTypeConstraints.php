<?php

namespace Neos\EventSourcedContentRepository\Domain\ValueObject;

/*
 * This file is part of the Neos.ContentRepository package.
 *
 * (c) Contributors of the Neos Project - www.neos.io
 *
 * This package is Open Source Software. For the full copyright and license
 * information, please view the LICENSE file which was distributed with this
 * source code.
 */
use Neos\Flow\Annotations as Flow;

/**
 * The node type constraints value object
 */
final class NodeTypeConstraints
{
    /**
     * @var bool
     */
    protected $wildcardAllowed;

    /**
     * @var array|NodeTypeName[]
     */
    protected $explicitlyAllowedNodeTypeNames;

    /**
     * @var array|NodeTypeName[]
     */
    protected $explicitlyDisallowedNodeTypeNames;


    /**
     * @param bool $wildCardAllowed
     * @param array $explicitlyAllowedNodeTypeNames
     * @param array $explicitlyDisallowedNodeTypeNames
     */
    public function __construct(bool $wildCardAllowed, array $explicitlyAllowedNodeTypeNames = [], array $explicitlyDisallowedNodeTypeNames = [])
    {
        $this->wildcardAllowed = $wildCardAllowed;
        $this->explicitlyAllowedNodeTypeNames = $explicitlyAllowedNodeTypeNames;
        $this->explicitlyDisallowedNodeTypeNames = $explicitlyDisallowedNodeTypeNames;
    }

    /**
     * @return bool
     */
    public function isWildcardAllowed(): bool
    {
        return $this->wildcardAllowed;
    }

    /**
     * @return array|NodeTypeName[]
     */
    public function getExplicitlyAllowedNodeTypeNames(): array
    {
        return $this->explicitlyAllowedNodeTypeNames;
    }

    /**
     * @return array|NodeTypeName[]
     */
    public function getExplicitlyDisallowedNodeTypeNames(): array
    {
        return $this->explicitlyDisallowedNodeTypeNames;
    }

    public function matches(NodeTypeName $nodeTypeName)
    {
        // if $nodeTypeName is explicitely blacklisted, it is DENIED.
        foreach ($this->explicitlyDisallowedNodeTypeNames as $disallowed) {
            if ((string)$nodeTypeName === (string)$disallowed) {
                return false;
            }
        }

        // if $nodeTypeName is explicitely whitelisted, it is ALLOWED.
        foreach ($this->explicitlyAllowedNodeTypeNames as $allowed) {
            if ((string)$nodeTypeName === (string)$allowed) {
                return true;
            }
        }

        // otherwise, we return $wildcardAllowed.
        return $this->wildcardAllowed;
    }


    /**
     * IMMUTABLE, returns a new instance
     *
     * @param NodeTypeName $nodeTypeName
     * @return NodeTypeConstraints
     */
    public function withExplicitlyDisallowedNodeType(NodeTypeName $nodeTypeName): NodeTypeConstraints
    {
        $disallowedNodeTypeNames = $this->explicitlyDisallowedNodeTypeNames;
        $disallowedNodeTypeNames[] = $nodeTypeName;
        return new NodeTypeConstraints($this->wildcardAllowed, $this->explicitlyAllowedNodeTypeNames, $disallowedNodeTypeNames);
    }
}
