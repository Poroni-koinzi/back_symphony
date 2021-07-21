<?php

namespace App\DataFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Category;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $category = new Category;
        $category->setIdCategory("CAT008");
        $category->setLibelleCategory("accessoirefg");
        $manager->persist($category);
        $manager->flush();

    }
}