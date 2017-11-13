<?php
namespace AppBundle;

use Spatie\OpeningHours\OpeningHours;
use Spatie\OpeningHours\Time;
use Spatie\OpeningHours\TimeRange;

class CustomOpeningHours extends OpeningHours
{
  /**
   * @param  DateTimeInterface $dateTime [description]
   * @return DateTime                   [description]
   */
  public function endOpen(\DateTimeInterface $dateTime): \DateTime
  {
    $answer = $dateTime;
    foreach ($this->forDate($dateTime) as $range)
    {
      if($range->containsTime(Time::fromDateTime($dateTime)))
      {
        $end = $range->end()->toDateTime();
        $answer->setTime($end->format('H'), $end->format('i'));

        // dump("endOpen asked for dt :" . $dateTime->format(\DateTime::ATOM) . ' : ' . $answer->format(\DateTime::ATOM));

        return $answer;
      }
    }

    throw new \RuntimeException('No range containing time found for input : ' . $dateTime->format(\DateTime::ATOM));

  }
}
