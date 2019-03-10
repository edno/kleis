<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Account;
use App\Group;
use Storage;

class ExportGroups extends Command
{
    use Traits\StringNormalizeTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:groups
                            {--ci : No progress bar (eg for CI)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export proxy groups of accounts';

    /**
     * The export folder location.
     *
     * @var string
     */
    protected $exportFolder = 'groups';


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
         $groups = Group::get();

         if ($groups->isEmpty()) {
             $this->info("No groups to export");
             return;
         }

         foreach ($groups as $group){
             $accounts = Account::where('status', Account::ACCOUNT_ENABLE)
                            ->where('group_id', $group->id)
                            ->orderBy('netlogin', 'desc')
                            ->get();

             $count = count($accounts);

             $name = static::stringNormalise($group->name);
             $filename = "{$this->exportFolder}/{$name}{$this->exportFileExt}";
             $this->storage->put($filename, '');

             $flagCI = $this->option('ci');
             if ($flagCI === false) {
               $bar = $this->output->createProgressBar($count);
             }

             foreach ($accounts as $account) {
                 $this->storage->prepend($filename, "{$account->netlogin}");
                 if (isset($bar)) {
                   $bar->advance();
                 }
             }

             if (isset($bar)) {
               $bar->finish();
               $this->info("\n");
             }

             $url = $this->storage->path($filename);
             $this->info("{$count} accounts '{$group->name}' exported into file '{$url}'");
         }
     }
}
