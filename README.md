<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

## About this repo

Anyone using TenancyForLaravel with Passport? I've made a basic setup but Route Model Injection fails in resource controller parameters. 

Writing a UserController::show( User $user) , a GET 'api/users/1' gets a $user as an EMPTY User, that is, $user::class is an App\Models\User but empty. Changing tha parameter to a basic show($id) takes $id correctly.


