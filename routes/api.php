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

Route::get('/user', static function (Request $request) {
    return $request->user();
})->middleware('auth:api');

/*
Route::post('callback/announcement', function() {

    $status = StuhlService::send('This is a test of the Revision Broadcast System', '', '', 'BORING', 'discord');
        return response($status);
});
 */
