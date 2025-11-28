<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Modelos\Usuario;

class SincronizarRolesUsuarios extends Command
{
    protected $signature = 'usuarios:sincronizar-roles';
    protected $description = 'Sincroniza los roles de Spatie con los idrols de la tabla usuarios';

    public function handle()
    {
        $this->info('🔄 Sincronizando roles de usuarios...');
        $this->newLine();

        // 👇 MAPEO CORREGIDO SEGÚN TU BASE DE DATOS
        $mapaRoles = [
            1 => 'Vendedor',       // idrols = 1 → Vendedor
            2 => 'Cliente',        // idrols = 2 → Cliente
            3 => 'Administrador',  // idrols = 3 → Administrador
        ];

        $usuarios = Usuario::all();
        $sincronizados = 0;
        $errores = 0;

        foreach ($usuarios as $usuario) {
            try {
                $rolSpatie = $mapaRoles[$usuario->idrols] ?? null;

                if ($rolSpatie) {
                    // Remover roles anteriores y asignar el nuevo
                    $usuario->syncRoles([$rolSpatie]);
                    
                    $this->line("✓ {$usuario->nombre} (ID: {$usuario->id}, idrols: {$usuario->idrols}) → {$rolSpatie}");
                    $sincronizados++;
                } else {
                    $this->warn("⚠ {$usuario->nombre} tiene idrols inválido: {$usuario->idrols}");
                    $errores++;
                }
            } catch (\Exception $e) {
                $this->error("✗ Error con {$usuario->nombre}: " . $e->getMessage());
                $errores++;
            }
        }

        $this->newLine();
        $this->info("========================================");
        $this->info("✅ Sincronización completada");
        $this->info("========================================");
        $this->info("Total de usuarios: " . $usuarios->count());
        $this->info("Sincronizados: {$sincronizados}");
        
        if ($errores > 0) {
            $this->warn("Con errores: {$errores}");
        }

        // Limpiar caché de permisos
        \Artisan::call('cache:forget', ['key' => 'spatie.permission.cache']);
        $this->info('✓ Caché de permisos limpiada');

        return Command::SUCCESS;
    }
}