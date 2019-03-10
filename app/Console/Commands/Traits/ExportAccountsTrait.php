<?php

namespace App\Console\Commands\Traits;

trait ExportAccountsTrait
{
    public function exportAccount($accounts, $filename, $password = false, $flagCI = false)
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
}
