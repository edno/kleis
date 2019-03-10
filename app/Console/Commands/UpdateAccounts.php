<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Account;

class UpdateAccounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:accounts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Disable expired accounts';

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
        $accounts = Account::where('expire', '<=', date('Y-m-d'))
                    ->where('status', Account::ACCOUNT_ENABLE)
                    ->get();
        $count = count($accounts);
        $bar = $this->output->createProgressBar($count);
        foreach ($accounts as $account) {
            $account->disable();
            $bar->advance();
        }
        $bar->finish();
        $this->info("\n{$count} accounts disabled");
    }
}
