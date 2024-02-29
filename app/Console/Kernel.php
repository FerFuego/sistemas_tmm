<?php

namespace App\Console;

use App\URL;
use Request;
use App\Alarm;
use App\Value;
use Carbon\Carbon;
use App\Mail\AlarmaEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use DateTimeZone;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule){

        //state  = Alarma -> solo hace email
        //state = Alerta -> solo en sistema

        $schedule->call(function () {
            $alarms = Alarm::where('published', '!=', 1)
                            ->where('state','=','Alarma')
                            ->where('date', '<', Carbon::now(new DateTimeZone('America/Argentina/Buenos_Aires'))->toDateTimeString())
                            ->whereNull('deleted_at')
                            ->get();
                        
            foreach($alarms as $a) {
                $values = Value::findOrFail($a['idvalues']);

                if($a['email'] != ''){               
                    $data = [
                        'user' => $a['name'], 
                        'message' => $a['detail'], 
                        'title' => $a['title'], 
                        'link' => 'http://tmm.wcanvasqa.com/'.$values->type.'/mediciones/ver/'.$values->id
                    ];
                    //'link' => Request::root().'/'.$values->type.'/mediciones/ver/'.$values->id
                    Mail::to($a['email'])->send(new AlarmaEmail($data));
                }
                $obj = Alarm::findOrFail($a['id']);
                $obj->published = true;
                $obj->save();
            }
        })->everyMinute();
    }


    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
