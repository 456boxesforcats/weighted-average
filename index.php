<?php

$prices = [
    '2022-01-02 00:00' => '5',
    '2022-01-02 10:00' => '6',
    '2022-01-02 12:00' => '100000',
    '2022-01-02 12:01' => '6',
    '2022-01-02 20:00' => '5',
    '2022-01-02 21:00' => '6.2',
    '2022-01-02 22:00' => '100000',
    '2022-01-02 23:00' => '50000'
];

/**
 * Returns difference between 2 dates in minutes
 *
 * @param string $startDate
 * @param string $endDate
 * @return int
 */
function getDatesDiff(string $startDate, string $endDate): int
{
    return round((strtotime($endDate) - strtotime($startDate)) / 60);
}

/**
 * Returns next array key
 *
 * @param array $array
 * @param string $key
 * @return string|null
 */
function getNextKey(array $array, string $key) : ?string
{
    $currentKey = key($array);

    while ($currentKey !== null && $currentKey !== $key) {
        next($array);
        $currentKey = key($array);
    }

    next($array);

    return key($array);
}

/**
 * Calculates prices weighted average
 *
 * @param array $prices
 * @return float
 */
function getPrice(array $prices): float
{
    $price = 0;
    $weightsSum = 0;

    if (empty($prices)) {
        return 0;
    }

    foreach ($prices as $date => $datePrice) {
        $nextDate = getNextKey($prices, $date);

        if ($nextDate !== null) {
            $weight = getDatesDiff($date, $nextDate);
            $price += $weight * $datePrice;
            $weightsSum += $weight;
        }
    }

    return round($price / $weightsSum, 2);
}

echo getPrice($prices);
