<?php

namespace App\Console\Commands;

use App\Interfaces\League;
use App\User;
use Illuminate\Console\Command;

class AtualizarInformacoes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'league:atualizar';

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
     * @return void
     */
    public function handle() {
        $users = User::all();
        $league = new League();

        foreach ($users as $user) {
            $league->atualizarPerfil($user);
            $league->atualizarPartidas($user);
            $league->atualizarRanks($user);
        }

    }
}
