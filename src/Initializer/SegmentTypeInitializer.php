<?php

namespace Aligent\FixturesBundle\Initializer;

use Doctrine\Common\Collections\Collection;
use Doctrine\Persistence\ObjectManager;
use Oro\Bundle\EntityConfigBundle\Attribute\Entity\AttributeFamily;
use Oro\Bundle\SegmentBundle\Entity\SegmentType;

class SegmentTypeInitializer implements ReferenceInitializerInterface
{
    public function init(ObjectManager $manager, Collection $referenceRepository): void
    {
        $repo = $manager->getRepository(SegmentType::class);

        /** @var SegmentType $type */
        foreach ($repo->findAll() as $type) {
            $referenceRepository->set(
                $type->getName() . '_segment_type',
                $type
            );
        }
    }
}
