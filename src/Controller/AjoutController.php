<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\AjoutType;
use App\Form\AjoutAtelierType;
use App\Form\AjoutThemeType;
use App\Form\AjoutVacationType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormTypeInterface;

class AjoutController extends AbstractController
{
    #[Route('/ajout', name: 'app_ajout')]
    public function index(Request $request): Response
    {
        
        $formAtelier = $this->createForm(AjoutAtelierType::class);
        $formTheme = $this->createForm(AjoutThemeType::class);
        $formVacation = $this->createForm(AjoutVacationType::class);
        $formAtelier->handleRequest($request);
        $formTheme->handleRequest($request);
        $formVacation->handleRequest($request);
        
        
        
    
        $context = [
            'formAtelier' => $formAtelier->createView(),
            'formTheme' => $formTheme->createView(),
            'formVacation' => $formVacation->createView(),
        ];
        
        return $this->render('ajout/index.html.twig', $context);
    }
}
