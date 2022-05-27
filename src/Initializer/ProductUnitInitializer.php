<?php

namespace Aligent\FixturesBundle\Initializer;

use Doctrine\Common\Collections\Collection;
use Doctrine\Persistence\ObjectManager;
use Oro\Bundle\ProductBundle\Entity\ProductUnit;

class ProductUnitInitializer implements ReferenceInitializerInterface
{
    public function init(ObjectManager $manager, Collection $referenceRepository): void
    {
        $repo = $manager->getRepository(ProductUnit::class);
        $productUnits = $repo->findAll();

        /** @var ProductUnit $productUnit */
        foreach ($productUnits as $productUnit) {
            $referenceRepository->set(
                'unit_' . $productUnit->getCode(),
                $productUnit
            );
        }
    }
}
