<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'plans';
	public function med()
    {
        return $this->hasOne('App\Med', 'id', 'med_id');
    }
    protected $fillable = ['med_id', 'interval', 'offset', 'dose' , 'repeats', 'name'];
    protected $with = ['med'];
}