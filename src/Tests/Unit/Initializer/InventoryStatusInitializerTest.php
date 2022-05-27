<?php
namespace Aligent\FixturesBundle\Tests\Unit\Initializer;

use Aligent\FixturesBundle\Initializer\InventoryStatusInitializer;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ObjectManager;
use Oro\Bundle\EntityExtendBundle\Entity\AbstractEnumValue;
use Oro\Bundle\EntityExtendBundle\Entity\Repository\EnumValueRepository;
use PHPUnit\Framework\TestCase;

class InventoryStatusInitializerTest extends TestCase
{
    public function testInit(): void
    {
        $initializer = new InventoryStatusInitializer();
        $collection = new ArrayCollection();

        $manager = $this->createMock(ObjectManager::class);
        $repo = $this->createMock(EnumValueRepository::class);
        $mockBuilder = $this->getMockBuilder(AbstractEnumValue::class);

        $enums['inventory_status_in_stock'] = $mockBuilder
            ->setConstructorArgs(['in_stock', 'In Stock'])
            ->getMockForAbstractClass();

        $manager->expects($this->once())
            ->method('getRepository')
            ->willReturn($repo);

        $repo->expects($this->once())
            ->method('findAll')
            ->willReturn(array_values($enums));


        $initializer->init($manager, $collection);

        $this->assertEquals(
            $enums,
            $collection->toArray()
        );
    }
}
