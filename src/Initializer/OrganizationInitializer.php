<?php

namespace Aligent\FixturesBundle\Initializer;

use Doctrine\Common\Collections\Collection;
use Doctrine\Persistence\ObjectManager;
use Oro\Bundle\OrganizationBundle\Entity\Organization;
use Oro\Bundle\OrganizationBundle\Entity\Repository\OrganizationRepository;

class OrganizationInitializer implements ReferenceInitializerInterface
{
    use NameNormalizerTrait;

    public function init(ObjectManager $manager, Collection $referenceRepository): void
    {
        /** @var OrganizationRepository $repo */
        $repo = $manager->getRepository(Organization::class);
        $organizations = $repo->findAll();

        if (count($organizations) == 1) {
            $referenceRepository->set(
                'default_organization',
                $organizations[0]
            );
        } else {
            /** @var Organization $organization */
            foreach ($organizations as $organization) {
                $referenceRepository->set(
                    'org_' . $this->normalizeName($organization->getName()),
                    $organization
                );
            }
        }
    }
}
