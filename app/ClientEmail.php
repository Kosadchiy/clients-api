<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientEmail extends Model
{
    protected $fillable = [
        'email'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
