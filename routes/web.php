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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/search', 'HardwareController@searchHardware');
Route::get('/searchUser', 'HardwareController@searchUser');
Route::get('/inventory', 'HardwareController@inventory');
Route::get('/repair', 'HardwareController@repairPage');
Route::get('/disposed', 'HardwareController@disposed');
Route::get('/deployed', 'HardwareController@deployed');
Route::get('/device/{id}', 'HardwareController@showDevice');
Route::get('/administrators', 'AdminController@index');

Route::post('/notifications', 'AdminController@notifications');
Route::put('/notifications/{id}', 'AdminController@readNotif');
/*REPORTS ROUTE*/
Route::get('/dashboard-pdf', 'HomeController@dashboard');
Route::get('/dashboard-pdf/{from}/{to}', 'HomeController@dashboardDateRange');
Route::get('/deliveries/report', 'HomeController@deliveries');
Route::get('/inventory/report', 'HomeController@inventory');
Route::get('/deployed/report', 'HomeController@deployed');
Route::get('/repair/report', 'HomeController@repair');
Route::get('/disposed/report', 'HomeController@disposed');

Route::get('/deployed', 'HardwareController@deployed');
Route::get('/device/{id}', 'HardwareController@showDevice');

/* Deliveries*/
Route::get('/deliveries', 'HardwareController@deliveries');
/*Sort Delivery*/
Route::get('/deliveries/warranty/asc', 'HardwareController@deliveriesSortByWarrantyASC');
Route::get('/deliveries/warranty/desc', 'HardwareController@deliveriesSortByWarrantyDESC');
Route::get('/deliveries/purchased-date/asc', 'HardwareController@deliveriesSortByPurchasedDateASC');
Route::get('/deliveries/purchased-date/desc', 'HardwareController@deliveriesSortByPurchasedDateDESC');
/*Sort Inventory*/
Route::get('/inventory/warranty/asc', 'HardwareController@inventorySortByWarrantyASC');
Route::get('/inventory/warranty/desc', 'HardwareController@inventorySortByWarrantyDESC');
Route::get('/inventory/purchased-date/asc', 'HardwareController@inventorySortByPurchasedDateASC');
Route::get('/inventory/purchased-date/desc', 'HardwareController@inventorySortByPurchasedDateDESC');
/*Sort Deployed*/
Route::get('/deployed/warranty/asc', 'HardwareController@deployedSortByWarrantyASC');
Route::get('/deployed/warranty/desc', 'HardwareController@deployedSortByWarrantyDESC');
Route::get('/deployed/purchased-date/asc', 'HardwareController@deployedSortByPurchasedDateASC');
Route::get('/deployed/purchased-date/desc', 'HardwareController@deployedSortByPurchasedDateDESC');
Route::get('/deployed/deployed-date/asc', 'HardwareController@deployedSortByDeployedDateASC');
Route::get('/deployed/deployed-date/desc', 'HardwareController@deployedSortByDeployedDateDESC');
/* store data */
Route::post('add/deliveries/excel', 'HardwareController@importExcel');
Route::post('add/deployed/excel', 'HardwareController@importExcelDeployed');
Route::post('single', 'HardwareController@singleDelivery');
Route::post('singleDeployed', 'HardwareController@singleDeployed');

/* Edit data */
Route::put('edit/delivery/{id}', 'HardwareController@editDelivery');
Route::put('add/edit/delivery/{id}', 'HardwareController@editDelivery');
Route::put('in/delivery/{id}', 'HardwareController@InDelivery');
Route::put('deliver/{id}', 'HardwareController@putDeviceOnDelivery');
Route::put('out/delivery/{id}', 'HardwareController@OutDelivery');
Route::put('in/all', 'HardwareController@InAllSelected');
Route::put('delivery/all', 'HardwareController@DeliveryAllSelected');
Route::put('repair/all', 'HardwareController@repairAllSelected');
/* Delete data */
Route::put('/delete/delivery/{id}', 'HardwareController@deleteDelivery');
Route::put('/repair/device/{id}', 'HardwareController@repair');
Route::delete('delete/all', 'HardwareController@deleteAllSelected');


