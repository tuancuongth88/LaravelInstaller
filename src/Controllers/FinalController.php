<?php

namespace cuongnt\LaravelSetup\Controllers;

use Illuminate\Routing\Controller;
use cuongnt\LaravelSetup\Events\LaravelSetupFinished;
use cuongnt\LaravelSetup\Helpers\EnvironmentManager;
use cuongnt\LaravelSetup\Helpers\FinalSetupManager;
use cuongnt\LaravelSetup\Helpers\SetupFileManager;

class FinalController extends Controller
{
    /**
     * Update installed file and display finished view.
     *
     * @param \cuongnt\LaravelSetup\Helpers\SetupFileManager $fileManager
     * @param \cuongnt\LaravelSetup\Helpers\FinalSetupManager $finalInstall
     * @param \cuongnt\LaravelSetup\Helpers\EnvironmentManager $environment
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function finish(SetupFileManager $fileManager, FinalSetupManager $finalInstall, EnvironmentManager $environment)
    {
        $finalMessages = $finalInstall->runFinal();
        $finalStatusMessage = $fileManager->update();
        $finalEnvFile = $environment->getEnvContent();

        event(new LaravelSetupFinished);

        return view('vendor.setup.finished', compact('finalMessages', 'finalStatusMessage', 'finalEnvFile'));
    }
}
