<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use App\Repository\SujetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategorieRepository;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use App\Repository\ReponseRepository;
use App\Repository\UtilisateurRepository;

use Symfony\Component\HttpFoundation\Response;

class ApiController extends AbstractController
{
    /**
     * @Route("/api/categories", name="api_categories", methods={"GET"})
     */
    public function get_categories(CategorieRepository $categorieRepository, NormalizerInterface $normalizer)
    {
        return $this->json($categorieRepository->findAll(), 200, [], ['groups' => "categorie:read"]);
    }

    /**
     * @Route("/api/sujets/{id_categorie}", name="api_sujets", methods={"GET"})
     */
    public function get_sujets_from_categorie(EntityManagerInterface $entityManager, CategorieRepository $categorieRepository, SujetRepository $sujetRepository, int $id_categorie)
    {
        return $this->json($sujetRepository->findByCategorie($id_categorie,$entityManager,$categorieRepository), 200, [], ['groups' => "sujet:read"]);
    }


    /**
     * @Route("/api/reponses/{id_sujet}", name="api_reponses", methods={"GET"})
     */
    public function get_reponses_from_sujet(EntityManagerInterface $entityManager, ReponseRepository $reponseRepository, SujetRepository $sujetRepository, int $id_sujet)
    {
        return $this->json($reponseRepository->findBySujet($id_sujet,$entityManager,$sujetRepository), 200, [], ['groups' => "reponse:read"]);
    }

    /**
     * @Route("/api/utilisateur/{id_utilisateur}", name="api_utilisateur", methods={"GET"})
     */
    public function get_utilisateur(UtilisateurRepository $utilisateurRepository, int $id_utilisateur)
    {
        return $this->json($utilisateurRepository->find($id_utilisateur), 200, [], ['groups' => "utilisateur:read"]);
    }

    /**
     * @Route("/api/utilisateurs", name="api_utilisateurs", methods={"GET"})
     */
    public function get_all_utilisateurs(UtilisateurRepository $utilisateurRepository)
    {
        return $this->json($utilisateurRepository->findAll(), 200, [], ['groups' => "utilisateur:read"]);
    }
}
