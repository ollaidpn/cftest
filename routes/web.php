<?php

use App\Http\Controllers\CategorieController;
use Database\Factories\CategorieFactory;
use Illuminate\Support\Facades\Auth;
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
Route::group(['prefix'=>'/'], function(){

    Route::get('', ['uses' => 'App\Http\Controllers\FrontController@index', 'as' => 'home']);
    Route::get('cours', ['uses' => 'App\Http\Controllers\FrontController@courses', 'as' => 'front.courses']);
    Route::get('cours/{slug}', ['uses' => 'App\Http\Controllers\FrontController@showCourse', 'as' => 'front.course.show']);
    Route::get('contact', ['uses' => 'App\Http\Controllers\FrontController@contact', 'as' => 'front.contact']);
    Route::post('contact/create', ['uses' => 'App\Http\Controllers\FrontController@message', 'as' => 'contact.message']);
    Route::get('/categorie/{slug} ', ['uses' => 'App\Http\Controllers\FrontController@showCategorie', 'as' => 'category.show']);
    Route::get('panier', ['uses' => 'App\Http\Controllers\FrontController@cart', 'as' => 'cart']);
    Route::post('recherche', ['uses' => 'App\Http\Controllers\FrontController@search', 'as' => 'search']);
    Route::get('/en-construction', ['uses' => 'App\Http\Controllers\FrontController@construction'])->name('front.construction');
    Route::post('cours/enroll', ['uses' => 'App\Http\Controllers\EnrollementController@store', 'as' => 'front.course.enroll']);
    Route::post('cours/addtocart', ['uses' => 'App\Http\Controllers\CartController@addToCart', 'as' => 'front.course.addtocart']);
    Route::post('cours/paycartcontent', ['uses' => 'App\Http\Controllers\CartController@payCartContent', 'as' => 'front.course.paycartcontent']);

});

Route::group(['prefix'=>'/mon-compte', 'middleware' => ['student', 'auth']], function(){

    Route::get('', ['App\Http\Controllers\StudentController','dashboard'])->name('student.dashboard');
    Route::get('/mes-cours', ['uses' => 'App\Http\Controllers\StudentController@myCourses'])->name('student.mycourses');
    Route::get('/mes-cours/{organization_slug}', ['uses' => 'App\Http\Controllers\StudentController@private'])->name('student.mycourses.private');
    Route::get('/lire-cours/{slug}', ['uses' => 'App\Http\Controllers\StudentController@takePrivateCourses'])->name('student.take-private-courses');
    Route::get('/organisation/lire-cours/{slug}', ['uses' => 'App\Http\Controllers\StudentController@takePublicCourses'])->name('student.take-public-courses');
    Route::post('/recherche', ['uses' => 'App\Http\Controllers\StudentController@search'])->name('student.search');

    Route::get('/favoris', ['uses' => 'App\Http\Controllers\StudentController@wishlist'])->name('student.whishlist');
    Route::get('/temoignage', ['uses' => 'App\Http\Controllers\TestimonialController@testimonial'])->name('student.testimonial');
    Route::post('/testimonial/create', ['uses' => 'App\Http\Controllers\TestimonialController@store', 'as' => 'student.testimonial.validate']);
    Route::get('/parrametres', ['uses' => 'App\Http\Controllers\StudentController@settings'])->name('student.setting');
    Route::post('/update-parametres',  ['uses' => 'App\Http\Controllers\StudentController@update', 'as' => 'student.settings.update']);
    Route::post('/update-profil',  ['uses' => 'App\Http\Controllers\StudentController@updateProfil', 'as' => 'student.settings.profil.update']);

});


