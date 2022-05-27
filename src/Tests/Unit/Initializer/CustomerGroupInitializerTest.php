<?php
namespace Aligent\FixturesBundle\Tests\Unit\Initializer;

use Aligent\FixturesBundle\Initializer\CustomerGroupInitializer;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ObjectManager;
use Oro\Bundle\CustomerBundle\Entity\CustomerGroup;
use Oro\Bundle\CustomerBundle\Entity\Repository\CustomerGroupRepository;
use PHPUnit\Framework\TestCase;

class CustomerGroupInitializerTest extends TestCase
{
    public function testInit(): void
    {
        $initializer = new CustomerGroupInitializer();
        $collection = new ArrayCollection();

        $manager = $this->createMock(ObjectManager::class);
        $repo = $this->createMock(CustomerGroupRepository::class);

        $entities = [
            'group_test_a' => (new CustomerGroup())->setName('Test A'),
            'group_test_b' => (new CustomerGroup())->setName('Test B'),
            'group_test_c' => (new CustomerGroup())->setName('Test C')
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
