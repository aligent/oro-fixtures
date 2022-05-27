<?php

namespace Aligent\FixturesBundle\Initializer;

use Doctrine\Common\Collections\Collection;
use Doctrine\Persistence\ObjectManager;
use Oro\Bundle\WarehouseBundle\Entity\Repository\WarehouseRepository;
use Oro\Bundle\WarehouseBundle\Entity\Warehouse;

class WarehouseInitializer implements ReferenceInitializerInterface
{
    use NameNormalizerTrait;

    public function init(ObjectManager $manager, Collection $referenceRepository): void
    {
        /** @var WarehouseRepository $repo */
        $repo = $manager->getRepository(Warehouse::class);

        /** @var Warehouse $warehouse */
        foreach ($repo->findAll() as $warehouse) {
            $referenceRepository->set(
                'warehouse_' . $this->normalizeName($warehouse->getName()),
                $warehouse
            );
        }
    }
}
