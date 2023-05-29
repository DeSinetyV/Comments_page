<?php

namespace App\DataFixtures;

use App\Entity\Commentaires;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use phpDocumentor\Reflection\PseudoTypes\True_;

class CommentairesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        for ($i = 1; $i <= 10; $i++) {
            $commentaire = new Commentaires();
            $commentaire->setTitre("test $i");
            $commentaire->setTexte("<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Libero quo nam consequatur quasi quod! Rem dolores veniam provident ipsam asperiores reiciendis? Non nobis iste, rem quia optio aut et ex nisi, a voluptates architecto aperiam placeat neque sapiente unde sed!</p>
            <p>Saepe mollitia culpa explicabo assumenda laudantium delectus dolorum necessitatibus alias, dolores aut sapiente, nam temporibus dicta consectetur tempore soluta quis repellendus error ipsam. Cum blanditiis rem dolor recusandae omnis velit architecto reiciendis possimus dolore accusantium. Assumenda amet doloribus voluptates perferendis.</p>");
            $commentaire->setVisible(True);
            $commentaire->setEmail("test@test.fr");
            $commentaire->setNote(5);
            $commentaire->setPseudo("pseudo $i");
            $commentaire->setCreationDate(new \DateTime());

            $manager->persist($commentaire);
        }

        $manager->flush();
    }
}
