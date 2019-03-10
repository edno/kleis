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
    protected $signature = 'export:accounts
                            {--empty : Create empty file if no record}';

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
     * The export storage disk name.
     *
     * @var string
     */
    protected $storageDisk = 'export';

    /**
     * The export storage location.
     *
     * @var Illuminate\Contracts\Filesystem\Filesystem
     */
    protected $storage;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->storage = Storage::disk($this->storageDisk);
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

        if ($accounts->isEmpty() && !$this->option('empty')) {
            $this->info("No accounts to export");
            return;
        }

        $filename = "{$this->exportFolder}/{$this->exportFileName}{$this->exportFileExt}";
        $this->storage->put($filename, '');

        $count = count($accounts);

        $bar = $this->output->createProgressBar($count);

        foreach ($accounts as $account) {
            $this->storage->prepend($filename, "{$account->netlogin}:{$account->netpass}");
            $bar->advance();
        }

        $bar->finish();

        $url = $this->storage->path($filename);
        $this->info("\n{$count} accounts exported into file '{$url}'");
    }
}
