<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Posts;

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
    return view(
        'Index'
    );
});

Route::get('/Index', function () {
    return view(
        'Index'
    );
});

Route::get('/Info', function () {
    return view(
        'Info'
    );
});

Route::get('/index', function () {
    return view(
        'Index'
    );
});

Route::get('/Booking', function () {
    return view(
        'Booking'
    );
});

Route::get('/VerifyRequest', function () {
    return view(
        'VerifyRequest'
    );
});


//
//Examples
//


// Route::get('/', function () {
//     return view(
//         'MainPage',
//         [
//             'heading' => 'Heading',
//             'posts' => Posts::all()
//         ]
//     );
// });

// Route::get('/{id}', function ($id) {
//     $posts = Posts::find($id);
//     if ($posts) {
//         return view(
//             'MainPage',
//             [
//                 'heading' => 'Heading',
//                 'posts' => $posts
//             ]
//         );
//     } else {
//         abort('404');
//     }
// });

// Route::get('/{posts}', function (Posts $posts) {
//     return view(
//         'MainPage',
//         [
//             'heading' => 'Heading',
//             'posts' => $posts
//         ]
//     );
// });

// 
// Route::get('/hello', function () {
//     $one = 'user';
//     return response('<h1>hello world ' . $one);
// });

// Route::get('/posts/{id}', function ($id) {
//     return response('Post ' . $id);
// })->where('id', '[0-9]+');

// Route::get('/search', function (Request $request) {
//     dd($request->name);
// });
