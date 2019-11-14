<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $manager;
    private $faker;
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->faker=factory::create("fr_FR");
        $this->passwordEncoder=$passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $this->manager=$manager;
        $this->loadUser();
        $manager->flush();
    }


    public function loadUser(){
        $genre="male";
        for($i=0;$i<25;$i++){
          $user=new User();
          $user ->setName($this->faker->lastName())
                ->setPrenom($this->faker->firstName($genre))
                ->setEmail(strtolower($user->getName())."@gmail.com")
                ->setPassword($this->passwordEncoder->encodePassword($user,$user->getName()));
          $this->addReference("users".$i,$user);
          $this->manager->persist($user);
        }
        $user=new User();
        $user ->setName("SuperUser")
            ->setPrenom("Peter")
            ->setEmail("admin@gmail.com")
            ->setPassword("Peter");
        $this->manager->persist($user);
        $this->manager->flush();

    }
}
