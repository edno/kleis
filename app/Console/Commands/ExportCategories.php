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
         $categories = Category::get();

         if ($categories->isEmpty()) {
             $this->info("No categories to export");
             return;
         }

         foreach ($categories as $category){
             $accounts = Account::where('status', Account::ACCOUNT_ENABLE)
                            ->where('category_id', $category->id)
                            ->orderBy('netlogin', 'desc')
                            ->get();

             $count = count($accounts);

             $name = static::stringNormalise($category->name);
             $filename = "{$this->exportFolder}/{$name}{$this->exportFileExt}";
             $this->storage->put($filename, '');

             $flagCI = $this->option('ci');
             if ($flagCI === false) {
               $bar = $this->output->createProgressBar($count);
             }

             foreach ($accounts as $account) {
                 $this->storage->prepend($filename, "{$account->netlogin}:{$account->netpass}");
                 if (isset($bar)) {
                   $bar->advance();
                 }
             }

             if (isset($bar)) {
               $bar->finish();
               $this->info("\n");
             }

             $url = $this->storage->path($filename);
             $this->info("{$count} accounts '{$category->name}' exported into file '{$url}'");
         }
     }
}
