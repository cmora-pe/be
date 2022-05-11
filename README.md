<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

## About this repo

Anyone using TenancyForLaravel with Passport? I've made a basic setup but Route Model Injection fails in resource controller parameters. 

Writing a UserController::show( User $user) , a GET 'api/users/1' gets a $user as an EMPTY User, that is, $user::class is an App\Models\User but empty. Changing tha parameter to a basic show($id) takes $id correctly.


Checked the matching route many times. The point is I'm getting an User, but empty, not the right one.
For the sake of testing, I've changes the show() to this:
```php
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, $id)
    {
        return response()->json([
            'class' => $user::class,
            'user' => $user,
            'fromAuth' => Auth::user(),
            'id' => $id,
            'fromId (spected)' => User::find($id),
        ]);
    }

```
 and GET /api/users/1 gets :
```json
{
    "class": "App\\Models\\User",
    "user": [],
    "fromAuth": {
        "id": 1,
        "name": "Carlos Mora",
        "email": "cam@people-experts.com",
        "email_verified_at": null,
        "created_at": "2022-05-10T11:50:58.000000Z",
        "updated_at": "2022-05-11T10:54:20.000000Z",
        "deleted_at": null,
        "created_by": null,
        "updated_by": null,
        "deleted_by": null
    },
    "id": "1",
    "fromId (spected)": {
        "id": 1,
        "name": "Carlos Mora",
        "email": "cam@people-experts.com",
        "email_verified_at": null,
        "created_at": "2022-05-10T11:50:58.000000Z",
        "updated_at": "2022-05-11T10:54:20.000000Z",
        "deleted_at": null,
        "created_by": null,
        "updated_by": null,
        "deleted_by": null
    }
}
```
the involved route as reported by route:list: 
```
GET|HEAD        be.test/api/users/{user} ............................. users.show › UserController@show
```
that comes from routes\api.php : 
```php
<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::resource('users', UserController::class);
```


There must be a clashing among Tenancy and Passport.  In App\Providers\RouteServiceProvider.php the api routes are registered as required by Tenancy:

```php
    protected function mapApiRoutes()
    {
        foreach ($this->centralDomains() as $domain) {
            Route::middleware('auth:api')
                ->prefix('api')
                ->domain($domain)
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));
        }
    }
```
If the middleware('auth:api') is removed, everything works fine except the routes are not protected.
```php
    // This works :(
    protected function mapApiRoutes()
    {
        foreach ($this->centralDomains() as $domain) {
            Route::prefix('api')
                ->domain($domain)
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));
        }
    }
```
Also tried Explicit BInding without success:

```php
// app\Providers\RouteServiceProvider.php

Route::model('user', User::class);
```
