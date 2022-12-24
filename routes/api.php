<?php

use Illuminate\Http\Request;
use Partymeister\Core\Services\StuhlService;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
Route::post('callback/announcement', function() {

    $status = StuhlService::send('This is a test of the Revision Broadcast System', '', '', 'BORING', 'discord');
        return response($status);
});
 */
Route::group([
    'middleware' => ['bindings'],
    'namespace'  => '\Partymeister\Core\Http\Controllers\Api',
    'prefix'     => 'ajax',
    'as'         => 'ajax.',
], function () {
    Route::get('schedules-for-zenta/{schedule}', 'SchedulesController@show')
         ->name('schedules.show');
});
