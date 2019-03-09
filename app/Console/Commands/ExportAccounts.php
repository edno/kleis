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
     * The export folder location.
     *
     * @var string
     */
    protected $exportFolder = 'accounts';

    /**
     * The export file name.
     *
     * @var string
     */
    protected $exportFileName = 'accounts';


    /**
     * The export extension file.
     *
     * @var string
     */
    protected $exportFileExt = '.txt';

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
        $accounts = Account::where('status', Account::ACCOUNT_ENABLE)
                      ->orderBy('netlogin', 'desc')->get();

        if ($accounts->isEmpty()) {
            $this->info("No accounts to export");
            return;
        }

        $filename = "{$this->exportFolder}/{$this->exportFileName}{$this->exportFileExt}";
        Storage::disk('export')->put($filename, '');
        $count = count($accounts);
        $bar = $this->output->createProgressBar($count);
        foreach ($accounts as $account) {
            Storage::disk('export')->prepend($filename, "{$account->netlogin}:{$account->netpass}");
            $bar->advance();
        }
        $bar->finish();
        $url = Storage::disk('export')->path($filename);
        $this->info("\n{$count} accounts exported into file '{$url}'");
    }
}
