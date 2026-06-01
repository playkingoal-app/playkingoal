<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $rolAdministrador = Role::firstOrCreate(['name' => 'Administrador']);
        $rolJugador = Role::firstOrCreate(['name' => 'Jugador']);


        Permission::firstOrCreate(['name' => 'modulo-jornadas'])->syncRoles([$rolAdministrador],$rolJugador);
        Permission::firstOrCreate(['name' => 'modulo-pronosticos'])->syncRoles([$rolAdministrador, $rolJugador]);
        Permission::firstOrCreate(['name' => 'modulo-jugadores'])->syncRoles([$rolAdministrador]);
        Permission::firstOrCreate(['name' => 'modulo-resultados'])->syncRoles([$rolAdministrador, $rolJugador]);
        Permission::firstOrCreate(['name' => 'modulo-partidos'])->syncRoles([$rolAdministrador]);
        Permission::firstOrCreate(['name' => 'modulo-equipos'])->syncRoles([$rolAdministrador]);
        Permission::firstOrCreate(['name' => 'modulo-perfil'])->syncRoles([$rolAdministrador, $rolJugador]);
        Permission::firstOrCreate(['name' => 'modulo-torneos'])->syncRoles([$rolAdministrador]);



        Permission::firstOrCreate(['name' => 'boton-agregarResultado'])->syncRoles([$rolAdministrador]);
        Permission::firstOrCreate(['name' => 'boton-bloquearPronostico'])->syncRoles([$rolAdministrador]);









    }
}
