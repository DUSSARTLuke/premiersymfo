<?php
// src/service/gestionContact.php
namespace App\Service;

use App\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Twig\Environment;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\ContactRepository;
use App\Repository\ProduitRepository;
use Mailjet\Client;
use Mailjet\Resources;

/**
 * Description of GestionContact
 *
 * @author Benoît
 */
class GestionContact
{

//documentation : https://swiftmailer.symfony.com/docs/sending.html
  private \Swift_Mailer $mail;
  private Environment $environnementTwig;
  private ManagerRegistry $doctrine;
  private ContactRepository $repo;

  //private ProduitRepository $produitRepo;

  function __construct(\Swift_Mailer $mail, Environment $environnementTwig, ManagerRegistry $doctrine, ContactRepository $repo)
  {
    $this->mail = $mail;
    $this->environnementTwig = $environnementTwig;
    $this->doctrine = $doctrine;
    $this->repo = $repo;
  }

  public function envoiMailContact(Contact $contact)
  {
    //$titre = ($contact->getTitre() == 'M') ? ('Monsieur') : ('Madame');
    $mj = new Client('b9db8d259d359ad10412b99084c89054', '0e8aeeacaa0512455828d76ee9562b56', true);
    $body = [
      'Messages' => [
        [
          'From' => [
            'Email' => "lukedussart@hotmail.fr",
            'Name' => "Luke"
          ],
          'To' => [
            [
              'Email' => "lukedussart@hotmail.fr",
              'Name' => $contact->getPrenom()
            ]
          ],
          'Subject' => "Demande de contact",
          'TextPart' => "My first Mailjet email",
          'HTMLPart' => "<h3>Dear passenger 1, welcome to <a href='https://www.mailjet.com/'>Mailjet</a>!</h3><br />May the delivery force be with you!",
          'CustomID' => "AppGettingStartedTest"
        ]
      ]
    ];
    $response = $mj->post(Resources::$Email, ['body' => $body]);
    $response->success() && var_dump($response->getData());
  }

  public function creerContact(Contact $contact): void
  {
    $em = $this->doctrine->getManager();
    $em->persist($contact);
    $em->flush();
  }

  public function envoiMailTous()
  {
    $contacts = $this->repo->findAll();
    $produits = $this->produitRepo->findAll();
    $message = (new \Swift_Message('Voyages en promo chez Roche'))
      ->setFrom(['isn.ocincle@gmail.com' => 'Benoît Voyages']);
    foreach ($contacts as $contact) {
      //$destinataires[]= "'". $contact->getMail(). "'=>'"  .$contact->getNom()."'";
      $message->addBcc($contact->getMail());
    }
    //->addTo('benoit.roche@gmail.com')
    //$message->addTo(['benoit.roche@gmail.com', 'benoit.roche@hotmail.fr']);
    $img = $message->embed(\Swift_Image::fromPath('build/images/symfony.png'));
    $message->setBody(
      $this->environnementTwig->render(
        // templates/emails/registration.html.twig
        'mail/mailtous.html.twig',
        ['img' => $img, 'produits' => $produits]
      ),
      'text/html'
    );
    $message->attach(\Swift_Attachment::fromPath('documents/presentation.pdf'));

    $this->mail->send($message);
  }
}
