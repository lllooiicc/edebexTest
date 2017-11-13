<?php

namespace Tests\AppBundle\Service;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Service\BusinessHoursManagement;

class BusinessHoursManagementTest extends WebTestCase
{

    public static $container;
    public static $serv;

    public static function setUpBeforeClass()
    {
       //start the symfony kernel
       $kernel = static::createKernel();
       $kernel->boot();

       //get the DI container
       self::$container = $kernel->getContainer();

       //now we can instantiate our service (if you want a fresh one for
       //each test method, do this in setUp() instead
       self::$serv = self::$container->get('BusinessHoursManagement');
    }

    public function testIndex()
    {
        $now = new \DateTime();
        $this->assertEquals($now, self::$serv->addBusinessHours($now, 0));
    }
}
