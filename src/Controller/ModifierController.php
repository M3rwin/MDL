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
    
    #[Route('/modifier/{id}', name: 'app_modifier_vacation')]
    public function modifier(Request $request, VacationRepository $repo, EntityManagerInterface $em, int $id): Response
    {
        $vacation = $repo->find($id);
        
        $formVacation = $this->createForm(AjoutVacationType::class, $vacation);
        $formVacation->handleRequest($request);
        
        if ($formVacation->isSubmitted() && $formVacation->isValid()) {
                    $data = $formVacation->getData();
                    $vacation->setDateheuredebut($data->dateheuredebut);
                    $vacation->setDateheurefin($data->dateheurefin);
                    $vacation->setAtelier($data->atelier);
                    $em->flush();
        }
        
        return $this->render('modifier/modifierVacation.html.twig', [
            'formVacation' => $formVacation->createView(),
            'vacation' => $vacation,
            'id' => $id,
        ]);
    }
}
