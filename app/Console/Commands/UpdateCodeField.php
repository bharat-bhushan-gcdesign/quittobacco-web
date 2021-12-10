<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\WithWhom;
use Illuminate\Support\Str;

class UpdateCodeField extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'codefield-generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To update code field with random value in all the tables';

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
     * @return mixed
     */
    public function handle()
    {
        $this->info('test-jk executed succsfuly');
        \Log::info('test-run');

        $carvings = WithWhom::all();

        foreach ($carvings  as  $carving) {
            do{
                $code=Str::random(4);
            } while (WithWhom::where('code', $code)->exists());
            $carving->code=$code;
            $carving->save();

        $this->info('test-j'.$carving->id);
       
        }

    }
}
