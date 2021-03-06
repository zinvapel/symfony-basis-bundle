<?php
declare(strict_types=1);

namespace Zinvapel\Basis\OpenApiAssertionBundle\Proto\Generate\Builder\BuildContext;

use Doctrine\Common\Collections\ArrayCollection;
use Zinvapel\Basis\OpenApiAssertionBundle\Proto\Generate\Builder\NameJoinStrategy\JoinStrategyInterface;
use Zinvapel\Basis\OpenApiAssertionBundle\Proto\Generate\SchemaWrapper\Dto\SchemaWrapperDto;

final class BuildContext
{
    private SchemaWrapperDto $schema;
    private Names $names;
    private JoinStrategyInterface $joinStrategy;
    private ArrayCollection $knownObjects;
    private array $serializationGroups = [];

    /**
     * @todo refactor
     */
    private ?BuildContext $parent = null;

    public function __construct(SchemaWrapperDto $schema, Names $names, JoinStrategyInterface $joinStrategy)
    {
        $this->schema = $schema;
        $this->names = $names;
        $this->joinStrategy = $joinStrategy;
        $this->knownObjects = new ArrayCollection();
    }

    public function withNames(Names $names): BuildContext
    {
        return
            (new self($this->schema, $names, $this->joinStrategy))
                ->setSerializationGroups($this->serializationGroups)
                ->setParent($this)
            ;
    }

    public function getSchema(): SchemaWrapperDto
    {
        return $this->schema;
    }

    public function getNames(): Names
    {
        return $this->names;
    }

    public function getJoinStrategy(): JoinStrategyInterface
    {
        return $this->joinStrategy;
    }

    public function getKnownObjects(): ArrayCollection
    {
        if ($this->parent !== null) {
            return $this->parent->getKnownObjects();
        }

        return $this->knownObjects;
    }

    public function getSerializationGroups(): array
    {
        return $this->serializationGroups;
    }

    public function setSerializationGroups(array $serializationGroups): self
    {
        $this->serializationGroups = $serializationGroups;

        return $this;
    }

    private function setParent(?BuildContext $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    public function getParent(): ?BuildContext
    {
        return $this->parent;
    }
}