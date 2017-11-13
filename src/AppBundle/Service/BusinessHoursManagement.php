<?php
namespace AppBundle\Service;

use Psr\Log\LoggerInterface;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Spatie\OpeningHours\OpeningHours;

class BusinessHoursManagement
{
    private $logger;


    public function __construct(LoggerInterface $logger, ContainerInterface $container)
    {
      $this->container = $container;
      $this->logger = $logger;

      // Load business hours config
      $root = $this->container->get('kernel')->getRootDir();
      $config = Yaml::parse(file_get_contents($root.'/config/openinghours.yml'));


      $this->opnHrs = OpeningHours::create($config);
    }

    /**
     * @param \DateTime $from  Initial datetime
     * @param int $hours Number of hours to add
     * @return \DateTime
     */
    public function addBusinessHours($from, $hours)
    {
        $this->logger->debug('Starting addBusinessHours');
        return new \DateTime();
    }
}
