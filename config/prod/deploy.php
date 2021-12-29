<?php

use EasyCorp\Bundle\EasyDeployBundle\Configuration\DefaultConfiguration;
use EasyCorp\Bundle\EasyDeployBundle\Deployer\DefaultDeployer;

return new class extends DefaultDeployer {
    public function configure(): DefaultConfiguration
    {
        return $this->getConfigBuilder()
            ->server('vagrant@congregation-manager.org')
            ->deployDir('/var/www/congregation-manager')
            ->repositoryUrl('git@github.com:lruozzi9/congregation-manager.git')
            ->repositoryBranch('master')
            ->sharedFilesAndDirs(['.env.local', 'var/log']);
    }

    /**
     * Needed for https://github.com/EasyCorp/easy-deploy-bundle/issues/78
     */
    public function beforePreparing(): void
    {
        $this->runRemote('cp {{ deploy_dir }}/repo/.env {{ project_dir }}/.env');
    }
};
