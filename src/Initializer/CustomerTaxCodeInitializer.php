<?php

namespace Aligent\FixturesBundle\Initializer;

use Doctrine\Common\Collections\Collection;
use Doctrine\Persistence\ObjectManager;
use Oro\Bundle\TaxBundle\Entity\CustomerTaxCode;

class CustomerTaxCodeInitializer implements ReferenceInitializerInterface
{
    public function init(ObjectManager $manager, Collection $referenceRepository): void
    {
        $repo = $manager->getRepository(CustomerTaxCode::class);

        /** @var CustomerTaxCode $taxCode */
        foreach ($repo->findAll() as $taxCode) {
            $referenceRepository->set(
                'customer_tax_code_' . strtolower($taxCode->getCode()),
                $taxCode
            );
        }
    }
}
