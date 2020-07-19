<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientPhone extends Model
{
    protected $fillable = [
        'phone'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
