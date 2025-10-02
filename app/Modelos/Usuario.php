<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios';   // 👈 tu tabla en PostgreSQL
    protected $primaryKey = 'id';    // PK
    public $timestamps = false;      // porque usas created_at pero no updated_at

    protected $fillable = [
        'nombre',
        'email',
        'contrasenia',
        'idrols',
        'idvendedors',
        'idclientes',
    ];

    protected $hidden = [
        'contrasenia',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }

    /**
     * 👈 Hack para decirle a Laravel que el campo password es 'contrasenia'
     */
    public function getAuthPassword()
    {
        return $this->contrasenia;
    }

    /**
     * Valida credenciales usando la función PostgreSQL es_contrasenia_correcta
     *
     * @param string $email
     * @param string $contrasenia
     * @return int 0 = no existe, 1 = contraseña incorrecta, 2 = correcta
     */
    public static function validarCredenciales(string $email, string $contrasenia): int
    {
        $resultado = DB::selectOne(
            "SELECT es_contrasenia_correcta(?, ?) AS estado",
            [$email, $contrasenia]
        );

        return $resultado->estado ?? 0;
    }
    public static function obtenerUsuariosCompleto()
    {
        return collect(DB::select('SELECT * FROM obtener_usuarios_completo()'));
    }
    public static function eliminarPorId(int $id): void
    {
        \DB::statement('CALL eliminar_usuario_por_id(?)', [$id]);
    }

}
