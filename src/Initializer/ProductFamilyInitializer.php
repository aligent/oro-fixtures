<?php

namespace Aligent\FixturesBundle\Initializer;

use Doctrine\Common\Collections\Collection;
use Doctrine\Persistence\ObjectManager;
use Oro\Bundle\EntityConfigBundle\Attribute\Entity\AttributeFamily;

class ProductFamilyInitializer implements ReferenceInitializerInterface
{
    public function init(ObjectManager $manager, Collection $referenceRepository): void
    {
        $repo = $manager->getRepository(AttributeFamily::class);

        /** @var AttributeFamily $family */
        foreach ($repo->findAll() as $family) {
            $referenceRepository->set(
                'product_family_' . $family->getCode(),
                $family
            );
        }
    }
}
