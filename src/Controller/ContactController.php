<?php

namespace App\Controller;

use App\Form\ContactFormType;
use Symfony\Component\Mime\Email;
use App\Repository\CategoryRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="wood_contact")
     */
    public function contacts(Request $request,MailerInterface $mailer,CategoryRepository $categoryRepository): Response
    {   

        $form = $this->createForm(ContactFormType::class);
        $contact = $form->handleRequest($request);
        $categories = $categoryRepository->findAll();
        if($form->isSubmitted() && $form->isValid()){
            
            $email = (new Email())
            ->from($contact->get('email')->getData())
            ->to('reda.lamfa@gmail.com')
            ->subject('Contact a propos d un article')
        /*    ->context([
                'fullname' => $contact->get('firstname')->getData(),
                'numerotel' => $contact->get('phonenumber')->getData(),
                'mail' => $contact->get('email')->getData(),
                'message' => $contact->get('message')->getData()
            ])*/
            ->text($contact->get('message')->getData())
            ;
            $mailer->send($email);

            $this->addFlash('message', 'Votre e-mail a bien été envoyé');
            return $this->redirectToRoute('wood_contact');
        }
        return $this->render('contact/contact_wood.html.twig', [
            'form' => $form->createView(),
            'categories' => $categories
        ]);
    }
}
