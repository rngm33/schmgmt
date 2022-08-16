<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


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

// Auth::routes();
Auth::routes(['reset' => false,
      'register' => false
      ]);
Route::group(["middleware" => 'admin'], function(){
  // home routes
    Route::get('/home', 'Admin\HomeController@index')->name('home');
    Route::get('/currentmanager/{id}','Admin\Report\HomeController@currentmanager');


    // manager routes
    Route::resource('/home/manager','Admin\ManagerController');
    Route::post('/home/manager/{id}/update', 'Admin\ManagerController@update');
    Route::get('/home/manager/status/{id}/{status}', 'Admin\ManagerController@status');
    Route::get('/home/manager/select/getAllManager', 'Admin\ManagerController@getAllManager');
    Route::post('/home/manager/change-password','Admin\ManagerController@changePassword')->name('changepassword');

    Route::get('/home/luckydraw/select/getAllLuckyDraw', 'Admin\LuckyDrawController@getAllLuckyDraw');
    Route::get('/home/luckydraw/mselect/getAllMLuckyDraw', 'Admin\LuckyDrawController@getAllMLuckyDraw');
    Route::resource('/home/luckydraw','Admin\LuckyDrawController');
    Route::get('/home/luckydraw/status/{id}/{status}', 'Admin\LuckyDrawController@status');

    Route::get('/home/kista/select/getAllKista', 'Admin\KistaController@getAllKista');
    Route::get('/home/kista/status/{id}/{status}', 'Admin\KistaController@status');

    Route::resource('/home/kista','Admin\KistaController');
    Route::get('/home/agent/select/getAllAgent', 'Admin\AgentController@getAllAgent');
    Route::resource('/home/agent','Admin\AgentController');
    Route::get('/home/agent/status/{id}/{status}', 'Admin\AgentController@status');
    Route::get('/home/mdetail','Admin\DetailController@detail');
    Route::get('/home/detail/revise/{id}/{lotteryStatus}', 'Admin\DetailController@revise');

    Route::get('/home/clientlist', 'Admin\ClientListController@index');
    Route::resource('/home/bankbalance','Admin\BankBalanceController');
    Route::get('/home/bankbalance/status/{id}/{status}', 'Admin\BankBalanceController@status');

    Route::resource('/home/incomeexpenditure','Admin\IncomeExpenditureController');
    Route::get('/home/incomeexpenditure/status/{id}/{status}', 'Admin\IncomeExpenditureController@status');

    Route::resource('/home/record','Admin\RecordController');
    Route::get('/home/record/status/{id}/{status}', 'Admin\RecordController@status');

    Route::resource('/home/purchase','Admin\PurchaseController');
    Route::get('/home/purchase/status/{id}/{status}', 'Admin\PurchaseController@status');



    //report
    Route::get('/home/report','Admin\Report\HomeController@loadDashboard');
    Route::get('/home/report/tpnp','Admin\Report\TpnpController@tpnpreport');
    Route::get('/home/report/tpnpl','Admin\Report\TpnplController@tpnplreport');
    Route::get('/home/report/agent','Admin\Report\AgentController@index');
    Route::get('/home/report/purchase','Admin\Report\PurchaseController@index');
    Route::get('/home/report/incomeexpenditure','Admin\Report\IncomeExpenditureController@index');
    Route::get('/home/report/expenditure','Admin\Report\ExpenditureReportController@index');
    Route::get('/home/report/record','Admin\Report\RecordController@index');
    Route::get('/home/report/lotteryprize','Admin\Report\LotteryPrizeController@index');
    Route::get('/home/report/member','Admin\Report\MemberController@index');

});

