<?php
namespace Aligent\FixturesBundle\Tests\Unit\Initializer;

use Aligent\FixturesBundle\Initializer\ProductFamilyInitializer;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ObjectManager;
use Oro\Bundle\EntityConfigBundle\Attribute\Entity\AttributeFamily;
use Oro\Bundle\EntityConfigBundle\Entity\Repository\AttributeFamilyRepository;
use PHPUnit\Framework\TestCase;

class ProductFamilyInitializerTest extends TestCase
{
    public function testInit(): void
    {
        $initializer = new ProductFamilyInitializer();
        $collection = new ArrayCollection();

        $manager = $this->createMock(ObjectManager::class);
        $repo = $this->createMock(AttributeFamilyRepository::class);

        $entities = [
            'product_family_default' => (new AttributeFamily())->setCode('default'),
            'product_family_secondary' => (new AttributeFamily())->setCode('secondary'),
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
