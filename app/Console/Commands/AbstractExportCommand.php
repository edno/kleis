<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;
use App\Account;

abstract class AbstractExportCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = '';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    /**
     * The export folder location.
     *
     * @var string
     */
    protected $exportFolder = '';

    /**
     * The export file name.
     *
     * @var string
     */
    protected $exportFileName = '';


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
    abstract public function handle();


    /**
     * Export filtered accounts into target file.
     *
     * @param App\Account $accounts
     * @param string $filename
     * @param bool $password
     * @param bool $flagCI
     *
     * @return int
     */
    final protected function exportAccounts($accounts, $filename, $password = false, $flagCI = false)
    {
        $this->storage->put($filename, '');

        $count = count($accounts);

        if ($flagCI === false) {
          $bar = $this->output->createProgressBar($count);
        }

        foreach ($accounts as $account) {
            $record = "{$account->netlogin}";
            $record .= $password ? ":{$account->netpass}" : '';
            $this->storage->prepend($filename, $record);
            if (isset($bar)) {
              $bar->advance();
            }
        }

        if (isset($bar)) {
          $bar->finish();
          $this->info("\n");
        }

        return $count;
    }

    /**
     * Retrieve enabled accounts.
     *
     * @param array $filter
     *
     * @return App\Account
     */
    final protected function fecthAccounts($filter=null)
    {
        $query = Account::where('status', Account::ACCOUNT_ENABLE);

        if(is_null($filter) === false && is_array($filter)) {
          $query = $query->where($filter);
        }

        return $query->orderBy('netlogin', 'desc')->get();
    }

    final protected function exportToLocation($filename)
    {
        $source = $this->storage->path($filename);

        if($this->argument('output')) {
            $target = $this->argument('output') . '/' . $filename;

            $fs = new Filesystem(new Local('/'));

            if ($fs->has($target) ) {
                if ($this->option('ci')) {
                    $fs->delete($target);
                } else {
                    if ($this->confirm("Overwrite existing '$target' ?")) {
                        $fs->delete($target);
                    } else {
                      throw new \Exception();
                    }
                }
            }

            $fs->rename($source, $target);

        } else {
          $target = $source;
        }

        return $target;
    }
}
