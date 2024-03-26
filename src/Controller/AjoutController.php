<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\AjoutAtelierType;
use App\Form\AjoutThemeType;
use App\Form\AjoutVacationType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\AtelierRepository;

class AjoutController extends AbstractController
{
    #[Route('/ajout', name: 'app_ajout')]
    public function index(Request $request): Response
    {
        // on initie/récupère les forms
        $formAtelier = $this->createForm(AjoutAtelierType::class);
        $formTheme = $this->createForm(AjoutThemeType::class);
        $formVacation = $this->createForm(AjoutVacationType::class);
        $formAtelier->handleRequest($request);
        $formTheme->handleRequest($request);
        $formVacation->handleRequest($request);
        
        // on commence à déclarer les éléments du context
        $context = [
            'formAtelier' => $formAtelier->createView(),
            'formTheme' => $formTheme->createView(),
            'formVacation' => $formVacation->createView(),
        ];
        
        $forms = array($formAtelier, $formTheme, $formVacation);
        
        // récupération du type d'entité à faire persister
        $formType = $request->request->get('form_type');
        
        // on traite les data du form
        foreach($forms as $form){
            if($form->isSubmitted() && $form->isValid()){
                $data=$form->getData();
                $context['data'] = $data;
            }
        }
        
    
        
        
        return $this->render('ajout/index.html.twig', $context);
    }
}
