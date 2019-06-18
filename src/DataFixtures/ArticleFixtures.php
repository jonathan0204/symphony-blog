<?php
	
namespace App\DataFixtures;

use App\Entity\Tag;
use App\Entity\User;
use App\Service\Slugify;
use  Faker;
use App\Entity\Article;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;



class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
	/**
	 * @var Slugify
	 */
	private $slugify;

	/**
	 * AppFixtures constructor.
	 * @param Slugify $slugify
	 */
	public function __construct(Slugify $slugify)
	{
		$this->slugify = $slugify;
}
	
	public function getDependencies()
	{
		return [UserFixtures::class];
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
		/** @var User $author*/
		$author= $this->getReference('author');
		for ($i = 1; $i <= 1000; $i++) {
			$category = new Category();
			$category->setName("category " . $i);
			$manager->persist($category);
			
			$tag = new Tag();
			$tag->setName("tag " . $i);
			$manager->persist($tag);
			
			$article = new Article();
			$article->setTitle("article " . $i);
			$article->setSlug($this->slugify->generate($article->getTitle()));
			$article->setContent("article " . $i . " content");
			$article->setCategory($category);
			$article->addTag($tag);
			$article->setAuthor($author);
			$manager->persist($article);
		}
		
		$manager->flush();
		
		
		
		
	}
	
}
