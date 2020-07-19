<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'name',
        'surname'
    ];

    protected $with = [
        'phones',
        'emails'
    ];

    public function phones()
    {
        return $this->hasMany(ClientPhone::class);
    }

    public function emails()
    {
        return $this->hasMany(ClientEmail::class);
    }
}
