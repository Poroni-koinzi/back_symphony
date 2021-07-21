<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Fake;
use App\Entity\User;
use Faker\Factory;
class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    public function load(ObjectManager $manager)
    {
        // On configure dans quelles langues nous voulons nos données
        $roles = ["USER_ROLE"];
        // on créé 10 users
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setEmail(sprintf('userdemo%d@example.com', $i));
            $user->setRoles($roles);
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'userdemo'
            ));
            $manager->persist($user);
        }

        $manager->flush();

    }
}