/*SERVERMON ROUTE*/
  Route::get('/servermon', 'ServermonController@index');
  Route::get('/status', 'ServermonController@status');
  /*POST*/
  Route::post('/servermon', 'ServermonController@pingSearch');
  Route::post('/add-server', 'ServermonController@addServer');
  Route::post('/status', 'ServermonController@addServer');

  /*PUT*/
  Route::put('/edit-server/{id}', 'ServermonController@updateServer');
  Route::put('/status', 'ServermonController@updateServers');
  Route::put('/ping-server/{id}', 'ServermonController@pingServer');
  Route::put('/servers', 'ServermonController@updateServerScheduler');

  /*DELETE*/
  Route::delete('/delete-server/{id}', 'ServermonController@deleteServer');


/*CALENDAR*/
  Route::get('/calendar', 'CalendarController@index')->name('calendar');
  Route::get('/calendar/{id}', 'CalendarController@event');
  Route::post('/calendar', 'CalendarController@addEvent');
  Route::put('/calendar/{id}', 'CalendarController@updateEvent');
  Route::delete('delete/calendar/{id}', 'CalendarController@deleteEvent');

/*SOFTWARE ASSETS ROUTE*/
Route::get('/software', 'SoftwareController@index');
Route::delete('/delete/delivery/{id}', 'HardwareController@deleteDelivery');
Route::delete('delete/all', 'HardwareController@deleteAllSelected');

/*Date Filter*/
Route::post('/home', 'HomeController@dateRange');


/*Hardware Info*/
Route::get('/hardware-type', 'HardwareInfoController@hardwareType');
Route::get('/brand', 'HardwareInfoController@brand');
Route::get('/processor', 'HardwareInfoController@processor');
Route::get('/storage-type', 'HardwareInfoController@storageType');

/* Hardware Info Insert */
Route::post('/hardware-type', 'HardwareInfoController@AddHT');
Route::post('/brand', 'HardwareInfoController@Addbrand');
Route::post('/processor', 'HardwareInfoController@AddProcessor');
Route::post('/storage-type', 'HardwareInfoController@AddStorageType');

/* Hardware Info Edit */
Route::put('/hardware-type/{id}', 'HardwareInfoController@EditHT');
Route::put('/brand/{id}', 'HardwareInfoController@EditBrand');
Route::put('/processor/{id}', 'HardwareInfoController@EditProcessor');
Route::put('/storage-type/{id}', 'HardwareInfoController@EditStorageType');

/* Hardware Info Remove */
Route::put('/hardware-type/remove/{id}', 'HardwareInfoController@RemoveHT');
Route::put('/brand/remove/{id}', 'HardwareInfoController@RemoveBrand');
Route::put('/processor/remove/{id}', 'HardwareInfoController@RemoveProcessor');
Route::put('/storage-type/remove/{id}', 'HardwareInfoController@RemoveStorageType');

/*Date Filters*/
Route::get('/stats/today', 'HomeController@today');
Route::get('/stats/yesterday', 'HomeController@yesterday');
Route::get('/stats/week', 'HomeController@week');
Route::get('/stats/month', 'HomeController@month');
Route::get('/stats/last-month', 'HomeController@lastMonth');

/*Date Filter Reports*/
Route::get('/report/today', 'HomeController@todayReport');
Route::get('/report/yesterday', 'HomeController@yesterdayReport');
Route::get('/report/week', 'HomeController@weekReport');
Route::get('/report/month', 'HomeController@monthReport');
Route::get('/report/last-month', 'HomeController@lastMonthReport');


/*Export Excel */
Route::get('/dashboard-excel', 'HomeController@exportDashboardExcel');

Route::get('/delivery-excel', 'HardwareController@exportDeliveryExcel');
Route::get('/inventory-excel', 'HardwareController@exportInventoryExcel');
Route::get('/deployed-excel', 'HardwareController@exportDeployedExcel');
Route::get('/repair-excel', 'HardwareController@exportRepairExcel');

/*Log Viewer */
Route::get('/log-viewer', 'LogsController@index');
Route::get('/log-viewer/added', 'LogsController@added');
Route::get('/log-viewer/edited', 'LogsController@edited');
Route::get('/log-viewer/deleted', 'LogsController@deleted');
Route::get('/log-viewer/logs', 'LogsController@logs');
Route::get('/log-viewer/reports', 'LogsController@reports');

/*Admin Controller */
Route::put('/administrator/{id}', 'AdminController@changeRole');
Route::put('administrator/delete/{id}', 'AdminController@deleteUser');

Route::get('/profile', 'AdminController@profile');
Route::put('/profile', 'AdminController@EditProfile');
