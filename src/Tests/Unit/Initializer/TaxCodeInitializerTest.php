<?php
namespace Aligent\FixturesBundle\Tests\Unit\Initializer;

use Aligent\FixturesBundle\Initializer\TaxCodeInitializer;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ObjectManager;
use Oro\Bundle\TaxBundle\Entity\CustomerTaxCode;
use Oro\Bundle\TaxBundle\Entity\Repository\CustomerTaxCodeRepository;
use PHPUnit\Framework\TestCase;

class TaxCodeInitializerTest extends TestCase
{
    public function testInit(): void
    {
        $initializer = new TaxCodeInitializer();
        $collection = new ArrayCollection();

        $manager = $this->createMock(ObjectManager::class);
        $repo = $this->createMock(CustomerTaxCodeRepository::class);

        $entities = [
            'tax_code_gst' => (new CustomerTaxCode())->setCode('GST'),
            'tax_code_gst_free' => (new CustomerTaxCode())->setCode('GST_FREE'),
        ];

        $manager->expects($this->once())
            ->method('getRepository')
            ->willReturn($repo);

        $repo->expects($this->once())
            ->method('findAll')
            ->willReturn(array_values($entities));


        $initializer->init($manager, $collection);

        $this->assertEquals(
            $entities,
            $collection->toArray()
        );
    }

}
