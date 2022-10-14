<?php

namespace App\Lib;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class Git extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pull files from GIT';

    /**
     * Is the code already updated or not
     * 
     * @var boolean
     */
    private $alreadyUpToDate;

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
     * Run git pull process
     * 
     * @return boolean
     */

    public function runPull() {
        $process = new Process(['git', 'pull']);

        $process->run(function($type, $buffer) {
            if($buffer == "Already up to date.\n") {
                $this->alreadyUpToDate = TRUE;
            }
        });

        return $process->isSuccessful();
    }

}