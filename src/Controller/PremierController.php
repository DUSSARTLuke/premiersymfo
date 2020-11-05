<?php
/**
 * Description of PremierController
 *
 * @author ahmedali.nassim
 */

namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PremierController {
    /**
     * @Route("/index", name="index")
     */
    public function index()
    {
        return new Response($content = 'Bonjour mon premier controleur');
    }
}
