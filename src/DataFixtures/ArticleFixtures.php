<?php
namespace App\DataFixtures;

use App\Entity\Article;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use  Faker;

class ArticleFixtures extends Fixture implements DependentFixtureInterface

{

    public function load(ObjectManager $manager)
    {
        

        $slug = new Slugify();
        $faker  =  Faker\Factory::create('fr_FR');
        for($i=0; $i<50; $i++)
        {

            $article = new Article();
            $sentence = $faker->sentence();
            $article->setTitle(mb_strtolower($sentence));
            $article->setSlug($slug->generate($sentence));
            $article->setContent($faker->sentence());
        if ($i<10)
        {
            $article->setCategory($this->getReference('categorie_0'));      
        }
        else if ($i<20)
        {
            $article->setCategory($this->getReference('categorie_1'));      
        }
        else if ($i<30)
        {
            $article->setCategory($this->getReference('categorie_2'));      
        }
        else if ($i<40)
        {
            $article->setCategory($this->getReference('categorie_3'));      
        }
        else if ($i<50)
        {
            $article->setCategory($this->getReference('categorie_4'));      
        }
            $manager->persist($article);
            $manager->flush();
            
        }
    }
    public function getDependencies()
    {
        return [CategoryFixtures::class];
    }
}