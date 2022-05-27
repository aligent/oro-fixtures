<?php

namespace Aligent\FixturesBundle\Initializer;

use Doctrine\Common\Collections\Collection;
use Doctrine\Persistence\ObjectManager;
use Oro\Bundle\OrganizationBundle\Entity\BusinessUnit;

class BusinessUnitInitializer implements ReferenceInitializerInterface
{
    use NameNormalizerTrait;

    public function init(ObjectManager $manager, Collection $referenceRepository): void
    {
        $repo = $manager->getRepository(BusinessUnit::class);
        $businessUnits = $repo->findAll();

        /** @var BusinessUnit $businessUnit */
        foreach ($businessUnits as $businessUnit) {
            $referenceRepository->set(
                $this->normalizeName($businessUnit->getName()) . '_business_unit',
                $businessUnit
            );
        }
    }
}
