<?php

namespace App\Console\Commands;

class ExportAccounts extends AbstractExportCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:accounts
                            {--empty : Create empty file if no record}
                            {--ci : No progress bar (eg for CI)}';

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
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $accounts = $this->fecthAccounts();

        if ($accounts->isEmpty() && !$this->option('empty')) {
            $this->info("No accounts to export");
            return;
        }

        $filename = "{$this->exportFolder}/{$this->exportFileName}{$this->exportFileExt}";

        $count = $this->exportAccounts($accounts, $filename, true, $this->option('ci'));

        $url = $this->storage->path($filename);
        $this->info("{$count} accounts exported into file '{$url}'");

    }
}
