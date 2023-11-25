<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    

    // use SoftDeletes;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
    
    

    public function product() {
        return $this->belongsTo(\App\Product::class);
    }


}
