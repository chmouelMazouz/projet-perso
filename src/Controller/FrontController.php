<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\MonologBundle\SwiftMailer;

class FrontController extends AbstractController
{
    /**
     * @Route("/", name="front")
     */
    public function index()
    {
        return $this->render('front/index.html.twig');
    }

    /**
     * @Route("/location", name="location")
     */
    public function location()
    {
        return $this->render('front/location.html.twig');
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(Request $request,\Swift_Mailer $mailer)
    {

        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $value=$form->getData();
            $message = (new \Swift_Message('Nouveau message en provenance du site du Mariage'))
                ->setFrom($value['email'])
                ->setTo('chmouelmazouz@gmail.com')
                ->setBody(
                    $this->renderView(
                    // templates/emails/registration.html.twig
                        'emails/contact.html.twig',
                        [
                            'name' => $value["nom"],
                            'prenom' => $value["prenom"],
                            'email' => $value["email"],
                            'message' => $value["message"],
                        ]
                    ),
                    'text/html'
                );

                $mailer->send($message);
                $this->addFlash(
                    'notice',
                    'Votre message a été bien envoyé'
                );

        }

        return $this->render('front/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
