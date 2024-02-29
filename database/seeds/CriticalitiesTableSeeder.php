<?php

use Illuminate\Database\Seeder;
use App\Criticality;

class CriticalitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $crit = new Criticality();
		$crit->since_1 = '0';
		$crit->since_2 = '0';
		$crit->since_3 = '0';
		$crit->since_4 = '0';
		$crit->until_1 = '0';
		$crit->until_2 = '0';
		$crit->until_3 = '0';
		$crit->until_4 = '0';
		$crit->observation_1 = 'Normal';
		$crit->observation_2 = 'Incipiente';
		$crit->observation_3 = 'Pronunciada';
		$crit->observation_4 = 'Severa';
		$crit->idranges = '1';
		$crit->save();

		$crit = new Criticality();
		$crit->since_1 = '0';
		$crit->since_2 = '0';
		$crit->since_3 = '0';
		$crit->since_4 = '0';
		$crit->until_1 = '0';
		$crit->until_2 = '0';
		$crit->until_3 = '0';
		$crit->until_4 = '0';
		$crit->observation_1 = 'Normal';
		$crit->observation_2 = 'Incipiente';
		$crit->observation_3 = 'Pronunciada';
		$crit->observation_4 = 'Severa';
		$crit->idranges = '2';
		$crit->save();

		$crit = new Criticality();
		$crit->since_1 = '0';
		$crit->since_2 = '0';
		$crit->since_3 = '0';
		$crit->since_4 = '0';
		$crit->until_1 = '0';
		$crit->until_2 = '0';
		$crit->until_3 = '0';
		$crit->until_4 = '0';
		$crit->observation_1 = 'Normal';
		$crit->observation_2 = 'Incipiente';
		$crit->observation_3 = 'Pronunciada';
		$crit->observation_4 = 'Severa';
		$crit->idranges = '3';
		$crit->save();
    }
}
