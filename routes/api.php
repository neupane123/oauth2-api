<?php

use App\User;
use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/users', function (Request $request){
	if ($request->user()->tokenCan('view-users')) {
	        return User::all();
	    }
	
})->middleware('auth:api');


Route::Group(['middleware'=>['auth:api', 'scope:view-users']], function(){

		Route::get('/users', function (Request $request){
			// if ($request->user()->tokenCan('view-users')) {
			//         return User::all();
			//     }
				if(Gate::allows('view-users'))
				{
			    	return User::all();
				}
				return response()->json(['error'=>'sorry, you have no sufficient previledge'], 401);
			
		});


});


Route::Resource('/students', 'StudentController');
Route::Resource('/courses', 'CourseController');


