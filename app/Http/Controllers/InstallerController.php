<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Artisan;
use App\Http\Requests;
use App\Http\Helpers\Installer\DatabaseManager;
use App\Http\Helpers\Installer\EnvironmentManager;
use App\Http\Helpers\Installer\PermissionsChecker;
use App\Http\Helpers\Installer\RequirementsChecker;
use App\Http\Helpers\Installer\InstalledFileManager;

class InstallerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('canInstall');
    }

    /**
     * Display the installer welcome page.
     *
     * @return \Illuminate\View\View
     */
    public function stepWelcome()
    {
        return view('installer.welcome');
    }

    /**
     * XXXXXXXXXX
     *
     * @return \Illuminate\View\View
     */
    public function stepApplication()
    {
        return view('installer.application');
    }

    /**
     * XXXXXXXXXX
     *
     * @return \Illuminate\View\View
     */
    public function stepStoreApp(Request $request, Redirector $redirect)
    {
        session([
            'APP_URL'    => $request->url,
            'APP_LOCALE' => $request->locale,
            'APP_ENV'    => $request->env,
            'APP_KEY'    => env('APP_KEY')
        ]);

        return $redirect->route('KleisInstaller::stepDatabase');
    }

    /**
     * XXXXXXXXXX
     *
     * @return \Illuminate\View\View
     */
    public function stepDatabase()
    {
        return view('installer.database');
    }

    /**
     * XXXXXXXXXX
     *
     * @return \Illuminate\View\View
     */
    public function stepStoreDb(Request $request, Redirector $redirect)
    {
        session([
            'DB_CONNECTION' => $request->dbtype,
            'DB_HOST'       => $request->dbhost,
            'DB_PORT'       => $request->dbport,
            'DB_DATABASE'   => $request->dbname,
            'DB_USERNAME'   => $request->dbuser,
            'DB_PASSWORD'   => $request->dbpassword
        ]);

        return $redirect->route('KleisInstaller::stepCustomization');
    }

    /**
     * XXXXXXXXXX
     *
     * @return \Illuminate\View\View
     */
    public function stepCustomization(Request $request)
    {
        $request->session()->forget('KLEIS_LOGO');
        $request->session()->forget('KLEIS_ANNOUNCE');

        return view('installer.customization');
    }

    /**
     * XXXXXXXXXX
     *
     * @return \Illuminate\View\View
     */
    public function stepStoreCusto(Request $request, Redirector $redirect)
    {
        $validator = Validator::make($request->all(), [
            'logo' => 'image|mimes:jpeg,png|dimensions:max_height:200',
        ]);

        if ($validator->fails()) {
            return $redirect->route('KleisInstaller::stepCustomization')
                            ->withErrors($validator)
                            ->withInput();
        }

        if ($request->hasFile('logo')) {
            if ($request->file('logo')->isValid()) {
                $ext = $request->logo->guessClientExtension();
                $filename = "logo.{$ext}";
                $request->logo->move('images', $filename);
                session(['KLEIS_LOGO' => $filename]);
            }
        }

        if(!empty($request->announce)) {
            $filename = 'announce.md';
            $mdfile = public_path("markdown/{$filename}");
            try {
                file_put_contents($mdfile, $request->announce);
            }  catch(Exception $e) {
                return $redirect->route('KleisInstaller::stepCustomization')
                                ->withInput();
            }
            session(['KLEIS_ANNOUNCE' => $filename]);
        }

        return $redirect->route('KleisInstaller::stepEnvironment');
    }


    /**
     * XXXXXXXXXX
     *
     * @return \Illuminate\View\View
     */
    public function stepEnvironment(EnvironmentManager $environmentManager, Request $request)
    {
        $envConfig = $environmentManager->getEnvContent($request);

        return view('installer.environment', compact('envConfig'));
    }

    /**
     * Processes the newly saved environment configuration and continue.
     *
     * @param Request $input
     * @param Redirector $redirect
     * @return \Illuminate\Http\RedirectResponse
     */
    public function stepSaveEnv(EnvironmentManager $environmentManager, Request $request, Redirector $redirect)
    {
        $status = $environmentManager->saveFile($request);

        if($status) {
            return $redirect->route('KleisInstaller::stepRequirements')
                            ->with(['message' => session('message')]);
        } else {
            return $redirect->route('KleisInstaller::stepEnvironment')
                            ->with(['message' => session('message')]);
        }
    }

    /**
     * Display the permissions check page.
     *
     * @return \Illuminate\View\View
     */
    public function stepPermissions(PermissionsChecker $checker)
    {
        $permissions = $checker->check(config('installer.permissions'));

        return view('installer.permissions', compact('permissions'));
    }

    /**
     * Display the requirements page.
     *
     * @return \Illuminate\View\View
     */
    public function stepRequirements(RequirementsChecker $checker)
    {
        $requirements = $checker->check(config('installer.requirements'));

        return view('installer.requirements', compact('requirements'));
    }

    /**
     * XXXXXXXXXX
     *
     * @return \Illuminate\View\View
     */
    public function stepMigrate(DatabaseManager $databaseManager)
    {
        $response = $databaseManager->migrateAndSeed();

        return redirect()->route('KleisInstaller::stepFinal')
                         ->with(['message' => $response]);
    }

    /**
     * Update installed file and display finished view.
     *
     * @param InstalledFileManager $fileManager
     * @return \Illuminate\View\View
     */
    public function stepFinish(InstalledFileManager $fileManager)
    {
        $fileManager->update();

        return view('installer.finished');
    }
}
