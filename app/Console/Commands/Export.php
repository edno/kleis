<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Storage;

class Export extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export
                            {--ci : No progress bar (eg for CI)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export accounts, groups and categories at once';

    protected $commands = [
      'export:accounts',
      'export:groups',
      'export:categories'
    ];

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
        foreach ($this->commands as $cmd) {
          $this->call($cmd, [
            '--ci' => $this->option('ci')
          ]);
        }
    }
}
