<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Utilisateur;
use App\Entity\Sujet;
use App\Entity\Reponse;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class CategorieFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $a = new Categorie();
        $a->setNom("Jeux Video");
        $manager->persist($a);

        $b = new Categorie();
        $b->setNom("Programation");
        $manager->persist($b);

        $c = new Categorie();
        $c->setNom("Litterature");
        $manager->persist($c);

        $user_1 = new Utilisateur();
        $user_1->setEmail("matthieu@test.fr");
        $user_1->setRoles(array("ROLE_USER"));
	    $user_1->setPseudo("Matthieu");
        $user_1->setAdmin(False);
        $user_1->setDateNaissance(date_create('1999-01-01'));
        $user_1->setPassword('a94a8fe5ccb19ba61c4c0873d391e987982fbbd3');
        $user_1->setApiToken("API_USER1");
        $manager->persist($user_1);


        $user_2 = new Utilisateur();
        $user_2->setEmail("erwan@test.fr");
        $user_2->setRoles(array("ROLE_USER"));
	    $user_2->setPseudo("Erwan");
        $user_2->setAdmin(False);
        $user_2->setDateNaissance(date_create('1999-01-01'));
        $user_2->setPassword('a94a8fe5ccb19ba61c4c0873d391e987982fbbd3');
        $user_2->setApiToken("API_USER2");
        $manager->persist($user_2);

        $s_1 = new Sujet();
        $s_1->setTitre("Cyberpunk 2077");
        $s_1->setCategorie($a);
        $s_1->setUtilisateur($user_1);
        $manager->persist($s_1);
    
            $r1_1 = new Reponse();
            $r1_1->setMessage("Je trouve ça scandaleux que CDPR ait sorti ces versions PS4 et Xbox injouables et je suis très heureux qu'ils proposent un remboursement.");
            $r1_1->setSujet($s_1);
            $r1_1->setUtilisateur($user_2);
            $manager->persist($r1_1);

            $r1_2 = new Reponse();
            $r1_2->setMessage("J'espère quand même qu'ils ne vont pas mettre la clef sous la porte parce que j'estime que des jeux comme ça, qui tentent autre chose, il en faudrait plus.");
            $r1_2->setSujet($s_1);
            $r1_2->setUtilisateur($user_1);
            $manager->persist($r1_2);

            $r1_3 = new Reponse();
            $r1_3->setMessage("Vu le shitstorm qui se déverse sur C2077 et sur CDPR, je me demande si malgré tout vous aviez une bonne expérience de jeu comme moi ?");
            $r1_3->setSujet($s_1);
            $r1_3->setUtilisateur($user_2);
            $manager->persist($r1_3);

        $s_2 = new Sujet();
        $s_2->setTitre("Minecraft");
        $s_2->setCategorie($a);
        $s_2->setUtilisateur($user_2);
        $manager->persist($s_2);

        $s_3 = new Sujet();
        $s_3->setTitre("How to install symfony with composer?");
        $s_3->setCategorie($b);
        $s_3->setUtilisateur($user_1);
        $manager->persist($s_3);
           
            $r3_1 = new Reponse();
            $r3_1->setMessage("I am using Windows 10 When I install symfony2 with:<br>
                composer create-project symfony/framework-standard-edition my_project_name<br>
            Error:<br>
                bash: composer: command not found");
            $r3_1->setSujet($s_3);
            $r3_1->setUtilisateur($user_1);
            $manager->persist($r3_1);

            $r3_2 = new Reponse();
            $r3_2->setMessage("To downloads symfony, you need to download symfony.phar (a small file PHP) from this link: http://symfony.com/installer");
            $r3_2->setSujet($s_3);
            $r3_2->setUtilisateur($user_2);
            $manager->persist($r3_2);
    
        $manager->flush();
    }
}
