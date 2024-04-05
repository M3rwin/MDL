<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Outils\Outils;
use App\Repository\CompteRepository;
use App\Entity\Compte;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

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
    public function ChangeMail(EntityManagerInterface $em, Request $request ) {
        ///recupere le licencie
        $user = $this->getUser();
        $username = $user->getUserIdentifier();
        $compte = $em->getRepository(Compte::class)->findOneBy(['email'=>$username]);
        //recupere la variable post et défini le mail
        $mail = $request->request->get('mail');
        $compte->setEmail($mail);
        $em->flush();
        
        return $this->redirectToRoute("app_inscription_congres");
    }
    
    
}
