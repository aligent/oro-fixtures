<?php

namespace Aligent\FixturesBundle\Initializer;

use Doctrine\Common\Collections\Collection;
use Doctrine\Persistence\ObjectManager;
use Oro\Bundle\EntityExtendBundle\Entity\AbstractEnumValue;
use Oro\Bundle\EntityExtendBundle\Entity\Repository\EnumValueRepository;
use Oro\Bundle\EntityExtendBundle\Tools\ExtendHelper;

class InventoryStatusInitializer implements ReferenceInitializerInterface
{
    public function init(ObjectManager $manager, Collection $referenceRepository): void
    {
        $entityName = ExtendHelper::buildEnumValueClassName('prod_inventory_status');
        /** @var EnumValueRepository $repo */
        $repo = $manager->getRepository($entityName);

        /** @var AbstractEnumValue $inventoryStatus */
        foreach ($repo->findAll() as $inventoryStatus) {
            $referenceRepository->set(
                'inventory_status_' . $inventoryStatus->getId(),
                $inventoryStatus
            );
        }
    }
}
