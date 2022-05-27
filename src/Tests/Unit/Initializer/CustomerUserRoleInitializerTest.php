<?php
namespace Aligent\FixturesBundle\Tests\Unit\Initializer;

use Aligent\FixturesBundle\Initializer\CustomerUserRoleInitializer;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ObjectManager;
use Oro\Bundle\CustomerBundle\Entity\CustomerUserRole;
use Oro\Bundle\CustomerBundle\Entity\Repository\CustomerUserRoleRepository;
use PHPUnit\Framework\TestCase;

class CustomerUserRoleInitializerTest extends TestCase
{
    public function testInit(): void
    {
        $initializer = new CustomerUserRoleInitializer();
        $collection = new ArrayCollection();

        $manager = $this->createMock(ObjectManager::class);
        $repo = $this->createMock(CustomerUserRoleRepository::class);

        $entities = [
            'role_frontend_administrator' => (new CustomerUserRole('ADMINISTRATOR')),
            'role_frontend_buyer' => (new CustomerUserRole('BUYER')),
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
