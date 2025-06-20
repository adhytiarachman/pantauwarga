<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RejectedUser extends Model
{
    protected $fillable = ['name', 'email', 'no_kk', 'rejected_at'];
}
