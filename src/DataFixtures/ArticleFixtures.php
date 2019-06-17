<?php
	
namespace App\DataFixtures;

use App\Service\Slugify;
use  Faker;
use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
	public function getDependencies()
	{
		return [CategoryFixtures::class];
	}
	public function load(ObjectManager $manager)
	{
		/**$faker  =  Faker\Factory::create('fr_FR');
		for ($i = 0; $i < 50; $i++) {
			$article = new Article();
			$article->setTitle(mb_strtolower($faker->sentence()));
			$article->setContent($faker->sentences($nbWords = 6, $variableNbWords = true));
			
			$slugify = New Slugify();
			$slug = $slugify->generate($article->getTitle());
			$article->setSlug($slug);
			
			
			
			
			$manager->persist($article);
			$article->setCategory($this->getReference('categorie_0'));
			$manager->flush();
		}*/
		for ($i = 1; $i <= 1000; $i++) {
			$category = new Category();
			$category->setName("category " . $i);
			$manager->persist($category);
			
			$tag = new Tag();
			$tag->setName("tag " . $i);
			$manager->persist($tag);
			
			$article = new Article();
			$article->setTitle("article " . $i);
			$article->setSlug($this->slugify>generate($article->getTitle()));
			$article->setContent("article " . $i . " content");
			$article->setCategory($category);
			$article->addTag($tag);
			$manager->persist($article);
		}
		
		$manager->flush();
		
		
		
		
	}
	
}
