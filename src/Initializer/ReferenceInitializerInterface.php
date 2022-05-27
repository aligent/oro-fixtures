<?php

namespace Aligent\FixturesBundle\Initializer;

use Doctrine\Common\Collections\Collection;
use Doctrine\Persistence\ObjectManager;

interface ReferenceInitializerInterface
{
    /**
     * @param ObjectManager $manager
     * @param Collection<string, object> $referenceRepository
     * @return void
     */
    public function init(ObjectManager $manager, Collection $referenceRepository): void;
}
