<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Contact;
use \App\Form\ContactType;
use \Symfony\Component\HttpFoundation\Request;
use App\Service\GestionContact;

/**
 * @Route("/contact", name="contact")
 */
class ContactController extends AbstractController
{

  /**
     * @Route("/contact", name="_success")
     */
    public function index()
    {
        return new Response($content = 'Vous vous êtes enregistré');
    }
  /**
   * @Route("/creercontact", name="formContact")
   */
  public function formContact(Request $request, GestionContact $gestionContact)
  {
    $contact = new Contact();
    $form = $this->createForm(ContactType::class, $contact);

    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {

      $this->addFlash('notification', "Votre message a bien été envoyé");
      $contact = $form->getData();
      $contact->setDateHeureContact(new \DateTime());
      $gestionContact->creerContact($contact);

      $gestionContact->envoiMailContact($contact);


      return $this->redirectToRoute("contact_success");
    }
    return $this->render('contact/creerContact.html.twig', [
        'form' => $form->createView(),
    ]);
  }

  /**
   * @Route("/creer", name="creerClient")
   * 
   */
  public function creerContact(ManagerRegistry $doctrine)
  {
    $doctrine->getRepository(Contact::class)->create();
  }
}
