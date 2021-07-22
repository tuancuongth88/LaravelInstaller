<?php

namespace cuongnt\LaravelInstaller\Controllers;

use Illuminate\Routing\Controller;
use cuongnt\LaravelInstaller\Events\LaravelInstallerFinished;
use cuongnt\LaravelInstaller\Helpers\EnvironmentManager;
use cuongnt\LaravelInstaller\Helpers\FinalInstallManager;
use cuongnt\LaravelInstaller\Helpers\InstalledFileManager;

class FinalController extends Controller
{
    /**
     * Update installed file and display finished view.
     *
     * @param \cuongnt\LaravelInstaller\Helpers\InstalledFileManager $fileManager
     * @param \cuongnt\LaravelInstaller\Helpers\FinalInstallManager $finalInstall
     * @param \cuongnt\LaravelInstaller\Helpers\EnvironmentManager $environment
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
