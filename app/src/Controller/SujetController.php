<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use App\Entity\Sujet;
use App\Repository\SujetRepository;
use App\Form\SujetType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

class SujetController extends AbstractController
{
    /**
     * @Route("/sujet/{id_categorie}", name="sujet")
     */
    public function index($id_categorie, EntityManagerInterface $entityManager, SujetRepository $sujetRepository, CategorieRepository $categorieRepository)
    {
        return $this->render('sujet/index.html.twig', [
            'sujets' => $sujetRepository->findByCategorie($id_categorie,$entityManager,$categorieRepository),
	    'categorie' => $categorieRepository->find($id_categorie)
        ]);
    }

    /**
     * @Route("/user/sujet/creer/{id_categorie}", name="creer_sujet")
     */
    public function createSujet($id_categorie, Request $request, EntityManagerInterface $entityManager, UserInterface $user, CategorieRepository $categorieRepository)
    {
        $sujet = new Sujet();
	$sujet->setUtilisateur($user);
	$categorie = $categorieRepository->find($id_categorie);
	$sujet->setCategorie($categorie);

        $form = $this->createForm(SujetType::class, $sujet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $entityManager->persist($data);
            $entityManager->flush();

            $this->addFlash('message', 'Sujet créé avec succès');
            return $this->redirectToRoute('sujet', array(
                'id_categorie' => $id_categorie
            ));
        }
        
        return $this->render('sujet/createsujet.html.twig', [
            'sujetForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/sujet/edition/{id_categorie}/{id}", name="edition_sujet")
     */
    public function editSujet($id_categorie, $id, Request $request, EntityManagerInterface $entityManager, SujetRepository $sujetRepository)
    {
        $sujet = $sujetRepository->find($id);

        $form = $this->createForm(SujetType::class, $sujet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $entityManager->persist($data);
            $entityManager->flush();

            $this->addFlash('message', 'sujet créé avec succès');
            return $this->redirectToRoute('sujet', array(
                'id_categorie' => $id_categorie
            ));
        }
        
        return $this->render('sujet/createsujet.html.twig', [
            'sujetForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/sujet/supprimer/{id_categorie}/{id}", name="supprimer_sujet")
     */
    public function deleteSujet($id_categorie, $id, EntityManagerInterface $entityManager, SujetRepository $sujetRepository)
    {
        $sujet = $sujetRepository->find($id);

        if (!$sujet) {
            throw $this->createNotFoundException('No guest found');
        }
    
        $entityManager->remove($sujet);
        $entityManager->flush();
    
        return $this->redirectToRoute('sujet', array(
                'id_categorie' => $id_categorie
            ));  
    }
}
