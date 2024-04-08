<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Outils\Outils;
use App\Repository\CompteRepository;
use App\Entity\Compte;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Atelier;
use App\Entity\Proposer;
use App\Entity\Restauration;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Inscription;

class InscriptionCongresController extends AbstractController {

    #[Route('/inscriptioncongres', name: 'app_inscription_congres')]
    public function index(CompteRepository $compte, EntityManagerInterface $em): Response {
        ///recupere le licencie
        $user = $this->getUser();
        $username = $user->getUserIdentifier();
        $compte = $compte->findOneBy(['email' => $username]);
        $licencie = Outils::GetLicencieByNumLicence($compte->getNumlicence());
        $ateliers = $em->getRepository(Atelier::class)->findNotFull();
        $hotels = $em->getRepository(Proposer::class)->findAll();
        $restauration = $em->getRepository(Restauration::class)->findAll();

        return $this->render('inscription_congres/index.html.twig', [
                    'controller_name' => 'InscriptionCongresController',
                    'user' => $user,
                    'licencie' => $licencie,
                    'username' => $username,
                    'ateliers' => $ateliers,
                    'hotels' => $hotels,
                    'restauration' => $restauration,
        ]);
    }

    #[Route('/changementEmail', name: 'app_changemail')]
    public function ChangeMail(EntityManagerInterface $em, Request $request) {
        ///recupere le licencie
        $user = $this->getUser();
        $username = $user->getUserIdentifier();
        $compte = $em->getRepository(Compte::class)->findOneBy(['email' => $username]);
        //recupere la variable post et défini le mail
        $mail = $request->request->get('mail');
        $compte->setEmail($mail);
        $em->flush();

        return $this->redirectToRoute("app_inscription_congres");
    }

    #[Route('/commitinscription', name: 'app_commitinscription')]
    public function CommitInscription(EntityManagerInterface $em, Request $request) {
        //recuperer l'user
        try {
            $user = $this->getUser();
            $username = $user->getUserIdentifier();
            $compte = $em->getRepository(Compte::class)->findOneBy(['email' => $username]);
            //creer une inscription et l'associé au compte de l'user
            $inscription = new Inscription();
            //remplir la table inscription_atelier (id inscription et id atelier)
            foreach ($_POST["ateliers"] as $atelier) {
                $atelier = filter_input(INPUT_POST, $atelier, FILTER_SANITIZE_NUMBER_INT);
                $inscription->addAtelier(intval($atelier));
            }

            //split les informations des restaurations reçu sous forme id_date_type_repas
            //remplir la table inscription_restauration (id inscription et id restauration)
            foreach ($_POST["Restauration"] as $restauration) {
                $restaurationArray = explode("_",$restauration);
                $inscription->addRestauration(intval($restaurationArray[0]));
            }
            
            
            //split info nuite recu sous forme nuite.id _hotel.nom _categoriechambre.libellecategorie_nuite.tarifnuite_datenuite_categoriechambre.id_hotel.id
            //remplir la table nuite (id inscription et id hotel et id categorie et date nuite)

            $parameters = json_decode($request->getContent(), true);
            return new Response(var_dump($_POST));
        } catch (Exception $ex) {
            return;
        }
    }
}
