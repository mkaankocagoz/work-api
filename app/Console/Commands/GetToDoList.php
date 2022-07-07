<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\ToDoList;

class GetToDoList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'work:get {type}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $type = $this->argument('type');

        $url = "";

        if($type == 1){
            $url = config('app.service_provider_1');
            $work_list = Http::acceptJson()->get($url)->json();

            foreach($work_list as $item){
                $list = ToDoList::updateOrCreate(
                    ['name' => $item['id']],
                    [
                        'level' => $item['zorluk'], 
                        'estimated_duration' => $item['sure'],
                        'provider_type' => $type,
                        'pending' => 1
                    ]
                );
            }

        }elseif($type == 2){
            $url = config('app.service_provider_2');
            $work_list = Http::acceptJson()->get($url)->json();

            foreach($work_list as $item){
                $list = ToDoList::updateOrCreate(
                    ['name' => array_keys($item)[0]],
                    [
                        'level' => $item[array_keys($item)[0]]['level'], 
                        'estimated_duration' => $item[array_keys($item)[0]]['estimated_duration'],
                        'provider_type' => $type,
                        'pending' => 1
                    ]
                );
            }

        }else{
            $this->error('Hatalı provider tipi');
        }

        return 0;
    }
}
