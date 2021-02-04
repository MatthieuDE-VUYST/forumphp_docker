<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use App\Form\CategorieType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class CategorieController extends AbstractController
{
    /**
     * @Route("/categorie", name="categorie")
     */
    public function index(CategorieRepository $categorieRepository)
    {
        return $this->render('categorie/index.html.twig', [
            'categories' => $categorieRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/categorie/creer", name="creer_categorie")
     */
    public function createCategorie(Request $request, EntityManagerInterface $entityManager)
    {
        $categorie = new Categorie();

        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $entityManager->persist($data);
            $entityManager->flush();

            $this->addFlash('message', 'Categorie créé avec succès');
            return $this->redirectToRoute('categorie');
        }
        
        return $this->render('categorie/createcategorie.html.twig', [
            'categorieForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/categorie/edition/{id}", name="edition_categorie")
     */
    public function editCategorie($id, Request $request, EntityManagerInterface $entityManager, CategorieRepository $categorieRepository)
    {
        $categorie = $categorieRepository->find($id);

        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $entityManager->persist($data);
            $entityManager->flush();

            $this->addFlash('message', 'Categorie créé avec succès');
            return $this->redirectToRoute('categorie');
        }
        
        return $this->render('categorie/createcategorie.html.twig', [
            'categorieForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/categorie/supprimer/{id}", name="supprimer_categorie")
     */
    public function deleteCategorie($id, EntityManagerInterface $entityManager, CategorieRepository $categorieRepository)
    {
        $categorie = $categorieRepository->find($id);

        if (!$categorie) {
            throw $this->createNotFoundException('No guest found');
        }
    
        $entityManager->remove($categorie);
        $entityManager->flush();
    
        return $this->redirectToRoute('categorie');  
    }
}
