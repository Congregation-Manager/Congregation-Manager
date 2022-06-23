<?php

namespace Deployer;

require 'recipe/symfony.php';

// Config

set('repository', 'git@github.com:lruozzi9/congregation-manager.git');

add('shared_files', [
    '.env.local',
    'public/robots.txt',
    'public/.htaccess',
]);
add('shared_dirs', []);
add('writable_dirs', [
    'var/log',
]);

// Hosts

host('164.92.187.221')
    ->set('remote_user', 'congregation-manager')
    ->set('deploy_path', '/var/www/congregation-manager');

// Tasks

task('build', function () {
    cd('{{release_path}}');
    run('yarn install');
    run('yarn build');
});

after('deploy:failed', 'deploy:unlock');
