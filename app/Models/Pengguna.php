<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Pengguna extends Authenticatable
{
    protected $table = 'pengguna';
}
