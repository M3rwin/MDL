<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\AjoutAtelierType;
use App\Form\AjoutThemeType;
use App\Form\AjoutVacationType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Atelier;
use App\Repository\AtelierRepository;

class AjoutController extends AbstractController
{
    #[Route('/ajout', name: 'app_ajout')]
    public function index(Request $request, EntityManagerInterface $em): Response
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
                switch($formType){
                    case 'atelier':
                        //$atelier = new Atelier($data['libelle'], $data['nbplacesmaxi'], $data['inscriptions'], $data['vacations'], $data['themes']);
                        //$em->persist($atelier);
                        break;
                }
            }
        }
        
    
        
        
        return $this->render('ajout/index.html.twig', $context);
    }
}
