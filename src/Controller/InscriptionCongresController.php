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
use App\Entity\Hotel;
use App\Entity\Categoriechambre;
use DateTime;
use App\Entity\Nuite;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Inscription;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class InscriptionCongresController extends AbstractController {

    #[Route('/inscriptioncongres', name: 'app_inscription_congres')]
    public function index(CompteRepository $compte, EntityManagerInterface $em): Response {
        ///recupere le licencie
        $user = $this->getUser();
        $username = $user->getUserIdentifier();
        $compte = $compte->findOneBy(['email' => $username]);
        if ($compte->getInscription() == null) {
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
        } else {
            return $this->redirectToRoute("app_accueil");
        }
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
    public function CommitInscription(EntityManagerInterface $em, Request $request, MailerInterface $mailer) {
        //recuperer l'user
        try {
            $user = $this->getUser();
            $username = $user->getUserIdentifier();
            $compte = $em->getRepository(Compte::class)->findOneBy(['email' => $username]);
            //creer une inscription et l'associé au compte de l'user
            $inscription = new Inscription();
            $inscription->setDateinscription(new DateTime());
            //remplir la table inscription_atelier (id inscription et id atelier)
            foreach ($_POST["ateliers"] as $atelier) {
                $atelierExistant = $em->getRepository(Atelier::class)->findOneBy(['id' => intval($atelier)]);
                $inscription->addAtelier($atelierExistant);
            }

            //split les informations des restaurations reçu sous forme id_date_type_repas
            //remplir la table inscription_restauration (id inscription et id restauration)
            if (isset($_POST["Restauration"])) {
                foreach ($_POST["Restauration"] as $restauration) {
                    $restaurationArray = explode("_", $restauration);
                    $restaurationExistant = $em->getRepository(Restauration::class)->findOneBy(['id' => intval($restaurationArray[0])]);
                    $inscription->addRestauration($restaurationExistant);
                }
            }
            //split info nuite recu sous forme nuite.id _hotel.nom _categoriechambre.libellecategorie_nuite.tarifnuite_datenuite_categoriechambre.id_hotel.id
            //remplir la table nuite (id inscription et id hotel et id categorie et date nuite)
            if (isset($_POST["Nuites"])) {
                foreach ($_POST["Nuites"] as $nuite) {
                    $nuiteArray = explode("_", $nuite);
                    $nuiteobjet = new Nuite();
                    $hotelExistant = $em->getRepository(Hotel::class)->findOneBy(['id' => intval($nuiteArray[6])]);
                    $nuiteobjet->setHotel($hotelExistant);
                    $categorieExistant = $em->getRepository(Categoriechambre::class)->findOneBy(['id' => intval($nuiteArray[5])]);
                    $nuiteobjet->setCategorie($categorieExistant);
                    $date = DateTime::createFromFormat("Y-d-m", $nuiteArray[4]);
                    $nuiteobjet->setDatenuitee($date);
                    $inscription->addNuite($nuiteobjet);
                    $em->persist($nuiteobjet);
                }
            }
            $em->persist($inscription);
            $compte->setInscription($inscription);

            $email = (new Email())
                    ->from('ne-pas-repondre@doney.fr')
                    ->to($user->getEmail())
                    ->subject('Confirmation D\'inscription')
                    ->text($_POST["recap_div"]);

            $mailer->send($email);

            $em->flush();

            return $this->redirectToRoute("app_accueil");
        } catch (Exception $ex) {
            return $ex;
        }
    }
}
