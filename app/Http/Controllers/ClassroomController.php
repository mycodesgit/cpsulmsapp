<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\EnrollmentDB\Student;
use App\Models\EnrollmentDB\StudentLevel;
use App\Models\EnrollmentDB\Grade;
use App\Models\EnrollmentDB\GradeCode;
use App\Models\EnrollmentDB\YearLevel;
use App\Models\EnrollmentDB\MajorMinor;
use App\Models\EnrollmentDB\StudentStatus;
use App\Models\EnrollmentDB\StudentType;
use App\Models\EnrollmentDB\StudentShifTrans;
use App\Models\EnrollmentDB\StudEnrolmentHistory;

use App\Models\ScheduleDB\ClassEnroll;
use App\Models\ScheduleDB\College;
use App\Models\ScheduleDB\EnPrograms;
use App\Models\ScheduleDB\Subject;
use App\Models\ScheduleDB\SubjectOffered;
use App\Models\ScheduleDB\Faculty;
use App\Models\ScheduleDB\FacultyLoad;
use App\Models\ScheduleDB\SetClassSchedule;

use App\Models\SettingDB\ConfigureCurrent;

use App\Models\LmsDB\Topics;

class ClassroomController extends Controller
{
    public function studsemester()
    {
        $progen = StudEnrolmentHistory::join(DB::connection('schedule')->getDatabaseName() . '.programs', 'program_en_history.progCod', '=', 'coasv2_db_schedule.programs.progCod')
                    ->where('studentID', '=', Auth::guard('web')->user()->studenID)
                    ->select('program_en_history.*', 'program_en_history.id as progenid', 'coasv2_db_schedule.programs.progAcronym')
                    ->groupBy('schlyear', 'semester', 'campus')
                    ->orderBy('schlyear', 'desc')
                    ->orderBy('semester', 'desc')
                    ->get();

        return view('classroom.virtual_semester', compact('progen'));
    }

    public function facultyindex()
    {
        $progen = ConfigureCurrent::where('schlyear', '>=', '2024-2025')
                    ->orderBy('schlyear', 'desc')
                    ->orderBy('semester', 'desc')
                    ->get();
        return view('classroom.virtual_semester', compact('progen'));
    }

    public function virtual_class(Request $request)
    {
        $semester = $request->query('semester');
        $schlyear = $request->query('schlyear');
        $studentID = Auth::guard('web')->user()->studenID;

        $subprogen = Grade::leftJoin('coasv2_db_schedule.scheduleclass', 'studgrades.subjID', '=', 'coasv2_db_schedule.scheduleclass.subject_id')
                    ->leftJoin('coasv2_db_schedule.faculty', 'coasv2_db_schedule.scheduleclass.faculty_id', '=', 'coasv2_db_schedule.faculty.id')
                    ->join('coasv2_db_schedule.sub_offered', 'studgrades.subjID', '=', 'coasv2_db_schedule.sub_offered.id')
                    ->leftJoin('coasv2_db_schedule.subjects', 'coasv2_db_schedule.sub_offered.subCode', '=', 'coasv2_db_schedule.subjects.sub_code')
                    ->select(
                        'studgrades.*',
                        'studgrades.id as stugdeID',
                        'coasv2_db_schedule.subjects.sub_name',
                        'coasv2_db_schedule.sub_offered.subSec',
                        'coasv2_db_schedule.sub_offered.schlyear',
                        'coasv2_db_schedule.sub_offered.semester',
                        'coasv2_db_schedule.sub_offered.campus',
                        'coasv2_db_schedule.scheduleclass.faculty_id',
                        'coasv2_db_schedule.scheduleclass.subject_id',
                        'coasv2_db_schedule.faculty.fname',
                        'coasv2_db_schedule.faculty.lname',
                    )
                    ->where('sub_offered.semester', '=', $semester)
                    ->where('sub_offered.schlyear', '=', $schlyear)
                    ->where('sub_offered.campus', '=', Auth::guard('web')->user()->campus)
                    ->where('studgrades.studID', '=', $studentID)
                    ->groupBy('studgrades.subjID')
                    ->get();
        return view('classroom.virtualroom', compact('subprogen', 'semester', 'schlyear'));
    }

