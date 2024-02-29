<?php

use Illuminate\Database\Seeder;
use App\State;

class StatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $state = new State();
       $state->state = 'Bueno';
       $state->observation = 'Valores no especificados';
       $state->type = 'termografia';
       $state->idranges = 4;
       $state->save();

       $state = new State();
       $state->state = 'Regular';
       $state->observation = 'Valores no especificados';
       $state->type = 'termografia';
       $state->idranges = 4;
       $state->save();

       $state = new State();
       $state->state = 'Malo';
       $state->observation = 'Valores no especificados';
       $state->type = 'termografia';
       $state->idranges = 4;
       $state->save();
    }
}
