<?php

namespace App\Console\Commands;

use App\Account;
use App\Category;

use function App\Lib\mb_normalise as normalise;

class ExportCategories extends AbstractExportCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:categories
                            {--ci : No progress bar (eg for CI)}';

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
             $accounts = $this->fecthAccounts(['category_id' => $category->id]);

             $name = normalise($category->name);
             $filename = "{$this->exportFolder}/{$name}{$this->exportFileExt}";

             $count = $this->exportAccounts($accounts, $filename, false, $this->option('ci'));

             $url = $this->storage->path($filename);
             $this->info("{$count} accounts '{$category->name}' exported into file '{$url}'");
         }
     }
}
