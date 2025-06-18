<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class xml extends Model
{
    protected $table = "storage";
    protected $fillable = ["title","description","code"];
}