Route::group(['prefix'=>'/admin', 'middleware' => ['admin', 'auth']], function(){

    Route::get('', ['uses' => 'App\Http\Controllers\AdminController@dashboard', 'as' => 'admin.dashboard']);

    Route::get('/formateurs', ['uses' => 'App\Http\Controllers\TeacherController@index', 'as' => 'admin.teachers']);
    Route::get('/ajouter-formateurs', ['uses' => 'App\Http\Controllers\TeacherController@create', 'as' => 'admin.teachers.create']);
    Route::post('/ajouter-formateurs/create', ['uses' => 'App\Http\Controllers\TeacherController@store', 'as' => 'admin.teachers.create.validate']);
    Route::get('/delete-teacher/{id}',  ['uses' => 'App\Http\Controllers\TeacherController@delete', 'as' => 'admin.teachers.delete']);
    Route::get('/afficher-formateurs/{id}',  ['uses' => 'App\Http\Controllers\TeacherController@show', 'as' => 'admin.teachers.show']);
    Route::get('/edit-formateurs/{id}',  ['uses' => 'App\Http\Controllers\TeacherController@edit', 'as' => 'admin.teachers.edit']);
    Route::post('/update-formateurs/{id}',  ['uses' => 'App\Http\Controllers\TeacherController@update', 'as' => 'admin.teachers.update']);

    Route::get('/responsables-pedagogiques', ['uses' => 'App\Http\Controllers\EducationalAdminController@index', 'as' => 'admin.educational-admins']);
    Route::get('/ajouter-responsables-pedagogiques', ['uses' => 'App\Http\Controllers\EducationalAdminController@create', 'as' => 'admin.educational-admins.create']);
    Route::post('/ajouter-responsables-pedagogiques/create', ['uses' => 'App\Http\Controllers\EducationalAdminController@store', 'as' => 'admin.educational-admins.store']);
    Route::get('/delete-responsables-pedagogiques/{id}',  ['uses' => 'App\Http\Controllers\EducationalAdminController@delete', 'as' => 'admin.educational-admins.delete']);
    Route::get('/afficher-responsables-pedagogiques/{id}',  ['uses' => 'App\Http\Controllers\EducationalAdminController@show', 'as' => 'admin.educational-admins.show']);
    Route::get('/edit-responsables-pedagogiques/{id}',  ['uses' => 'App\Http\Controllers\EducationalAdminController@edit', 'as' => 'admin.educational-admins.edit']);
    Route::post('/update-responsables-pedagogiques/{id}',  ['uses' => 'App\Http\Controllers\EducationalAdminController@update', 'as' => 'admin.educational-admins.update']);

    Route::get('/courses', ['uses' => 'App\Http\Controllers\FormationController@index', 'as' => 'admin.formations']);
    Route::get('/ajouter-cours', ['uses' => 'App\Http\Controllers\FormationController@create', 'as' => 'admin.formations.create']);
    Route::get('/modifier-cours/{id}', ['uses' => 'App\Http\Controllers\FormationController@udpate', 'as' => 'admin.formations.update']);
    Route::get('/supprimer-cours/{id}', ['uses' => 'App\Http\Controllers\FormationController@destroy', 'as' => 'admin.formations.delete']);

    Route::get('/categories-cours', ['uses' => 'App\Http\Controllers\CategorieController@index', 'as' => 'admin.categories']);

    Route::get('/quizz', ['uses' => 'App\Http\Controllers\QuizController@index', 'as' => 'admin.quizz']);
    Route::get('/quizz-reponses', ['uses' => 'App\Http\Controllers\QuizAnswerController@index', 'as' => 'admin.quizz.answers']);

    Route::get('/equipe', ['uses' => 'App\Http\Controllers\TeamController@index', 'as' => 'admin.equipes']);
    Route::post('/update-equipe/{id}',  ['uses' => 'App\Http\Controllers\TeamController@update', 'as' => 'admin.teams.update']);
    Route::get('/get_equipe/{id}',  ['uses' => 'App\Http\Controllers\TeamController@getOrganizationTeams', 'as' => 'admin.organization.getTeam']);
    Route::get('equipe/{id}', ['uses' => 'App\Http\Controllers\TeamController@show', 'as' => 'admin.team.show']);
    Route::get('/delete-equipe/{id}',  ['uses' => 'App\Http\Controllers\TeamController@delete', 'as' => 'admin.teams.delete']);
    Route::post('/ajouter-equipe/create', ['uses' => 'App\Http\Controllers\TeamController@store', 'as' => 'admin.team.validate']);
    Route::get('/ajouter_equipe/{id}',  ['uses' => 'App\Http\Controllers\TeamController@show', 'as' => 'admin.teams.show']);
    Route::get('/message', ['uses' => 'App\Http\Controllers\MsgVisitorController@index', 'as' => 'admin.messages']);
    Route::get('/afficher-messages/{id}',  ['uses' => 'App\Http\Controllers\MsgVisitorController@show', 'as' => 'admin.msgVisitors.show']);

    Route::get('/apprenants', ['uses' => 'App\Http\Controllers\StudentController@index', 'as' => 'admin.students']);
    Route::get('/ajouter-apprenants', ['uses' => 'App\Http\Controllers\StudentController@create', 'as' => 'admin.students.create']);
    Route::post('/ajouter-apprenants/create', ['uses' => 'App\Http\Controllers\StudentController@store', 'as' => 'admin.students.create.validate']);
    Route::get('/delete-student/{id}',  ['uses' => 'App\Http\Controllers\StudentController@delete', 'as' => 'admin.students.delete']);
    Route::get('/afficher-apprenants/{id}',  ['uses' => 'App\Http\Controllers\StudentController@show', 'as' => 'admin.students.show']);
    Route::get('/edit-apprenants/{id}',  ['uses' => 'App\Http\Controllers\StudentController@edit', 'as' => 'admin.students.edit']);
    Route::post('/update-apprenants/{id}',  ['uses' => 'App\Http\Controllers\StudentController@update', 'as' => 'admin.students.update']);

    Route::get('/organismes', ['uses' => 'App\Http\Controllers\OrganizationController@index', 'as' => 'admin.organizations']);
    Route::get('/ajouter-organismes', ['uses' => 'App\Http\Controllers\OrganizationController@create', 'as' => 'admin.organizations.create']);
    Route::get('/modifier-organismes/{id}', ['uses' => 'App\Http\Controllers\OrganizationController@edit', 'as' => 'admin.organizations.edit']);
    Route::post('/update-organismes/{id}', ['uses' => 'App\Http\Controllers\OrganizationController@update', 'as' => 'admin.organizations.update']);
    Route::get('/organismes-detail/{id}', ['uses' => 'App\Http\Controllers\OrganizationController@show', 'as' => 'admin.organizations.show']);
    Route::post('/ajouter-organismes/save', ['uses' => 'App\Http\Controllers\OrganizationController@store', 'as' => 'admin.organizations.save']);
    Route::get('/delete-organismes/{id}', ['uses' => 'App\Http\Controllers\OrganizationController@delete', 'as' => 'admin.organizations.delete']);

    Route::get('/parametres', ['uses' => 'App\Http\Controllers\AdminController@settings', 'as' => 'admin.settings']);
    Route::get('/profil', ['uses' => 'App\Http\Controllers\UserController@profil', 'as' => 'admin.profile']);
    Route::post('/profil/update', ['uses' => 'App\Http\Controllers\UserController@updateProfil', 'as' => 'admin.profile.update']);
    Route::get('/parametre-systeme', ['uses' => 'App\Http\Controllers\InfosSystemController@index', 'as' => 'admin.systeminfo']);
    Route::Post('/parametre-systeme/update', ['uses' => 'App\Http\Controllers\InfosSystemController@update', 'as' => 'admin.settings.update']);
    Route::get('/utilisateurs-liste', ['uses' => 'App\Http\Controllers\UserController@allUser', 'as' => 'admin.settings.users.liste']);

    Route::get('/utilisateurs', ['uses' => 'App\Http\Controllers\UserController@index', 'as' => 'admin.settings.users']);
    Route::get('/ajouter-utilisateurs', ['uses' => 'App\Http\Controllers\UserController@create', 'as' => 'admin.settings.users.create']);
    Route::post('/ajouter-utilisateurs/save', ['uses' => 'App\Http\Controllers\UserController@store', 'as' => 'admin.settings.users.store']);
    Route::get('/edit-utilisateurs/{id}',  ['uses' => 'App\Http\Controllers\UserController@edit', 'as' => 'admin.settings.users.edit']);
    Route::post('/update-utilisateurs/{id}',  ['uses' => 'App\Http\Controllers\UserController@update', 'as' => 'admin.settings.users.update']);

    Route::get('/temoignages', ['uses' => 'App\Http\Controllers\TestimonialController@index', 'as' => 'admin.testimonials']);
    Route::get('/temoignages-show/{id}', ['uses' => 'App\Http\Controllers\TestimonialController@show', 'as' => 'admin.testimonials.show']);
    Route::get('/temoignages-delete/{id}', ['uses' => 'App\Http\Controllers\TestimonialController@destroy', 'as' => 'admin.testimonials.destroy']);
    Route::get('/temoignages-update/{id}', ['uses' => 'App\Http\Controllers\TestimonialController@update', 'as' => 'admin.testimonials.update']);

    Route::post('/send-email', ['uses' => 'App\Http\Controllers\AdminController@sendEmail', 'as' => 'admin.send-email']);
    Route::post('/send-email', ['uses' => 'App\Http\Controllers\AdminController@sendEmail', 'as' => 'admin.send-email']);

    Route::resource('categorie', CategorieController::class);

});

