<?php

namespace App\Helpers;


use App\Exceptions\BanknotesException;

class Banknotes
{

    /**
     * @param $value
     * @return array
     * @throws BanknotesException
     */
    public static function calculator($value)
    {
        $combination = [100, 50, 20];

        $banknotes = [];

        $i = 0;

        while ($value > 0) {

            if (!isset($combination[$i])) {
                throw new BanknotesException();
            }

            $cash = $combination[$i];

            $diff = $value - $cash;

            if ($diff < 0 || $diff == 10 || $diff == 30) {
                $i++;
            } else {
                $banknotes[] = $cash;
                $value -= $cash;
            }

        }

        return $banknotes;
    }

}
