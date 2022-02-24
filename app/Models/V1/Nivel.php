<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Nivel
 * @package App\Models\V1
 * @OA\Schema(
 * )
 */
class Nivel extends Model
{
    /**
    * @OA\Property(property="id",type="number",example="1"),
    * @OA\Property(property="nivel",type="string",example="A"),
    * @OA\Property(property="goles_mes",type="number",example="5"),
    * @OA\Property(property="equipos_id",type="int",example="1"),
     */
    use HasFactory;
    use SoftDeletes;

    protected $table = 'niveles';
    protected $hidden = ["created_at", "updated_at", "deleted_at"];
}
