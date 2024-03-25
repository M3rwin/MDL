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

class AjoutController extends AbstractController
{
    #[Route('/ajout', name: 'app_ajout')]
    public function index(Request $request): Response
    {
        
        // formulaire de choix d'ajout Atelier/Theme/Vacation
        $form = $this->createForm(AjoutType::class);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            switch ($data['choix']){
                case 'atelier':
                    $formEntite = $this->createForm(AjoutAtelierType::class);
                    break;
                case 'theme':
                    $formEntite = $this->createForm(AjoutThemeType::class);
                    break;
                case 'vacation':
                    $formEntite = $this->createForm(AjoutVacationType::class);
                    break;
                default:
                    $formEntite = $data['choix'];
                    break;
            }
            // Traiter les données
            // (afficher le formulaire correspondant au choix)
        }
        
       $context = [
            'controller_name' => 'AjoutController',
            'form' => $form->createView(),
        ];
       
       if(isset($formEntite)){
           $context['formEntite'] = $formEntite->createView();
       }
       
        return $this->render('ajout/index.html.twig', $context);
    }
}
