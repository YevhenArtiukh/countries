<?php

namespace App\DataFixtures;

use App\Entity\Users\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $admin = new User(
            'admin',
            'admin',
            25,
            'admintest@gmail.com',
            'admin',
            'admin',
            null
        );
        $admin->confirmed();
        $admin->setRole(User::ROLE_ADMIN);
        $manager->persist($admin);

        $user = new User(
            'user',
            'user',
            25,
            'usertest@gmail.com',
            'user',
            'user',
            null
        );
        $user->confirmed();
        $manager->persist($user);

        $manager->flush();
    }
}