Route::group(["middleware" => 'manager'], function(){
  // home routes
    Route::get('/manager', 'Manager\HomeController@index')->name('manager');
    Route::post('/manager/change-password','Manager\HomeController@changePassword')->name('changepassword');

    //current user
    Route::get('/currentuser','Manager\HomeController@currentuser');


    Route::get('/manager/luckydraw/select/getAllLuckyDraw', 'Manager\LuckyDrawController@getAllLuckyDraw');
    Route::resource('/manager/luckydraw','Manager\LuckyDrawController');
    Route::get('/manager/luckydraw/status/{id}/{status}', 'Manager\LuckyDrawController@status');
    
    Route::get('/manager/kista/select/getAllKista', 'Manager\KistaController@getAllKista');
    Route::get('/manager/kista/select/getAllKistaCommision', 'Manager\KistaController@getAllKistaCommision');
    Route::resource('/manager/kista','Manager\KistaController');
    Route::get('/manager/kista/status/{id}/{status}', 'Manager\KistaController@status');
    Route::get('/manager/check/{id}/{word?}','Manager\KistaController@check');

    // Route::get('/manager/kista/add/agent/{id}', 'Manager\AgentController@agentlist');
    Route::get('/manager/agent/select/getAllAgent', 'Manager\AgentController@getAllAgent');
    Route::resource('/manager/agent','Manager\AgentController');
    Route::get('/manager/agent/status/{id}/{status}', 'Manager\AgentController@status');

    Route::get('/manager/subagent/{id}', 'Manager\SubAgentController@subagentlist');
    Route::resource('/manager/subagent','Manager\SubAgentController');

    //commision
    Route::resource('/manager/agent/commision','Manager\AgentHasController');

    Route::get('/manager/agent/add/client/{id}', 'Manager\ClientController@clientlist');
    Route::resource('/manager/client','Manager\ClientController');
    Route::get('/manager/agent_name/{id}', 'Manager\ClientController@agent_name');
    Route::get('/manager/client/status/{id}/{status}', 'Manager\ClientController@status');
    Route::get('/manager/client/leave/{id}/{leaveId}', 'Manager\ClientController@leave');
    Route::get('/manager/export','Manager\ClientController@fileExport');

    Route::post('/manager/detail/prize','Manager\DetailController@prize');
    Route::get('/manager/mdetail','Manager\DetailController@detail');
    Route::get('/manager/mdetailvoucher','Manager\DetailController@detailVoucher');
    Route::get('/manager/mdetailvoucheragent','Manager\DetailController@detailVoucherAgent');
    Route::get('/manager/mdetailvoucherdef','Manager\DetailController@detailVoucherDefault');

    Route::post('/manager/voucher/add','Manager\VoucherController@store');
    Route::resource('/manager/detail','Manager\DetailController');
    Route::get('/manager/detail/revise/{id}/{lotteryStatus}', 'Manager\DetailController@revise');


    Route::get('/manager/payment','Manager\PaymentController@payment');
    Route::post('/manager/payment','Manager\PaymentController@store');

    //remaining
    Route::resource('/manager/remaining','Manager\RemainingController');
    
    Route::get('/manager/clientlist', 'Manager\ClientListController@index');

    //expense
    Route::resource('/manager/expense','Manager\ExpenseController');
    Route::get('/manager/expense/status/{id}/{status}', 'Manager\ExpenseController@status');

    //supplier
    Route::resource('/manager/supplier','Manager\SupplierController');
    Route::resource('/manager/purchase','Manager\PurchaseController');
    Route::get('/manager/purchase/status/{id}/{status}', 'Manager\PurchaseController@status');

    //income and expenditure
    Route::resource('/manager/incomeexpenditure','Manager\IncomeExpenditureController');
    Route::get('/manager/incomeexpenditure/status/{id}/{status}', 'Manager\IncomeExpenditureController@status');
    
    //assets and liabilities
    Route::resource('/manager/assetsliabilities','Manager\AssetsLiabilitiesController');
    Route::get('/manager/assetsliabilities/status/{id}/{status}', 'Manager\AssetsLiabilitiesController@status');
    
    //bank balance
    Route::resource('/manager/bankbalance','Manager\BankBalanceController');
    Route::get('/manager/bankbalance/status/{id}/{status}', 'Manager\BankBalanceController@status');

    //cash balance
    Route::resource('/manager/cashbalance','Manager\CashBalanceController');
    Route::get('/manager/cashbalance/status/{id}/{status}', 'Manager\CashBalanceController@status');

     //digital balance
     Route::resource('/manager/digitalbalance','Manager\DigitalBalanceController');
     Route::get('/manager/digitalbalance/status/{id}/{status}', 'Manager\DigitalBalanceController@status');

    Route::resource('/manager/agenthaspaid','Manager\AHasPaidController');
    Route::resource('/manager/record','Manager\RecordController');
    Route::get('/manager/record/status/{id}/{status}', 'Manager\RecordController@status');
    Route::resource('/manager/kistahasopening','Manager\KistaHasOpeningController');

    Route::get('/manager/booking/cancel/{id}/{st}','Manager\BookingController@cancelBooking');
    Route::resource('/manager/booking','Manager\BookingController');
    Route::get('/manager/booking/check/{id}/{word?}','Manager\BookingController@check');

    //report section
    Route::get('/manager/report','Manager\Report\HomeController@loadDashboard');
    Route::get('/manager/report/tpnp','Manager\Report\TpnpController@tpnpreport');
    Route::get('/manager/report/tpnp/export','Manager\Report\TpnpController@fileExport');
    Route::get('/manager/report/tpnpl','Manager\Report\TpnplController@index');
    Route::get('/manager/report/agent','Manager\Report\AgentController@index');
    Route::get('/manager/report/expense','Manager\Report\ExpenseReportController@index');
    Route::get('/manager/report/lotteryprize','Manager\Report\LotteryPrizeController@index');
    Route::get('/manager/report/purchase','Manager\Report\CreditController@index');

    Route::get('/manager/report/purchase','Manager\Report\PurchaseController@index');
    Route::get('/manager/report/purchase/export','Manager\Report\PurchaseController@fileExport');
    Route::post('/manager/report/purchase/import','Manager\Report\PurchaseController@fileImport');

    Route::get('/manager/report/incomeexpenditure','Manager\Report\IncomeExpenditureController@index');
    Route::get('/manager/report/expenditure','Manager\Report\ExpenditureReportController@index');
    Route::get('/manager/report/expenditure/export','Manager\Report\ExpenditureReportController@fileExport');

    Route::get('/manager/report/assetsliabilities','Manager\Report\AssetsLiabilitiesController@index');
    Route::get('/manager/report/assetsliabilities/export','Manager\Report\AssetsLiabilitiesController@fileExport');
    
    Route::get('/manager/report/record','Manager\Report\RecordController@index');
    Route::get('/manager/report/record/export','Manager\Report\RecordController@fileExport');

    Route::get('/manager/report/preview','Manager\Report\PreviewController@index');
    Route::get('/manager/report/preview/export','Manager\Report\PreviewController@fileExport');

    Route::get('/manager/report/member','Manager\Report\MemberController@index');
    Route::get('/manager/report/member/export','Manager\Report\MemberController@fileExport');
    Route::post('/manager/report/member/import','Manager\Report\MemberController@fileImport');
    Route::get('/manager/report/voucher','Manager\Report\VoucherController@index');
    Route::get('/manager/report/mdetailvoucherreport','Manager\Report\VoucherController@getVoucherReport');
    Route::get('/manager/report/mdetailvoucheragentreport','Manager\Report\VoucherController@getAgentReport');



});
// Route::get('/home', 'HomeController@index')->name('home');
