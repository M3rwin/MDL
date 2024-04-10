<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CompteRepository;
use App\Repository\AtelierRepository;
use App\Repository\HotelRepository;

class AccueilController extends AbstractController
{
    #[Route('/accueil', name: 'app_accueil')]
    #[Route('/', name: 'app_accueilbis')]
    public function index(CompteRepository $compte, AtelierRepository $atelier, HotelRepository $hotel): Response
    {
        //verification si user est verifié
        $user = $this->getUser();
        if($user!=null) {
           $username = $user->getUserIdentifier();
           
           $compte = $compte->findOneBy(['email'=>$username]);
           $verif=$compte->isVerified();
           if(!$verif){
               
               return $this->redirectToRoute('app_logout');
           }
        }
        
        $ateliers = $atelier->findAll();
        $hotels = $hotel->findAll();
        return $this->render('accueil/index.html.twig', [
            'ateliers'=>$ateliers,
            'hotels'=>$hotels,
        ]);
    }
    
}
