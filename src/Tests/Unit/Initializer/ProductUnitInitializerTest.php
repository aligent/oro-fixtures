<?php
namespace Aligent\FixturesBundle\Tests\Unit\Initializer;

use Aligent\FixturesBundle\Initializer\ProductUnitInitializer;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ObjectManager;
use Oro\Bundle\EntityConfigBundle\Entity\Repository\AttributeFamilyRepository;
use Oro\Bundle\ProductBundle\Entity\ProductUnit;
use PHPUnit\Framework\TestCase;

class ProductUnitInitializerTest extends TestCase
{
    public function testInit(): void
    {
        $initializer = new ProductUnitInitializer();
        $collection = new ArrayCollection();

        $manager = $this->createMock(ObjectManager::class);
        $repo = $this->createMock(AttributeFamilyRepository::class);

        $entities = [
            'unit_each' => (new ProductUnit())->setCode('each'),
            'unit_metre' => (new ProductUnit())->setCode('metre'),
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
