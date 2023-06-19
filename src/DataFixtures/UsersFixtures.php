<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\Users;
use Faker;

class UsersFixtures extends Fixture
{
    private $counter = 1;
    
    public function __construct(private UserPasswordHasherInterface $passwordEncoder)
    {
        //
    }
    
    public function load(ObjectManager $manager): void
    {
        $admin = new Users();

        $admin->setEmail("kevinferrogl@gmail.com");
        $admin->setUsername("Vinke013");
        $admin->setGender("man");
        $admin->setBirthdate(new \DateTimeImmutable("1988-04-02T00:00:00"));
        $admin->setPostal("13011");
        $admin->setCity("Marseille");
        $admin->setSearch("woman");
        $admin->setIsAdmin(true);

        $admin->setPassword(
            $this->passwordEncoder->hashPassword($admin, "admin")
        );
        $admin->setRoles(["ROLE_ADMIN"]);

        $manager->persist($admin);

        $faker = Faker\Factory::create("fr-FR");

        for($i=1; $i<=5; $i++)
        {
            $user = new Users();

            $user->setEmail($faker->email());
            $user->setUsername($faker->firstname());
            $user->setGender("man");
            $user->setBirthdate($faker->dateTime());
            $user->setPostal($faker->postCode());
            $user->setCity($faker->city());
            $user->setSearch("woman");

            $user->setPassword(
                $this->passwordEncoder->hashPassword($user, "secret")
            );
            $user->setRoles(["ROLE_USER"]);

            $manager->persist($user);

            $this->addReference("user-" . $this->counter, $user);
            $this->counter++;
        }

        $manager->flush();
    }
}
