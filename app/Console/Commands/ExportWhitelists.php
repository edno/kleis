<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\ProxyListItem;
use Storage;

class ExportWhitelists extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:whitelists
                            {--list= : Type of whitelist (domain or url)}
                            {--blacklist : Export blacklist instead of whitelist}
                            {--ci : No progress bar (eg for CI)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export proxy whitelists (domain, url)';

    /**
     * The export folder location.
     *
     * @var string
     */
    protected $exportFolder = 'proxylists';


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
        $whitelist = empty($this->option('blacklist'));
        if ( false === empty($this->option('list'))) {
            $this->exportProxyList($this->option('list'), $whitelist);
        } else {
            $this->exportProxyList('domain', $whitelist);
            $this->exportProxyList('url', $whitelist);
        }
    }

    private function exportProxyList($type, $isWhiteList)
    {
        $items = ProxyListItem::where('type', $type)
                    ->where('whitelist', $isWhiteList)
                    ->orderBy('value', 'desc')
                    ->get();
        $count = count($items);

        if ($items->isEmpty()) {
            $this->info("No {$type} record to export");
            return;
        }

        $list = $isWhiteList ? 'white' : 'black';
        $filename = "{$this->exportFolder}/{$type}.{$list}{$this->exportFileExt}";
        $this->storage->put($filename, '');

        $flagCI = $this->option('ci');
        if ($flagCI === false) {
          $bar = $this->output->createProgressBar($count);
        }

        foreach ($items as $item) {
            $this->storage->prepend($filename, "{$item->value}");
            if ($flagCI === false) {
              $bar->advance();
            }
        }

        if ($flagCI === false) {
          $bar->finish();
          $this->info("\n");
        }

        $url = $this->storage->path($filename);
        $this->info("{$count} {$type}s exported into file '{$url}'");
    }
}
