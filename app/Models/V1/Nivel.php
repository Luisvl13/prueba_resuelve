<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nivel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'niveles';
    protected $hidden = ["created_at", "updated_at", "deleted_at"];
}
