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
            'password' => 'Secret42069',
            'roles' => [User::ROLE_SUPERADMIN]
        ],
        [
            'username' => 'john_doe',
            'email' => 'john_doe@not.es',
            'name' => 'John Doe',
            'password' => 'Secret42069',
            'roles' => [User::ROLE_ADMIN]
        ], 
        [
            'username' => 'rob_smith',
            'email' => 'rob_smith@not.es',
            'name' => 'Rob Smith',
            'password' => 'Secret42069',
            'roles' => [User::ROLE_WRITER]
        ],  
        [
            'username' => 'mike_hawk',
            'email' => 'mike_hawk@not.es',
            'name' => 'Mike Hawk',
            'password' => 'Secret42069',
            'roles' => [User::ROLE_WRITER]
        ],  
        [
            'username' => 'hans_hawk',
            'email' => 'hans_hawk@not.es',
            'name' => 'Hans Hawk',
            'password' => 'Secret42069',
            'roles' => [User::ROLE_EDITOR]
        ],  
        [
            'username' => 'hans_duo',
            'email' => 'hans_duo@not.es',
            'name' => 'Hans Duo',
            'password' => 'Secret42069',
            'roles' => [User::ROLE_EDITOR]
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
        for ($i = 0; $i < 100; $i++) {
            $note = new Note();
            $note->setTitle($this->faker->realText(30));
            $note->setTaken($this->faker->dateTimeThisYear);
            $note->setContent($this->faker->realText());

            $authorReference = $this->getRandomUserReference($note);
            $note->setUser($authorReference);
            
            $this->setReference("note_$i", $note); 

            $manager->persist($note);
        }
        $manager->flush();
    }

    public function loadUsers(ObjectManager $manager) {
        foreach (self::USERS as $userFixture) {
            $user = new User();
            $user->setUsername($userFixture['username']);
            $user->setEmail($userFixture['email']);
            $user->setName($userFixture['name']);
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                $userFixture['password']
            ));

            $user->setRoles($userFixture['roles']);

            $this->addReference('user_' . $userFixture['username'], $user);

            $manager->persist($user);
        }
        
        $manager->flush();
    }

    protected function getRandomUserReference($entity): User {
        $randomUser = self::USERS[rand(0, 5)];

        if($entity instanceof Note && !count(array_intersect(
                $randomUser['roles'],
                [User::ROLE_SUPERADMIN, User::ROLE_ADMIN, User::ROLE_WRITER]
            ))) {
            return $this->getRandomUserReference($entity);
        }

        return $this->getReference(
            'user_'.$randomUser['username']
        );
    }
}