    public function virtualfaculty_class(Request $request)
    {
        $semester = $request->query('semester');
        $schlyear = $request->query('schlyear');
        $facID = Auth::guard('faculty')->user()->id;

        $facsubprogen = Grade::leftJoin('coasv2_db_schedule.scheduleclass', 'studgrades.subjID', '=', 'coasv2_db_schedule.scheduleclass.subject_id')
                    ->leftJoin('coasv2_db_schedule.faculty', 'coasv2_db_schedule.scheduleclass.faculty_id', '=', 'coasv2_db_schedule.faculty.id')
                    ->join('coasv2_db_schedule.sub_offered', 'studgrades.subjID', '=', 'coasv2_db_schedule.sub_offered.id')
                    ->leftJoin('coasv2_db_schedule.subjects', 'coasv2_db_schedule.sub_offered.subCode', '=', 'coasv2_db_schedule.subjects.sub_code')
                    ->select(
                        'studgrades.*',
                        'studgrades.id as stugdeID',
                        'coasv2_db_schedule.subjects.sub_name',
                        'coasv2_db_schedule.sub_offered.subSec',
                        'coasv2_db_schedule.sub_offered.schlyear',
                        'coasv2_db_schedule.sub_offered.semester',
                        'coasv2_db_schedule.sub_offered.campus',
                        'coasv2_db_schedule.scheduleclass.faculty_id',
                        'coasv2_db_schedule.scheduleclass.subject_id',
                        'coasv2_db_schedule.faculty.fname',
                        'coasv2_db_schedule.faculty.lname',
                    )
            ->where('coasv2_db_schedule.sub_offered.semester', $semester)
            ->where('coasv2_db_schedule.sub_offered.schlyear', $schlyear)
            ->where('coasv2_db_schedule.sub_offered.campus', Auth::guard('faculty')->user()->campus)
            ->where('coasv2_db_schedule.scheduleclass.faculty_id', $facID)
            ->groupBy('studgrades.subjID')
            ->get();

        return view('classroom.virtualroom', compact('facsubprogen', 'semester', 'schlyear'));
    }

    public function virtual_subjectclass(Request $request, $id)
    {
        $semester = $request->query('semester');
        $schlyear = $request->query('schlyear');
        $studentID = Auth::guard('web')->user()->studenID;
        
        $sub = Grade::leftJoin('coasv2_db_schedule.scheduleclass', 'studgrades.subjID', '=', 'coasv2_db_schedule.scheduleclass.subject_id')
                    ->leftJoin('coasv2_db_schedule.faculty', 'coasv2_db_schedule.scheduleclass.faculty_id', '=', 'coasv2_db_schedule.faculty.id')
                    ->leftJoin('coasv2_db_schedule.sub_offered', 'studgrades.subjID', '=', 'coasv2_db_schedule.sub_offered.id')
                    ->leftJoin('coasv2_db_schedule.subjects', 'coasv2_db_schedule.sub_offered.subCode', 'coasv2_db_schedule.subjects.sub_code')
                    ->leftJoin('students', 'studgrades.studID', '=', 'students.stud_id')
                    ->select(
                        'studgrades.*', 
                        'studgrades.id as stugdeID', 
                        'coasv2_db_schedule.subjects.sub_name', 
                        'coasv2_db_schedule.subjects.sub_title', 
                        'coasv2_db_schedule.sub_offered.subSec', 
                        'coasv2_db_schedule.sub_offered.schlyear', 
                        'coasv2_db_schedule.sub_offered.semester', 
                        'coasv2_db_schedule.sub_offered.campus',
                        'coasv2_db_schedule.scheduleclass.faculty_id',
                        'coasv2_db_schedule.scheduleclass.subject_id',
                        'coasv2_db_schedule.faculty.fname',
                        'coasv2_db_schedule.faculty.lname',
                    )
                    ->where('sub_offered.semester', '=', $semester)
                    ->where('sub_offered.schlyear', '=', $schlyear)
                    ->where('sub_offered.campus', '=', Auth::guard('web')->user()->campus)
                    ->where('studgrades.studID', '=', $studentID)
                    ->where('studgrades.subjID', '=', $id)
                    ->orderBy('students.lname', 'ASC')
                    ->first();

        $substudQuery = Grade::join('students', 'studgrades.studID', '=', 'students.stud_id')
                        ->select('studgrades.*', 'studgrades.id as stugdeID', 'students.lname', 'students.fname', 'students.mname')
                        ->where('studgrades.subjID', '=', $id)
                        ->orderBy('students.lname', 'ASC');

        $substud = $substudQuery->get();
        $substudcount = $substudQuery->count();

        return view('classroom.virtualsubroom', compact('sub', 'substud', 'substudcount'));
    }

