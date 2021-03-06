<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Enable/Disable Migrations
|--------------------------------------------------------------------------
|
| Migrations are disabled by default for security reasons.
| You should enable migrations whenever you intend to do a schema migration
| and disable it back when you're done.
|
*/

// Nov 05, 2012 - Galbraith Desmond - Found that we need to enable migrations for live sites.
//if(ENVIRONMENT == "development" || ENVIRONMENT == "testing") $config['migration_enabled'] = TRUE;
//else $config['migration_enabled'] = FALSE;

$config['migration_enabled'] = TRUE;


/*
|--------------------------------------------------------------------------
| Migrations version
|--------------------------------------------------------------------------
|
| This is used to set migration version that the file system should be on.
| If you run $this->migration->latest() this is the version that schema will
| be upgraded / downgraded to.
|
*/

// THIS MUST BE UPDATED EVERY TIME YOU UPDATE THE MIGRATION VERSION
$config['migration_version'] = 12;

/*
|--------------------------------------------------------------------------
| Migrations Path
|--------------------------------------------------------------------------
|
| Path to your migrations folder.
| Typically, it will be within your application path.
| Also, writing permission is required within the migrations path.
|
*/
$config['migration_path'] = APPPATH . 'migrations/';

/* End of file migration.php */