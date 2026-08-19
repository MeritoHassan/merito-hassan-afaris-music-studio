<?php

namespace App\Controller;

use App\Form\ContactForm;
use App\Helper\Helper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

final class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request,  MailerInterface $mailer): Response
    {

        $form = $this->createForm(ContactForm::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            if(!Helper::checkEmail($data['email'])){
                $this->addFlash('error', 'Votre adresse email est invalide!');
            }
            else{
                $email = (new Email())
                    ->from($data['email'])
                    ->to($_ENV['CONTACT_EMAIL'])
                    ->subject($data['sujet'])
                    ->text(sprintf(
                        "Message de: %s (%s)\n\n%s",
                        $data['nom'],
                        $data['email'],
                        $data['message']
                    ));

                try {
                    $mailer->send($email);
                    $this->addFlash('success', 'Votre message a été envoyé avec succès!');
                } catch (\Exception $e) {
                    $this->addFlash('error', 'Erreur lors de l\'envoi du message.');
                }
            }

            return $this->redirectToRoute('app_contact');
        }
        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
