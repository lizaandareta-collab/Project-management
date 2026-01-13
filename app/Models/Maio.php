<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Maio
{
    protected static $db;
    protected static function db()
    {
        if (!self::$db) {
            self::$db = DB::connection('oracle');
        }
        return self::$db;
    }

    public static function get_holiday_table()
    {
        try {
            return self::db()
                ->table('PROMAN.HOLIDAY')
                ->select('ID', 'DESCRIPTION', 'DATE', 'STATUS1', 'SYSDATE1')
                ->orderByRaw('TO_NUMBER(ID) DESC')
                ->get();
        } catch (\Exception $e) {
            \Log::error('Error getHolidayTable: ' . $e->getMessage());
            return [];
        }
    }

    public static function get_client_table()
    {
        try {
            return self::db()
                ->table('PROMAN.CLIENT')
                ->select('ID', 'CLIENT_ORA', 'NAME', 'COMPANY', 'COUNTRY', 'STATUS1', 'SYSDATE1')
                ->orderByRaw('TO_NUMBER(ID) DESC')
                ->get();
        } catch (\Exception $e) {
            \Log::error('Error getHolidayTable: ' . $e->getMessage());
            return [];
        }
    }




    public static function get_projects()
    {
        try {
            return self::db()->table('PROMAN.PROJECT as p')
                ->leftJoin('PROMAN.RESOURCE_MGMT as r', 'p.RESPONSIBLE', '=', 'r.NPK')
                ->leftJoin('PROMAN.CLIENT as c', 'p.CLIENT', '=', 'c.CLIENT_ORA')
                ->leftJoin('PROMAN.LOV as lc', 'p.COMPLEXITY', '=', 'lc.LOV_ID')
                ->leftJoin('PROMAN.LOV as lp', 'p.PRIORITY', '=', 'lp.LOV_ID')
                ->leftJoin('PROMAN.LOV as ls', 'p.STATUS', '=', 'ls.LOV_ID')
                ->select(
                    'p.ID',
                    'p.PROJECT_NAME',
                    'r.EMP_NAME as RESPONSIBLE',
                    'c.NAME as CLIENT',
                    'p.BUDGET',
                    'p.START_DATE',
                    'p.DAYS',
                    'p.END_DATE',
                    'lc.DESCRIPTION as COMPLEXITY',
                    'lp.DESCRIPTION as PRIORITY',
                    'ls.DESCRIPTION as STATUS'
                )
                ->orderBy('p.ID', 'DESC')
                ->get();
        } catch (\Exception $e) {
            return [];
        }
    }

    public static function get_invoice_amount_by_project($projectId)
    {
        try {
            return self::db()->table('PROMAN.INVOICE_MGMT')
                ->where('PROJECT_ID', $projectId)
                ->sum('AMOUNT');
        } catch (\Exception $e) {
            return 0;
        }
    }

    public static function get_invoices_by_project($projectId)
    {
        $db = DB::connection('oracle');

        return $db->table('PROMAN.INVOICE_MGMT')
            ->select('ID', 'PROJECT_ID', 'CLIENT_ID', 'AMOUNT', 'REMARKS', 'DATE_CREATED')
            ->where('PROJECT_ID', $projectId)
            ->orderBy('DATE_CREATED', 'desc')
            ->get();
    }


    public static function get_project_by_id($id)
    {
        try {
            return self::db()->table('PROMAN.PROJECT')
                ->where('ID', $id)
                ->select('ID', 'PROJECT_NAME', 'BUDGET')
                ->first();
        } catch (\Exception $e) {
            return null;
        }
    }


    public static function get_lov()
    {
        try {
            return self::db()->table('PROMAN.LOV')->get();
        } catch (\Exception $e) {
            return [];
        }
    }

    public static function get_standard()
    {
        try {
            return self::db()->table('PROMAN.STANDARD')->get();
        } catch (\Exception $e) {
            return [];
        }
    }

    public static function get_standard_by_project_process($project_id, $process_id)
    {
        return self::db()
            ->table('PROMAN.STANDARD')
            ->where('PROJECT_ID', $project_id)
            ->where('PROCESS_ID', $process_id)
            ->whereIn('STDPROC_ID', [77, 78, 79])
            ->get();
    }



    public static function get_trial_rr($project_id, $process_id)
    {
        try {
            return self::db()
                ->table('PROMAN.TRIAL_RR')
                ->where('PROJECT_ID', $project_id)
                ->where('PROCESS_ID', $process_id)
                ->orderBy('TRIAL_DATE', 'DESC')
                ->get();
        } catch (\Exception $e) {
            return [];
        }
    }

    public static function get_softcopy_by_ids(array $ids)
{
    return self::db()
        ->table('PROMAN.SOFTCOPY')
        ->whereIn('ID', $ids)
        ->get()
        ->keyBy('id'); // key = ID
}



    public static function get_client()
    {
        try {
            return self::db()->table('PROMAN.CLIENT')->get();
        } catch (\Exception $e) {
            return [];
        }
    }

    public static function get_resource_mgmt()
    {
        try {
            return self::db()
                ->table('PROMAN.RESOURCE_MGMT as rm')
                ->leftJoin('PROMAN.LOV as lt', 'rm.EMP_TYPE', '=', 'lt.LOV_ID')
                ->leftJoin('PROMAN.LOV as ld', 'rm.DEPARTMENT', '=', 'ld.LOV_ID')
                ->select(
                    'rm.NPK',
                    'rm.EMP_NAME',
                    'lt.DESCRIPTION as EMP_TYPE',
                    'ld.DESCRIPTION as DEPARTMENT',
                    'rm.RATE_PER_HOUR',
                    'rm.MAX_HOUR'
                )
                ->orderBy('rm.EMP_NAME', 'ASC')
                ->get();
        } catch (\Exception $e) {
            return [];
        }
    }



    public static function get_holiday()
    {
        try {
            $data = self::db()->table('PROMAN.HOLIDAY')->get();

            // Ambil hanya kolom DATE dan ubah ke format Y-m-d
            $dates = $data->map(function ($row) {
                return date('Y-m-d', strtotime($row->date));
            })->toArray();

            return $dates;
        } catch (\Exception $e) {
            \Log::error('Error getHoliday: ' . $e->getMessage());
            return [];
        }
    }



    public static function get_activity_log($projectId, $taskId)
    {
        try {
            return self::db()->table('PROMAN.ACTIVITY_LOG as al')
                ->select(
                    'al.SYSDATE1',
                    'al.INPUTBY',
                    'al.TASK_DET',
                    'al.PICTURE',
                    'al.ACTIVITY'
                )
                ->where('al.PROJECT_ID', $projectId)
                ->where('al.TASK_ID', $taskId)
                ->orderBy('al.SYSDATE1', 'desc')
                ->get();
        } catch (\Exception $e) {
            return [];
        }
    }


    public static function get_project_task($projectId)
    {
        try {
            return self::db()->table('PROMAN.PROJECT_TASK as pt')
                ->leftJoin('PROMAN.PROJECT as p', 'pt.PROJECT_ID', '=', 'p.ID')
                ->leftJoin('PROMAN.RESOURCE_MGMT as r', 'pt.RESPONSIBLE', '=', 'r.NPK')
                ->leftJoin('PROMAN.LOV as ls', 'pt.STATUS', '=', 'ls.LOV_ID')
                ->leftJoin('PROMAN.LOV as lc', 'pt.COMPLEXITY', '=', 'lc.LOV_ID')
                ->leftJoin('PROMAN.LOV as lp', 'pt.PRIORITY', '=', 'lp.LOV_ID')
                ->leftJoin('PROMAN.LOV as lm', 'pt.IS_MILESTONE', '=', 'lm.LOV_ID')
                ->leftJoin('PROMAN.LOV as la', 'pt.ACTUAL_PROGRESS', '=', 'la.LOV_ID')
                ->select(
                    'pt.ID',
                    'pt.TASK_ID',
                    'pt.PARENT_TASK', // TAMBAHKAN INI
                    'p.PROJECT_NAME',
                    'pt.MILESTONE_TASK',
                    'pt.RESPONSIBLE',
                    'r.EMP_NAME as RESPONSIBLE_NAME',
                    'pt.PLAN_START',
                    'pt.PLAN_DURATION',
                    'pt.PLAN_END',
                    'pt.ACTUAL_START',
                    'pt.ACTUAL_DURATION',
                    'pt.ACTUAL_END',
                    'pt.STATUS',
                    'ls.DESCRIPTION as STATUS_NAME',
                    'pt.COMPLEXITY',
                    'lc.DESCRIPTION as COMPLEXITY_NAME',
                    'pt.PRIORITY',
                    'lp.DESCRIPTION as PRIORITY_NAME',
                    'pt.IS_MILESTONE',
                    'lm.DESCRIPTION as IS_MILESTONE_NAME',
                    'pt.ACTUAL_PROGRESS',
                    'la.DESCRIPTION as ACTUAL_PROGRESS_NAME',
                    'pt.PLAN_HOUR',
                    'pt.ACTUAL_HOUR',
                    'pt.REMARK',
                    'pt.HEAT_TASK',
                    'pt.ORDER1',
                )
                ->where('pt.PROJECT_ID', $projectId)
                ->orderBy('pt.ORDER1')
                ->get();
        } catch (\Exception $e) {
            return collect();
        }
    }


}
