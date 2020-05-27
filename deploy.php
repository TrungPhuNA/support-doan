<?php
namespace Deployer;
require 'recipe/laravel.php';

# Env
task('upload_main:env', function(){
	upload('.env_deploy', '{{release_path}}/.env');
});


# Opcache
task('artisan:opcache:clear', function () {
	run('{{bin/php}} {{release_path}}/artisan opcache:clear');
});

# Npm install
# Npm install
task('npm', function () {

	run('cd {{release_path}} && npm install');
	writeln("---[done] npm install");

	run('cd {{release_path}} && sh webpack_module.sh');
	writeln("---[done] npm run webpack_module.sh");

});

// set('/usr/local/bin/php', 'php');
set('application', 'document');
set('repository', 'git@gitlab.com:product-du-an/tailieu.git');
set('branch', 'version_3');

set('git_tty', true);
set('git_recursive', '');
set('git_cache', false);


 set('shared_files', [
     'public/sitemap.xml'
 ]);

add('shared_dirs', [
	'public/photos',
	'public/uploads',
	'public/previews',
	'public/uploads_preview',
	'storage'
]);

set('writable_dirs', [
]);

set('http_user', 'nginx');
//host('103.124.92.184')
host('123.31.41.38')
	->stage('document')
	->user('root')
	->port(22)
	->set('deploy_path', '/var/www/html/tailieu247');

// end if

/**
 * Main task
 */
desc('Deploy your project');
task('deploy', [
	'deploy:info',
	'deploy:prepare',
	'deploy:lock',
	'deploy:release',
	'deploy:update_code',
	'deploy:shared',
	'deploy:vendors',
	'deploy:writable',
	'artisan:storage:link',
	// 'artisan:view:cache',
	'artisan:config:cache',
	'artisan:optimize',
	'deploy:symlink',
	'artisan:opcache:clear',
	// 'artisan:opcache:optimize',
	'deploy:unlock',
	'cleanup',
]);

# Opcache
//after( 'rollback', 'artisan:opcache:clear');
//after("deploy:update_code", "npm");
after('deploy:failed', 'deploy:unlock');
//before('deploy:symlink', 'artisan:migrate');
after('deploy:vendors', 'upload_main:env');
