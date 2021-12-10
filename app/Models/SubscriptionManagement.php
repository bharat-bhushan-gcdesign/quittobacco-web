<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionManagement extends Model
{
    protected $table='subscription_management';

    public function getRouteKeyName()
    {
        return 'code';
    }
}
