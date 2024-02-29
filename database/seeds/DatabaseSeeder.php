<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // La creación de datos de roles debe ejecutarse primero
	    $this->call(RoleTableSeeder::class);
	    // Los usuarios necesitarán los roles previamente generados
    	$this->call(UserTableSeeder::class);
        // Crea Rangos iniciales
        $this->call(RangesTableSeeder::class);
        // Crea Valores de Rangos Criticos iniciales
        $this->call(CriticalitiesTableSeeder::class);
        // Crea Valores de Estados iniciales
        $this->call(StatesTableSeeder::class);
        // Crea Valores de Validaciones iniciales
        $this->call(ValiditiesTableSeeder::class);
        // Crea Valores de Ranges Values iniciales
        $this->call(Range_ValueTableSeeder::class);
    }
}
