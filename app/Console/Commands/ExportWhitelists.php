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
                            {--blacklist : Export blacklist instead of whitelist}';

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

        if ($items->isEmpty()) {
            $this->info("No {$type} record to export");
            return;
        }

        $list = $isWhiteList ? 'white' : 'black';
        $filename = "{$this->exportFolder}/{$type}.{$list}{$this->exportFileExt}";
        Storage::disk('export')->put($filename, '');
        $count = count($items);
        $bar = $this->output->createProgressBar($count);
        foreach ($items as $item) {
            Storage::disk('export')->prepend($filename, "{$item->value}");
            $bar->advance();
        }
        $bar->finish();
        $url = Storage::disk('export')->path($filename);
        $this->info("\n{$count} {$type}s exported into file '{$url}'");
    }
}
