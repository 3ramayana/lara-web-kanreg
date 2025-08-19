<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'penulis']);

        Permission::create(['name' => 'tambah-tulisan']);
        Permission::create(['name' => 'edit-tulisan']);
        Permission::create(['name' => 'lihat-tulisan']);
        Permission::create(['name' => 'hapus-tulisan']);

        Permission::create(['name' => 'tambah-user']);
        Permission::create(['name' => 'edit-user']);
        Permission::create(['name' => 'lihat-user']);
        Permission::create(['name' => 'hapus-user']);

        $role = Role::findByName('penulis');
        $role->givePermissionTo('tambah-tulisan');
        $role->givePermissionTo('edit-tulisan');
        $role->givePermissionTo('lihat-tulisan');
        $role->givePermissionTo('hapus-tulisan');

        $role = Role::findByName('admin');
        $role->givePermissionTo('tambah-user');
        $role->givePermissionTo('edit-user');
        $role->givePermissionTo('lihat-user');
        $role->givePermissionTo('hapus-user');
    }
}
