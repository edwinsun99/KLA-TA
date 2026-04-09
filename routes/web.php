<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

// ===========================
// 🔹 IMPORT CONTROLLERS
// ===========================

// MASTER CONTROLLERS
use App\Http\Controllers\master\ServiceController as MasterServiceController;
use App\Http\Controllers\master\HomeController as MasterHomeController;
use App\Http\Controllers\master\CaseController as MasterCaseController;
use App\Http\Controllers\master\NewCaseController as MasterNewCaseController;
use App\Http\Controllers\master\DetailController as MasterDetailController;
use App\Http\Controllers\master\UserController;
use App\Http\Controllers\master\QuotAppCancController as MasterQuotAppCancController;
use App\Http\Controllers\master\EngineerController as MasterEngineerController;
use App\Http\Controllers\master\RoleController;
use App\Http\Controllers\master\ErfController as MasterErfController;
use App\Http\Controllers\master\QuotReqController as MasterQuotReqController;
use App\Http\Controllers\master\FinishController as MasterFinishController;
use App\Http\Controllers\master\ProductController as MasterProductController;
use App\Http\Controllers\master\ProfileController as MasterProfileController;

// CM CONTROLLERS
use App\Http\Controllers\cm\ServiceController as CmServiceController;
use App\Http\Controllers\cm\HomeController as CmHomeController;
use App\Http\Controllers\cm\CaseController as CmCaseController;
use App\Http\Controllers\cm\DetailController as CmDetailController;
use App\Http\Controllers\cm\QuotPartReqController;
use App\Http\Controllers\cm\QuotReqController as CmQuotReqController;
use App\Http\Controllers\cm\ProfileController as CmProfileController;

// CE CONTROLLERS
use App\Http\Controllers\ce\ServiceController as CeServiceController;
use App\Http\Controllers\ce\HomeController as CeHomeController;
use App\Http\Controllers\ce\CaseController as CeCaseController;
use App\Http\Controllers\ce\DetailController as CeDetailController;
use App\Http\Controllers\ce\EngineerController as CeEngineerController;
use App\Http\Controllers\ce\QuotAppCancController as CeQuotAppCancController;
use App\Http\Controllers\ce\ProductController as CeProductController;
use App\Http\Controllers\ce\ErfController as CeErfController;
use App\Http\Controllers\ce\FinishController as CeFinishController;
use App\Http\Controllers\ce\ProfileController as CeProfileController;

// CE CONTROLLERS
use App\Http\Controllers\cs\ServiceController as CsServiceController;
use App\Http\Controllers\cs\HomeController as CsHomeController;
use App\Http\Controllers\cs\CaseController as CsCaseController;
use App\Http\Controllers\cs\DetailController as CsDetailController;
use App\Http\Controllers\cs\ProductController as CsProductController;
use App\Http\Controllers\cs\ErfController as CsErfController;
use App\Http\Controllers\cs\FinishController as CsFinishController;
use App\Http\Controllers\cs\ProfileController as CsProfileController;

// Customer Controllers
use App\Http\Controllers\customer\TrackCaseController;
use App\Http\Controllers\customer\ServiceLocationController;

// OTHER CONTROLLERS
use App\Http\Controllers\MasterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;



// ===========================
// 🔐 AUTH ROUTES
// ===========================
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'loginProcess'])->name('login.process');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/enroll', [RegisterController::class, 'store'])->name('register.process');


// Default redirect ke login
Route::get('/', fn() => redirect()->route('login'));

// ===========================
// 🔹 Customer ROUTES
// ===========================
Route::get('/track', [TrackCaseController::class, 'index'])->name('track.form');
Route::post('/track/check', [TrackCaseController::class, 'check'])->name('track.check');
Route::get('/track/{id}', [TrackCaseController::class, 'show'])->name('track.journey');
// public page
Route::get('/service-location', [ServiceLocationController::class, 'index'])->name('service.location');

// API untuk kirim data branches JSON
Route::get('/api/branches', [ServiceLocationController::class, 'branchesJson'])->name('api.branches');

