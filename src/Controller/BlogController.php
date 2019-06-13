<?php
// src/Controller/BlogController.php
namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use App\Entity\Category;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ArticleSearchType;
use Doctrine\Common\Persistence\ObjectManager;
use App\Form\CategoryType;

class BlogController extends AbstractController
{
	
 /**
 * Show all row from article's entity
 * @Route("/", name="blog_index")
 * @return Response A response instance
 */
	
 public function index(ObjectManager $manager)
 {
	 $articles = $this->getDoctrine()
		 ->getRepository(Article::class)
		 ->findAll();
	
	 if (!$articles) {
		 throw $this->createNotFoundException(
			 'No article found in article\'s table.'
		 );
	 }
	 $form = $this->createForm(
		 ArticleSearchType::class,
		 null,
		 ['method' => Request::METHOD_GET]
	 );
	
	 return $this->render(
		 'blog/index.html.twig', [
			 'articles' => $articles,
			 'form' => $form->createView(),
		 ]
	 );
 }

      /**
       * @Route("/blog/new", name="blog_new")
	   */
	public function add(Request $request, ObjectManager $manager)
	{
		$category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
	 
		 if ($form->isSubmitted() && $form->isValid()){
	 	$data = $form->getData();
	 	$manager->persist($data);
	 	$manager->flush();
	 	return $this->redirectToRoute('blog_index');
	 	
	 }
	
	 return $this->render(
		 'blog/newCategory.html.twig', [
			 
			 'form' => $form->createView(),
		 ]
	 );
	
	}

/**
 * Getting a article with a formatted slug for title
 *
 * @param string $slug The slugger
 * @Route("blog/show/{slug<^[a-z0-9-]+$>}",
 *     defaults={"slug" = null},
 *     name="blog_show")
 *  @return Response A response instance
 */
 public function show(?string $slug) : Response
 {
     if (!$slug) {
            throw $this
            ->createNotFoundException('No slug has been sent to find an article in article\'s table.');
        }

         $slug = preg_replace(
          '/-/',
          ' ', ucwords(trim(strip_tags($slug)), "-")
            );

     $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findOneBy(['title' => mb_strtolower($slug)]);

     if (!$article) {
          throw $this->createNotFoundException(
          'No article with '.$slug.' title, found in article\'s table.'
      );
        }
    

     return $this->render(
     'blog/show.html.twig',
      [
              'article' => $article,
              'slug' => $slug,
      ]
    );
  
  }
     /**
     //* @Route("/blog/category/{category}", name="show_category")
    */
    
     /**public function showByCategory(string $category)
     {
      $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findOneBy(['name' => $category]);
     
     $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findBy(['category' => $category],[ "id" =>"desc"],3);


            return $this->render(
              'blog/category.html.twig',
              ['articles' => $articles,
                'category' => $category,
            ]);
     
     }*/
	/**            <h2>{{ article.id }} / {{ categoryName  .name }} - Category : {{ article.title}}</h2>

	 * @Route("/blog/category/{name}", name="show_category")
	 */
	public function showByCategory(category $category)
	{
		/**$category = $this->getDoctrine()
			->getRepository(Category::class)
			->findOneBy(['name' => $categoryName]);
		*/$articles = $category->getArticles();
			
			return $this->render(
				'blog/category.html.twig',
				['articles' => $articles,
					'categoryName' => $category,
				]);
}
}
