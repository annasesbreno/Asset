<?php

namespace App;
use Carbon\Carbon;
use App\Employee;
use Illuminate\Database\Eloquent\Model;

class Hardware extends Model
{
    protected $fillable =
    [
      'serial', 'model_name', 'hardwaretype_id', 'brand_id', 'processor_id', 'ram',
        'storage', 'storagetype_ud', 'purchased_date', 'warranty_date', 'status',
        'deployed_date', 'disposed_date'

    ];

    protected $dates = ['purchased_date', 'warranty_date', 'deployed_date', 'disposed_date'];

    public function owners()
    {
        return $this->hasMany('App\Employee','employee_id');
    }

    public function hardwareType()
    {
      return $this->belongsTo('App\HardwareType', 'hardwaretype_id');
    }

    public function deployed_by()
    {
      return $this->belongsTo('App\User', 'user_id');
    }

    public function brandKey()
    {
      return $this->belongsTo('App\Brand', 'brand_id');
    }
    public function processorKey()
    {
      return $this->belongsTo('App\Processor', 'processor_id');
    }

    public function storageType()
    {
      return $this->belongsTo('App\StorageType', 'storagetype_id');
    }
}
