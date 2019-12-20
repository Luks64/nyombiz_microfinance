<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });
Auth::routes();

Route::get('/', 'LoansController@index' );

Route::get('/loan/new/{id?}', 'LoansController@new_loan');

Route::get('/loan/edit/{id}', 'LoansController@edit_loan');

Route::post('/loan/new',  'LoansController@add_loan_to_user');

Route::post('/loan/edit/{id}',  'LoansController@update_loan_to_user');

// Route::post('/loan/new', 'LoansController@register_loan_repayment');

Route::post('/calcualate/interest', 'LoansController@calculate_interest');

// Route::get('/applicant/details/{id?}', 'LoansController@applicant_details');

Route::get('/all/loans', 'LoansController@getLoans');

Route::get('/active/loans', 'LoansController@getActiveLoans');

Route::get('/repayment/{id?}', 'LoansController@getLoanToRepay');

Route::post('/repayment/{id?}', 'LoansController@repay');

Route::post('/reset/{id?}', 'LoansController@reset');

Route::get('/arrear/loans/', 'LoansController@getArrearLoans');

Route::get('/print/applicant/{id}','LoansController@getApplicantPDF');

Route::get('/print/old_applicant/{id}','LoansController@getOldApplicantPDF');

Route::get('print/all/loans', 'LoansController@printLoans');

Route::get('save/all/loans', 'LoansController@saveLoans');

Route::get('print/active/loans', 'LoansController@printActiveLoans');

Route::get('save/active/loans', 'LoansController@saveActiveLoans');

Route::get('print/arrear/loans', 'LoansController@printArrearLoans');

Route::get('save/arrear/loans', 'LoansController@saveArrearLoans');

Route::get('print/repayment/{id?}', 'LoansController@printRepayment');

// Route::post('/applicant/edit/{id}', 'LoansController@edit_applicant_details');

// members/applicants
Route::get('/members', 'MembersController@members');

Route::get('/member/details/{id}', 'MembersController@member');

//Route::get('/applicant/new', 'LoansController@new_applicant');
Route::get('/member/new', 'MembersController@register_member');

//Route::post('/applicant/new', 'LoansController@register_applicant');
Route::post('/member/new', 'MembersController@save');

Route::get('/applicant/edit/{id}', 'MembersController@edit');

Route::get('/applicant/delete/{id}', 'MembersController@delete');

//Route::post('/applicant/edit', 'LoansController@update_applicant');
Route::put('/applicant/edit/{id}', 'MembersController@save');

Route::get('/applicant/{id?}', 'LoansController@getNewApplicant');

Route::get('/old_applicant/{id?}', 'LoansController@getOldApplicant');

// groups
Route::get('/groups', 'GroupController@groups');

Route::get('/group/details/{id?}', 'GroupController@group');

Route::get('/group/new', 'GroupController@register_group');

Route::post('/group/new', 'GroupController@save');

Route::get('/group/edit/{id?}', 'GroupController@edit');

Route::put('/group/edit', 'GroupController@save');

Route::get('/portfolio/group', 'GroupController@group_portfolio');

// Employees 
Route::get('/employees', 'EmployeeController@employees');

Route::get('/employee/details/{id?}', 'EmployeeController@employee'); // bug correction from /employee/{id?} to /employee/details/{id?}

Route::get('/employee/new', 'EmployeeController@register_employee');

Route::post('/employee/new', 'EmployeeController@save');

Route::get('/employee/edit/{id?}', 'EmployeeController@edit');

Route::put('/employee/edit/{id?}', 'EmployeeController@save');


//REPORTS
Route::get('/reports/annual', 'ReportsController@annual');

Route::get('/reports/monthly/{year?}', 'ReportsController@by_months');//select year

Route::get('/reports/weekly/{month?}', 'ReportsController@by_weeks');//select month

Route::get('/reports/thisweek', 'ReportsController@this_week');

Route::get('/reports/par', 'ReportsController@par');

Route::get('/collection-sheet/{group_id?}', 'ReportsController@collectsheet');

Route::get('/home', 'HomeController@index')->name('home');
