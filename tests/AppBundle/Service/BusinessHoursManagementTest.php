<?php

namespace Tests\AppBundle\Service;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Service\BusinessHoursManagement;

class BusinessHoursManagementTest extends WebTestCase
{

    public static $container;
    public static $serv;
    public static $DELTA;

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

       self::$DELTA = 4;
    }

    public function testNotInOpenHours()
    {
      // Dimanche
      $d = new \DateTime('12-11-2017 09:00:00');
      $answer = new \DateTime('14-11-2017 09:30:00');

      //$this->expectException(\RuntimeException::class);
      //self::$serv->addBusinessHours($d, self::$DELTA);
      $this->assertEquals($answer, self::$serv->addBusinessHours($d, self::$DELTA));
    }

    public function testMardi9Heures()
    {
      $d = new \DateTime('14-11-2017 09:00:00');
      $answer = new \DateTime('14-11-2017 14:30:00');
      $this->assertEquals($answer, self::$serv->addBusinessHours($d, self::$DELTA));
    }

    public function testVendredi10Heures()
    {
      $d = new \DateTime('17-11-2017 10:00:00');
      $answer = new \DateTime('20-11-2017 15:30:00');
      $this->assertEquals($answer, self::$serv->addBusinessHours($d, self::$DELTA));
    }

    public function testNouvelAn()
    {
      $d = new \DateTime('29-12-2017 10:00:00');
      $answer = new \DateTime('02-01-2018 11:00:00');
      $this->assertEquals($answer, self::$serv->addBusinessHours($d, self::$DELTA));
    }

}
