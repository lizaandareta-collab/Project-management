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
                'SYSDATE1' => now()
            ];

            DB::connection('mysql')->table('RESOURCE_MGMT')->insert($data);

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
                'SYSDATE1' => now()
            ];

            DB::connection('mysql')->table('RESOURCE_MGMT')
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
            DB::connection('mysql')->table('RESOURCE_MGMT')
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
            DB::connection('mysql')->beginTransaction();

            $data = [
                'DESCRIPTION' => $req->description,
                'DATE' => $req->date,
                'STATUS1' => 1,
                'SYSDATE1' => now()
            ];

            DB::connection('mysql')->table('HOLIDAY')->insert($data);

            DB::connection('mysql')->commit();
            return ['success' => true, 'message' => 'Holiday inserted successfully'];
        } catch (\Exception $e) {
            DB::connection('mysql')->rollBack();
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public static function update_inholiday($req)
    {
        try {
            DB::connection('mysql')->beginTransaction();

            DB::connection('mysql')
                ->table('HOLIDAY')
                ->where('ID', $req->id)
                ->update([
                    'DESCRIPTION' => $req->description,
                    'DATE' => $req->date,
                    'STATUS1' => 1,
                    'SYSDATE1' => now()
                ]);

            DB::connection('mysql')->commit();
            return ['success' => true, 'message' => 'Holiday updated successfully'];
        } catch (\Exception $e) {
            DB::connection('mysql')->rollBack();
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public static function delete_inholiday($id)
    {
        try {
            DB::connection('mysql')->beginTransaction();

            DB::connection('mysql')
                ->table('HOLIDAY')
                ->where('ID', $id)
                ->delete();

            DB::connection('mysql')->commit();

            return ['success' => true, 'message' => 'Holiday deleted successfully'];
        } catch (\Exception $e) {
            DB::connection('mysql')->rollBack();
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public static function insert_inclient($req)
    {
        try {
            DB::connection('mysql')->beginTransaction();

            $data = [
                'CLIENT_ORA' => $req->client_ora,
                'NAME' => $req->name,
                'COMPANY' => $req->company,
                'ADDRESS' => $req->address ?? null,
                'COUNTRY' => $req->country,
                'STATUS1' => 1,
                'SYSDATE1' => now()
            ];

            DB::connection('mysql')->table('CLIENT')->insert($data);

            DB::connection('mysql')->commit();
            return ['success' => true, 'message' => 'Client inserted successfully'];
        } catch (\Exception $e) {
            DB::connection('mysql')->rollBack();
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public static function update_inclient($req)
    {
        try {
            DB::connection('mysql')->beginTransaction();

            $data = [
                'CLIENT_ORA' => $req->client_ora,
                'NAME' => $req->name,
                'COMPANY' => $req->company,
                'ADDRESS' => $req->address ?? null,
                'COUNTRY' => $req->country,
                'STATUS1' => 1,
                'SYSDATE1' => now()
            ];

            DB::connection('mysql')
                ->table('CLIENT')
                ->where('ID', $req->id)
                ->update($data);

            DB::connection('mysql')->commit();
            return ['success' => true, 'message' => 'Client updated successfully'];
        } catch (\Exception $e) {
            DB::connection('mysql')->rollBack();
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
    public static function delete_inclient($id)
    {
        try {
            DB::connection('mysql')->beginTransaction();

            DB::connection('mysql')
                ->table('CLIENT')
                ->where('ID', $id)
                ->delete();

            DB::connection('mysql')->commit();

            return ['success' => true, 'message' => 'Client deleted successfully'];
        } catch (\Exception $e) {
            DB::connection('mysql')->rollBack();
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public static function add_invoice($projectId, $amount, $remarks = null)
    {
        try {
            $db = DB::connection('mysql');
            $db->beginTransaction();

            $project = $db->table('PROJECT')
                ->select('CLIENT')
                ->where('ID', $projectId)
                ->first();

            $clientId = $project ? $project->CLIENT : null;

            $db->table('INVOICE_MGMT')
                ->insert([
                    'PROJECT_ID' => $projectId,
                    'CLIENT_ID' => $clientId,
                    'AMOUNT' => $amount,
                    'REMARKS' => $remarks,
                    'DATE_CREATED' => now()
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
            DB::connection('mysql')->beginTransaction();

            $data = [
                'PROJECT_NAME' => $req->project_name,
                'RESPONSIBLE' => $req->responsible,
                'CLIENT' => $req->client,
                'BUDGET' => $req->budget,
                'START_DATE' => $req->start_date,
                'DAYS' => $req->days,
                'END_DATE' => $req->end_date,
                'COMPLEXITY' => $req->complexity ?? null,
                'PRIORITY' => $req->priority,
                'STATUS' => $req->status,
                'SYSDATE1' => now()
            ];

            DB::connection('mysql')->table('PROJECT')->insert($data);

            $project = DB::connection('mysql')
                ->table('PROJECT')
                ->where('PROJECT_NAME', $req->project_name)
                ->orderByDesc('ID')
                ->first();

            if (!$project) {
                throw new \Exception('Project not found after insert');
            }

            $projectId = $project->ID;

            DB::connection('mysql')
                ->table('STANDARD')
                ->whereNull('PROJECT_ID')
                ->update([
                    'PROJECT_ID' => $projectId
                ]);

            $taskSetup = DB::connection('mysql')
                ->table('TASK_SETUP')
                ->select('TASK_ID', 'MILESTONE_TASK', 'IS_MILESTONE', 'PARENT_TASK', 'ORDER1')
                ->get();

            foreach ($taskSetup as $task) {
                DB::connection('mysql')->table('PROJECT_TASK')->insert([
                    'PROJECT_ID' => $projectId,
                    'TASK_ID' => $task->TASK_ID,
                    'MILESTONE_TASK' => $task->MILESTONE_TASK,
                    'IS_MILESTONE' => $task->IS_MILESTONE,
                    'ORDER1' => $task->ORDER1,
                    'PARENT_TASK' => $task->PARENT_TASK,
                    'SYSDATE1' => now()
                ]);
            }

            DB::connection('mysql')->commit();
            return ['success' => true, 'message' => 'Project inserted successfully'];
        } catch (\Exception $e) {
            DB::connection('mysql')->rollBack();
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public static function save_process_temp($req)
    {
        try {
            DB::connection('mysql')->beginTransaction();

            if ($req->checked) {

                if ($req->init === 'process') {
                    DB::connection('mysql')->table('STANDARD')->insert([
                        'PROCESS_ID' => $req->lov_id,
                        'INIT' => 'process',
                        'SYSDATE1' => now()
                    ]);
                }

                if ($req->init === 'stdproc') {
                    DB::connection('mysql')->table('STANDARD')->insert([
                        'PROCESS_ID' => $req->process_id,
                        'STDPROC_ID' => $req->stdproc_id,
                        'VALUE' => $req->value,
                        'INIT' => 'stdproc',
                        'SYSDATE1' => now()
                    ]);
                }
            } else {

                if ($req->init === 'process') {

                    DB::connection('mysql')->table('STANDARD')
                        ->where('PROCESS_ID', $req->lov_id)
                        ->where('INIT', 'stdproc')
                        ->whereNull('PROJECT_ID')
                        ->delete();

                    DB::connection('mysql')->table('STANDARD')
                        ->where('PROCESS_ID', $req->lov_id)
                        ->where('INIT', 'process')
                        ->whereNull('PROJECT_ID')
                        ->delete();
                }

                if ($req->init === 'stdproc') {
                    DB::connection('mysql')->table('STANDARD')
                        ->where('PROCESS_ID', $req->process_id)
                        ->where('STDPROC_ID', $req->stdproc_id)
                        ->where('INIT', 'stdproc')
                        ->whereNull('PROJECT_ID')
                        ->delete();
                }
            }

            DB::connection('mysql')->commit();
            return ['success' => true];
        } catch (\Exception $e) {
            DB::connection('mysql')->rollBack();
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
    public static function insert_trial($req)
    {
        try {
            DB::connection('mysql')->beginTransaction();

            $softcopyIds = [];

            /*
        |------------------------------------------
        | 0. PASTIKAN FOLDER ACTIVITY ADA
        |------------------------------------------
        */
            $activityPath = public_path('activity');
            if (!file_exists($activityPath)) {
                mkdir($activityPath, 0777, true);
            }


            if ($req->hasFile('picture')) {
                $files = $req->file('picture');

                if (!is_array($files)) {
                    $files = [$files];
                }

                foreach ($files as $file) {
                    if (!$file->isValid()) {
                        continue;
                    }

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
                    $destinationPath = public_path($fullPath);

                    $moved = $file->move(public_path($filePath), $uniqueName);

                    if (!$moved) {
                        throw new \Exception("Gagal memindahkan file: " . $originalName);
                    }

                    $size = file_exists($destinationPath) ? filesize($destinationPath) : 0;

                    $softId = DB::connection('mysql')->table('SOFTCOPY')->insertGetId([
                        'CLIENT_NAME' => $cleanClientName,
                        'FILE_NAME' => $uniqueName,
                        'FILE_PATH' => $filePath,
                        'FULL_PATH' => $fullPath,
                        'FILE_SIZE' => $size,
                        'FILE_EXT' => $ext,
                        'FILE_TYPE' => $type,
                        'STATUS1' => 1,
                        'SYSDATE1' => now()
                    ]);

                    $softcopyIds[] = $softId;
                }
            }

            /*
        |------------------------------------------
        | 2. INSERT TRIAL_RR
        |------------------------------------------
        */
            $softcopyIdJson = !empty($softcopyIds) ? json_encode($softcopyIds) : null;

            $trialId = DB::connection('mysql')->table('TRIAL_RR')->insertGetId([
                'PROJECT_ID' => $req->project_id,
                'PROCESS_ID' => $req->process_id,
                'STDPROC_ID' => $req->stdproc_id ?? null,
                'TRIAL_NO' => $req->trial_no,
                'TRIAL_STAT' => $req->trial_stat,
                'TRIAL_MACHINE' => $req->trial_machine,
                'TRIAL_DATE' => $req->trial_date,
                'ACTUAL' => $req->actual ?? 0,
                'OK' => $req->ok ?? 0,
                'PERCT' => $req->perct ?? 0,
                'TARGET' => $req->target ?? null,
                'CT' => $req->ct ?? null,
                'CT_TARGET' => $req->ct_target ?? null,
                'BERAT' => $req->berat ?? null,
                'BERAT_TARGET' => $req->berat_target ?? null,
                'PIC' => $req->pic,
                'SOFTCOPY_ID' => $softcopyIdJson,
                'SYSDATE1' => now()
            ]);

            /*
        |------------------------------------------
        | 3. AMBIL DATA TRIAL (AMAN)
        |------------------------------------------
        */
            $trial = DB::connection('mysql')
                ->table('TRIAL_RR')
                ->where('ID', $trialId)
                ->first();

            if (!$trial) {
                throw new \Exception('TRIAL_RR tidak ditemukan');
            }

            /*
        |------------------------------------------
        | 4. INSERT DETAIL
        |------------------------------------------
        */
            $defects = DB::connection('mysql')
                ->table('DEFECT')
                ->where('DEF_TYPE', $trial->PROCESS_ID)
                ->whereRaw('IFNULL(ISACTIVE, 1) = 1')
                ->get();

            foreach ($defects as $defect) {
                DB::connection('mysql')->table('TRIAL_RR_DET')->insert([
                    'PROJECT_ID' => $trial->PROJECT_ID,
                    'PROCESS_ID' => $trial->PROCESS_ID,
                    'STDPROC_ID' => $trial->STDPROC_ID,
                    'PIC' => $trial->PIC,
                    'TRIAL_NO' => $trial->ID,
                    'DEFECT_ID' => $defect->ID,
                    'TRANS_TYPE' => $defect->DEF_MAKING,
                    'ORDER' => $defect->ORDER,
                    'OK' => $trial->OK,
                    'ACTUAL' => $trial->ACTUAL,
                    'STATUS1' => 1,
                    'SYSDATE1' => now()
                ]);
            }

            DB::connection('mysql')->commit();

            return [
                'success' => true,
                'message' => 'Trial RR & Detail berhasil disimpan',
                'files' => $softcopyIds,
                'softcopy_id' => $softcopyIdJson,
                'trial_id' => $trialId
            ];
        } catch (\Exception $e) {
            DB::connection('mysql')->rollBack();
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public static function update_trial_detail($req)
    {
        try {
            DB::connection('mysql')->table('TRIAL_RR_DET')
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

    public static function insert_task($req)
{
    try {
        DB::connection('mysql')->beginTransaction();

        $projectId = $req->input('project_id');
        $taskId    = $req->input('task_id');

        $old = DB::connection('mysql')
            ->table('PROJECT_TASK')
            ->where('PROJECT_ID', $projectId)
            ->where('TASK_ID', $taskId)
            ->first();

        if (!$old) {
            throw new \Exception('Task not found');
        }

        $planStart    = $req->plan_start    ?: ($old->PLAN_START    ? date('Y-m-d', strtotime($old->PLAN_START))    : null);
        $planDuration = $req->plan_duration ?: $old->PLAN_DURATION;
        $actualStart  = $req->actual_start  ?: ($old->ACTUAL_START  ? date('Y-m-d', strtotime($old->ACTUAL_START))  : null);
        $actualEnd    = $req->actual_end    ?: ($old->ACTUAL_END    ? date('Y-m-d', strtotime($old->ACTUAL_END))    : null);

        $planEnd = ($planStart && $planDuration)
            ? self::add_working_days($planStart, $planDuration)
            : null;

        $actualDuration = null;
        if ($actualStart && $actualEnd) {
            $actualDuration = self::calculate_working_days_between($actualStart, $actualEnd);
        } else {
            $actualDuration = $old->ACTUAL_DURATION;
        }

        $planHour = $req->plan_hour ?: $old->PLAN_HOUR;
        $heatTask = null;
        if ($planHour && $actualDuration && $actualDuration > 0) {
            $heatTask = round($planHour / $actualDuration, 1);
        }

        $isMilestone = $req->is_milestone ?? $old->IS_MILESTONE;
        $parentTask  = $old->PARENT_TASK;

        $milestoneParentMap = [
            20 => null,
            21 => 20,
            70 => 21,
        ];

        if ($isMilestone !== null && array_key_exists((int)$isMilestone, $milestoneParentMap)) {
            $parentMilestone = $milestoneParentMap[(int)$isMilestone];

            if ($parentMilestone === null) {
                $parentTask = null;
            } else {
                $parent = DB::connection('mysql')
                    ->table('PROJECT_TASK')
                    ->where('PROJECT_ID', $projectId)
                    ->where('IS_MILESTONE', $parentMilestone)
                    ->where('ORDER1', '<', $old->ORDER1)
                    ->orderBy('ORDER1', 'DESC')
                    ->first();

                $parentTask = $parent ? $parent->TASK_ID : null;
            }
        }

        // =============================================
        // FIX UTAMA: Jangan pakai array_filter yang
        // ikut hapus nilai 0, '0', false, dll
        // =============================================
        $data = [];

        if ($req->has('plan_start'))       $data['PLAN_START']       = $req->plan_start       ?: null;
        if ($req->has('plan_duration'))     $data['PLAN_DURATION']    = $req->plan_duration     ?: null;
        if ($planEnd !== null)              $data['PLAN_END']         = $planEnd;
        if ($req->has('actual_start'))      $data['ACTUAL_START']     = $req->actual_start      ?: null;
        if ($req->has('actual_end'))        $data['ACTUAL_END']       = $req->actual_end        ?: null;
        if ($actualDuration !== null)       $data['ACTUAL_DURATION']  = $actualDuration;
        if ($req->has('plan_hour'))         $data['PLAN_HOUR']        = $req->plan_hour         ?: null;
        if ($req->has('actual_hour'))       $data['ACTUAL_HOUR']      = $req->actual_hour       ?: null;
        if ($req->has('responsible'))       $data['RESPONSIBLE']      = $req->responsible       ?: null;
        if ($req->has('status'))            $data['STATUS']           = $req->status            ?: null;
        if ($req->has('complexity'))        $data['COMPLEXITY']       = $req->complexity        ?: null;
        if ($req->has('priority'))          $data['PRIORITY']         = $req->priority          ?: null;
        if ($req->has('is_milestone'))      $data['IS_MILESTONE']     = $req->is_milestone      ?: null;
        if ($req->has('actual_progress'))   $data['ACTUAL_PROGRESS']  = $req->actual_progress   ?: null;
        if ($req->has('remark'))            $data['REMARK']           = $req->remark;
        if ($heatTask !== null)             $data['HEAT_TASK']        = $heatTask;
        if ($parentTask !== null)           $data['PARENT_TASK']      = $parentTask;

        $data['UPDATETIME'] = now();

        if (empty($data)) {
            throw new \Exception('No data to update');
        }

        // =============================================
        // FIX: Gunakan updateOrIgnore atau cek dulu
        // pastikan where kondisi benar
        // =============================================
        $affected = DB::connection('mysql')
            ->table('PROJECT_TASK')
            ->where('PROJECT_ID', (string) $projectId)
            ->where('TASK_ID', (string) $taskId)
            ->update($data);

        // Jika 0 rows affected tapi record ada → data tidak berubah, anggap sukses
        // Jika record tidak ada → error
        $exists = DB::connection('mysql')
            ->table('PROJECT_TASK')
            ->where('PROJECT_ID', (string) $projectId)
            ->where('TASK_ID', (string) $taskId)
            ->exists();

        if (!$exists) {
            throw new \Exception("Task tidak ditemukan. PROJECT_ID: {$projectId}, TASK_ID: {$taskId}");
        }

        // Update status project
        $notCompleted = DB::connection('mysql')
            ->table('PROJECT_TASK')
            ->where('PROJECT_ID', $projectId)
            ->where(function ($q) {
                $q->where('STATUS', '!=', 3)
                  ->orWhereNull('STATUS');
            })
            ->count();

        if ($notCompleted == 0) {
            DB::connection('mysql')
                ->table('PROJECT')
                ->where('ID', $projectId)
                ->update(['STATUS' => 3]);
        } else {
            DB::connection('mysql')
                ->table('PROJECT')
                ->where('ID', $projectId)
                ->update(['STATUS' => 2]);
        }

        DB::connection('mysql')->commit();

        return [
            'success'           => true,
            'message'           => 'Task updated successfully',
            'heat_task'         => $heatTask,
            'plan_end'          => $planEnd,
            'actual_end'        => $actualEnd,
            'actual_duration'   => $actualDuration,
            'parent_task'       => $parentTask
        ];

    } catch (\Exception $e) {
        DB::connection('mysql')->rollBack();
        return [
            'success' => false,
            'message' => $e->getMessage()
        ];
    }
}
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
            DB::connection('mysql')->beginTransaction();

            $task = DB::connection('mysql')
                ->table('PROJECT_TASK')
                ->where('ID', $id)
                ->first();

            if (!$task) {
                throw new \Exception("Task with ID {$id} not found");
            }

            $projectId = $task->PROJECT_ID;

            $deleted = DB::connection('mysql')
                ->table('PROJECT_TASK')
                ->where('ID', $id)
                ->delete();

            $hasNotCompleted = DB::connection('mysql')
                ->table('PROJECT_TASK')
                ->where('PROJECT_ID', $projectId)
                ->where(function ($q) {
                    $q->where('STATUS', '!=', 3)
                        ->orWhereNull('STATUS');
                })
                ->count();

            if ($hasNotCompleted == 0) {
                DB::connection('mysql')
                    ->table('PROJECT')
                    ->where('ID', $projectId)
                    ->update([
                        'STATUS' => 3
                    ]);
            } else {
                DB::connection('mysql')
                    ->table('PROJECT')
                    ->where('ID', $projectId)
                    ->update([
                        'STATUS' => 2
                    ]);
            }

            DB::connection('mysql')->commit();
            return $deleted;
        } catch (\Exception $e) {
            DB::connection('mysql')->rollBack();
            throw $e;
        }
    }

    public static function insert_milestone_task($req)
    {
        try {
            DB::connection('mysql')->beginTransaction();

            $projectId = $req->input('project_id');
            $milestoneTask = $req->input('milestone_task');
            $category = (int) $req->input('category');
            $insertAfter = (int) $req->input('insert_after');

            DB::connection('mysql')
                ->table('PROJECT_TASK')
                ->where('PROJECT_ID', $projectId)
                ->where('ORDER1', '>', $insertAfter)
                ->update([
                    'ORDER1' => DB::raw('ORDER1 + 1')
                ]);

            $newOrder = $insertAfter + 1;

            $maxTask = DB::connection('mysql')
                ->table('TASK_SETUP_ADD')
                ->select(DB::raw("MAX(CAST(SUBSTRING_INDEX(TASK_ID, 'PT', -1) AS UNSIGNED)) AS MAX_ID"))
                ->value('MAX_ID');

            $taskId = 'PT' . (($maxTask ?? 0) + 1);

            $parentTask = null;

            $milestoneParentMap = [
                20 => null,
                21 => 20,
                70 => 21,
            ];

            if (array_key_exists($category, $milestoneParentMap)) {

                $parentMilestone = $milestoneParentMap[$category];

                if ($parentMilestone === null) {
                    $parentTask = null;
                } else {
                    $parent = DB::connection('mysql')
                        ->table('PROJECT_TASK')
                        ->where('PROJECT_ID', $projectId)
                        ->where('IS_MILESTONE', $parentMilestone)
                        ->where('ORDER1', '<=', $insertAfter)
                        ->orderBy('ORDER1', 'DESC')
                        ->first();

                    $parentTask = $parent ? $parent->TASK_ID : null;
                }
            }
            DB::connection('mysql')
                ->table('TASK_SETUP_ADD')
                ->insert([
                    'TASK_ID' => $taskId,
                    'PROJECT' => $projectId,
                    'MILESTONE_TASK' => $milestoneTask,
                    'IS_MILESTONE' => $category,
                    'PARENT_TASK' => $parentTask,
                    'ORDER1' => $newOrder,
                    'SYSDATE1' => now()
                ]);

            DB::connection('mysql')
                ->table('PROJECT_TASK')
                ->insert([
                    'PROJECT_ID' => $projectId,
                    'TASK_ID' => $taskId,
                    'MILESTONE_TASK' => $milestoneTask,
                    'IS_MILESTONE' => $category,
                    'PARENT_TASK' => $parentTask,
                    'ORDER1' => $newOrder,
                    'SYSDATE1' => now()
                ]);

            $allCompleted = DB::connection('mysql')
                ->table('PROJECT_TASK')
                ->where('PROJECT_ID', $projectId)
                ->where('TASK_ID', '!=', $taskId)
                ->where('STATUS', '!=', 3)
                ->count() == 0;

            if ($allCompleted) {
                DB::connection('mysql')
                    ->table('PROJECT')
                    ->where('ID', $projectId)
                    ->update(['STATUS' => 2]);
            }

            DB::connection('mysql')->commit();

            return [
                'success' => true,
                'message' => "Milestone task added successfully",
                'task_id' => $taskId,
                'parent_task' => $parentTask,
                'order' => $newOrder
            ];
        } catch (\Exception $e) {
            DB::connection('mysql')->rollBack();
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public static function insert_activity_log($req)
    {
        try {
            $activityName = $req->activity ?? '-';
            $softcopyIds = [];

            if ($req->hasFile('picture')) {
                foreach ($req->file('picture') as $file) {

                    $originalName = $file->getClientOriginalName();
                    $cleanClientName = preg_replace('/\s+/', '_', $originalName);

                    $rand = substr(md5(uniqid()), 0, 10);
                    $uniqueName = $rand . $cleanClientName;

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

                    $savePath = public_path('activity/' . $uniqueName);
                    $skipCompress = $file->getSize() < (200 * 1024);

                    if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {

                        if ($ext === 'gif' || $skipCompress) {
                            $file->move(public_path('activity'), $uniqueName);
                            $size = filesize($savePath);
                        } else {
                            if (in_array($ext, ['jpg', 'jpeg'])) {
                                $encoder = new JpegEncoder(70);
                            } else {
                                $encoder = new PngEncoder(8);
                            }

                            Image::read($file->getRealPath())
                                ->scaleDown(1600)
                                ->encode($encoder)
                                ->save($savePath);

                            $size = filesize($savePath);
                        }
                    } else {
                        $file->move(public_path('activity'), $uniqueName);
                        $size = $file->getSize();
                    }

                    $fileRelPath = 'activity/' . $uniqueName;

                    $insertId = DB::connection('mysql')->table('SOFTCOPY')->insertGetId([
                        'CLIENT_NAME' => $cleanClientName,
                        'FILE_NAME' => $uniqueName,
                        'FILE_PATH' => 'activity',
                        'FULL_PATH' => $fileRelPath,
                        'FILE_SIZE' => $size,
                        'FILE_EXT' => $ext,
                        'FILE_TYPE' => $type,
                        'STATUS1' => 1,
                        'SYSDATE1' => now()
                    ]);

                    $softcopyIds[] = $insertId;
                }
            }

            DB::connection('mysql')
                ->table('ACTIVITY_LOG')
                ->insert([
                    'PROJECT_ID' => $req->project_id,
                    'TASK_ID' => $req->task_id,
                    'ACTIVITY' => $activityName,
                    'TASK_DET' => $req->task_det,
                    'PICTURE' => json_encode($softcopyIds),
                    'INPUTBY' => $req->inputby,
                    'STATUS1' => 1,
                    'SYSDATE1' => now()
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

        $last = DB::connection('mysql')->table(strtoupper($table))
            ->select(DB::raw("MAX($col) as maxid"))
            ->first();

        $lastId = ($last && $last->maxid) ? intval($last->maxid) : 10000000000001;

        return $lastId + 1;
    }
}
