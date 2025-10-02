<?php
namespace App\Modelos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';   // nombre tabla
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'direccion',
        'telefono',
    ];

    // Relación con usuarios (1 cliente puede tener varios usuarios, si es el caso)
    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'idclientes');
    }
}
