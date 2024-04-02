<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AtelierRepository;

class ModifierController extends AbstractController
{
    #[Route('/modifier', name: 'app_modifier')]
    public function index(AtelierRepository $repo): Response
    {
        $ateliers = $repo->findAll();
        
        return $this->render('modifier/index.html.twig', [
            'controller_name' => 'ModifierController',
            'ateliers' => $ateliers,
        ]);
    }
}
