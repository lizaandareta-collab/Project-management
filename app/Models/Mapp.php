<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use App\Models\Maio;
use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\Encoders\PngEncoder;
use Intervention\Image\Encoders\WebpEncoder;



class Mapp
{
    public static function insert_resource($req)
    {
        try {
            $data = [
                'NPK' => $req->npk,
                'EMP_NAME' => $req->emp_name,
                'EMP_TYPE' => $req->emp_type,
                'DEPARTMENT' => $req->department,
                'MAX_HOUR' => $req->max_hour,
                'SYSDATE1' => DB::raw('SYSDATE')
            ];

            DB::connection('oracle')->table('PROMAN.RESOURCE_MGMT')->insert($data);

            return ['success' => true, 'message' => 'Resource inserted successfully'];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public static function update_resource($req)
    {
        try {
            $data = [
                'EMP_NAME' => $req->emp_name,
                'EMP_TYPE' => $req->emp_type,
                'DEPARTMENT' => $req->department,
                'MAX_HOUR' => $req->max_hour,
                'SYSDATE1' => DB::raw('SYSDATE')
            ];

            DB::connection('oracle')->table('PROMAN.RESOURCE_MGMT')
                ->where('NPK', $req->npk)
                ->update($data);

            return ['success' => true, 'message' => 'Resource updated successfully'];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public static function delete_resource($req)
    {
        try {
            DB::connection('oracle')->table('PROMAN.RESOURCE_MGMT')
                ->where('NPK', $req->npk)
                ->delete();

            return ['success' => true, 'message' => 'Resource deleted successfully'];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public static function insert_inholiday($req)
    {
        try {
            DB::connection('oracle')->beginTransaction();

            $data = [
                'DESCRIPTION' => $req->description,
                'DATE' => DB::raw("TO_DATE('{$req->date}', 'YYYY-MM-DD')"),
                'STATUS1' => 1,
                'SYSDATE1' => DB::raw('SYSDATE')
            ];

            DB::connection('oracle')->table('PROMAN.HOLIDAY')->insert($data);

            DB::connection('oracle')->commit();
            return ['success' => true, 'message' => 'Holiday inserted successfully'];
        } catch (\Exception $e) {
            DB::connection('oracle')->rollBack();
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public static function update_inholiday($req)
    {
        try {
            DB::connection('oracle')->beginTransaction();

            DB::connection('oracle')
                ->table('PROMAN.HOLIDAY')
                ->where('ID', $req->id)
                ->update([
                    'DESCRIPTION' => $req->description,
                    'DATE' => DB::raw("TO_DATE('{$req->date}', 'YYYY-MM-DD')"),
                    'STATUS1' => 1,
                    'SYSDATE1' => DB::raw('SYSDATE')
                ]);

            DB::connection('oracle')->commit();
            return ['success' => true, 'message' => 'Holiday updated successfully'];
        } catch (\Exception $e) {
            DB::connection('oracle')->rollBack();
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public static function delete_inholiday($id)
    {
        try {
            DB::connection('oracle')->beginTransaction();

            DB::connection('oracle')
                ->table('PROMAN.HOLIDAY')
                ->where('ID', $id)
                ->delete();

            DB::connection('oracle')->commit();

            return ['success' => true, 'message' => 'Client deleted successfully'];

        } catch (\Exception $e) {
            DB::connection('oracle')->rollBack();
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public static function insert_inclient($req)
    {
        try {
            DB::connection('oracle')->beginTransaction();

            $data = [
                'CLIENT_ORA' => $req->client_ora,
                'NAME' => $req->name,
                'COMPANY' => $req->company,
                'COUNTRY' => $req->country,
                'STATUS1' => 1,
                'SYSDATE1' => DB::raw('SYSDATE')
            ];

            DB::connection('oracle')->table('PROMAN.CLIENT')->insert($data);

            DB::connection('oracle')->commit();
            return ['success' => true, 'message' => 'Client inserted successfully'];
        } catch (\Exception $e) {
            DB::connection('oracle')->rollBack();
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }


    public static function update_inclient($req)
    {
        try {
            DB::connection('oracle')->beginTransaction();

            DB::connection('oracle')
                ->table('PROMAN.CLIENT')
                ->where('ID', $req->id)
                ->update([
                    'CLIENT_ORA' => $req->client_ora,
                    'NAME' => $req->name,
                    'COMPANY' => $req->company,
                    'COUNTRY' => $req->country,
                    'STATUS1' => 1,
                    'SYSDATE1' => DB::raw('SYSDATE')
                ]);

            DB::connection('oracle')->commit();
            return ['success' => true, 'message' => 'Client updated successfully'];
        } catch (\Exception $e) {
            DB::connection('oracle')->rollBack();
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public static function delete_inclient($id)
    {
        try {
            DB::connection('oracle')->beginTransaction();

            DB::connection('oracle')
                ->table('PROMAN.CLIENT')
                ->where('ID', $id)
                ->delete();

            DB::connection('oracle')->commit();

            return ['success' => true, 'message' => 'Client deleted successfully'];

        } catch (\Exception $e) {
            DB::connection('oracle')->rollBack();
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public static function add_invoice($projectId, $amount, $remarks = null)
    {
        try {
            $db = DB::connection('oracle');
            $db->beginTransaction();

            // Ambil CLIENT_ID
            $client = $db->table('PROMAN.PROJECT')
                ->select('CLIENT')
                ->where('ID', $projectId)
                ->first();

            $clientId = $client ? $client->client : null;

            $db->table('PROMAN.INVOICE_MGMT')
                ->insert([
                    'PROJECT_ID' => $projectId,
                    'CLIENT_ID' => $clientId,
                    'AMOUNT' => $amount,
                    'REMARKS' => $remarks,
                    'DATE_CREATED' => DB::raw('SYSDATE')
                ]);

            $db->commit();

            return ['success' => true, 'message' => 'Invoice berhasil ditambahkan'];

        } catch (\Exception $e) {
            $db->rollBack();
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public static function insert_project($req)
    {
        try {
            DB::connection('oracle')->beginTransaction();

            // === 1. INSERT PROJECT ===
            $data = [
                'PROJECT_NAME' => $req->project_name,
                'RESPONSIBLE' => $req->responsible,
                'CLIENT' => $req->client,
                'BUDGET' => $req->budget,
                'START_DATE' => DB::raw("TO_DATE('{$req->start_date}', 'YYYY-MM-DD')"),
                'DAYS' => $req->days,
                'END_DATE' => DB::raw("TO_DATE('{$req->end_date}', 'YYYY-MM-DD')"),
                'COMPLEXITY' => $req->complexity,
                'PRIORITY' => $req->priority,
                'STATUS' => $req->status,
                'SYSDATE1' => DB::raw('SYSDATE')
            ];

            DB::connection('oracle')->table('PROMAN.PROJECT')->insert($data);

            // === 2. AMBIL ID PROJECT YANG BARU DIBUAT ===
            $project = DB::connection('oracle')
                ->table('PROMAN.PROJECT')
                ->where('PROJECT_NAME', $req->project_name)
                ->orderByDesc('ID')
                ->first();

            if (!$project) {
                throw new \Exception('Project not found after insert');
            }

            // $projectId = $project->id;

            // // === 3. AMBIL TEMPLATE TASK DARI TASK_SETUP ===
            // $taskSetup = DB::connection('oracle')
            //     ->table('PROMAN.TASK_SETUP')
            //     ->select('TASK_ID', 'MILESTONE_TASK', 'IS_MILESTONE', 'PARENT_TASK', 'ORDER1')
            //     ->get();

            $projectId = $project->id;

            /*
            |--------------------------------------------------------------------------
            | 🔥 UPDATE PROMAN.STANDARD
            | Isi PROJECT_ID untuk data temp
            |--------------------------------------------------------------------------
            */
            DB::connection('oracle')
                ->table('PROMAN.STANDARD')
                ->whereNull('PROJECT_ID')
                ->update([
                    'PROJECT_ID' => $projectId
                ]);

            // === 3. AMBIL TEMPLATE TASK DARI TASK_SETUP ===
            $taskSetup = DB::connection('oracle')
                ->table('PROMAN.TASK_SETUP')
                ->select('TASK_ID', 'MILESTONE_TASK', 'IS_MILESTONE', 'PARENT_TASK', 'ORDER1')
                ->get();


            // === 4. INSERT TASK KE PROJECT_TASK ===
            foreach ($taskSetup as $task) {
                DB::connection('oracle')->table('PROMAN.PROJECT_TASK')->insert([
                    'PROJECT_ID' => $projectId,
                    'TASK_ID' => $task->task_id,
                    'MILESTONE_TASK' => $task->milestone_task,
                    'IS_MILESTONE' => $task->is_milestone,
                    'ORDER1' => $task->order1,
                    'PARENT_TASK' => $task->parent_task,
                    'SYSDATE1' => DB::raw('SYSDATE')
                ]);
            }

            DB::connection('oracle')->commit();
            return ['success' => true, 'message' => 'Project inserted successfully'];
        } catch (\Exception $e) {
            DB::connection('oracle')->rollBack();
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public static function save_process_temp($req)
    {
        try {
            DB::connection('oracle')->beginTransaction();

            if ($req->checked) {

                // === SIMPAN PROCESS ===
                if ($req->init === 'process') {
                    DB::connection('oracle')->table('PROMAN.STANDARD')->insert([
                        'PROCESS_ID' => $req->lov_id,
                        'INIT' => 'process',
                        'SYSDATE1' => DB::raw('SYSDATE')
                    ]);
                }

                // === SIMPAN STDPROC VALUE ===
                if ($req->init === 'stdproc') {
                    DB::connection('oracle')->table('PROMAN.STANDARD')->insert([
                        'PROCESS_ID' => $req->process_id,
                        'STDPROC_ID' => $req->stdproc_id,
                        'VALUE' => $req->value,
                        'INIT' => 'stdproc',
                        'SYSDATE1' => DB::raw('SYSDATE')
                    ]);
                }

            } else {

                // ============================
                // DELETE PROCESS
                // ============================
                if ($req->init === 'process') {

                    DB::connection('oracle')->table('PROMAN.STANDARD')
                        ->where('PROCESS_ID', $req->lov_id)
                        ->where('INIT', 'stdproc')
                        ->whereNull('PROJECT_ID')   // 🔥 penting
                        ->delete();

                    DB::connection('oracle')->table('PROMAN.STANDARD')
                        ->where('PROCESS_ID', $req->lov_id)
                        ->where('INIT', 'process')
                        ->whereNull('PROJECT_ID')   // 🔥 penting
                        ->delete();

                }

                // ============================
                // DELETE STDPROC (MANUAL UNCHECK / FUTURE)
                // ============================
                if ($req->init === 'stdproc') {
                    DB::connection('oracle')->table('PROMAN.STANDARD')
                        ->where('PROCESS_ID', $req->process_id)
                        ->where('STDPROC_ID', $req->stdproc_id)
                        ->where('INIT', 'stdproc')
                        ->whereNull('PROJECT_ID')   // 🔥 penting
                        ->delete();

                }
            }


            DB::connection('oracle')->commit();
            return ['success' => true];

        } catch (\Exception $e) {
            DB::connection('oracle')->rollBack();
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    // public static function insert_trial($req)
    // {
    //     try {
    //         // Mulai transaction
    //         DB::connection('oracle')->beginTransaction();

    //         // -----------------------
    //         // 1. Upload file jika ada
    //         // -----------------------
    //         $softcopyIds = [];  // simpan ID softcopy

    //         if ($req->hasFile('picture')) {
    //             foreach ($req->file('picture') as $file) {
    //                 // Generate ID softcopy
    //                 $softId = self::generate_id('softcopy');

    //                 // Nama asli file dari user → CLIENT_NAME
    //                 $originalName = $file->getClientOriginalName();
    //                 $cleanClientName = preg_replace('/\s+/', '_', $originalName);

    //                 // Generate nama unik untuk FILE_NAME
    //                 $rand = substr(md5(uniqid()), 0, 10);
    //                 $uniqueName = $rand . '_' . $cleanClientName;

    //                 // Size file
    //                 $size = $file->getSize();

    //                 // Ekstensi & tipe file
    //                 $ext = strtolower($file->getClientOriginalExtension());

    //                 // Tentukan FILE_TYPE
    //                 if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
    //                     $type = 'image';
    //                 } elseif ($ext === 'pdf') {
    //                     $type = 'pdf';
    //                 } elseif (in_array($ext, ['doc', 'docx'])) {
    //                     $type = 'document';
    //                 } elseif (in_array($ext, ['xls', 'xlsx'])) {
    //                     $type = 'spreadsheet';
    //                 } else {
    //                     $type = 'other';
    //                 }

    //                 // Path untuk penyimpanan
    //                 $filePath = 'activity';  // menggunakan 'activity' seperti contoh lain
    //                 $fullPath = $filePath . '/' . $uniqueName;
    //                 $savePath = public_path($fullPath);

    //                 // Simpan file
    //                 $file->move(public_path($filePath), $uniqueName);

    //                 // Perbarui ukuran file setelah disimpan
    //                 $size = filesize($savePath);

    //                 // -----------------------
    //                 // Insert ke SOFTCOPY
    //                 // -----------------------
    //                 DB::connection('oracle')->table('PROMAN.SOFTCOPY')->insert([
    //                     'ID' => $softId,
    //                     'CLIENT_NAME' => $cleanClientName,
    //                     'FILE_NAME' => $uniqueName,
    //                     'FILE_PATH' => $filePath,
    //                     'FULL_PATH' => $fullPath,
    //                     'FILE_SIZE' => $size,
    //                     'FILE_EXT' => $ext,
    //                     'FILE_TYPE' => $type,
    //                     'STATUS1' => 1,
    //                     'SYSDATE1' => DB::raw('SYSDATE')
    //                 ]);

    //                 // Simpan ID softcopy
    //                 $softcopyIds[] = $softId;
    //             }
    //         }

    //         // -----------------------
    //         // 2. Insert ke TRIAL_RR
    //         // -----------------------
    //         $trialData = [
    //             'PROJECT_ID' => $req->project_id,
    //             'PROCESS_ID' => $req->process_id,
    //             'TRIAL_NO' => $req->trial_no,
    //             'TRIAL_STAT' => $req->trial_stat,
    //             'TRIAL_MACHINE' => $req->trial_machine,
    //             'TRIAL_DATE' => $req->trial_date,
    //             'ACTUAL' => $req->actual,
    //             'OK' => $req->ok,
    //             'PERCT' => $req->perct,
    //             'TARGET' => $req->target,
    //             'CT' => $req->ct,
    //             'CT_TARGET' => $req->ct_target,
    //             'BERAT' => $req->berat,
    //             'BERAT_TARGET' => $req->berat_target,
    //             'PIC' => $req->pic,  // tambahkan PIC
    //             'SYSDATE1' => DB::raw('SYSDATE')
    //         ];

    //         // Tambahkan SOFTCOPY_ID jika ada file
    //         if (!empty($softcopyIds)) {
    //             $trialData['SOFTCOPY_ID'] = json_encode($softcopyIds);
    //         }

    //         DB::connection('oracle')->table('PROMAN.TRIAL_RR')->insert($trialData);

    //         // Commit transaction
    //         DB::connection('oracle')->commit();

    //         return [
    //             'success' => true,
    //             'message' => 'Trial berhasil disimpan',
    //             'files' => $softcopyIds
    //         ];

    //     } catch (\Exception $e) {
    //         // Rollback jika error
    //         DB::connection('oracle')->rollBack();

    //         return [
    //             'success' => false,
    //             'message' => $e->getMessage()
    //         ];
    //     }
    // }

    public static function insert_trial($req)
    {
        try {
            DB::connection('oracle')->beginTransaction();

            /*
            |--------------------------------------------------------------------------
            | 1. UPLOAD FILE (SOFTCOPY)
            |--------------------------------------------------------------------------
            */
            $softcopyIds = [];

            if ($req->hasFile('picture')) {
                foreach ($req->file('picture') as $file) {

                    $softId = self::generate_id('softcopy');

                    $originalName = $file->getClientOriginalName();
                    $cleanClientName = preg_replace('/\s+/', '_', $originalName);

                    $rand = substr(md5(uniqid()), 0, 10);
                    $uniqueName = $rand . '_' . $cleanClientName;

                    $ext = strtolower($file->getClientOriginalExtension());

                    if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
                        $type = 'image';
                    } elseif ($ext === 'pdf') {
                        $type = 'pdf';
                    } elseif (in_array($ext, ['doc', 'docx'])) {
                        $type = 'document';
                    } elseif (in_array($ext, ['xls', 'xlsx'])) {
                        $type = 'spreadsheet';
                    } else {
                        $type = 'other';
                    }

                    $filePath = 'activity';
                    $fullPath = $filePath . '/' . $uniqueName;

                    $file->move(public_path($filePath), $uniqueName);
                    $size = filesize(public_path($fullPath));

                    DB::connection('oracle')->table('PROMAN.SOFTCOPY')->insert([
                        'ID' => $softId,
                        'CLIENT_NAME' => $cleanClientName,
                        'FILE_NAME' => $uniqueName,
                        'FILE_PATH' => $filePath,
                        'FULL_PATH' => $fullPath,
                        'FILE_SIZE' => $size,
                        'FILE_EXT' => $ext,
                        'FILE_TYPE' => $type,
                        'STATUS1' => 1,
                        'SYSDATE1' => DB::raw('SYSDATE')
                    ]);

                    $softcopyIds[] = $softId;
                }
            }

            /*
            |--------------------------------------------------------------------------
            | 2. INSERT TRIAL_RR
            |--------------------------------------------------------------------------
            */
            DB::connection('oracle')->table('PROMAN.TRIAL_RR')->insert([
                'PROJECT_ID' => $req->project_id,
                'PROCESS_ID' => $req->process_id,
                'STDPROC_ID' => $req->stdproc_id,
                'TRIAL_NO' => $req->trial_no,
                'TRIAL_STAT' => $req->trial_stat,
                'TRIAL_MACHINE' => $req->trial_machine,
                'TRIAL_DATE' => $req->trial_date,
                'ACTUAL' => $req->actual,
                'OK' => $req->ok,
                'PERCT' => $req->perct,
                'TARGET' => $req->target,
                'CT' => $req->ct,
                'CT_TARGET' => $req->ct_target,
                'BERAT' => $req->berat,
                'BERAT_TARGET' => $req->berat_target,
                'PIC' => $req->pic,
                'SOFTCOPY_ID' => !empty($softcopyIds) ? json_encode($softcopyIds) : null,
                'SYSDATE1' => DB::raw('SYSDATE')
            ]);

            /*
            |--------------------------------------------------------------------------
            | 3. AMBIL TRIAL_RR YANG BARU (UNTUK ID)
            |--------------------------------------------------------------------------
            */
            $trial = DB::connection('oracle')
                ->table('PROMAN.TRIAL_RR')
                ->where('PROJECT_ID', $req->project_id)
                ->where('PROCESS_ID', $req->process_id)
                ->where('TRIAL_NO', $req->trial_no)
                ->orderByDesc('ID')
                ->first();

            if (!$trial) {
                throw new \Exception('TRIAL_RR tidak ditemukan');
            }

            /*
            |--------------------------------------------------------------------------
            | 4. INSERT TRIAL_RR_DET (INI FIX UTAMA)
            |--------------------------------------------------------------------------
            */
            DB::connection('oracle')->insert("
                INSERT INTO PROMAN.TRIAL_RR_DET
                (
                    PROJECT_ID,
                    PROCESS_ID,
                    STDPROC_ID,
                    PIC,
                    TRIAL_NO,
                    DEFECT_ID,
                    TRANS_TYPE,
                    \"ORDER\",
                    OK,
                    ACTUAL,
                    STATUS1,
                    SYSDATE1
                )
                SELECT
                    :project_id,
                    :process_id,
                    :stdproc_id,
                    :pic,
                    :trial_rr_id,
                    d.ID,
                    d.DEF_MAKING,
                    d.\"ORDER\",
                    :ok,
                    :actual,
                    1,
                    SYSDATE
                FROM PROMAN.DEFECT d
                WHERE d.DEF_TYPE = :process_id
                AND NVL(d.ISACTIVE,1) = 1
            ", [
                'project_id' => $trial->project_id,
                'process_id' => $trial->process_id,
                'stdproc_id' => $trial->stdproc_id,
                'pic' => $trial->pic,
                'trial_rr_id' => $trial->id,
                'ok' => $trial->ok,
                'actual' => $trial->actual,
            ]);



            DB::connection('oracle')->commit();

            return [
                'success' => true,
                'message' => 'Trial RR & Trial RR Detail berhasil disimpan',
                'files' => $softcopyIds
            ];

        } catch (\Exception $e) {
            DB::connection('oracle')->rollBack();
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public static function update_trial_detail($req)
{
    try {
        DB::connection('oracle')->table('PROMAN.TRIAL_RR_DET')
            ->where('PROJECT_ID', $req->project_id)
            ->where('PROCESS_ID', $req->process_id)
            ->where('TRIAL_NO', $req->trial_id)
            ->where('DEFECT_ID', $req->defect_id)
            ->update([
                'NG' => $req->ng,
                'PERCT' => $req->perct
            ]);
        
        return true;
    } catch (\Exception $e) {
        throw $e;
    }
}


    // public static function insert_task($req)
    // {
    //     try {
    //         DB::connection('oracle')->beginTransaction();

    //         $projectId = $req->input('project_id');
    //         $taskId = $req->input('task_id');

    //         // --- Ambil data lama untuk auto hitung ---
    //         $old = DB::connection('oracle')
    //             ->table('PROMAN.PROJECT_TASK')
    //             ->where('PROJECT_ID', $projectId)
    //             ->where('TASK_ID', $taskId)
    //             ->first();

    //         // === Ambil nilai lama atau baru dari request ===
    //         $planStart = $req->plan_start ?: ($old->plan_start ? date('Y-m-d', strtotime($old->plan_start)) : null);
    //         $planDuration = $req->plan_duration ?: $old->plan_duration;
    //         $actualStart = $req->actual_start ?: ($old->actual_start ? date('Y-m-d', strtotime($old->actual_start)) : null);
    //         $actualDuration = $req->actual_duration ?: $old->actual_duration;

    //         // === Hitung tanggal akhir (skip weekend saja) ===
    //         $planEnd = ($planStart && $planDuration) ? self::add_working_days($planStart, $planDuration) : null;
    //         $actualEnd = ($actualStart && $actualDuration) ? self::add_working_days($actualStart, $actualDuration) : null;

    //         // === Hitung HEAT_TASK otomatis ===
    //         $planHour = $req->plan_hour ?: $old->plan_hour;
    //         $actualDurationForHeat = $req->actual_duration ?: $old->actual_duration;

    //         $heatTask = null;
    //         if ($planHour && $actualDurationForHeat && $actualDurationForHeat > 0) {
    //             $heatTask = round($planHour / $actualDurationForHeat, 1);
    //         }

    //         $data = [
    //             'PLAN_START' => $req->plan_start ? DB::raw("TO_DATE('{$req->plan_start}', 'YYYY-MM-DD')") : null,
    //             'PLAN_DURATION' => $req->plan_duration,
    //             'PLAN_END' => $planEnd ? DB::raw("TO_DATE('{$planEnd}', 'YYYY-MM-DD')") : null,
    //             'ACTUAL_START' => $req->actual_start ? DB::raw("TO_DATE('{$req->actual_start}', 'YYYY-MM-DD')") : null,
    //             'ACTUAL_DURATION' => $req->actual_duration,
    //             'ACTUAL_END' => $actualEnd ? DB::raw("TO_DATE('{$actualEnd}', 'YYYY-MM-DD')") : null,
    //             'PLAN_HOUR' => $req->plan_hour,
    //             'ACTUAL_HOUR' => $req->actual_hour,
    //             'RESPONSIBLE' => $req->responsible,
    //             'STATUS' => $req->status,
    //             'COMPLEXITY' => $req->complexity,
    //             'PRIORITY' => $req->priority,
    //             'IS_MILESTONE' => $req->is_milestone,
    //             'ACTUAL_PROGRESS' => $req->actual_progress,
    //             'REMARK' => $req->remark,
    //             'HEAT_TASK' => $heatTask,
    //             'UPDATETIME' => DB::raw('SYSDATE')
    //         ];

    //         $data = array_filter($data, fn($v) => !is_null($v) && $v !== '');

    //         if (empty($data)) {
    //             throw new \Exception('No data to update');
    //         }

    //         $updated = DB::connection('oracle')
    //             ->table('PROMAN.PROJECT_TASK')
    //             ->where('PROJECT_ID', $projectId)
    //             ->where('TASK_ID', $taskId)
    //             ->update($data);

    //         if ($updated <= 0) {
    //             throw new \Exception("No rows updated. PROJECT_ID: {$projectId}, TASK_ID: {$taskId}");
    //         }



    //         DB::connection('oracle')->commit();

    //         return [
    //             'success' => true,
    //             'message' => 'Task updated successfully',
    //             'heat_task' => $heatTask,
    //             'plan_end' => $planEnd,
    //             'actual_end' => $actualEnd
    //         ];

    //     } catch (\Exception $e) {
    //         DB::connection('oracle')->rollBack();
    //         return [
    //             'success' => false,
    //             'message' => $e->getMessage()
    //         ];
    //     }
    // }

    public static function insert_task($req)
    {
        try {
            DB::connection('oracle')->beginTransaction();

            $projectId = $req->input('project_id');
            $taskId = $req->input('task_id');

            // ===========================
            // GET CURRENT TASK
            // ===========================
            $old = DB::connection('oracle')
                ->table('PROMAN.PROJECT_TASK')
                ->where('PROJECT_ID', $projectId)
                ->where('TASK_ID', $taskId)
                ->first();

            if (!$old) {
                throw new \Exception('Task not found');
            }

            // ===========================
            // DATE & DURATION LOGIC
            // ===========================
            $planStart = $req->plan_start ?: ($old->plan_start ? date('Y-m-d', strtotime($old->plan_start)) : null);
            $planDuration = $req->plan_duration ?: $old->plan_duration;
            $actualStart = $req->actual_start ?: ($old->actual_start ? date('Y-m-d', strtotime($old->actual_start)) : null);
            $actualEnd = $req->actual_end ?: ($old->actual_end ? date('Y-m-d', strtotime($old->actual_end)) : null);

            // === PLAN END ===
            $planEnd = ($planStart && $planDuration)
                ? self::add_working_days($planStart, $planDuration)
                : null;

            // === ACTUAL DURATION ===
            $actualDuration = null;
            if ($actualStart && $actualEnd) {
                $actualDuration = self::calculate_working_days_between($actualStart, $actualEnd);
            } else {
                $actualDuration = $old->actual_duration;
            }

            // === HEAT TASK ===
            $planHour = $req->plan_hour ?: $old->plan_hour;
            $heatTask = null;
            if ($planHour && $actualDuration && $actualDuration > 0) {
                $heatTask = round($planHour / $actualDuration, 1);
            }

            // ===========================
            // 🔥 AUTO PARENT_TASK LOGIC
            // ===========================
            $isMilestone = $req->is_milestone ?? $old->is_milestone;
            $parentTask = $old->parent_task;

            // milestone hierarchy
            $milestoneParentMap = [
                20 => null, // ROOT
                21 => 20,   // child of 20
                70 => 21,   // child of 21
            ];

            if ($isMilestone !== null && array_key_exists($isMilestone, $milestoneParentMap)) {

                $parentMilestone = $milestoneParentMap[$isMilestone];

                // === ROOT MILESTONE ===
                if ($parentMilestone === null) {
                    $parentTask = null;
                }
                // === SEARCH NEAREST PARENT ABOVE ===
                else {
                    $parent = DB::connection('oracle')
                        ->table('PROMAN.PROJECT_TASK')
                        ->where('PROJECT_ID', $projectId)
                        ->where('IS_MILESTONE', $parentMilestone)
                        ->where('ORDER1', '<', $old->order1)
                        ->orderBy('ORDER1', 'DESC')

                        ->first();

                    $parentTask = $parent ? $parent->task_id : null;
                }
            }

            // ===========================
            // UPDATE DATA
            // ===========================
            $data = [
                'PLAN_START' => $req->plan_start ? DB::raw("TO_DATE('{$req->plan_start}', 'YYYY-MM-DD')") : null,
                'PLAN_DURATION' => $req->plan_duration,
                'PLAN_END' => $planEnd ? DB::raw("TO_DATE('{$planEnd}', 'YYYY-MM-DD')") : null,
                'ACTUAL_START' => $req->actual_start ? DB::raw("TO_DATE('{$req->actual_start}', 'YYYY-MM-DD')") : null,
                'ACTUAL_END' => $req->actual_end ? DB::raw("TO_DATE('{$req->actual_end}', 'YYYY-MM-DD')") : null,
                'ACTUAL_DURATION' => $actualDuration,
                'PLAN_HOUR' => $req->plan_hour,
                'ACTUAL_HOUR' => $req->actual_hour,
                'RESPONSIBLE' => $req->responsible,
                'STATUS' => $req->status,
                'COMPLEXITY' => $req->complexity,
                'PRIORITY' => $req->priority,
                'IS_MILESTONE' => $isMilestone,
                'PARENT_TASK' => $parentTask,
                'ACTUAL_PROGRESS' => $req->actual_progress,
                'REMARK' => $req->remark,
                'HEAT_TASK' => $heatTask,
                'UPDATETIME' => DB::raw('SYSDATE')
            ];

            // remove null / empty
            $data = array_filter($data, fn($v) => !is_null($v) && $v !== '');

            if (empty($data)) {
                throw new \Exception('No data to update');
            }

            // ===========================
            // UPDATE TASK
            // ===========================
            $updated = DB::connection('oracle')
                ->table('PROMAN.PROJECT_TASK')
                ->where('PROJECT_ID', $projectId)
                ->where('TASK_ID', $taskId)
                ->update($data);

            if ($updated <= 0) {
                throw new \Exception("No rows updated. PROJECT_ID: {$projectId}, TASK_ID: {$taskId}");
            }

            // ===========================
            // AUTO UPDATE PROJECT STATUS
            // ===========================
            $notCompleted = DB::connection('oracle')
                ->table('PROMAN.PROJECT_TASK')
                ->where('PROJECT_ID', $projectId)
                ->where(function ($q) {
                    $q->where('STATUS', '!=', 3)
                        ->orWhereNull('STATUS');
                })
                ->count();

            if ($notCompleted == 0) {
                DB::connection('oracle')
                    ->table('PROMAN.PROJECT')
                    ->where('ID', $projectId)
                    ->update(['STATUS' => 3]);
            } else {
                DB::connection('oracle')
                    ->table('PROMAN.PROJECT')
                    ->where('ID', $projectId)
                    ->update(['STATUS' => 2]);
            }

            DB::connection('oracle')->commit();

            return [
                'success' => true,
                'message' => 'Task updated successfully',
                'heat_task' => $heatTask,
                'plan_end' => $planEnd,
                'actual_end' => $actualEnd,
                'actual_duration' => $actualDuration,
                'parent_task' => $parentTask
            ];

        } catch (\Exception $e) {
            DB::connection('oracle')->rollBack();
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }



    // Fungsi baru untuk menghitung hari kerja antara dua tanggal
    private static function calculate_working_days_between($startDate, $endDate)
    {
        $start = new \DateTime($startDate);
        $end = new \DateTime($endDate);

        if ($end < $start) {
            return 0;
        }

        $holidays = Maio::get_holiday();
        $count = 0;
        $current = clone $start;

        while ($current <= $end) {
            $dayOfWeek = (int) $current->format('N');
            $dateString = $current->format('Y-m-d');

            $isWeekend = ($dayOfWeek >= 6);
            $isHoliday = in_array($dateString, $holidays);

            if (!$isWeekend && !$isHoliday) {
                $count++;
            }

            $current->modify('+1 day');
        }

        return $count;
    }




    private static function add_working_days($startDate, $days)
    {
        $date = new \DateTime($startDate);
        $count = 0;

        // $holidays = \App\Models\Maio::getHoliday();
        $holidays = Maio::get_holiday();


        while ($count < $days) {
            $dayOfWeek = (int) $date->format('N');
            $dateString = $date->format('Y-m-d');

            $isWeekend = ($dayOfWeek >= 6);
            $isHoliday = in_array($dateString, $holidays);

            if (!$isWeekend && !$isHoliday) {
                $count++;
                if ($count >= $days) {
                    break;
                }
            }

            $date->modify('+1 day');
        }

        return $date->format('Y-m-d');
    }

    public static function delete_task($id)
    {
        try {
            DB::connection('oracle')->beginTransaction();

            // 1. Ambil PROJECT_ID dari task yang dihapus
            $task = DB::connection('oracle')
                ->table('PROMAN.PROJECT_TASK')
                ->where('ID', $id)
                ->first();

            if (!$task) {
                throw new \Exception("Task with ID {$id} not found");
            }

            $projectId = $task->project_id;

            // 2. Hapus task
            $deleted = DB::connection('oracle')
                ->table('PROMAN.PROJECT_TASK')
                ->where('ID', $id)
                ->delete();

            // 3. Cek apakah masih ada task dengan status != 3
            $hasNotCompleted = DB::connection('oracle')
                ->table('PROMAN.PROJECT_TASK')
                ->where('PROJECT_ID', $projectId)
                ->where('STATUS', '!=', 3)
                ->count();

            // 4. Kalau TIDAK ada (semua 3), update project ke 3
            if ($hasNotCompleted == 0) {
                DB::connection('oracle')
                    ->table('PROMAN.PROJECT')
                    ->where('ID', $projectId)
                    ->update([
                        'STATUS' => 3
                    ]);
            }

            DB::connection('oracle')->commit();
            return $deleted;

        } catch (\Exception $e) {
            DB::connection('oracle')->rollBack();
            throw $e;
        }
    }


    public static function insert_milestone_task($req)
    {
        try {
            DB::connection('oracle')->beginTransaction();

            $projectId = $req->input('project_id');
            $milestoneTask = $req->input('milestone_task');
            $category = (int) $req->input('category'); // IS_MILESTONE
            $insertAfter = (int) $req->input('insert_after');

            /**
             * ===========================
             * 1. SHIFT ORDER1
             * ===========================
             */
            DB::connection('oracle')
                ->table('PROMAN.PROJECT_TASK')
                ->where('PROJECT_ID', $projectId)
                ->where('ORDER1', '>', $insertAfter)
                ->update([
                    'ORDER1' => DB::raw('ORDER1 + 1')
                ]);

            /**
             * ===========================
             * 2. NEW ORDER
             * ===========================
             */
            $newOrder = $insertAfter + 1;

            /**
             * ===========================
             * 3. GENERATE TASK_ID (PTxxx)
             * ===========================
             */
            $maxTask = DB::connection('oracle')
                ->table('PROMAN.TASK_SETUP_ADD')
                ->select(DB::raw("MAX(TO_NUMBER(REGEXP_SUBSTR(TASK_ID, '[0-9]+'))) AS MAX_ID"))
                ->value('MAX_ID');

            $taskId = 'PT' . (($maxTask ?? 0) + 1);

            /**
             * ===========================
             * 4. AUTO PARENT_TASK LOGIC
             * ===========================
             */
            $parentTask = null;

            // milestone hierarchy
            $milestoneParentMap = [
                20 => null, // ROOT
                21 => 20,   // child of 20
                70 => 21,   // child of 21
            ];

            if (array_key_exists($category, $milestoneParentMap)) {

                $parentMilestone = $milestoneParentMap[$category];

                // === ROOT ===
                if ($parentMilestone === null) {
                    $parentTask = null;
                }
                // === CHILD ===
                else {
                    $parent = DB::connection('oracle')
                        ->table('PROMAN.PROJECT_TASK')
                        ->where('PROJECT_ID', $projectId)
                        ->where('IS_MILESTONE', $parentMilestone)
                        ->where('ORDER1', '<=', $insertAfter)
                        ->orderBy('ORDER1', 'DESC')
                        ->first();

                    $parentTask = $parent ? $parent->task_id : null;
                }
            }

            /**
             * ===========================
             * 5. INSERT TASK_SETUP_ADD
             * ===========================
             */
            DB::connection('oracle')
                ->table('PROMAN.TASK_SETUP_ADD')
                ->insert([
                    'TASK_ID' => $taskId,
                    'PROJECT' => $projectId,
                    'MILESTONE_TASK' => $milestoneTask,
                    'IS_MILESTONE' => $category,
                    'PARENT_TASK' => $parentTask,
                    'ORDER1' => $newOrder,
                    'SYSDATE1' => DB::raw('SYSDATE')
                ]);

            /**
             * ===========================
             * 6. INSERT PROJECT_TASK
             * ===========================
             */
            DB::connection('oracle')
                ->table('PROMAN.PROJECT_TASK')
                ->insert([
                    'PROJECT_ID' => $projectId,
                    'TASK_ID' => $taskId,
                    'MILESTONE_TASK' => $milestoneTask,
                    'IS_MILESTONE' => $category,
                    'PARENT_TASK' => $parentTask,
                    'ORDER1' => $newOrder,
                    'SYSDATE1' => DB::raw('SYSDATE')
                ]);

            /**
             * ===========================
             * 7. REOPEN PROJECT IF NEEDED
             * ===========================
             */
            $allCompleted = DB::connection('oracle')
                ->table('PROMAN.PROJECT_TASK')
                ->where('PROJECT_ID', $projectId)
                ->where('TASK_ID', '!=', $taskId)
                ->where('STATUS', '!=', 3)
                ->count() == 0;

            if ($allCompleted) {
                DB::connection('oracle')
                    ->table('PROMAN.PROJECT')
                    ->where('ID', $projectId)
                    ->update(['STATUS' => 2]);
            }

            DB::connection('oracle')->commit();

            return [
                'success' => true,
                'message' => "Milestone task added successfully",
                'task_id' => $taskId,
                'parent_task' => $parentTask,
                'order' => $newOrder
            ];

        } catch (\Exception $e) {

            DB::connection('oracle')->rollBack();

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }



    //     public static function insert_milestone_task($req)
// {
//     try {
//         DB::connection('oracle')->beginTransaction();

    //         $projectId     = $req->input('project_id');
//         $milestoneTask = $req->input('milestone_task');
//         $category      = (int) $req->input('category'); // IS_MILESTONE
//         $insertAfter   = (int) $req->input('insert_after');

    //         // ===========================
//         // 1. SHIFT ORDER
//         // ===========================
//         DB::connection('oracle')
//             ->table('PROMAN.PROJECT_TASK')
//             ->where('PROJECT_ID', $projectId)
//             ->where('ORDER1', '>', $insertAfter)
//             ->update([
//                 'ORDER1' => DB::raw('ORDER1 + 1')
//             ]);

    //         // ===========================
//         // 2. NEW ORDER
//         // ===========================
//         $newOrder = $insertAfter + 1;

    //         // ===========================
//         // 3. GENERATE TASK_ID (PTxxx)
//         // ===========================
//         $maxTask = DB::connection('oracle')
//             ->table('PROMAN.TASK_SETUP_ADD')
//             ->select(DB::raw("MAX(TO_NUMBER(REGEXP_SUBSTR(TASK_ID, '[0-9]+'))) AS MAX_ID"))
//             ->value('MAX_ID');

    //         $taskId = 'PT' . (($maxTask ?? 0) + 1);

    //         // ===========================
//         // 4. AUTO PARENT_TASK (INTI LOGIKA)
//         // ===========================
//         $parentTask = null;

    //         if ($category === 21) {
//             // cari milestone 20 terdekat
//             $parent = DB::connection('oracle')
//                 ->table('PROMAN.PROJECT_TASK')
//                 ->where('PROJECT_ID', $projectId)
//                 ->where('IS_MILESTONE', 20)
//                 ->where('ORDER1', '<', $newOrder)
//                 ->orderBy('ORDER1', 'DESC')
//                 ->first();

    //             $parentTask = $parent ? $parent->task_id : null;

    //         } elseif ($category === 70) {
//             // cari milestone 21 terdekat
//             $parent = DB::connection('oracle')
//                 ->table('PROMAN.PROJECT_TASK')
//                 ->where('PROJECT_ID', $projectId)
//                 ->where('IS_MILESTONE', 21)
//                 ->where('ORDER1', '<', $newOrder)
//                 ->orderBy('ORDER1', 'DESC')
//                 ->first();

    //             $parentTask = $parent ? $parent->task_id : null;
//         }
//         // category 20 → parent tetap NULL

    //         // ===========================
//         // 5. INSERT PROJECT_TASK
//         // ===========================
//         DB::connection('oracle')
//             ->table('PROMAN.PROJECT_TASK')
//             ->insert([
//                 'PROJECT_ID'     => $projectId,
//                 'TASK_ID'        => $taskId,
//                 'PARENT_TASK'    => $parentTask,
//                 'MILESTONE_TASK' => $milestoneTask,
//                 'IS_MILESTONE'   => $category,
//                 'ORDER1'         => $newOrder,
//                 'SYSDATE1'       => DB::raw('SYSDATE')
//             ]);

    //         // ===========================
//         // 6. INSERT TASK_SETUP_ADD
//         // ===========================
//         DB::connection('oracle')
//             ->table('PROMAN.TASK_SETUP_ADD')
//             ->insert([
//                 'TASK_ID'        => $taskId,
//                 'PROJECT'        => $projectId,
//                 'MILESTONE_TASK' => $milestoneTask,
//                 'IS_MILESTONE'   => $category,
//                 'ORDER1'         => $newOrder,
//                 'SYSDATE1'       => DB::raw('SYSDATE')
//             ]);

    //         // ===========================
//         // 7. PROJECT STATUS CHECK
//         // ===========================
//         $allCompleted = DB::connection('oracle')
//             ->table('PROMAN.PROJECT_TASK')
//             ->where('PROJECT_ID', $projectId)
//             ->where('TASK_ID', '!=', $taskId)
//             ->where('STATUS', '!=', 3)
//             ->count() == 0;

    //         if ($allCompleted) {
//             DB::connection('oracle')
//                 ->table('PROMAN.PROJECT')
//                 ->where('ID', $projectId)
//                 ->update(['STATUS' => 2]);
//         }

    //         DB::connection('oracle')->commit();

    //         return [
//             'success' => true,
//             'message' => "Milestone task added successfully",
//             'task_id' => $taskId,
//             'parent_task' => $parentTask
//         ];

    //     } catch (\Exception $e) {
//         DB::connection('oracle')->rollBack();
//         return [
//             'success' => false,
//             'message' => $e->getMessage()
//         ];
//     }
// }

    public static function insert_activity_log($req)
    {
        try {
            $activityName = $req->activity ?? '-';
            $softcopyIds = [];  // simpan ID softcopy

            if ($req->hasFile('picture')) {

                foreach ($req->file('picture') as $file) {

                    // -----------------------
                    // 1) Generate ID
                    // -----------------------
                    $softId = self::generate_id('softcopy');

                    // -----------------------
                    // 2) Nama asli user → client_name
                    // -----------------------
                    $originalName = $file->getClientOriginalName();  // contoh: "Foto Mesin Produksi.jpg"
                    $cleanClientName = preg_replace('/\s+/', '_', $originalName);
                    // hasil: "Foto_Mesin_Produksi.jpg"

                    // -----------------------
                    // 3) Rename jadi nama unik untuk FILE_NAME
                    // -----------------------
                    $rand = substr(md5(uniqid()), 0, 10);
                    $uniqueName = $rand . $cleanClientName;

                    // -----------------------
                    // 4) Size
                    // -----------------------
                    $size = $file->getSize();

                    // -----------------------
                    // 5) EXT & FILE TYPE
                    // -----------------------
                    $ext = strtolower($file->getClientOriginalExtension());

                    if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
                        $type = 'image';
                    } elseif ($ext === 'pdf') {
                        $type = 'pdf';
                    } elseif (in_array($ext, ['doc', 'docx'])) {
                        $type = 'document';
                    } elseif (in_array($ext, ['xls', 'xlsx'])) {
                        $type = 'spreadsheet';
                    } else {
                        $type = 'other';
                    }

                    // -----------------------
                    // 6) Compress jika IMAGE
                    // -----------------------

                    $savePath = public_path('activity/' . $uniqueName);

                    // Kondisi: ukuran file < 200 KB → JANGAN COMPRESS
                    $skipCompress = $file->getSize() < (200 * 1024);

                    if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {

                        $type = 'image';

                        // ------------------------
                        // GIF → tidak bisa compress
                        // ------------------------
                        if ($ext === 'gif') {
                            $file->move(public_path('activity'), $uniqueName);
                            $savePath = public_path('activity/' . $uniqueName);
                            $size = filesize($savePath);   // ✅ benar

                        }

                        // ------------------------
                        // PNG / JPG kecil → tidak compress
                        // ------------------------
                        elseif ($skipCompress) {
                            $file->move(public_path('activity'), $uniqueName);
                            $savePath = public_path('activity/' . $uniqueName);
                            $size = filesize($savePath);   // ✅ benar

                        }

                        // ------------------------
                        // COMPRESS JPG / PNG besar
                        // ------------------------
                        else {

                            // Tentukan encoder
                            if (in_array($ext, ['jpg', 'jpeg'])) {
                                $encoder = new JpegEncoder(70); // kualitas 70%
                            } else {
                                // PNG → compression level (0-9)
                                $encoder = new PngEncoder(8);
                            }

                            // Resize + encode
                            Image::read($file->getRealPath())
                                ->scaleDown(1600)          // resize otomatis
                                ->encode($encoder)         // compress
                                ->save($savePath);

                            $size = filesize($savePath);
                        }

                    } else {

                        // Bukan image → langsung move
                        $file->move(public_path('activity'), $uniqueName);
                        $type = $type ?? 'other';
                        $size = $file->getSize();
                    }

                    $fileRelPath = 'activity/' . $uniqueName;



                    // -----------------------
                    // 7) Insert ke SOFTCOPY
                    // -----------------------
                    DB::connection('oracle')->table('PROMAN.SOFTCOPY')->insert([
                        'ID' => $softId,
                        'CLIENT_NAME' => $cleanClientName,  // NAMA ASLI FILE USER
                        'FILE_NAME' => $uniqueName,       // NAMA FILE YANG DISIMPAN
                        'FILE_PATH' => 'activity',
                        'FULL_PATH' => $fileRelPath,
                        'FILE_SIZE' => $size,
                        'FILE_EXT' => $ext,
                        'FILE_TYPE' => $type,
                        'STATUS1' => 1,
                        'SYSDATE1' => DB::raw('SYSDATE')
                    ]);

                    // -----------------------
                    // 8) Simpan ID Softcopy
                    // -----------------------
                    $softcopyIds[] = $softId;
                }
            }

            // -----------------------
            // 9) Insert ke ACTIVITY_LOG
            // -----------------------
            DB::connection('oracle')
                ->table('PROMAN.ACTIVITY_LOG')
                ->insert([
                    'PROJECT_ID' => $req->project_id,
                    'TASK_ID' => $req->task_id,
                    'ACTIVITY' => $activityName,
                    'TASK_DET' => $req->task_det,
                    'PICTURE' => json_encode($softcopyIds), // simpan ID softcopy
                    'INPUTBY' => $req->inputby,
                    'STATUS1' => 1,
                    'SYSDATE1' => DB::raw('SYSDATE')
                ]);

            return [
                'success' => true,
                'message' => 'Activity and files have been successfully uploaded.',
                'files' => $softcopyIds
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }


    public static function generate_id($table)
    {
        $col = 'ID';

        $last = DB::connection('oracle')->table("PROMAN." . strtoupper($table))
            ->select(DB::raw("MAX($col) as maxid"))
            ->first();

        $lastId = ($last && $last->maxid) ? intval($last->maxid) : 10000000000001;

        return $lastId + 1;
    }

}

