<?php
// tests/Controller/Admin/BodyController.php

namespace App\Tests\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Guard\Token\PostAuthenticationGuardToken;
use App\Entity\User;

class BodyControllerTest extends WebTestCase
{
    
    private $client = null;
    private $em = null;

    public function setUp()
    {
        $this->client = static::createClient();
        $kernel = self::bootKernel();
        $this->em = $kernel->getContainer()->get('doctrine')->getManager();
    }

    public function logAdminUser()
    {
        $user = $this->em->getRepository(User::class)->findOneBy(['username' => 'user01']);
        $this->assertSame(['ROLE_ADMIN','ROLE_USER'],$user->getRoles());
        return $user;
    }

    public function testListing()
    {
        $user = $this->logAdminUser();
        $token = new PostAuthenticationGuardToken($user, 'secure_area', $user->getRoles());
        $session = self::$container->get('session');
        $session->set('_security_secured_area', serialize($token));
        $session->save();
        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
        $this->client->request('GET', '/admin/listing/body');
        $this->client->request('GET', '/login');
//        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
    }
    
//    public function testEdit()
//    {
//        $client = static::createClient();
//        $crawler = $client->request('GET', '/admin/body/edit/1');
//        $this->assertEquals(200, $client->getResponse()->getStatusCode());
//    }

//    public function testNew()
//    {
//        $client = static::createClient();
//        $crawler = $client->request('GET', '/admin/body/new');
//        $this->assertEquals(200, $client->getResponse()->getStatusCode());
//    }

//    public function testDelete()
//    {
//        $cl//    ient = static::createClient();
//        $crawler = $client->request('GET', '/admin/body/delete/1');
//        $this->assertEquals(200, $client->getResponse()->getStatusCode());
//    }
    
}
