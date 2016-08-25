<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Account;
use App\Category;
use Storage;

class ExportCategories extends Command
{
    use StringNormalizeTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:categories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export proxy categories of accounts';

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
         $categories = Category::get();
         foreach ($categories as $category){
             $name = static::stringNormalise($category->name);
             $filename = 'export/categories/' . $name . '.txt';
             $accounts = Account::where('status', 1)->where('category_id', $category->id)->orderBy('netlogin', 'desc')->get();
             Storage::put($filename, '');
             $count = count($accounts);
             $bar = $this->output->createProgressBar($count);
             foreach ($accounts as $account) {
                 Storage::prepend($filename, "{$account->netlogin}:{$account->netpass}");
                 $bar->advance();
             }
             $bar->finish();
             $this->info("\n{$count} accounts '{$category->name}' exported into file 'storage/app/{$filename}'");
         }
     }
}
