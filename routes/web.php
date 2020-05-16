<?php

use App\Events\TaskEvent;
use App\Notifications\MailNotification;
use App\User;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

/**
 * BroadCasting using Pusher
 */
Route::get('event',function (){
   event(new TaskEvent('Hello')) ;
});

Route::get('listener',function (){
   return view('pusher.listener');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


/**
 * Notification
 */

/**
 * Mail Notification
 */

Route::get('/mail',function ()
{
    /**
     * For Multiple user
     */
    $when = now()->addSeconds(10);
    $users =  User::all();
    foreach ($users as $user)
    {
        Notification::route('mail',$user->email)
            ->notify((new MailNotification())->delay($when));
    }

    return "done";

    /**
     * For Single user
     */
//    $user->find(1);
//    $user->notify((new MailNotification())->delay($when));
//  ->notify(new MailNotification());
});