<?php
namespace Deployer;

require 'recipe/laravel.php';

// Project info
set('application', 'LeaderboardLive.co.uk');
set('repository', 'git@github.com:ExallRoofing/LeaderboardLive.co.uk.git');
set('branch', 'main');

// Shared files/folders
add('shared_files', ['.env']);
add('shared_dirs', ['storage', 'node_modules', 'public/build']);
add('writable_dirs', ['storage', 'bootstrap/cache']);

// Host setup
host('production')
    ->setHostname('ec2-52-30-37-26.eu-west-1.compute.amazonaws.com')
    ->set('remote_user', 'ubuntu')
    ->set('identity_file', '~/.ssh/exall-ssh.pem')
    ->set('deploy_path', '/var/www/leaderboardlive.co.uk');

// Assets build task
task('build_assets', function () {
    run('cd {{release_path}} && npm ci && npm run build');
});

// Fix .env + storage symlinks
task('fix_symlinks', function () {
    run('ln -sfn {{deploy_path}}/shared/.env {{release_path}}/.env');
    run('rm -rf {{release_path}}/public/storage');
    run('ln -s {{deploy_path}}/shared/storage/app/public {{release_path}}/public/storage');
});

// Artisan commands
task('artisan:prepare', function () {
    run('php {{release_path}}/artisan config:clear');
    run('php {{release_path}}/artisan cache:clear');
    run('php {{release_path}}/artisan view:clear');
    run('php {{release_path}}/artisan migrate --force');
});

// Deployment flow
before('deploy:symlink', 'build_assets');
after('deploy:symlink', 'fix_symlinks');
after('fix_symlinks', 'artisan:prepare');
after('deploy:failed', 'deploy:unlock');

