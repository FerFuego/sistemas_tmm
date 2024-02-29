<?php

use App\Validity;
use Illuminate\Database\Seeder;

class ValiditiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $val = new Validity();
        $val->type = 'pat';
        $val->since = '0';
        $val->until = '10';
        $val->state = 'Vigente';
        $val->save();

        $val = new Validity();
        $val->type = 'pat';
        $val->since = '11';
        $val->until = '11';
        $val->state = 'En fecha de renovación';
        $val->save();

        $val = new Validity();
        $val->type = 'pat';
        $val->since = '12';
        $val->until = '9999';
        $val->state = 'Medición no vigente';
        $val->save();

        /*---------------------*/

        $val = new Validity();
        $val->type = 'continuidad';
        $val->since = '0';
        $val->until = '10';
        $val->state = 'Vigente';
        $val->save();

        $val = new Validity();
        $val->type = 'pcontinuidadat';
        $val->since = '11';
        $val->until = '11';
        $val->state = 'En fecha de renovación';
        $val->save();

        $val = new Validity();
        $val->type = 'continuidad';
        $val->since = '12';
        $val->until = '9999';
        $val->state = 'Medición no vigente';
        $val->save();

        /*----------------------*/

        $val = new Validity();
        $val->type = 'diferencial';
        $val->since = '0';
        $val->until = '10';
        $val->state = 'Vigente';
        $val->save();

        $val = new Validity();
        $val->type = 'diferencial';
        $val->since = '11';
        $val->until = '11';
        $val->state = 'En fecha de renovación';
        $val->save();

        $val = new Validity();
        $val->type = 'diferencial';
        $val->since = '12';
        $val->until = '9999';
        $val->state = 'Medición no vigente';
        $val->save();

        /*---------------------*/

        $val = new Validity();
        $val->type = 'termografia';
        $val->since = '0';
        $val->until = '5';
        $val->state = 'Vigente';
        $val->save();

        $val = new Validity();
        $val->type = 'termografia';
        $val->since = '6';
        $val->until = '6';
        $val->state = 'En fecha de renovación';
        $val->save();

        $val = new Validity();
        $val->type = 'termografia';
        $val->since = '7';
        $val->until = '9999';
        $val->state = 'Medición no vigente';
        $val->save();

    }
}
