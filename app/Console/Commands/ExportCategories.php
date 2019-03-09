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
     * The export folder location.
     *
     * @var string
     */
    protected $exportFolder = 'categories';


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
         $categories = Category::get();

         if ($categories->isEmpty()) {
             $this->info("No categories to export");
             return;
         }

         foreach ($categories as $category){
             $name = static::stringNormalise($category->name);
             $filename = "{$this->exportFolder}/{$name}{$this->exportFileExt}";
             $accounts = Account::where('status', Account::ACCOUNT_ENABLE)
                            ->where('category_id', $category->id)
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
             $this->info("\n{$count} accounts '{$category->name}' exported into file '{$url}'");
         }
     }
}
