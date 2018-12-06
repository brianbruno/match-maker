<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;

class EnviarStatusDiario extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'enviar:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia os status diarios dos usuarios.';

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
        $users = User::all();
        $bar = $this->output->createProgressBar(count($users));
        $bar->setFormat(' %current%/%max% [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s% %memory:6s%');
        $this->info('');
        $this->info('');
        $bar->start();   
        $bar->setMaxSteps(sizeof($users));
      
        foreach($users as $user) {
          $user->sendStatus();
          $bar->advance();
        }
      
      $bar->finish();
      $this->info('');
      $this->info('');
      $this->info('');      
        
    }
}
