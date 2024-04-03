<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Outils\Outils;
use App\Entity\Compte;
use App\Repository\CompteRepository;

class InscriptionCongresController extends AbstractController
{
    #[Route('/inscriptioncongres', name: 'app_inscription_congres')]
    public function index(CompteRepository $compte): Response
    {
        ///recupere le licencie
        $user = $this->getUser();
        $username = $user->getUserIdentifier();
        $compte = $compte->findOneBy(['email'=>$username]);
        $licencie = Outils::GetLicencieByNumLicence($compte->getNumlicence());
        
        
        return $this->render('inscription_congres/index.html.twig', [
            'controller_name' => 'InscriptionCongresController',
            'user' => $user,
            'licencie' => $licencie,
            'username' => $username,
        ]);
    }
    
    #[Route('/changementEmail', name: 'app_changemail')]
    public function ChangeMail() {
        return $this->redirectToRoute("app_inscription_congres");
    }
    
    
}
