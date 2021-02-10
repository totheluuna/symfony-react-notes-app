<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use App\Entity\Note;
use App\Entity\User;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * @var \Faker\Factory
     */
    private $faker;

    private const USERS = [
        [
            'username' => 'admin42069',
            'email' => 'admin42069@not.es',
            'name' => 'Admin42069 User',
            'password' => 'Secret42069'
        ],
        [
            'username' => 'john_doe',
            'email' => 'john_doe@not.es',
            'name' => 'John Doe',
            'password' => 'Secret42069'

        ], 
        [
            'username' => 'rob_smith',
            'email' => 'rob_smith@not.es',
            'name' => 'Rob Smith',
            'password' => 'Secret42069'

        ],  
        [
            'username' => 'mike_hawk',
            'email' => 'mike_hawk@not.es',
            'name' => 'Mike Hawk',
            'password' => 'Secret42069'

        ] 
    ];

    public function __construct(UserPasswordEncoderInterface $passwordEncoder) {
        $this->passwordEncoder = $passwordEncoder;
        $this->faker = \Faker\Factory::create();
    }

    /**
     * Load data fixtures with the passed EntityManager
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
        $this->loadNotes($manager);
        
    }

    public function loadNotes(ObjectManager $manager) {
        $user = $this->getReference('admin');

        for ($i = 0; $i < 100; $i++) {
            $note = new Note();
            $note->setTitle($this->faker->realText(30));
            $note->setTaken($this->faker->dateTimeThisYear);
            $note->setContent($this->faker->realText());
            $note->setUser($user);
            
            $this->setReference("note_$i", $note); 

            $manager->persist($note);
        }
        $manager->flush();
    }

    public function loadUsers(ObjectManager $manager) {
        $user = new User();
        $user->setUsername('admin');
        $user->setEmail('admin@not.es');
        $user->setName('John Doe');
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'admin42069'
        ));

        $this->addReference('admin', $user);

        $manager->persist($user);
        $manager->flush();
    }
}
