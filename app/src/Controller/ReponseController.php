<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use App\Entity\Sujet;
use App\Repository\SujetRepository;
use App\Entity\Reponse;
use App\Repository\ReponseRepository;
use App\Form\ReponseType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

class ReponseController extends AbstractController
{
    /**
     * @Route("/reponse/{id_categorie}/{id_sujet}", name="reponse")
     */
    public function index($id_categorie, $id_sujet, EntityManagerInterface $entityManager, CategorieRepository $categorieRepository, SujetRepository $sujetRepository, ReponseRepository $reponseRepository)
    {
        return $this->render('reponse/index.html.twig', [
            'reponses' => $reponseRepository->findBySujet($id_sujet,$entityManager,$sujetRepository),
	    'sujet' => $sujetRepository->find($id_sujet),
	    'categorie' => $categorieRepository->find($id_categorie)
        ]);
    }

    /**
     * @Route("/user/reponse/creer/{id_categorie}/{id_sujet}", name="creer_reponse")
     */
    public function createReponse($id_categorie, $id_sujet, Request $request, EntityManagerInterface $entityManager, UserInterface $user, SujetRepository $sujetRepository)
    {
        $reponse = new Reponse();
	$reponse->setUtilisateur($user);
	$sujet = $sujetRepository->find($id_sujet);
	$reponse->setSujet($sujet);

        $form = $this->createForm(ReponseType::class, $reponse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $entityManager->persist($data);
            $entityManager->flush();

            $this->addFlash('message', 'Reponse créé avec succès');
            return $this->redirectToRoute('reponse', array(
                'id_sujet' => $id_sujet,
		'id_categorie' => $id_categorie
            ));
        }
        
        return $this->render('reponse/createreponse.html.twig', [
            'reponseForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/reponse/edition/{id_categorie}/{id_sujet}/{id}", name="edition_reponse")
     */
    public function editReponse($id, $id_categorie, $id_sujet, Request $request, EntityManagerInterface $entityManager, ReponseRepository $reponseRepository)
    {
        $reponse = $reponseRepository->find($id);

        $form = $this->createForm(ReponseType::class, $reponse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $entityManager->persist($data);
            $entityManager->flush();

            $this->addFlash('message', 'reponse créé avec succès');
            return $this->redirectToRoute('reponse', array(
                'id_sujet' => $id_sujet,
		'id_categorie' => $id_categorie
            ));
        }
        
        return $this->render('reponse/createreponse.html.twig', [
            'reponseForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/reponse/supprimer/{id_categorie}/{id_sujet}/{id}", name="supprimer_reponse")
     */
    public function deleteReponse($id, $id_categorie, $id_sujet, EntityManagerInterface $entityManager, ReponseRepository $reponseRepository)
    {
        $reponse = $reponseRepository->find($id);

        if (!$reponse) {
            throw $this->createNotFoundException('No guest found');
        }
    
        $entityManager->remove($reponse);
        $entityManager->flush();
    
        return $this->redirectToRoute('reponse', array(
                'id_sujet' => $id_sujet,
		'id_categorie' => $id_categorie
            ));  
    }
}
