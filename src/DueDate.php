<?php declare(strict_types=1);

namespace Dominicus75\DueDate;

use \DateTime, \DateTimeImmutable, \DateInterval, \DatePeriod, \DateTimeZone, \InvalidArgumentException;

class DueDate
{
    /**
     * A napi munkaidő adatai.
     *
     * @var array
     */
    protected array $worktime = [
        'period' => 8,
        'start'  => null,
        'end'    => null
    ];

    /**
     * Inicializálja az új DueDate objektumpéldányt.
     *
     * @param  string|null $startingWork (H:i:s)
     * @param  int $worktime
     */
    public function __construct(
        string $startingWork = "9:0:0",
        int $worktime = 8
    ) {
        $start_string = explode(':', $startingWork);
        foreach ($start_string as $key => $value) {
            $value = (int) $value;
            switch($key) {
                case 0:
                    $result = ($value >= 0 && $value < 24) ? $value : 9;
                    break;
                case 1:
                case 2:
                    $result = ($value >= 0 && $value < 60) ? $value : 0;
                    break;
            }

            $start[$key] = $result;
        }

        $this->worktime['period'] = ($worktime > 0 && $worktime <= 24) ? $worktime : 8;
        $this->worktime['start']  = (new DateTimeImmutable())->setTime($start[0], $start[1], $start[2]);
        $this->worktime['end']    = $this->worktime['start']->add(new DateInterval('PT'.$worktime.'H'));
    }

    /**
     * A benyújtási időt és az átfutási időt fogadja bemenetként, és visszaadja azt a dátumot és időpontot 
     * - egy DateTimeImmutable objektumban - amikorra a problémát meg kell oldani.
     *
     * @param  \DateTimeImmutable|null $submissionDate benyújtási idő
     * @param  int|null $transitTime átfutási idő egész órában
     * 
     * @throws \InvalidArgumentException ha a benyújtási idő nem munkaidőben van.
     * 
     * @return \DateTimeImmutable a kért határidő
     */
    public function calculateDueDate(
        ?DateTimeImmutable $submissionDate = null,
        ?int $transitTime = null
    ): DateTimeImmutable {
        $submissionDate = $submissionDate instanceof DateTimeImmutable ? $submissionDate : new DateTimeImmutable();

        if($submissionDate < $this->worktime['start'] || $submissionDate > $this->worktime['end']) {
            throw new InvalidArgumentException("Hibát csak munkaidőben lehet jelenteni!");
        }

        $transitDays = !is_null($transitTime) 
            ? (int) round(num: $transitTime/$this->worktime['period'], mode: PHP_ROUND_HALF_UP) 
            : 1
        ;

        $transitInterval = new DateInterval('P'.$transitDays.'D');

        return $submissionDate->add($transitInterval);
    }

}