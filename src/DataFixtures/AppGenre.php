<?php

namespace App\DataFixtures;

use App\Entity\Genre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppGenre extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $genres = array('électronique', 'rock', 'pop', 'hip hop', 'funk/soul', 'folk & country', 'jazz', 'blues', 'classical', 'reggae', 'latin', 'children\'s');
        foreach ($genres as $genre) {
            $product = new Genre();
            $product->setGenreName($genre);
            $manager->persist($product);
            $manager->flush();
        }
    }
}
