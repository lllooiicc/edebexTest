<?php
namespace AppBundle\Service;

use Psr\Log\LoggerInterface;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\DependencyInjection\ContainerInterface;

use AppBundle\CustomOpeningHours;

class BusinessHoursManagement
{
    private $logger;


    public function __construct(LoggerInterface $logger, ContainerInterface $container)
    {
      $this->container = $container;
      $this->logger = $logger;
      $this->opnHrs = CustomOpeningHours::create($this->_getOpeningHoursConfig());
    }

    protected function _getOpeningHoursConfig() : Array
    {
      // Load business hours config
      $root = $this->container->get('kernel')->getRootDir();
      $config = Yaml::parse(file_get_contents($root.'/config/openinghours.yml'));

      return $config;
    }

    /**
     * @param \DateTime $from  Initial datetime
     * @param int $hours Number of hours to add
     * @return \DateTime
     */
    public function addBusinessHours($from, $hours) : \DateTime
    {
        $this->logger->debug('Starting addBusinessHours');

        if(!$this->opnHrs->isOpenAt($from))
        {
          throw new \RuntimeException('Datetime is not included in opened times');
        }

        $tmpDateTime = $from;
        $interval = new \DateInterval('PT' . $hours . 'H');

        return $this->_addRange($tmpDateTime, $interval);
    }

    /**
     * @param  DateTime     $dt    [description]
     * @param  DateInterval $range [description]
     * @return DateTime           [description]
     */
    protected function _addRange(\DateTime $dt, \DateInterval $range) : \DateTime
    {
      $endOpen = $this->opnHrs->endOpen(clone $dt);
      $tmp = clone $dt;

      if($tmp->add($range) < $endOpen) // Enought time
      {
        return $tmp;
      }
      else // Not enought
      {
        $nextOpen = $this->opnHrs->nextOpen(clone $dt);
        $newInterval = $tmp->diff($endOpen, true);

        // self calling with next open datetime and interval reduced by the time spent in the current business time range
        return $this->_addRange($nextOpen, $newInterval);
      }
    }
}
