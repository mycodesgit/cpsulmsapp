<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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

class ClassroomUploadTopicController extends Controller
{
    public function storeTopics(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'schlyear' => 'required',
                'semester' => 'required',
                'subjectID' => 'required',
                'instructorID' => 'required',
                'topicname' => 'required',
                'desctopicname' => 'required',
                //'filedocs' => 'nullable|file|mimes:pdf,doc,docx,txt|max:2048', // Uncomment this when needed
            ]);

            // Uncomment this section if you want to handle file uploads
            // $filePath = null;
            // if ($request->hasFile('filedocs')) {
            //     $filePath = $request->file('filedocs')->storeAs(
            //         'topics/' . $request->input('subjectID'). '-' . $request->input('sub_name'),
            //         $request->file('filedocs')->getClientOriginalName()
            //     );
            // }

            // $filePaths = []; // Array to hold the paths of uploaded files

            // // Handle multiple file uploads
            // if ($request->hasFile('filedocs')) {
            //     foreach ($request->file('filedocs') as $file) {
            //         $filePath = $file->storeAs(
            //             'topics/' . $request->input('subjectID') . '-' . $request->input('sub_name'),
            //             $file->getClientOriginalName()
            //         );
            //         $filePaths[] = $filePath; 
            //     }
            // }

            if ($request->hasFile('filedocs')) {
                $filePaths = []; // Initialize the array to store file paths
                foreach ($request->file('filedocs') as $file) {
                    // Create a directory path using the subject ID and name
                    $directoryPath = 'topics/' . $request->input('subjectID') . '-' . $request->input('sub_name');

                    // Construct the full path to the storage directory
                    $destinationPath = public_path('storage/' . $directoryPath);

                    // Create the directory if it doesn't exist
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0755, true);
                    }

                    // Move the uploaded file to the public storage path
                    $filePath = $file->move($destinationPath, $file->getClientOriginalName());

                    // Store the path relative to the storage directory
                    $filePaths[] = 'storage/' . $directoryPath . '/' . $file->getClientOriginalName(); 
                }
            }


            // Convert the array of file paths to a comma-separated string
            $filePathsString = implode(',', $filePaths);

            try {
                Topics::create([
                    'campus' => Auth::guard('faculty')->user()->campus,
                    'schlyear' => $request->input('schlyear'),
                    'semester' => $request->input('semester'),
                    'subjectID' => $request->input('subjectID'),
                    'instructorID' => $request->input('instructorID'),
                    'topicname' => $request->input('topicname'),
                    'desctopicname' => $request->input('desctopicname'),
                    'filedocs' => json_encode($filePaths), 
                    'postedBy' => Auth::guard('faculty')->user()->id,
                ]);

                return response()->json(['success' => true, 'message' => 'Topics Uploaded successfully']);
            } catch (\Exception $e) {
                return response()->json(['error' => true, 'message' => 'Failed to Upload Topics']);
            }
        }
    }

    public function showTopics($id)
    {
        $schlyear = request()->query('schlyear');
        $semester = request()->query('semester');

        // Fetch the topics based on subjectID, schlyear, and semester
        $topics = Topics::where('subjectID', $id)
                    ->where('schlyear', $schlyear)
                    ->where('semester', $semester)
                    ->get();

        // Return JSON response
        return response()->json($topics);
    }

    public function viewFile($filename)
    {
        // Assuming your files are in public/topics
        $filePath = public_path("topics/{$filename}"); // Adjusted path to point to the topics folder

        // Check if the file exists
        if (!file_exists($filePath)) {
            abort(404);
        }

        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        
        // Generate Google Docs/Slides/Drive viewer URLs
        switch ($extension) {
            case 'pdf':
                // Use Google Drive Viewer for PDFs
                $viewerUrl = "https://drive.google.com/viewerng/viewer?embedded=true&url=" . urlencode(asset("topics/{$filename}"));
                break;
            case 'docx':
                // Use Google Docs Viewer for DOCX
                $viewerUrl = "https://docs.google.com/viewer?url=" . urlencode(asset("topics/{$filename}")) . "&embedded=true";
                break;
            case 'pptx':
                // Use Google Slides Viewer for PPTX
                $viewerUrl = "https://docs.google.com/viewer?url=" . urlencode(asset("topics/{$filename}")) . "&embedded=true";
                break;
            default:
                abort(404, 'Unsupported file type.');
        }

        return view('classroom.fileviewer', compact('viewerUrl'));
    }
}
