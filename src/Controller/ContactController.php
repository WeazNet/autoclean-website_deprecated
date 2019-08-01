<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use App\Notification\ContactNotification;

class ContactController extends AbstractController
{

    /**
     * @Route("/prendre-rdv", name="contact.index")
     */
    public function index(Request $request, ContactNotification $notification) {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $notification->notify($contact);

            $this->addFlash('success', 'Votre email a bien été envoyé');
            return $this->redirectToRoute('contact.index');
        }
        if($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash('errors', "Votre email ne s'est pas envoyé correctement. Veuillez réessayer");
        }

        return $this->render('contact/index.html.twig', [
            'active' => 'contact',
            'form' => $form->createView()
        ]);
    }

}