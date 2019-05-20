<?php
// src/Controller/BlogController.php
namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use App\Entity\Category;

class BlogController extends AbstractController
{
    /**
     * @Route("/", name="blog_index")
    */
    public function index(): Response
    {
         $articles = $this->getDoctrine()
             ->getRepository(Article::class)
             ->findAll();
   
         if (!$articles) {
             throw $this->createNotFoundException(
             'No article found in article\'s table.'
             );
         }
   
         return $this->render(
                 'blog/index.html.twig',
                 ['articles' => $articles]
         );
   }
    
        /**
     * Getting a article with a formatted slug for title
     *
     * @param string $slug The slugger
     *
     * @Route("/blog/show/{slug<^[a-z0-9-]+$>}",
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
     * Getting a article with a formatted slug for title
     *
     * @param string $slug The slugger
     *
     * @Route("/blog/category/{name}",
     *     defaults={"slug" = null},
     *     name="show_category")
     *  @return Response A response instance
     */
    public function showByCategory(Category $categoryName): Response
    {

/*        $category = $this->getDoctrine()
        ->getRepository(Category::class)
        ->findOneBy(['name' => $categoryName]);
*/        $articles =$categoryName->getArticles();

        return $this->render(
            'blog/showByName.html.twig',
            [
                    'categories' => $articles,

            ]);
        
        
    }
}