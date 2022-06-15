<?php

namespace Aligent\FixturesBundle\Initializer;

use Doctrine\Common\Collections\Collection;
use Doctrine\Persistence\ObjectManager;
use Oro\Bundle\PricingBundle\Entity\Repository\PriceListRepository;
use Oro\Bundle\PricingBundle\Entity\PriceList;

class DefaultPriceListInitializer implements ReferenceInitializerInterface
{
    public function init(ObjectManager $manager, Collection $referenceRepository): void
    {
        /** @var PriceListRepository $repo */
        $repo = $manager->getRepository(PriceList::class);
        $defaultPriceList = $repo->getDefault();
        $referenceRepository->set(
            'default_price_list',
            $defaultPriceList
        );
    }
}
