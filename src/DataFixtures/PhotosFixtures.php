<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Photos;
use Faker;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class PhotosFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create("fr-FR");
        
        for($i=0; $i<20; $i++)
        {
            $photo = new Photos();

            $photo->setPath($faker->imageURL(640, 480, "cars", true));

            $user = $this->getReference("user-" . rand(1, 3));

            $photo->setUserId($user);

            $manager->persist($photo);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UsersFixtures::class
        ];
    }
}