<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Utilisateur;
use App\Repository\UtilisateurRepository;
use App\Form\UtilisateurType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class UtilisateurController extends AbstractController
{
    /**
     * @Route("/admin/utilisateur", name="utilisateur")
     */
    public function index(UtilisateurRepository $utilisateurRepository)
    {
        return $this->render('utilisateur/index.html.twig', [
            'utilisateurs' => $utilisateurRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/utilisateur/creer", name="creer_compte")
     */
    public function createUser(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $userPasswordEncoderInterface)
    {
        $user = new Utilisateur();

        $form = $this->createForm(UtilisateurType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword( 
                $userPasswordEncoderInterface->encodePassword( $user, $user->getPassword() )
            );
            $data = $form->getData();

            $entityManager->persist($data);
            $entityManager->flush();

            $this->addFlash('message', 'Utilisateur créé avec succès');
            return $this->redirectToRoute('utilisateur');
        }
        
        return $this->render('utilisateur/createuser.html.twig', [
            'userForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/utilisateur/edition/{id}", name="edition_utilisateur")
     */
    public function editUser($id, Request $request, EntityManagerInterface $entityManager, UtilisateurRepository $utilisateurRepository, UserPasswordEncoderInterface $userPasswordEncoderInterface)
    {
        $user = $utilisateurRepository->find($id);

        $form = $this->createForm(UtilisateurType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
	    $user->setPassword( 
                $userPasswordEncoderInterface->encodePassword( $user, $user->getPassword() )
            );
            $data = $form->getData();

            $entityManager->persist($data);
            $entityManager->flush();

            $this->addFlash('message', 'Categorie créé avec succès');
            return $this->redirectToRoute('utilisateur');
        }
        
        return $this->render('utilisateur/createuser.html.twig', [
            'userForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/utilisateur/supprimer/{id}", name="supprimer_utilisateur")
     */
    public function deleteUser($id, EntityManagerInterface $entityManager, UtilisateurRepository $utilisateurRepository)
    {
        $utilisateur = $utilisateurRepository->find($id);

        if (!$utilisateur) {
            throw $this->createNotFoundException('No guest found');
        }
    
        $entityManager->remove($utilisateur);
        $entityManager->flush();
    
        return $this->redirectToRoute('utilisateur');  
    }
}
