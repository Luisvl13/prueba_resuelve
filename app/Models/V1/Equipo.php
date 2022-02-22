<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipo extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'equipos';
    protected $hidden = ["created_at", "updated_at", "deleted_at"];

    public function niveles()
    {
        return $this->hasMany(Nivel::class, 'equipos_id');
    }
}
