<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Note;

class AppFixtures extends Fixture
{
    /**
     * Load data fixtures with the passed EntityManager
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $note = new Note();
        $note->setTitle('A first note!');
        $note->setTaken(new \DateTime('2021-02-09 10:49:01'));
        $note->setContent('Must finish by the end of the week!');
        $manager->persist($note);

        $note = new Note();
        $note->setTitle('The second note!');
        $note->setTaken(new \DateTime('2021-02-09 10:51:31'));
        $note->setContent('Whats gonna kill you is the second part');
        $manager->persist($note);

        $manager->flush();
    }
}
