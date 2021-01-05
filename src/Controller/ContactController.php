<?php

namespace App\Controller;

use App\Form\ContactFormType;
use App\Repository\ArticleRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function contacts(Request $request,MailerInterface $mailer): Response
    {   

        $form = $this->createForm(ContactFormType::class);
        $contact = $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            
            $email = (new TemplatedEmail())
            ->from($contact->get('email')->getData())
            ->to('reda.lamfa@gmail.com')
            ->subject('Contact a propos d un article')
            ->htmlTemplate('contact/contact_wood.html.twig')
            ->context([
                'fullname' => $contact->get('firstname')->getData(),
                'numerotel' => $contact->get('phonenumber')->getData(),
                'mail' => $contact->get('email')->getData(),
                'message' => $contact->get('message')->getData()
            ]);
            $mailer->send($email);

            $this->addFlash('message', 'Votre e-mail a bien été envoyé');
            
            return $this->redirectToRoute('contact');
        }
        return $this->render('contact/contact_wood.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
