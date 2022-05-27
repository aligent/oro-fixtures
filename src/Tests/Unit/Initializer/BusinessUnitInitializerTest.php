<?php
namespace Aligent\FixturesBundle\Tests\Unit\Initializer;

use Aligent\FixturesBundle\Initializer\BusinessUnitInitializer;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ObjectManager;
use Oro\Bundle\OrganizationBundle\Entity\BusinessUnit;
use Oro\Bundle\OrganizationBundle\Entity\Repository\BusinessUnitRepository;
use PHPUnit\Framework\TestCase;

class BusinessUnitInitializerTest extends TestCase
{
    public function testInit(): void
    {
        $initializer = new BusinessUnitInitializer();
        $collection = new ArrayCollection();

        $manager = $this->createMock(ObjectManager::class);
        $repo = $this->createMock(BusinessUnitRepository::class);

        $businessUnits = [
            'test_a_business_unit' => (new BusinessUnit())->setName('Test A'),
            'test_b_business_unit' => (new BusinessUnit())->setName('Test B'),
            'test_c_business_unit' => (new BusinessUnit())->setName('Test C')
        ];

        $manager->expects($this->once())
            ->method('getRepository')
            ->willReturn($repo);

        $repo->expects($this->once())
            ->method('findAll')
            ->willReturn(array_values($businessUnits));


        $initializer->init($manager, $collection);

        $this->assertEquals(
            $businessUnits,
            $collection->toArray()
        );
    }

}
