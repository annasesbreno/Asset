<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
  public function created_by()
  {
    return $this->belongsTo('App\User', 'user_id');
  }
}
