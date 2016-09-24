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
                            {--list= : type of whitelist (domain or url)}
                            {--blacklist : export blacklist instead of whitelist}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export proxy whitelists (domain, url)';

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
        $ext = $isWhiteList ? 'white' : 'black';
        $filename = "export/proxylists/{$type}.{$ext}.txt";
        Storage::put($filename, '');
        $count = count($items);
        $bar = $this->output->createProgressBar($count);
        foreach ($items as $item) {
            Storage::prepend($filename, "{$item->value}");
            $bar->advance();
        }
        $bar->finish();

        $this->info("\n{$count} {$type}s exported into file 'storage/app/{$filename}'");
    }
}
