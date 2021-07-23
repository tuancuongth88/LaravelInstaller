<?php

namespace cuongnt\LaravelSetup\Controllers;

use Illuminate\Routing\Controller;
use cuongnt\LaravelSetup\Helpers\DatabaseManager;
use cuongnt\LaravelSetup\Helpers\SetupFileManager;

class UpdateController extends Controller
{
    use \cuongnt\LaravelSetup\Helpers\MigrationsHelper;

    /**
     * Display the updater welcome page.
     *
     * @return \Illuminate\View\View
     */
    public function welcome()
    {
        return view('vendor.setup.update.welcome');
    }

    /**
     * Display the updater overview page.
     *
     * @return \Illuminate\View\View
     */
    public function overview()
    {
        $migrations = $this->getMigrations();
        $dbMigrations = $this->getExecutedMigrations();

        return view('vendor.setup.update.overview', ['numberOfUpdatesPending' => count($migrations) - count($dbMigrations)]);
    }

    /**
     * Migrate and seed the database.
     *
     * @return \Illuminate\View\View
     */
    public function database()
    {
        $databaseManager = new DatabaseManager;
        $response = $databaseManager->migrateAndSeed();

        return redirect()->route('LaravelUpdater::final')
                         ->with(['message' => $response]);
    }

    /**
     * Update installed file and display finished view.
     *
     * @param SetupFileManager $fileManager
     * @return \Illuminate\View\View
     */
    public function finish(SetupFileManager $fileManager)
    {
        $fileManager->update();

        return view('vendor.setup.update.finished');
    }
}
