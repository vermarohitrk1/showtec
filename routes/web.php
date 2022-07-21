<?php

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
   return redirect('home');
});

//LOGIN & SIGNUP
Route::get("/login", "Authenticate@logIn")->name('login');
Route::post("/login", "Authenticate@logInAction");
Route::get("/forgotpassword", "Authenticate@forgotPassword");
Route::post("/forgotpassword", "Authenticate@forgotPasswordAction");
Route::get("/signup", "Authenticate@signUp");
Route::post("/signup", "Authenticate@signUpAction");

//LOGOUT
Route::any('logout', function () {
   Auth::logout();
   return redirect('/login');
});

Route::any('home', 'Home@index')->name('home');

Route::group(['prefix' => 'employees'], function () {
   Route::get('/logo', 'Employees@logo');
   Route::put('/logo', 'Employees@updateLogo');
});
Route::resource('employees', 'Employees');

Route::group(['prefix' => 'user'], function () {
   Route::get('/avatar', 'User@avatar');
   Route::put("/avatar", "User@updateAvatar");
   Route::get("/updatepassword", "User@updatePassword");
   Route::put("/updatepassword", "User@updatePasswordAction");
});


/**
 * File Upload
 */
//FILEUPLOAD
Route::post("/fileupload", "Fileupload@save");
//AVATAR FILEUPLOAD
Route::post("/avatarupload", "Fileupload@saveAvatar");
//CLIENT LOGO FILEUPLOAD
Route::post("/uploadlogo", "Fileupload@saveLogo");
//APP LOGO FILEUPLOAD
Route::post("/upload-app-logo", "Fileupload@saveAppLogo");
//TINYMCE IMAGE FILEUPLOAD
Route::post("/upload-tinymce-image", "Fileupload@saveTinyMCEImage");



//LEADS & LEAD
Route::group(['prefix' => 'leads'], function () {
   Route::any("/search", "Leads@index");
   Route::any("/{lead}/details", "Leads@details")->where('lead', '[0-9]+');
   Route::post("/delete", "Leads@destroy")->middleware(['demoModeCheck']);
   Route::get("/change-category", "Leads@changeCategory");
   Route::post("/change-category", "Leads@changeCategoryUpdate");
   Route::get("/{lead}/change-status", "Leads@changeStatus")->where('lead', '[0-9]+');
   Route::post("/{lead}/change-status", "Leads@changeStatusUpdate")->where('lead', '[0-9]+');
   Route::post("/{lead}/update-description", "Leads@updateDescription")->where('lead', '[0-9]+');
   Route::post("/{lead}/attach-files", "Leads@attachFiles")->where('lead', '[0-9]+');
   Route::delete("/delete-attachment/{uniqueid}", "Leads@deleteAttachment");
   Route::get("/download-attachment/{uniqueid}", "Leads@downloadAttachment");
   Route::post("/{lead}/update-title", "Leads@updateTitle")->where('lead', '[0-9]+');
   Route::post("/{lead}/post-comment", "Leads@storeComment")->where('lead', '[0-9]+');
   Route::delete("/delete-comment/{commentid}", "Leads@deleteComment")->where('commentid', '[0-9]+');
   Route::post("/{lead}/add-checklist", "Leads@storeChecklist")->where('lead', '[0-9]+');
   Route::post("/update-checklist/{checklistid}", "Leads@updateChecklist")->where('checklistid', '[0-9]+');
   Route::delete("/delete-checklist/{checklistid}", "Leads@deleteChecklist")->where('checklistid', '[0-9]+');
   Route::post("/toggle-checklist-status/{checklistid}", "Leads@toggleChecklistStatus")->where('checklistid', '[0-9]+');
   Route::post("/{lead}/update-date-added", "Leads@updateDateAdded")->where('lead', '[0-9]+');
   Route::post("/{lead}/update-name", "Leads@updateName")->where('lead', '[0-9]+');
   Route::post("/{lead}/update-value", "Leads@updateValue")->where('lead', '[0-9]+');
   Route::post("/{lead}/update-status", "Leads@updateStatus")->where('lead', '[0-9]+');
   Route::post("/{lead}/update-category", "Leads@updateCategory")->where('lead', '[0-9]+');
   Route::post("/{lead}/update-contacted", "Leads@updateContacted")->where('lead', '[0-9]+');
   Route::post("/{lead}/update-phone", "Leads@updatePhone")->where('lead', '[0-9]+');
   Route::post("/{lead}/update-email", "Leads@updateEmail")->where('lead', '[0-9]+');
   Route::post("/{lead}/update-source", "Leads@updateSource")->where('lead', '[0-9]+');
   Route::post("/{lead}/update-organisation", "Leads@updateOrganisation")->where('lead', '[0-9]+');
   Route::post("/{lead}/update-assigned", "Leads@updateAssigned")->where('lead', '[0-9]+');
   Route::post("/update-position", "Leads@updatePosition");
   Route::post("/{lead}/convert-lead", "Leads@convertLead")->where('lead', '[0-9]+');
   Route::any("/v/{lead}/{slug}", "Leads@index")->where('lead', '[0-9]+');
   Route::post("/{lead}/update-custom", "Leads@updateCustomFields")->where('lead', '[0-9]+');
   Route::put("/{lead}/archive", "Leads@archive")->where('lead', '[0-9]+');
   Route::put("/{lead}/activate", "Leads@activate")->where('lead', '[0-9]+');
});
Route::resource('leads', 'Leads');


//--------------------------//
// {Projects}
//-------------------------//
Route::resource('projects', 'Projects');




//--------------------------//
// {Inventory}
//-------------------------//
Route::resource('inventory', 'InventoryController');


//SETTINGS - HOME
Route::group(['prefix' => 'settings'], function () {
   Route::get("/", "Settings\Home@index");
});


//CATEGORIES
Route::group(['prefix' => 'categories'], function () {
   Route::any("/", "Categories@index");
});
Route::resource('categories', 'Categories');