<?php

namespace Aligent\FixturesBundle\Initializer;

use Doctrine\Common\Collections\Collection;
use Oro\Bundle\CustomerBundle\Entity\CustomerUserRole;
use Doctrine\Persistence\ObjectManager;

class CustomerUserRoleInitializer implements ReferenceInitializerInterface
{
    public function init(ObjectManager $manager, Collection $referenceRepository): void
    {
        $repo = $manager->getRepository(CustomerUserRole::class);

        /** @var CustomerUserRole $userRole */
        foreach ($repo->findAll() as $userRole) {
            $referenceRepository->set(
                strtolower($userRole->getRole()),
                $userRole
            );
        }
    }
}
