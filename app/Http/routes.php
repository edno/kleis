<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => 'installed'], function () {

    Route::view('/', 'welcome');

    Route::get('/logout', 'UserController@logout');

    Route::auth();

    // home
    Route::get('/home', 'HomeController@index');

    // Accounts
    Route::group(['middleware' => 'can:manage,App\Account'], function() {
        Route::get('/accounts', 'AccountController@showAccounts');
        Route::post('/account', 'AccountController@addAccount');
        Route::get('/account/{id}', 'AccountController@editAccount');
        Route::get('/account', 'AccountController@editAccount');
        Route::post('/account/{id}', 'AccountController@updateAccount');
        Route::get('/account/{id}/enable', 'AccountController@enableAccount');
        Route::get('/account/{id}/disable', 'AccountController@disableAccount');
        Route::get('/account/{id}/delete', 'AccountController@removeAccount');
        Route::get('/accounts/category/{category_id}', 'AccountController@showAccounts');
    });

    // Groups (accounts)
    Route::group(['middleware' => 'can:manage,App\Group'], function() {
        Route::get('/groups', 'GroupController@showGroups');
        Route::post('/groups', 'GroupController@addGroup');
        Route::get('/group/{id}/delete', 'GroupController@removeGroup');
        Route::get('/group/{id}/purge', 'GroupController@purgeAccounts');
        Route::get('/group/{id}/disable', 'GroupController@disableAccounts');
        Route::get('/group/{group_id}/accounts', 'AccountController@showAccounts');
        Route::get('/group/{group_id}/accounts/category/{category_id}', 'AccountController@showAccounts');
    });

    // Categories (accounts)
    Route::group(['middleware' => 'can:manage,App\Category'], function() {
        Route::get('/categories', 'CategoryController@showCategories');
        Route::post('/categories', 'CategoryController@addCategory');
        Route::get('/category/{id}/delete', 'CategoryController@removeCategory');
        Route::get('/category/{id}/purge', 'CategoryController@purgeAccounts');
        Route::get('/category/{id}/disable', 'CategoryController@disableAccounts');
    });

    // Users (app administrators)
    Route::group(['middleware' => 'can:manage,App\User'], function() {
        Route::get('/administrators', 'AdminController@showUsers');
        Route::get('/user', 'AdminController@newUser');
        Route::get('/user/{id}', 'AdminController@editUser');
        Route::post('/user', 'AdminController@addUser');
        Route::post('/user/{id}', 'AdminController@updateUser');
        Route::get('/user/{id}/enable', 'AdminController@enableUser');
        Route::get('/user/{id}/disable', 'AdminController@disableUser');
        Route::get('/user/{id}/delete', 'AdminController@removeUser');
        Route::get('/profile', 'UserController@showProfile');
        Route::post('/profile', 'AdminController@updateUser');
    });

    // Whitelists
    Route::group(['middleware' => 'can:manage,App\ProxyListItem'], function() {
        Route::get('whitelist/{type}s', 'ProxyListItemController@showList');
        Route::post('whitelist/{type}', 'ProxyListItemController@addItem');
        Route::post('whitelist/{type}/{id}', 'ProxyListItemController@updateItem');
        Route::get('whitelist/{type}/{id}/delete', 'ProxyListItemController@removeItem');
        Route::get('whitelist/{type}s/clear', 'ProxyListItemController@clearList');
    });

});

Route::group(['prefix' => 'install', 'as' => 'KleisInstaller::'], function()
{
    Route::get('/', [
        'as' => 'stepWelcome',
        'uses' => 'InstallerController@stepWelcome'
    ]);

    Route::get('application', [
        'as' => 'stepApplication',
        'uses' => 'InstallerController@stepApplication'
    ]);

    Route::post('application/save', [
        'as' => 'saveApplication',
        'uses' => 'InstallerController@stepStoreApp'
    ]);

    Route::get('database', [
        'as' => 'stepDatabase',
        'uses' => 'InstallerController@stepDatabase'
    ]);

    Route::get('customization', [
        'as' => 'stepCustomization',
        'uses' => 'InstallerController@stepCustomization'
    ]);

    Route::post('customization/save', [
        'as' => 'saveCustomization',
        'uses' => 'InstallerController@stepStoreCusto'
    ]);

    Route::post('database/save', [
        'as' => 'saveDatabase',
        'uses' => 'InstallerController@stepStoreDb'
    ]);

    Route::get('environment', [
        'as' => 'stepEnvironment',
        'uses' => 'InstallerController@stepEnvironment'
    ]);

    Route::post('environment/save', [
        'as' => 'saveEnvironment',
        'uses' => 'InstallerController@stepSaveEnv'
    ]);

    Route::get('requirements', [
        'as' => 'stepRequirements',
        'uses' => 'InstallerController@stepRequirements'
    ]);

    Route::get('permissions', [
        'as' => 'stepPermissions',
        'uses' => 'InstallerController@stepPermissions'
    ]);

    Route::get('migration', [
        'as' => 'stepMigrate',
        'uses' => 'InstallerController@stepMigrate'
    ]);

    Route::get('final', [
        'as' => 'stepFinal',
        'uses' => 'InstallerController@stepFinish'
    ]);
});
