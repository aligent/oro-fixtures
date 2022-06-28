<?php

namespace Aligent\FixturesBundle\Initializer;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Persistence\ObjectManager;

class ReferenceInitializer implements ReferenceInitializerInterface
{
    /**
     * @var iterable<ReferenceInitializerInterface>
     */
    protected iterable $initializers = [];

    /**
     * @param iterable<ReferenceInitializerInterface> $initializers
     */
    public function __construct(iterable $initializers)
    {
        $this->initializers = $initializers;
    }

    /**
     * @return iterable<ReferenceInitializerInterface>
     */
    public function getInitializers(): iterable
    {
        return $this->initializers;
    }

    public function init(ObjectManager $manager, Collection $referenceRepository): void
    {
        foreach ($this->getInitializers() as $initializer) {
            $initializer->init($manager, $referenceRepository);
        }
    }
}
