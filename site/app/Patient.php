<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'patients';
    public function plans()
    {
        return $this->belongsToMany('App\Plan');
    }    
    protected $fillable = ['name', 'uid', 'age'];

    protected $with = array('plans');

}