// ===========================
// 🔹 MASTER ROUTES
// ===========================
Route::group([], function () {
    Route::get('/master/home', function () {
        if (!Session::get('login') || Session::get('role') !== 'MASTER') {
            return redirect()->route('login')->with('error', 'Akses ditolak.');
        }
        return app(MasterHomeController::class)->index();
    })->name('master.home');
    

    // Route::get('/home', function () {
    //     if (!Session::get('login') || Session::get('role') !== 'MASTER') {
    //         return redirect()->route('login')->with('error', 'Akses ditolak.');
    //     }
    //     return view('master.home');
    // })->name('home');

    Route::prefix('master')->name('master.')->group(function () {

    Route::get('/services', [MasterServiceController::class, 'index'])->name('services.index');
    Route::post('/services', [MasterServiceController::class, 'store'])->name('services.store');

    Route::get('/case', [MasterCaseController::class, 'index'])->name('case.index');

    Route::post('/case/{id}/status', 'App\Http\Controllers\master\DetailController@updateStatus')
    ->name('case.updateStatus');

    Route::post('/master/case/{id}/note', [MasterDetailController::class, 'addNote'])->name('case.note');

    Route::get('/finish-repair', [MasterFinishController::class, 'index']) ->name('finish.repair');

    Route::get('/master/finish/logdate', [MasterFinishController::class, 'logdate']) ->name('finish.logdate');

    Route::get('/master/erf/logdate', [MasterErfController::class, 'logdate']) ->name('selecterf.logdate');

    Route::get('/engineer', [MasterEngineerController::class, 'index']) ->name('engineer.index');

    Route::get('/quotation-request', [MasterQuotReqController::class, 'index']) ->name('qreq.index');

    Route::get('/quotreq/logdate', [MasterQuotReqController::class, 'logdate'])->name('qreq.logdate');

    Route::get('/quotation-appcancl', [MasterQuotAppCancController::class, 'index'])->name('qac.index');

    Route::get('/qac-logdate', [MasterQuotAppCancController::class, 'logdate'])->name('qac.logdate');


    Route::get('/select-case-for-erf', [MasterErfController::class, 'selectCase'])
        ->name('erf.select');

    Route::get('/logdate-for-erf', [MasterErfController::class, 'logdate'])
        ->name('erf.logdate');

    Route::get('/case/{id}/upload-erf', [MasterErfController::class, 'form'])
        ->name('erf.form');

    Route::post('/case/{id}/upload-erf', [MasterErfController::class, 'upload'])
        ->name('erf.upload');

    Route::get('/case/{id}/erf-preview', [MasterErfController::class, 'preview'])
        ->name('erf.preview');

    Route::get('/case/{id}/erf-download', [MasterErfController::class, 'download'])
        ->name('erf.download');

   Route::get('/profile', [MasterProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::post('/profile/update', [MasterProfileController::class, 'update'])
        ->name('profile.update');

    Route::post('/profile/password', [MasterProfileController::class, 'updatePassword'])
        ->name('profile.password');

        // Gunakan satu route ini untuk menghandle Status Update sekaligus Lognote
    Route::post('/master/case/{id}/update-all', [App\Http\Controllers\master\DetailController::class, 'updateAll'])
        ->name('case.updateAll');
    });

      // 🔥 ROUTE LOGDATE MASTER (FILTER TANGGAL + FILTER CABANG)
      Route::prefix('master')->name('master.')->group(function () {

        Route::get('/master/case/search', [MasterCaseController::class, 'search'])->name('case.search');

      });

    Route::get('/master/case/logdate', [MasterCaseController::class, 'logdate']) ->name('master.case.logdate');
    Route::get('/newcase', [MasterNewCaseController::class, 'create'])->name('master.newcase');
    Route::get('/master/engineer/logdate', [MasterEngineerController::class, 'logdate']) ->name('master.engineer.logdate');
    Route::get('/master/case/{id}', [MasterDetailController::class, 'show'])->name('master.case.show');
    Route::get('/case/{id}/pdf', [MasterDetailController::class, 'downloadPdf'])->name('case.downloadPdf');
    Route::get('/case/{id}/pdf/preview', [MasterDetailController::class, 'previewPdf'])->name('case.previewPdf');

// Pastikan ->name() nya sama dengan yang dipanggil di form
    Route::get('master/excel/cofdata', [MasterCaseController::class, 'excel'])->name('excel.cofdata');

      
      
        Route::prefix('master')->group(function () {
            Route::get('/master/manage-users', [RoleController::class, 'index'])->name('roles.index');
            Route::post('/save-users', [RoleController::class, 'store'])->name('roles.store');
        Route::delete('/destroy-roles/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');
        Route::put('/update-roles/{id}', [RoleController::class, 'update'])->name('roles.update');

        Route::get('/get-product-type', [MasterProductController::class, 'getProductType'])->name('getProductType');
    });
});

// ===========================
// 🔹 CM ROUTES (FINAL & FIXED)
// ===========================
Route::prefix('cm')->name('cm.')->group(function () {

    // HOME
    Route::get('/home', [CmHomeController::class, 'index'])->name('home');

    // SERVICE
    Route::get('/services', [CmServiceController::class, 'index'])->name('services.index');
    Route::post('/services', [CmServiceController::class, 'store'])->name('services.store');

    // CASE
    Route::get('/case', [CmCaseController::class, 'index'])->name('case.index');
    Route::get('/case/{id}', [CmDetailController::class, 'show'])->name('case.show');

    // SEARCH
    Route::get('cm/case/search', [CmCaseController::class, 'search'])->name('case.search');

    // LOGDATE
    Route::get('cm/case/logdate', [CmCaseController::class, 'logdate'])->name('case.logdate');
    Route::get('cm/qreq/logdate', [CmQuotReqController::class, 'logdate'])->name('qreq.logdate');

    // EXCEL
    Route::get('cm/excel/cofdata', [CmCaseController::class, 'excel'])->name('excel.cofdata');
        Route::get('cm/excel/qreqreport', [CmQuotReqController::class, 'excel'])->name('excel.qreqreport');

    // CM: menu Quotation Request (tampilkan list yang status == 'Quotation Request')
    Route::get('cm/quotation-request', [CmQuotReqController::class, 'index']) ->name('qreq.index');

    Route::post('/case/{id}/status', 'App\Http\Controllers\cm\DetailController@updateStatus')
    ->name('case.updateStatus');

    Route::post('/case/{id}/note', 
    [CmDetailController::class, 'addNote'])
    ->name('case.note');

      Route::get('/profile', [CmProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::post('/profile/update', [CmProfileController::class, 'update'])
        ->name('profile.update');

    Route::post('/profile/password', [CmProfileController::class, 'updatePassword'])
        ->name('profile.password');

        // Gunakan satu route ini untuk menghandle Status Update sekaligus Lognote
        Route::post('/cm/case/{id}/update-all', [App\Http\Controllers\cm\DetailController::class, 'updateAll'])
            ->name('case.updateAll');
});

// ===========================
// 🔹 CE ROUTES
// ===========================
    Route::group([], function () {
        Route::get('/ce/home', function (Request $request) {
            if (!Session::get('login') || Session::get('role') !== 'CE') {
                return redirect()->route('login')->with('error', 'Akses ditolak.');
            }
            return app(CeHomeController::class)->index($request);
        })->name('ce.home');

    // Route::get('/home', function () {
    //     if (!Session::get('login') || Session::get('role') !== 'CE') {
    //         return redirect()->route('login')->with('error', 'Akses ditolak.');
    //     }
    //     return view('ce.home');
    // })->name('home');

    Route::get('/ce/services', [CeServiceController::class, 'index'])->name('ce.services.index');
    Route::post('/ce/services', [CeServiceControlller::class, 'store'])->name('ce.services.store');

    Route::get('/ce/case', [CeCaseController::class, 'index'])->name('ce.case.index');
    Route::get('/ce/case/logdate', [CeCaseController::class, 'logdate'])->name('ce.case.logdate');
    Route::get('/ce/finish/logdate', [CeFinishController::class, 'logdate'])->name('ce.finish.logdate');
    Route::get('/ce/cases/new', fn() => view('ce.newcase'))->name('cases.new');
    Route::get('/ce/newcase', [CeCaseController::class, 'create'])->name('newcase');

    Route::get('/case/{id}', [CeDetailController::class, 'show'])->name('ce.case.show');
    Route::get('/case/{id}/pdf', [CeDetailController::class, 'downloadPdf'])->name('case.downloadPdf');
    Route::get('/case/{id}/pdf/preview', [CeDetailController::class, 'previewPdf'])->name('case.previewPdf');

    Route::get('/cases/search', [CeCaseController::class, 'search'])->name('case.search');
    Route::get('ce/excel/cofdata', [CeCaseController::class, 'excel'])->name('ce.excel.cofdata');
// CE - ERF ROUTES
Route::prefix('ce')->group(function () {

    Route::get('/select-case-for-erf', [CeErfController::class, 'selectCase'])
        ->name('erf.select');

    Route::get('/case/{id}/upload-erf', [CeErfController::class, 'form'])
        ->name('ce.erf.form');

    Route::post('/case/{id}/upload-erf', [CeErfController::class, 'upload'])
        ->name('erf.upload');

    Route::get('/case/{id}/erf-preview', [CeErfController::class, 'preview'])
        ->name('erf.preview');

    Route::get('/case/{id}/erf-download', [CeErfController::class, 'download'])
        ->name('erf.download');
                             // CM: menu Quotation Request (tampilkan list yang status == 'Quotation Request')
    Route::get('/quotation-appcancl/logdate', [CeQuotAppCancController::class, 'logdate'])
         ->name('quotaorc.logdate');    

});

   Route::prefix('ce')->name('ce.')->group(function () {

    // Halaman Engineer
    Route::get('/engineer', [CeEngineerController::class, 'index'])
        ->name('engineer.index');

Route::get('/case/{id}', 'App\Http\Controllers\ce\DetailController@status')
    ->name('ce.case.show');

// Gunakan satu route ini untuk menghandle Status Update sekaligus Lognote
Route::post('/ce/case/{id}/update-all', [App\Http\Controllers\ce\DetailController::class, 'updateAll'])
    ->name('case.updateAll');

      Route::get('/profile', [CeProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::post('/profile/update', [CeProfileController::class, 'update'])
        ->name('profile.update');

    Route::post('/profile/password', [CeProfileController::class, 'updatePassword'])
        ->name('profile.password');
        
        // Generate Invoice
    Route::post('/create/invoice/{id}', 
        [App\Http\Controllers\CeFinishController::class, 'create']
    )->name('invoice.create');

Route::get('/ce/invoice/{id}/preview', [FinishController::class, 'previewInvoice'])
    ->name('invoice.preview');

    // Mark as Paid
    Route::post('/paid/{id}', 
        [App\Http\Controllers\CeFinishController::class, 'markAsPaid']
    )->name('invoice.paid');
  
});

Route::prefix('ce')->name('ce.')->group(function () {

            // CM: menu Quotation Request (tampilkan list yang status == 'Quotation Request')
    Route::get('/quotation-appcancl', [CeQuotAppCancController::class, 'index'])
         ->name('quotation.appcancl');

             Route::get('/finish-repair', [CeFinishController::class, 'index'])
         ->name('finish.repair');
         
Route::get('/get-product-type', 
    [App\Http\Controllers\ce\ProductController::class, 'getProductType'])
    ->name('getProductType');

});

Route::post('/ce/case/{id}/note', 
    [CeDetailController::class, 'addNote'])
    ->name('ce.case.note');
});

// ===========================
// 🔹 CS ROUTES
// ===========================

Route::group([], function () {

    Route::get('/cs/home', function (Request $request) {
        if (!Session::get('login') || Session::get('role') !== 'CS') {
            return redirect()->route('login')->with('error', 'Akses ditolak.');
        }
        return app(CsHomeController::class)->index($request);
    })->name('cs.home');


    Route::get('/cs/services', [CsServiceController::class, 'index'])->name('cs.services.index');
    Route::post('/cs/services', [CsServiceController::class, 'store'])->name('cs.services.store');

    Route::get('/cs/case', [CsCaseController::class, 'index'])->name('cs.case.index');

    Route::get('/cs/case/logdate', [CsCaseController::class, 'logdate'])->name('cs.case.logdate');
    Route::get('/cs/finish/logdate', [CsFinishController::class, 'logdate'])->name('cs.finish.logdate');

    Route::get('/cs/cases/new', fn() => view('cs.newcase'))->name('cs.cases.new');
    Route::get('/cs/newcase', [CsCaseController::class, 'create'])->name('cs.newcase');


    Route::get('/cs/case/{id}', [CsDetailController::class, 'show'])->name('cs.case.show');

    Route::get('/cs/case/{id}/pdf', [CsDetailController::class, 'downloadPdf'])->name('cs.case.downloadPdf');
    Route::get('/cs/case/{id}/pdf/preview', [CsDetailController::class, 'previewPdf'])->name('cs.case.previewPdf');


    Route::get('/cs/cases/search', [CsCaseController::class, 'search'])->name('cs.case.search');

    Route::get('/cs/excel/cofdata', [CsCaseController::class, 'excel'])->name('cs.excel.cofdata');


    // ===========================
    // ERF ROUTES
    // ===========================

    Route::prefix('cs')->name('cs.')->group(function () {

        Route::get('/select-case-for-erf', [CsErfController::class, 'selectCase'])
            ->name('erf.select');

        Route::get('/case/{id}/upload-erf', [CsErfController::class, 'form'])
            ->name('erf.form');

        Route::post('/case/{id}/upload-erf', [CsErfController::class, 'upload'])
            ->name('erf.upload');

        Route::get('/case/{id}/erf-preview', [CsErfController::class, 'preview'])
            ->name('erf.preview');

        Route::get('/case/{id}/erf-download', [CsErfController::class, 'download'])
            ->name('erf.download');

    });


    // ===========================
    // CASE MANAGEMENT
    // ===========================

    Route::prefix('cs')->name('cs.')->group(function () {

        Route::get('/case/{id}', [CsDetailController::class, 'status'])
            ->name('case.show');

        Route::post('/case/{id}/update-all', 
            [CsDetailController::class, 'updateAll'])
            ->name('case.updateAll');


        Route::get('/profile', [CsProfileController::class, 'edit'])
            ->name('profile.edit');

        Route::post('/profile/update', [CsProfileController::class, 'update'])
            ->name('profile.update');

        Route::post('/profile/password', [CsProfileController::class, 'updatePassword'])
            ->name('profile.password');


        // Generate Invoice
        Route::post('/create/invoice/{id}', 
            [CsFinishController::class, 'create'])
            ->name('invoice.create');


        Route::get('/invoice/{id}/preview', [CsFinishController::class, 'previewInvoice'])
            ->name('invoice.preview');


        // Mark as Paid
        Route::post('/paid/{id}', 
            [CsFinishController::class, 'markAsPaid'])
            ->name('invoice.paid');

    });


    // ===========================
    // FINISH REPAIR
    // ===========================

    Route::prefix('cs')->name('cs.')->group(function () {

        Route::get('/finish-repair', [CsFinishController::class, 'index'])
            ->name('finish.repair');

        Route::get('/get-product-type', 
            [App\Http\Controllers\cs\ProductController::class, 'getProductType'])
            ->name('getProductType');
    });

    Route::post('/cs/case/{id}/note', 
        [CsDetailController::class, 'addNote'])
        ->name('cs.case.note');
});

// // ===========================
// // ⚡ ALIAS: CS ROUTES → ARAHKAN KE CE
// // (agar semua endpoint lama CS tetap bisa dipakai)
// // ===========================
// Route::prefix('cs')->group(function () {
//     Route::get('/home', fn() => redirect()->route('ce.home'));
//     Route::get('/services', [CeServiceController::class, 'index'])->name('cs.services.index');
//     Route::post('/services', [CeServiceController::class, 'store'])->name('cs.services.store');

//     Route::get('/case', [CeCaseController::class, 'index'])->name('cs.case.index');
//     Route::get('/case/{id}', [CeDetailController::class, 'show'])->name('cs.case.show');
//     Route::get('/cases/new', fn() => redirect()->route('cases.new'))->name('cs.cases.new');

//     Route::get('/case/{id}/pdf', [CeDetailController::class, 'downloadPdf'])->name('cs.case.downloadPdf');
//     Route::get('/case/{id}/pdf/preview', [CeDetailController::class, 'previewPdf'])->name('cs.case.previewPdf');

//     Route::get('/cases/search', [CeCaseController::class, 'search'])->name('cs.case.search');
//     Route::get('/excel/cofdata', [CeCaseController::class, 'excel'])->name('cs.excel.cofdata');
    
// });
// Route::middleware(['web', 'check.session'])->prefix('ce')->group(function () {
//     Route::get('/home', [CeHomeController::class, 'index'])->name('ce.home');
//     Route::post('/services', [CeServiceController::class, 'store'])->name('ce.services.store');
// });