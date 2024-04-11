<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AtelierRepository;
use App\Repository\VacationRepository;
use App\Form\AjoutVacationType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class ModifierController extends AbstractController
{
    #[Route('/modifier', name: 'app_modifier')]
    public function index(AtelierRepository $repo): Response
    {
        $ateliers = $repo->findAll();
        
        return $this->render('modifier/index.html.twig', [
            'ateliers' => $ateliers,
        ]);
    }
    
    #[Route('/modifier/{idAtelier}', name: 'app_modifier_atelier')]
    public function modifierAtelier(AtelierRepository $repoAtelier, int $idAtelier): Response
    {
        $atelier = $repoAtelier->find($idAtelier);
        
        return $this->render('modifier/modifierAtelier.html.twig', [
            'atelier' => $atelier,
            'id' => $idAtelier,
        ]);
    }
    
    
    #[Route('/modifier/{idAtelier}/{idVacation}', name: 'app_modifier_atelier_vacations')]
    public function modifierAtelierVacations(Request $request, VacationRepository $repoVacation, EntityManagerInterface $em, int $idAtelier, int $idVacation): Response
    {
        $vacation = $repoVacation->find($idVacation);
        
        $formVacation = $this->createForm(AjoutVacationType::class, $vacation);
        $formVacation->handleRequest($request);
        
        if ($formVacation->isSubmitted() && $formVacation->isValid()) {
                    $data = $formVacation->getData();
                    $vacation->setDateheuredebut($data->getDateheuredebut());
                    $vacation->setDateheurefin($data->getDateheurefin());
                    $vacation->setAtelier($data->getAtelier());
                    $em->flush();
                    return $this->redirectToRoute('app_modifier_atelier', ['idAtelier' => $idAtelier]);
        }
        
        return $this->render('modifier/modifierVacation.html.twig', [
            'formVacation' => $formVacation->createView(),
            'vacation' => $vacation,
            'id' => $idVacation,
        ]);
    }
    
    
}
