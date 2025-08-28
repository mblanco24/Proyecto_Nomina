<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Constancia extends Model
{
    protected $table = 'constancia'; // Asegúrate de que coincide con el nombre real de tu tabla
    protected $primaryKey = 'id_constancia'; // Si tu clave primaria no es "id"


    // Opcional: si quieres definir qué campos son rellenables (por seguridad)
    protected $fillable = [
        'empleado_id', 'empleado_nombre', 'tipo_constancia', 'contenido', 'fecha'
    ];
}
