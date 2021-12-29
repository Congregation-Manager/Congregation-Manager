<?php

namespace Deployer;

require 'recipe/symfony.php';

// Project name
set('application', 'congregation-manager');

// Project repository
set('repository', 'git@github.com:lruozzi9/congregation-manager.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', false);

// Shared files/dirs between deploys
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server
add('writable_dirs', []);
set('allow_anonymous_stats', false);

# set('composer_options', '{{composer_action}} --prefer-dist --no-progress --no-interaction --no-dev --optimize-autoloader');

// Hosts

host('congregation-manager.org')
    ->user('vagrant')
    ->set('deploy_path', '/var/www/{{application}}');

// Tasks

task('build', function () {
    run('cd {{release_path}} && build');
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

before('deploy:symlink', 'database:migrate');

set('env', [
    'APP_ENV' => 'prod',
]);
