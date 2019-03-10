<?php

namespace App\Console\Commands;

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
                            {--ci : No interaction (no progess, no confirmation)}
                            {output? : Target location for export (default Storage)}';

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

             try {
                 $url = $this->exportToLocation($filename);
             } catch(\Exception $e) {
                 $this->error('Export cancelled by user!');
                 return;
             }

             $this->info("{$count} accounts '{$category->name}' exported into file '{$url}'");
         }
     }
}
