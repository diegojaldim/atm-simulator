<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'type',
        'bank_balance',
    ];

    /**
     * @param $userId
     * @param $type
     * @return Model
     */
    public static function getByUserAndType($userId, $type)
    {
        return self::where('user_id', '=', $userId)->where('type', '=', $type)->first();
    }

}
