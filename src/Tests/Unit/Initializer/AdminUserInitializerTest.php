<?php
namespace Aligent\FixturesBundle\Tests\Unit\Initializer;

use Aligent\FixturesBundle\Initializer\AdminUserInitializer;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ObjectManager;
use Oro\Bundle\UserBundle\Entity\Repository\RoleRepository;
use Oro\Bundle\UserBundle\Entity\User;
use Oro\Bundle\UserBundle\Tests\Unit\Stub\RoleStub;
use Oro\Bundle\UserBundle\Tests\Unit\Stub\UserStub;
use PHPUnit\Framework\TestCase;

class AdminUserInitializerTest extends TestCase
{
    public function testInit(): void
    {
        $initializer = new AdminUserInitializer();
        $collection = new ArrayCollection();

        $manager = $this->createMock(ObjectManager::class);
        $repo = $this->createMock(RoleRepository::class);

        $user = new UserStub();
        $user->setUsername('admin');
        $role = new RoleStub(User::ROLE_ADMINISTRATOR);

        $manager->expects($this->once())
            ->method('getRepository')
            ->willReturn($repo);

        $repo->expects($this->once())
            ->method('findOneBy')
            ->willReturn($role);

        $repo->expects($this->once())
            ->method('getFirstMatchedUser')
            ->willReturn($user);

        $initializer->init($manager, $collection);

        $this->assertArrayHasKey(
            'admin_user',
            $collection->toArray()
        );

        $this->assertEquals($user, $collection->get('admin_user'));
    }

    public function testInitRoleMissing(): void
    {
        $initializer = new AdminUserInitializer();
        $collection = new ArrayCollection();
        $manager = $this->createMock(ObjectManager::class);
        $repo = $this->createMock(RoleRepository::class);

        $manager->expects($this->once())
            ->method('getRepository')
            ->willReturn($repo);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Administrator role should exist.');

        $initializer->init($manager, $collection);
    }

    public function testInitUserMissing(): void
    {
        $initializer = new AdminUserInitializer();
        $collection = new ArrayCollection();
        $manager = $this->createMock(ObjectManager::class);
        $repo = $this->createMock(RoleRepository::class);

        $role = new RoleStub(User::ROLE_ADMINISTRATOR);

        $manager->expects($this->once())
            ->method('getRepository')
            ->willReturn($repo);

        $repo->expects($this->once())
            ->method('findOneBy')
            ->willReturn($role);

        $repo->expects($this->once())
            ->method('getFirstMatchedUser')
            ->willReturn(null);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Administrator user should exist to load test data.');

        $initializer->init($manager, $collection);
    }
}
