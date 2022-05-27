<?php
namespace Aligent\FixturesBundle\Tests\Unit\Initializer;

use Aligent\FixturesBundle\Initializer\OrganizationInitializer;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ObjectManager;
use Oro\Bundle\OrganizationBundle\Entity\Organization;
use Oro\Bundle\OrganizationBundle\Entity\Repository\OrganizationRepository;
use PHPUnit\Framework\TestCase;

class OrganizationInitializerTest extends TestCase
{
    public function testInitWithSingleOrg(): void
    {
        $initializer = new OrganizationInitializer();
        $collection = new ArrayCollection();

        $manager = $this->createMock(ObjectManager::class);
        $repo = $this->createMock(OrganizationRepository::class);

        $entities = [
            'default_organization' => new Organization()
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

    public function testInitWithMultiOrg(): void
    {
        $initializer = new OrganizationInitializer();
        $collection = new ArrayCollection();

        $manager = $this->createMock(ObjectManager::class);
        $repo = $this->createMock(OrganizationRepository::class);

        $entities = [
            'org_test1' => (new Organization())->setName('Test 1'),
            'org_test2' => (new Organization())->setName('Test 2')
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
