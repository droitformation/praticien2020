<?php
namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'newpraticien');

// Project repository/droitenschemas.git
set('repository', 'git@github.com:droitformation/praticien2020.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

// Disable SSH multiplexing…
set('ssh_multiplexing', false);

// Shared files/dirs between deploys 
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server 
set('writable_dirs', []);
set('allow_anonymous_stats', false);

// Hosts
host('droitdutravail.ch')
	->stage('prod')
	->user('droitdut')
	->port(22)
	->addSshOption('UserKnownHostsFile', '/dev/null')
	->addSshOption('StrictHostKeyChecking', 'no')
    ->set('deploy_path', '~/deploy/{{application}}');    

// Tasks
task('build', function () {
    run('cd {{release_path}} && build');
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');
