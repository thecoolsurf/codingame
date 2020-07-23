<?php
// tests/Controller/Admin/BodyController.php

namespace App\Tests\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BodyControllerTest extends WebTestCase
{
    
    public function testListing()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/admin/body/listing');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
    
//    public function testEdit()
//    {
//        $client = static::createClient();
//        $crawler = $client->request('GET', '/admin/body/edit/1');
//        $this->assertEquals(200, $client->getResponse()->getStatusCode());
//    }
//    
//    public function testNew()
//    {
//        $client = static::createClient();
//        $crawler = $client->request('GET', '/admin/body/new');
//        $this->assertEquals(200, $client->getResponse()->getStatusCode());
//    }
//    
//    public function testDelete()
//    {
//        $client = static::createClient();
//        $crawler = $client->request('GET', '/admin/body/delete/1');
//        $this->assertEquals(200, $client->getResponse()->getStatusCode());
//    }
    
}
