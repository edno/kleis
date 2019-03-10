<?php

namespace App\Console\Commands;

use App\ProxyListItem;

class ExportWhitelists extends AbstractExportCommand
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
            if (isset($bar)) {
              $bar->advance();
            }
        }

        if (isset($bar)) {
          $bar->finish();
          $this->info("\n");
        }

        $url = $this->storage->path($filename);
        $this->info("{$count} {$type}s exported into file '{$url}'");
    }
}
