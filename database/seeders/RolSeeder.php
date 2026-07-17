<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Roles
        $su = Role::create(['name' => 'su']);
        $admin = Role::create(['name' => 'admin']);

        // CRUD Role
        $permiso_crear_rol = Permission::create(['name' => 'crear rol']);
        $permiso_mostrar_rol = Permission::create(['name' => 'mostrar rol']);
        $permiso_mostrar_roles = Permission::create(['name' => 'mostrar roles']);
        $permiso_editar_rol = Permission::create(['name' => 'editar rol']);
        $permiso_eliminar_rol = Permission::create(['name' => 'eliminar rol']);

        // CRUD usuario
        $permiso_mostrar_usuario = Permission::create(['name' => 'mostrar usuario']);
        $permiso_mostrar_usuarios = Permission::create(['name' => 'mostrar usuarios']);
        $permiso_editar_usuario = Permission::create(['name' => 'editar usuario']);
        $permiso_eliminar_usuario = Permission::create(['name' => 'eliminar usuario']);

        // CRUD Sitio
        $permiso_crear_sitio = Permission::create(['name' => 'crear sitio']);
        $permiso_mostrar_sitio = Permission::create(['name' => 'mostrar sitio']);
        $permiso_mostrar_sitios = Permission::create(['name' => 'mostrar sitios']);
        $permiso_editar_sitio = Permission::create(['name' => 'editar sitio']);
        $permiso_eliminar_sitio = Permission::create(['name' => 'eliminar sitio']);        

        // Asignacion de permisos
        $permisos_su = [
            $permiso_crear_rol,
            $permiso_mostrar_rol,
            $permiso_mostrar_roles,
            $permiso_editar_rol,
            $permiso_eliminar_rol,
            $permiso_mostrar_usuario,
            $permiso_mostrar_usuarios,
            $permiso_editar_usuario,
            $permiso_eliminar_usuario,
            $permiso_crear_sitio,
            $permiso_mostrar_sitio,
            $permiso_mostrar_sitios,
            $permiso_editar_sitio,
            $permiso_eliminar_sitio            
        ];

        $permisos_admin = [
            $permiso_crear_sitio,
            $permiso_mostrar_sitio,
            $permiso_editar_sitio,
            $permiso_eliminar_sitio            
        ];


        // ... Faltan mas permisos por agregar


        // Asignamos los permisos a los roles
        $su->syncPermissions($permisos_su);
        $admin->syncPermissions($permisos_admin);
    }
}

