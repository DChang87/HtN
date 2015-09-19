<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Med extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'meds';
    protected $fillable = ['name', 'manufacturer'];
}