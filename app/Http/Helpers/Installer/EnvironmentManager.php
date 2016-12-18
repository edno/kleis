<?php

namespace App\Http\Helpers\Installer;

use Exception;
use Illuminate\Http\Request;

class EnvironmentManager
{
    /**
     * @var string
     */
    private $envPath;

    /**
     * @var string
     */
    private $envExamplePath;

    /**
     * Set the .env and .env.example paths.
     */
    public function __construct()
    {
        $this->envPath = base_path('.env');
        $this->envExamplePath = base_path('.env.example');
    }

    /**
     * Get the content of the .env file.
     *
     * @return string
     */
    public function getEnvContent($request)
    {
        $data = $request->session()->all();

        $env = '';
        foreach($data as $key => $value) {
            if(preg_match('/^[A-Z]+_[A-Z]+$/', $key)) {
                $env .= "${key}=${value}" . PHP_EOL;
            }
        }

        return $env;
    }

    /**
     * Save the edited content to the file.
     *
     * @param Request $input
     * @return boolean
     */
    public function saveFile(Request $request)
    {
        $message = trans('installer.environment.success');
        $status = true;

        try {
            file_put_contents($this->envPath, $request->get('envConfig'));
        } catch(Exception $e) {
            $status = false;
        }

        $request->session()->flash('status', $message);

        return $status;
    }
}
