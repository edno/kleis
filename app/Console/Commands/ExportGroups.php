<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Account;
use App\Group;
use Storage;

class ExportGroups extends Command
{
    use StringNormalizeTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:groups';

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
         $groups = Group::get();

         if ($groups->isEmpty()) {
             $this->info("No groups to export");
             return;
         }

         foreach ($groups as $group){
             $name = static::stringNormalise($group->name);
             $filename = "{$this->exportFolder}/{$name}{$this->exportFileExt}";
             $accounts = Account::where('status', Account::ACCOUNT_ENABLE)
                            ->where('group_id', $group->id)
                            ->orderBy('netlogin', 'desc')
                            ->get();
             Storage::disk('export')->put($filename, '');
             $count = count($accounts);
             $bar = $this->output->createProgressBar($count);
             foreach ($accounts as $account) {
                 Storage::disk('export')->prepend($filename, "{$account->netlogin}:{$account->netpass}");
                 $bar->advance();
             }
             $bar->finish();
             $url = Storage::disk('export')->path($filename);
             $this->info("\n{$count} accounts '{$group->name}' exported into file '{$url}'");
         }
     }
}
