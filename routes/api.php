<?php

use Partymeister\Core\Http\Resources\ScheduleResource;
use Partymeister\Core\Services\ScheduleService;

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
], function () {
    Route::get('schedules-for-zenta/{schedule}', function(\Partymeister\Core\Models\Schedule $record) {
        $result = ScheduleService::show($record)
                                 ->getResult();

        return (new ScheduleResource($result->load('events')))->additional(['message' => 'Schedule read']);
    });
});
