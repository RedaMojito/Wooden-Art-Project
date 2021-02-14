<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\AttachementRepository;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Controller\CrudControllerInterface;

class WoodController extends AbstractController
{
    private $categoryRepository;
    private $attachementRepository;

    public function __construct(CategoryRepository $categoryRepository,AttachementRepository $attachementRepository)
    {
        $this->attachementRepository = $attachementRepository;
        $this->categoryRepository = $categoryRepository;
    }
    
    /**
     * @Route("/", name="wood_home")
     */
    public function index(ArticleRepository $articleRepository): Response
    {   
        $articles = $articleRepository->findBy([],['created_at'=>'DESC']);
        $attachements = $this->attachementRepository->findBy([],['updated_at'=>'DESC']);
        $categories = $this->categoryRepository->findAll();
        return $this->render('wood/index.html.twig', [
            'articles' => $articles,
            'categories' => $categories,
            'attachements' => $attachements
        ]);
    }
     /**
     * @Route("/about", name="wood_about")
     */
    public function about(): Response
    {
        $categories = $this->categoryRepository->findAll();
        return $this->render('wood/about.html.twig', ['categories' => $categories]);
    }
      /**
     * @Route("/{categoryId}", name="wood_category", methods="GET")
     */
    public function chairCategory($categoryId,ArticleRepository $articleRepository): Response
    {   
        $articles = $articleRepository->findBy(
            ['Category' => $categoryId],
            ['created_at'=>'DESC']);
        
        $categories = $this->categoryRepository->findAll();
        $currentCategory = $this->categoryRepository->findOneBy(['id' => $categoryId]);
            return $this->render('categories/category.html.twig', [
                'articles' => $articles,
                'categories' => $categories,
                'currentCategory' => $currentCategory
             ]);
    }
   

      /**
     * @Route("/articles/{id<[0-9]+>}", name="app-articles-show", methods="GET")
     */
    public function show($id,Article $article): Response
    {
       
        $attachements = $this->attachementRepository->findBy(['article'=> $id]);

        $categories = $this->categoryRepository->findAll();
        return $this->render('wood/show.html.twig', [
            'article' => $article,
             'categories' => $categories,
             'attachements' => $attachements
             ]);
    }

    /**
     * @Route("/adduser", name="create_user", priority=1)
     */
    public function addUser(EntityManagerInterface $em){
        $user = new User();
       
        $user->setFirstName('nidal');
        $user->setLastName('lamfadel');
        $user->setEmail('nidal.lamfa@gmail.com');
        $user->setPassword('$2y$13$rGHfp5Nk70uFl0Dj37PuT..1qtX/7mylwcA1GIYg9urnHFox64Uee');
        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $em->persist($user);

        // actually executes the queries (i.e. the INSERT query)
        $em->flush();
        
        $this->addFlash('success', 'Pan successfully created !');
        return $this->redirectToRoute('wood_home');
    }
}
