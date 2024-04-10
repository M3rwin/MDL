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
use App\Repository\CompteRepository;

class AjoutController extends AbstractController {

    #[Route('/ajout', name: 'app_ajout')]
    public function index(Request $request, EntityManagerInterface $em, AtelierRepository $repo): Response {
        // on récupère tout les ateliers
        $ateliers = $repo->findAll();
        
        
        if (count($ateliers) > 0) {
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
            foreach ($forms as $form) {
                if ($form->isSubmitted() && $form->isValid()) {
                    $data = $form->getData();
                    $em->persist($data);
                    $em->flush();
                    // ajout du message de confirmation
                    $this->addFlash(
                            'success',
                            'Votre ' . $formType . ' a bien été ajouté',
                    );
                    return $this->redirectToRoute('app_ajout');
                }
            }

            return $this->render('ajout/index.html.twig', $context);
        } else {
            $formAtelier = $this->createForm(AjoutAtelierType::class);
            $formAtelier->handleRequest($request);

            if ($formAtelier->isSubmitted() && $formAtelier->isValid()) {
                $data = $formAtelier->getData();
                $em->persist($data);
                $em->flush();
                $this->addFlash(
                        'success',
                        'Votre atelier a bien été ajouté',
                );
                return $this->redirectToRoute('app_ajout');
            }


            $this->addFlash(
                    'warning',
                    'Vous devez ajouter un atelier avant d\'ajouter autre chose',
            );

            $context = [
                'formAtelier' => $formAtelier->createView(),
            ];
            return $this->render('ajout/ajoutAtelier.html.twig', $context);
        }
    }
}