    public function virtual_facultysubjectclass(Request $request, $id)
    {
        $semester = $request->query('semester');
        $schlyear = $request->query('schlyear');
        $facID = Auth::guard('faculty')->user()->id;
        
        $sub = Grade::leftJoin('coasv2_db_schedule.scheduleclass', 'studgrades.subjID', '=', 'coasv2_db_schedule.scheduleclass.subject_id')
                    ->leftJoin('coasv2_db_schedule.faculty', 'coasv2_db_schedule.scheduleclass.faculty_id', '=', 'coasv2_db_schedule.faculty.id')
                    ->leftJoin('coasv2_db_schedule.sub_offered', 'studgrades.subjID', '=', 'coasv2_db_schedule.sub_offered.id')
                    ->leftJoin('coasv2_db_schedule.subjects', 'coasv2_db_schedule.sub_offered.subCode', 'coasv2_db_schedule.subjects.sub_code')
                    ->leftJoin('students', 'studgrades.studID', '=', 'students.stud_id')
                    ->select(
                        'studgrades.*', 
                        'studgrades.id as stugdeID', 
                        'coasv2_db_schedule.subjects.sub_name', 
                        'coasv2_db_schedule.subjects.sub_title', 
                        'coasv2_db_schedule.sub_offered.subSec', 
                        'coasv2_db_schedule.sub_offered.schlyear', 
                        'coasv2_db_schedule.sub_offered.semester', 
                        'coasv2_db_schedule.sub_offered.campus',
                        'coasv2_db_schedule.scheduleclass.faculty_id',
                        'coasv2_db_schedule.scheduleclass.subject_id',
                        'coasv2_db_schedule.faculty.fname',
                        'coasv2_db_schedule.faculty.lname',
                    )
                    ->where('sub_offered.semester', '=', $semester)
                    ->where('sub_offered.schlyear', '=', $schlyear)
                    ->where('sub_offered.campus', '=', Auth::guard('faculty')->user()->campus)
                    ->where('studgrades.subjID', '=', $id)
                    ->orderBy('students.lname', 'ASC')
                    ->first();

        $substudQuery = Grade::join('students', 'studgrades.studID', '=', 'students.stud_id')
                        ->select('studgrades.*', 'studgrades.id as stugdeID', 'students.lname', 'students.fname', 'students.mname')
                        ->where('studgrades.subjID', '=', $id)
                        ->orderBy('students.lname', 'ASC');

        $substud = $substudQuery->get();
        $substudcount = $substudQuery->count();

        return view('classroom.virtualsubroom', compact('sub', 'substud', 'substudcount'));
    }

    public function view()
    {
        // Get the file path from the storage
        $filePath = 'topics/document.pdf';
        
        // Create the URL to the file using storage helper
        $fileUrl = urlencode(asset('storage/' . $filePath));
        
        // Redirect to Google Docs Viewer
        return redirect("https://docs.google.com/gview?url={$fileUrl}&embedded=true");
    }

}
