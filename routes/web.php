<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth;
use App\Http\Controllers\App;
use App\Http\Controllers\Api;


Route::middleware(['web'])->group(function () {

    Route::get('/pm', [Auth::class, 'login'])->name('login');
    Route::post('/pm', [Auth::class, 'zzz_login']);
    Route::get('/dashboard', [Auth::class, 'dashboard'])->name('dashboard');
    Route::get('/logout', [Auth::class, 'logout'])->name('logout');

    Route::get('/', [App::class, 'homepage'])->name('homepage');
    Route::get('/data', [App::class, 'data'])->name('data');
    Route::get('/report', [App::class, 'report'])->name('report');
    Route::get('/calendar', [App::class, 'calendar'])->name('calendar');

    Route::get('/inholiday', [App::class, 'inholiday'])->name('inholiday');
    Route::post('/holiday-save', [App::class, 'holiday_save'])->name('holiday.save');
    Route::post('/holiday-update', [App::class, 'holiday_update'])->name('holiday.update');
    Route::post('/holiday/delete', [App::class, 'holiday_delete'])->name('holiday.delete');

    Route::get('/inclient', [App::class, 'inclient'])->name('inclient');
    Route::post('/client-save', [App::class, 'client_save'])->name('client.save');
    Route::post('/client-update', [App::class, 'client_update'])->name('client.update');
    Route::post('/client/delete', [App::class, 'client_delete'])->name('client.delete');

    Route::get('/inresponsible', [App::class, 'inresponsible'])->name('inresponsible');
    Route::post('/insert-resource', [App::class, 'insert_resource'])->name('insert_resource');
    Route::post('/update-resource', [App::class, 'update_resource'])->name('update_resource');
    Route::post('/delete-resource', [App::class, 'delete_resource'])->name('delete_resource');

    Route::get('/project', [App::class, 'project'])->name('project');
    Route::post('/zzz_project', [App::class, 'zzz_project'])->name('zzz_project');
    Route::post('/update_project/{id}', [App::class, 'updateProject'])->name('update_project');
    Route::delete('/delete_project/{id}', [App::class, 'deleteProject'])->name('delete_project');
    Route::post('/zzz_updateStatus', [App::class, 'zzz_updateStatus'])->name('zzz_updateStatus');
    Route::post('/zzz_save_process_temp', [App::class, 'zzz_save_process_temp'])->name('zzz_save_process_temp');
    Route::get('/zzz_get_stdproc', [App::class, 'zzz_get_stdproc']);
    Route::post('/zzz_save_stdproc', [App::class, 'zzz_save_stdproc']);

    Route::get('/trial/{id}', [App::class, 'trial'])->name('trial');
    Route::post('/trial/store', [App::class, 'trial_store'])->name('trial.store');
    Route::post('/trial/data', [App::class, 'trial_data'])->name('trial.data');
    Route::post('/trial/standard', [App::class, 'trial_standard'])
    ->name('trial.standard');

    Route::get('/task/{id}', [App::class, 'task'])->name('task');
    Route::get('/test-holiday', [App::class, 'testHoliday']);
    Route::post('/zzz_task_add', [App::class, 'zzz_task_add'])->name('zzz_task_add');
    Route::post('/zzz_task_update', [App::class, 'zzz_task_update'])->name('zzz_task_update');
    Route::post('/zzz_task_delete/{id}', [App::class, 'zzz_task_delete'])->name('zzz_task_delete');
    Route::post('/zzz_task_add_milestone', [App::class, 'zzz_task_add_milestone'])->name('zzz_task_add_milestone');
    Route::post('/zzz_activity_add', [App::class, 'zzz_activity_add']);
    Route::post('/get_activity_log', [App::class, 'get_activity_log']);
    Route::get('/activity-log', [App::class, 'showActivityLog']);
    Route::get(
        '/pm/activity-history/{projectId}/{taskId}',
        [App::class, 'activityHistory']
    );

    Route::get('/projectdash/{id}', [App::class, 'projectdash'])->name('projectdash');
    Route::post('/invoice/add', [App::class, 'addInvoice'])->name('invoice.add');
    Route::get('/invoice/list/{project_id}', [App::class, 'getInvoiceList'])->name('invoice.list');
    Route::post('/invoice/add', [App::class, 'addInvoice'])->name('invoice.add');
    Route::get('/api/resource-workload', [App::class, 'getResourceWorkload'])->name('api.resource-workload');
    
    Route::get('/problem/{id}', [App::class, 'problem'])->name('problem');


    Route::get('/ganttchart', [App::class, 'ganttchart'])->name('ganttchart');
    Route::get('/api/project-tasks/{projectId}', [App::class, 'getProjectTasks']);

    Route::get('/resource', [App::class, 'resource'])->name('resource');
    Route::get('/resource/all-data', [App::class, 'getAllResourcesData'])->name('resource.all.data');

    Route::get('/heatmap', [App::class, 'heatmap'])->name('heatmap');
    Route::get('/heatmap/data', [App::class, 'getHeatmapData'])->name('heatmap.data');

    Route::get('/progress', [App::class, 'progress'])->name('progress');
    Route::get('/progress/data', [App::class, 'getProgressData'])->name('getProgressData');

    // cek API
    Route::get('/get-masterdata', [Api::class, 'getMasterData']);

    // cek Oracle
    Route::get('/test-db', function () {
        try {
            $users = DB::table('USERS')->get();
            return response()->json($users);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    });
});
