<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Controller\CrudControllerInterface;

class WoodController extends AbstractController
{
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
    
    /**
     * @Route("/", name="wood_home")
     */
    public function index(ArticleRepository $articleRepository): Response
    {   
        $articles = $articleRepository->findBy([],['created_at'=>'DESC']);
        $categories = $this->categoryRepository->findAll();
        return $this->render('wood/index.html.twig', [
            'articles' => $articles,
            'categories' => $categories
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
            return $this->render('categories/category.html.twig', [
                'articles' => $articles,
                'categories' => $categories
             ]);
    }
   

      /**
     * @Route("/articles/{id<[0-9]+>}", name="app-articles-show", methods="GET")
     */
    public function show(Article $article): Response
    {
        $categories = $this->categoryRepository->findAll();
        return $this->render('wood/show.html.twig', ['article' => $article, 'categories' => $categories]);
    }
    /**
     * @Route("/adduser", name="create_user")
     */
    public function addUser(){
        $entityManager = $this->getDoctrine()->getManager();

        $user = new User();
        $user->setFirstName('Brandon');
        $user->setLastName('Boyd');
        $user->setEmail('brandon.boyd@gmail.com');
        $user->setPassword('$2y$13$xQEkvaRAJ30P9k.Va6Cr1eEVqTVGhSOhj1RB2MBrc24s44iGWAtCa');
        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($user);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new User with id '.$user->getId());
    }
}
