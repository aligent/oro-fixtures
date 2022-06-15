<?php

namespace Aligent\FixturesBundle\Initializer;

use Doctrine\Common\Collections\Collection;
use Doctrine\Persistence\ObjectManager;
use Oro\Bundle\CatalogBundle\Provider\MasterCatalogRootProviderInterface;

class RootCategoryInitializer implements ReferenceInitializerInterface
{
    protected MasterCatalogRootProviderInterface $catalogRootProvider;

    /**
     * @param MasterCatalogRootProviderInterface $catalogRootProvider
     */
    public function __construct(MasterCatalogRootProviderInterface $catalogRootProvider)
    {
        $this->catalogRootProvider = $catalogRootProvider;
    }

    public function init(ObjectManager $manager, Collection $referenceRepository): void
    {
        $rootCategory = $this->catalogRootProvider->getMasterCatalogRoot();
        $referenceRepository->set(
            'root_category',
            $rootCategory
        );
    }
}
