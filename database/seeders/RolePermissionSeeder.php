<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Resetear caché
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ========================================
        // DEFINIR TODOS LOS PERMISOS
        // ========================================
        
        $permissions = [
            // USUARIOS (5)
            'usuarios.ver', 'usuarios.crear', 'usuarios.editar', 'usuarios.eliminar', 'usuarios.perfil',
            
            // ROLES Y PERMISOS (5)
            'roles.ver', 'roles.crear', 'roles.editar', 'roles.eliminar', 'roles.permisos',
            
            // CATEGORÍAS (4)
            'categorias.ver', 'categorias.crear', 'categorias.editar', 'categorias.eliminar',
            
            // AVES (7)
            'aves.ver', 'aves.crear', 'aves.editar', 'aves.eliminar', 'aves.detalles', 'aves.fotos', 'aves.historial',
            
            // PROVEEDORES (5)
            'proveedores.ver', 'proveedores.crear', 'proveedores.editar', 'proveedores.eliminar', 'proveedores.exportar',
            
            // COMPRAS (6)
            'compras.ver', 'compras.crear', 'compras.editar', 'compras.eliminar', 'compras.detalles', 'compras.exportar',
            
            // VENTAS (6)
            'ventas.ver', 'ventas.crear', 'ventas.editar', 'ventas.eliminar', 'ventas.historial', 'ventas.exportar',
            
            // STOCK E INVENTARIO (5)
            'stock.ver', 'stock.movimientos', 'stock.ajustar', 'stock.alertas', 'stock.control',
            
            // MÉTODOS DE PAGO (4)
            'metodos_pago.ver', 'metodos_pago.crear', 'metodos_pago.editar', 'metodos_pago.eliminar',
            
            // CAJA (6)
            'caja.ver', 'caja.abrir', 'caja.cerrar', 'caja.movimientos', 'caja.pagos', 'caja.arqueo',
            
            // COTIZACIONES (5)
            'cotizaciones.ver', 'cotizaciones.crear', 'cotizaciones.editar', 'cotizaciones.eliminar', 'cotizaciones.convertir',
            
            // PEDIDOS (5)
            'pedidos.ver', 'pedidos.crear', 'pedidos.editar', 'pedidos.eliminar', 'pedidos.estado',
            
            // REPORTES (8)
            'reportes.ventas', 'reportes.compras', 'reportes.inventario', 'reportes.financiero', 
            'reportes.historial_ventas', 'reportes.productos_disponibles', 'reportes.dashboard', 'reportes.avanzados',
            
            // AUDITORÍA (3)
            'auditoria.ver', 'auditoria.eliminar', 'auditoria.exportar',
            
            // NOTIFICACIONES (3)
            'notificaciones.ver', 'notificaciones.crear', 'notificaciones.gestionar',
            
            // ENCUESTAS (3)
            'encuestas.ver', 'encuestas.crear', 'encuestas.responder',
            
            // SISTEMA (3)
            'sistema.backup', 'sistema.restaurar', 'sistema.configuracion',
        ];

        // Crear todos los permisos
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $this->command->info('✓ ' . count($permissions) . ' permisos creados');

        // ========================================
        // CREAR 3 ROLES
        // ========================================

        // 🔴 ADMINISTRADOR (Encargado/Dueño) - Control total
        $administrador = Role::create(['name' => 'Administrador']);
        $administrador->givePermissionTo(Permission::all()); // TODOS los permisos
        $this->command->info('✓ Administrador creado con ' . $administrador->permissions->count() . ' permisos (TODOS)');

        // 🟡 VENDEDOR (Empleado) - Operaciones de venta
        $vendedor = Role::create(['name' => 'Vendedor']);
        $vendedor->givePermissionTo([
            // Usuarios (solo perfil propio)
            'usuarios.perfil',
            // Categorías (solo ver)
            'categorias.ver',
            // Aves (ver, detalles, fotos)
            'aves.ver', 'aves.detalles', 'aves.fotos',
            // Ventas (crear, ver, historial, exportar)
            'ventas.ver', 'ventas.crear', 'ventas.historial', 'ventas.exportar',
            // Stock (ver y movimientos)
            'stock.ver', 'stock.movimientos',
            // Métodos de pago (solo ver)
            'metodos_pago.ver',
            // Caja (operaciones completas)
            'caja.ver', 'caja.abrir', 'caja.cerrar', 'caja.movimientos', 'caja.pagos',
            // Cotizaciones (ver, crear, convertir)
            'cotizaciones.ver', 'cotizaciones.crear', 'cotizaciones.convertir',
            // Pedidos (ver, crear, editar estado)
            'pedidos.ver', 'pedidos.crear', 'pedidos.estado',
            // Reportes básicos
            'reportes.ventas', 'reportes.historial_ventas', 'reportes.productos_disponibles',
            // Notificaciones
            'notificaciones.ver',
        ]);
        $this->command->info('✓ Vendedor creado con ' . $vendedor->permissions->count() . ' permisos');

        // 🟢 CLIENTE (Comprador) - Solo consultas y pedidos
        $cliente = Role::create(['name' => 'Cliente']);
        $cliente->givePermissionTo([
            // Ver perfil propio
            'usuarios.perfil',
            // Ver catálogo de aves
            'aves.ver', 'aves.detalles', 'aves.fotos',
            // Cotizaciones (ver y crear)
            'cotizaciones.ver', 'cotizaciones.crear',
            // Pedidos (ver propios y crear)
            'pedidos.ver', 'pedidos.crear',
            // Encuestas (responder)
            'encuestas.responder',
            // Ver productos disponibles
            'reportes.productos_disponibles',
        ]);
        $this->command->info('✓ Cliente creado con ' . $cliente->permissions->count() . ' permisos');

        $this->command->info('');
        $this->command->info('========================================');
        $this->command->info('✅ SISTEMA DE PERMISOS HUAVIAR CREADO');
        $this->command->info('========================================');
        $this->command->info('Total de permisos: ' . Permission::count());
        $this->command->info('Total de roles: ' . Role::count());
        $this->command->info('');
        $this->command->info('Roles creados:');
        $this->command->info('  🔴 Administrador → ' . $administrador->permissions->count() . ' permisos');
        $this->command->info('  🟡 Vendedor → ' . $vendedor->permissions->count() . ' permisos');
        $this->command->info('  🟢 Cliente → ' . $cliente->permissions->count() . ' permisos');
    }
}