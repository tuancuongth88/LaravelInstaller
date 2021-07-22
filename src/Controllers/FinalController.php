<?php

namespace Cuongnt\LaravelInstaller\Controllers;

use Illuminate\Routing\Controller;
use Cuongnt\LaravelInstaller\Events\LaravelInstallerFinished;
use Cuongnt\LaravelInstaller\Helpers\EnvironmentManager;
use Cuongnt\LaravelInstaller\Helpers\FinalInstallManager;
use Cuongnt\LaravelInstaller\Helpers\InstalledFileManager;

class FinalController extends Controller
{
    /**
     * Update installed file and display finished view.
     *
     * @param \Cuongnt\LaravelInstaller\Helpers\InstalledFileManager $fileManager
     * @param \Cuongnt\LaravelInstaller\Helpers\FinalInstallManager $finalInstall
     * @param \Cuongnt\LaravelInstaller\Helpers\EnvironmentManager $environment
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function finish(InstalledFileManager $fileManager, FinalInstallManager $finalInstall, EnvironmentManager $environment)
    {
        $finalMessages = $finalInstall->runFinal();
        $finalStatusMessage = $fileManager->update();
        $finalEnvFile = $environment->getEnvContent();

        event(new LaravelInstallerFinished);

        return view('vendor.installer.finished', compact('finalMessages', 'finalStatusMessage', 'finalEnvFile'));
    }
}
