<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Account;
use Storage;

class ExportAccounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:accounts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export active proxy accounts';

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
        $accounts = Account::where('status', 1)->orderBy('netlogin', 'desc')->get();
        $filename = 'export/accounts/accounts.txt';
        Storage::put($filename, '');
        $count = count($accounts);
        $bar = $this->output->createProgressBar($count);
        foreach ($accounts as $account) {
            Storage::prepend($filename, "{$account->netlogin}:{$account->netpass}");
            $bar->advance();
        }
        $bar->finish();
        $this->info("\n{$count} accounts exported into file 'storage/app/{$filename}'");
    }
}
