<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use \Doctrine\Persistence\ManagerRegistry;
use \App\Entity\Employe;

class PrincipalController extends AbstractController
{
    /**
     * @Route("/principal", name="principal")
     */
    public function index(): Response
    {
        return $this->render('principal/index.html.twig', [
            'controller_name' => "Symfony, c'est super"
        ]);
    }
    
     /**
     * @Route("/welcome/{nom}")
     */
    
     public function welcome(string $nom): Response 
     {
         return $this->render('principal/welcome.html.twig', [
             "nom" => $nom
         ]);
     }
     
     /**
     * @Route("/info/{cd}&{genre}")
     */
     public function info(string $cd, string $genre) : Response
     {
         return $this->render('principal/info.html.twig', [
             "cd" => $cd, "genre" => $genre 
         ]);
     }
     
     /**
      * @Route("/employes", name="employes")
      */
     public function afficheEmployes(ManagerRegistry $doctrine){
       $employes = $doctrine->getRepository(Employe::class)->findAll();
       $titre = "Liste des employés";
       return $this->render('principal/employes.html.twig', compact('titre', 'employes'));
     }
}
