<?php
use Illuminate\Database\Seeder;
use App\RangeValue;

class Range_ValueTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       	$ranges = new RangeValue(); //continuidad
        $ranges->since = '0';
        $ranges->until = '0';
        $ranges->icono = 'RANGO_1';//icono verde
        $ranges->observation = 'valores no especificados';
        $ranges->recomendation = 'valores no especificados';
        $ranges->idranges = '2';
        $ranges->save();
        

        $ranges = new RangeValue(); //diferencial
        $ranges->since = '0';
        $ranges->until = '0';
        $ranges->icono = 'RANGO_1';//icono verde
        $ranges->observation = 'valores no especificados';
        $ranges->recomendation = 'valores no especificados';
        $ranges->idranges = '3';
        $ranges->save();
    }
}
