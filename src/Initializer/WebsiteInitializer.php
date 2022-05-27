<?php

namespace Aligent\FixturesBundle\Initializer;

use Doctrine\Common\Collections\Collection;
use Doctrine\Persistence\ObjectManager;
use Oro\Bundle\WebsiteBundle\Entity\Website;

class WebsiteInitializer implements ReferenceInitializerInterface
{
    use NameNormalizerTrait;
    public function init(ObjectManager $manager, Collection $referenceRepository): void
    {
        $repo = $manager->getRepository(Website::class);

        /** @var Website $website */
        foreach ($repo->findAll() as $website) {
            $referenceRepository->set(
                'website_' .  $this->normalizeName($website->getName()),
                $website
            );
        }
    }
}
