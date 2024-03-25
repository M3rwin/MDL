<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CompteRepository;

class AccueilController extends AbstractController
{
    #[Route('/accueil', name: 'app_accueil')]
    #[Route('/', name: 'app_accueilbis')]
    public function index(CompteRepository $compte): Response
    {
        $user = $this->getUser();
        if($user!=null) {
           $username = $user->getUserIdentifier();
           
           $compte = $compte->findOneBy(['email'=>$username]);
           if(!$compte->isVerified()){
               $this->redirectToRoute('app_logout');
           }
        }
        
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }
    
}
