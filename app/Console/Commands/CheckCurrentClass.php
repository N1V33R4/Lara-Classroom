<?php

namespace App\Console\Commands;

use App\Models\Classroom;
use Illuminate\Console\Command;

class CheckCurrentClass extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:class';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '
        Check active classes and determine if end date is reached. Set ending class as inactive.
        If planned class exists, set that as current. 
        ';

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
        $ending_classes = Classroom::where('status', 'current')
                            ->whereDate('end_date', date('Y-m-d'))
                            ->get();
        foreach ($ending_classes as $class) 
        {
            $class->update([ 'status' => 'finished' ]);
            $class->room->update([ 'occupied' => false ]);
            $class->studentGroups->update([ 'active' => false ]);
        }

        $starting_classes = Classroom::where('status', 'future')
                            ->whereDate('start_date', date('Y-m-d'))
                            ->get()->unique('room_id'); // in case future start_dates overlap
        foreach ($starting_classes as $class) 
        {
            $class->update([ 'status' => 'current' ]);
            $class->room->update([ 'occupied' => true ]);
        }
        return 0;
    }
}