Route::group(['prefix'=>'/formateur', 'middleware' => ['teacher', 'auth']], function(){

    Route::get('', ['uses' => 'App\Http\Controllers\AdminController@dashboard', 'as' => 'teacher.dashboard']);

    Route::get('/courses', ['uses' => 'App\Http\Controllers\FormationController@index', 'as' => 'teacher.formations']);
    Route::get('/ajouter-cours', ['uses' => 'App\Http\Controllers\FormationController@create', 'as' => 'teacher.formations.create']);
    Route::get('/modifier-cours/{id}', ['uses' => 'App\Http\Controllers\FormationController@udpate', 'as' => 'teacher.formations.update']);

    Route::get('/profil', ['uses' => 'App\Http\Controllers\UserController@profil', 'as' => 'teacher.profile']);
    Route::post('/profil/update', ['uses' => 'App\Http\Controllers\UserController@updateProfil', 'as' => 'teacher.profile.update']);
});

Route::group(['prefix'=>'/responsable-pedagogique', 'middleware' => ['educational-admin', 'auth']], function(){

    Route::get('', ['uses' => 'App\Http\Controllers\AdminController@dashboard', 'as' => 'educational-admin.dashboard']);

    Route::get('/formateurs', ['uses' => 'App\Http\Controllers\TeacherController@index', 'as' => 'educational-admin.teachers']);
    Route::get('/ajouter-formateurs', ['uses' => 'App\Http\Controllers\TeacherController@create', 'as' => 'educational-admin.teachers.create']);
    Route::post('/ajouter-formateurs/create', ['uses' => 'App\Http\Controllers\TeacherController@store', 'as' => 'educational-admin.teachers.create.validate']);
    Route::get('/delete-teacher/{id}',  ['uses' => 'App\Http\Controllers\TeacherController@delete', 'as' => 'educational-admin.teachers.delete']);
    Route::get('/afficher-formateurs/{id}',  ['uses' => 'App\Http\Controllers\TeacherController@show', 'as' => 'educational-admin.teachers.show']);
    Route::get('/edit-formateurs/{id}',  ['uses' => 'App\Http\Controllers\TeacherController@edit', 'as' => 'educational-admin.teachers.edit']);
    Route::post('/update-formateurs/{id}',  ['uses' => 'App\Http\Controllers\TeacherController@update', 'as' => 'educational-admin.teachers.update']);

    Route::get('/categories-cours', ['uses' => 'App\Http\Controllers\CategorieController@index', 'as' => 'educational-admin.categories']);


    Route::get('/courses', ['uses' => 'App\Http\Controllers\FormationController@index', 'as' => 'educational-admin.formations']);
    Route::get('/ajouter-cours', ['uses' => 'App\Http\Controllers\FormationController@create', 'as' => 'educational-admin.formations.create']);
    Route::get('/modifier-cours/{id}', ['uses' => 'App\Http\Controllers\FormationController@udpate', 'as' => 'educational-admin.formations.update']);

    Route::get('/profil', ['uses' => 'App\Http\Controllers\UserController@profil', 'as' => 'educational-admin.profile']);
    Route::post('/profil/update', ['uses' => 'App\Http\Controllers\UserController@updateProfil', 'as' => 'educational-admin.profile.update']);
});

Auth::routes();
