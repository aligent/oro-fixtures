<?php

namespace Aligent\FixturesBundle\Initializer;

use Doctrine\Common\Collections\Collection;
use Oro\Bundle\CustomerBundle\Entity\CustomerGroup;
use Doctrine\Persistence\ObjectManager;

class CustomerGroupInitializer implements ReferenceInitializerInterface
{
    use NameNormalizerTrait;

    public function init(ObjectManager $manager, Collection $referenceRepository): void
    {
        $repo = $manager->getRepository(CustomerGroup::class);

        /** @var CustomerGroup $customerGroup */
        foreach ($repo->findAll() as $customerGroup) {
            $referenceRepository->set(
                'group_' . $this->normalizeName($customerGroup->getName()),
                $customerGroup
            );
        }
    }
}
