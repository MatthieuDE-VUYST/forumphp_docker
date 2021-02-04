<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UtilisateurFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user_root = new Utilisateur();
        $user_root->setEmail("root@root.fr");
        $user_root->setRoles(array("ROLE_ADMIN","ROLE_USER"));
	    $user_root->setPseudo("root");
        $user_root->setAdmin(True);
        $user_root->setDateNaissance(date_create('2000-01-01'));
        $user_root->setPassword('a94a8fe5ccb19ba61c4c0873d391e987982fbbd3');
        $user_root->setApiToken("API_ROOT");

        $manager->persist($user_root);

        $manager->flush();
    }
}
