<?php
namespace AppBundle\Services;

use DirkOlbrich\YahooFinanceQuery\YahooFinanceQuery;

class YahooFinance
{
    const PERIOD = '-2 years';
    private $query;

    public function __construct()
    {
        $this->query = new YahooFinanceQuery(['returnType' => 'json']);
    }

    public function stockToArray($code)
    {
        $now = new \Datetime();
        $period = new \DateTime(self::PERIOD);
        $period->modify('first day of this month');
        $toDateString = $now->format('Y-m-d');
        $fromDateString = $period->format('Y-m-d');

        $json = $this->query->historicalQuote($code, $toDateString, $fromDateString, 'm')->get();

        $return = [];
        if ($json) {
            $rows = json_decode($json);
            foreach ($rows as $row) {
                $return[\DateTime::createFromFormat('Y-m-d', $row->Date)->format('Y-m')] = round($row->Close, 2);
            }
        }

        return $return;
    }

    public function sumResults(array $array)
    {
        $result = [];
        foreach ($array as $rows) {
            foreach ($rows as $date => $row) {
                if (!array_key_exists($date, $result)) {
                    $result[$date] = $row;
                } else {
                    $result[$date] += $row;
                }
            }
        }

        ksort($result);

        return $result;
    }
}
