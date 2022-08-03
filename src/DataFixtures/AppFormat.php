<?php

namespace App\DataFixtures;

use App\Entity\Format;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFormat extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $formats = array('1 vinyle', '2 vinyles', '3 vinyles', '4 vinyles');
        foreach ($formats as $format) {
            $nameFormat = new Format();
            $nameFormat->setName($format);
            $manager->persist($nameFormat);
            $manager->flush();
        }
    }
}
