<?php

namespace Aligent\FixturesBundle\Initializer;

use Doctrine\Common\Collections\Collection;
use Doctrine\Persistence\ObjectManager;
use Oro\Bundle\UserBundle\Entity\Repository\RoleRepository;
use Oro\Bundle\UserBundle\Entity\Role;
use Oro\Bundle\UserBundle\Entity\User;

class AdminUserInitializer implements ReferenceInitializerInterface
{
    public function init(ObjectManager $manager, Collection $referenceRepository): void
    {
        $adminUser = $this->getAdminUser($manager);

        $referenceRepository->set(
            'admin_user',
            $adminUser
        );
    }

    /**
     * @param ObjectManager $manager
     * @return User
     * @throws \InvalidArgumentException
     */
    private function getAdminUser(ObjectManager $manager): User
    {
        /** @var RoleRepository $repository */
        $repository = $manager->getRepository(Role::class);
        $role = $repository->findOneBy(['role' => User::ROLE_ADMINISTRATOR]);

        if (!$role) {
            throw new \InvalidArgumentException('Administrator role should exist.');
        }

        /** @var User|null $user - Functions return type is incorrect */
        $user = $repository->getFirstMatchedUser($role);

        if (!$user) {
            throw new \InvalidArgumentException(
                'Administrator user should exist to load test data.'
            );
        }

        return $user;
    }
}
