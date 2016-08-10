<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Account;
use Storage;

class ExportGroups extends Command
{
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
    protected $description = 'Export proxy groups (category) of accounts';

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
         $groups = Account::ACCOUNT_CATEGORY;
         foreach ($groups as $id => $group){
             $filename = 'export/groups/group-' . str_pad($id, 4, '0', STR_PAD_LEFT) . '.txt';
             $accounts = Account::where('status', 1)->where('category', $id)->orderBy('netlogin', 'desc')->get();
             Storage::put($filename, '');
             $count = count($accounts);
             $bar = $this->output->createProgressBar($count);
             foreach ($accounts as $account) {
                 Storage::prepend($filename, "{$account->netlogin}:{$account->netpass}");
                 $bar->advance();
             }
             $bar->finish();
             $this->info("\n{$count} accounts '{$group['text']}' exported into file 'storage/app/{$filename}'");
         }
     }
}
