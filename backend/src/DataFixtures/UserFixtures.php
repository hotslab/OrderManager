<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager): void
    {
        $userManager = $manager->getRepository(User::class);
        $userExists = $userManager->findOneBy(['email' => 'chris@ordermanager.com']);
        if (!$userExists) {
            $user = new User;
            $user->setName('Chris');
            $user->setSurname('Willis');
            $user->setEmail('chris@ordermanager.com');
            $user->setRoles(['ROLE_ADMIN']);
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'secret'
             ));
            $manager->persist($user);
        }
        $manager->flush();
    }
}
