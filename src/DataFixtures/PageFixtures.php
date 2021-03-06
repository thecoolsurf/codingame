<?php
/* src/DataFixtures/PageFixtures.php */

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Page;
use App\Entity\Body;

class PageFixtures extends Fixture
{

    public function load(ObjectManager $em)
    {
        $menus = ['home', 'about', 'practice', 'login'];

        $text['home'] = 'Codez mieux Progressez en résolvant des challenges dans 25+ langages de programmation et technologies du moment. Apprenez des meilleurs Explorez de nouveaux frameworks, langages ou algorithmes à travers des jeux et tutoriels créés par les meilleurs programmeurs. Devenez un expert Notre approche a été conçue pour accompagner les développeurs confirmés dans leur passage au niveau supérieur.';
        $text['about'] = 'Chez CodinGame, notre but est de permettre aux développeurs d\'améliorer leurs compétences en continu en résolvant les problèmes de code les plus motivants et en échangeant avec les meilleurs programmeurs du monde.';
        $text['practice'] = 'La section des exercices suivant est consacrée aux développeurs PHP par le site Codingame afin de leur permettre de progresser dans leur language. Chaque exercice aborde un problème que le développeur doit résoudre en proposant le code solution.';
        $text['login'] = 'If you want to access the section ADMIN to this website you must be logged in.';

        foreach ($menus as $slug):
            // page
            $page = new Page();
            $page->setH1(ucfirst($slug));
            $page->setSlug($slug);
            $em->persist($page);
            // body
            $body = new Body();
            $body->setPage($page);
            $body->setH2(ucfirst('H2 tag for title '.$slug));
            $body->setDescription($text[$slug]);
            $em->persist($body);
        endforeach;
        $em->flush();
    }

}
