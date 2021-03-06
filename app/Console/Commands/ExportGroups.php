<?php

namespace App\Console\Commands;

use App\Group;

use function App\Lib\mb_normalise as normalise;

class ExportGroups extends AbstractExportCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:groups
                            {--ci : No interaction (no progess, no confirmation)}
                            {output? : Target location for export (default Storage)}';

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
            $accounts = $this->fecthAccounts(['group_id' => $group->id]);

             $name = normalise($group->name);
             $filename = "{$this->exportFolder}/{$name}{$this->exportFileExt}";

             $count = $this->exportAccounts($accounts, $filename, false, $this->option('ci'));

             try {
                 $url = $this->exportToLocation($filename);
             } catch(\Exception $e) {
                 $this->error('Export cancelled by user!');
                 return;
             }

             $this->info("{$count} accounts '{$group->name}' exported into file '{$url}'");
         }
     }
}
