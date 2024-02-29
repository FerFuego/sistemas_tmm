<?php

use Illuminate\Database\Seeder;
use App\Range;

class RangesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ranges = new Range();
        $ranges->type = 'pat';
        $ranges->value_max = '0';
        $ranges->observation = 'valores no especificados';
        $ranges->description = 'valores no especificados';
        $ranges->recomendation = 'valores no especificados';
        $ranges->save();

        $ranges = new Range();
        $ranges->type = 'continuidad';
        $ranges->value_max = '0';
        $ranges->observation = 'valores no especificados';
        $ranges->description = 'valores no especificados';
        $ranges->recomendation = 'valores no especificados';
        $ranges->save();

        $ranges = new Range();
        $ranges->type = 'diferencial';
        $ranges->value_max = '0';
        $ranges->observation = 'valores no especificados';
        $ranges->description = 'valores no especificados';
        $ranges->recomendation = 'valores no especificados';
        $ranges->save();

        $ranges = new Range();
        $ranges->type = 'termografia';
        $ranges->value_max = '0';
        $ranges->observation = 'valores no especificados';
        $ranges->description = 'valores no especificados';
        $ranges->recomendation = 'valores no especificados';
        $ranges->save();
    }
}
