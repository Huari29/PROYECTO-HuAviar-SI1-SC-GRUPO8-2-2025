<?php

namespace App\Observers;

use App\Modelos\Usuario;

class UsuarioObserver
{
    /**
     * Sincronizar rol de Spatie cuando se crea un usuario
     */
    public function created(Usuario $usuario): void
    {
        $this->sincronizarRol($usuario);
    }

    /**
     * Sincronizar rol de Spatie cuando se actualiza un usuario
     */
    public function updated(Usuario $usuario): void
    {
        // Solo sincronizar si cambió idrols
        if ($usuario->isDirty('idrols')) {
            $this->sincronizarRol($usuario);
        }
    }

    /**
     * Asignar rol de Spatie según idrols
     */
    private function sincronizarRol(Usuario $usuario): void
    {
        // 👇 MAPEO CORREGIDO SEGÚN TU BASE DE DATOS
        $mapaRoles = [
            1 => 'Vendedor',       // idrols = 1 → Vendedor
            2 => 'Cliente',        // idrols = 2 → Cliente
            3 => 'Administrador',  // idrols = 3 → Administrador
        ];

        // Obtener el rol correspondiente
        $rolSpatie = $mapaRoles[$usuario->idrols] ?? null;

        if ($rolSpatie) {
            // Remover todos los roles anteriores
            $usuario->syncRoles([]);
            
            // Asignar el nuevo rol
            $usuario->assignRole($rolSpatie);
        }
    }
}