<?php

namespace App\Http\Controllers;

use App\Course;
use App\Student;
use App\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Yajra\DataTables\Facades\DataTables;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('students.index');
    }

    public function create(Request $request)
    {
        if (session()->has('batch_id', 'batch_text', 'record', 'record_month_id', 'record_month_text')) {
            $batchId = $request->session()->get('batch_id');
            $batchText = $request->session()->get('batch_text');
            $record = $request->session()->get('record');
            $recordMonthId = $request->session()->get('record_month_id');
            $recordMonthText = $request->session()->get('record_month_text');

            $request->session()->flash('batch_id', $batchId);
            $request->session()->flash('batch_text', $batchText);
            $request->session()->flash('record', $record);
            $request->session()->flash('record_month_id', $recordMonthId);
            $request->session()->flash('record_month_text', $recordMonthText);

            $courseData = Course::all();

            //dd($batches, $record, $recordMonth);
            return view('students.create', compact('batchId', 'batchText', 'courseData', 'record', 'recordMonthId', 'recordMonthText'));
        } else {
            return redirect('/s');
        }
    }

    public function store(Request $request)
    {
        $batchId = $request->session()->get('batch_id');
        $batchText = $request->session()->get('batch_text');
        $record = $request->session()->get('record');
        $recordMonthId = $request->session()->get('record_month_id');
        $recordMonthText = $request->session()->get('record_month_text');

        $batchSemester = strstr($record, '?', true);

        $request->session()->flash('batch_id', $batchId);
        $request->session()->flash('batch_text', $batchText);
        $request->session()->flash('record', $record);
        $request->session()->flash('record_month_id', $recordMonthId);
        $request->session()->flash('record_month_text', $recordMonthText);

        $studentData = request()->validate([
            'batch_id' => '',
            'course' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'ic_number' => ['required', 'string', 'max:255'],
            'bank_account_number' => ['required', 'string', 'max:255'],
            'semester' => '',
            'allowance' => '',
            'ic_photo' => ['required', 'image', 'mimes:jpeg,png,jpg'],
            'bank_account_photo' => ['required', 'image', 'mimes:jpeg,png,jpg'],
            'month' => '',
            'disabilities_status' => ['required', 'boolean', 'max:1'],
        ]);

        $icImagePath = request('ic_photo')->store('record', 'public');
        $icImage = Image::make(public_path("storage/{$icImagePath}"))->encode('jpg', 90);
        $icImage->save();

        $bankAccountImagePath = request('bank_account_photo')->store('record', 'public');
        $bankAccountImage = Image::make(public_path("storage/{$bankAccountImagePath}"))->encode('jpg', 90);
        $bankAccountImage->save();

        $allowance = ($studentData['disabilities_status'] != 0) ? 300 : 100;

        Student::create([
            'batch_id' => $batchId,
            'course_id' => $studentData['course'],
            'name' => strtoupper($studentData['name']),
            'ic_number' => $studentData['ic_number'],
            'bank_account_number' => $studentData['bank_account_number'],
            'semester' => $batchSemester,
            'allowance' => $allowance,
            'ic_photo' => $icImagePath,
            'bank_account_photo' => $bankAccountImagePath,
            'month' => $recordMonthId,
            'disabilities_status' => $studentData['disabilities_status'],
        ]);

        return redirect('/s/record/create')->with('success', 'New Student Added')->with('batch_id', $batchId)->with('batch_text', $batchText)->with('record', $record)->with('record_month_id', $recordMonthId)->with('record_month_text', $recordMonthText);
    }

    public function searchRecord(Request $request)
    {
        $jsonString = ($request->batch1 != null) ? $request->batch1 : $request->batch2;
        $jsonData = json_decode($jsonString, true);
        $batchId = $jsonData['0']['id'];
        $batchText = $jsonData['0']['text'];
        $record = $request->record;
        $recordMonthId = $request->record_month;
        $recordMonthText = Carbon::parse($recordMonthId)->format("F Y");

        return redirect('/s/record')->with('batch_id', $batchId)->with('batch_text', $batchText)->with('record', $record)->with('record_month_id', $recordMonthId)->with('record_month_text', $recordMonthText);
    }

    public function dataRecord(Request $request)
    {
        if (session()->has('batch_id', 'batch_text', 'record', 'record_month_id', 'record_month_text')) {
            $batchId = $request->session()->get('batch_id');
            $batchText = $request->session()->get('batch_text');
            $record = $request->session()->get('record');
            $recordMonthId = $request->session()->get('record_month_id');
            $recordMonthText = $request->session()->get('record_month_text');

            $request->session()->flash('batch_id', $batchId);
            $request->session()->flash('batch_text', $batchText);
            $request->session()->flash('record', $record);
            $request->session()->flash('record_month_id', $recordMonthId);
            $request->session()->flash('record_month_text', $recordMonthText);

            $batchYear = substr($batchText, 2);
            $firstMonthBatch = 1;

            $batchSemester = strstr($record, '?', true);
            $batchSession = strstr($batchText, '/', true);
            $batchMonth = ($batchSession != 1) ? 'July' . $batchYear : 'January' . $batchYear;

            if ($batchSemester == 1 and $recordMonthId == $batchMonth) {
                $firstMonthBatch = 1;
            } else {
                $firstMonthBatch = 0;
            }

            //dd($semester);
            return view('students.record', compact('firstMonthBatch', 'batchId', 'batchText', 'record', 'recordMonthId', 'recordMonthText'));
        } else {
            return redirect('/s');
        }
    }

    public function grabRecord(Request $request)
    {
        $batchId = $request->session()->get('batch_id');
        $batchText = $request->session()->get('batch_text');
        $record = $request->session()->get('record');
        $recordMonthId = $request->session()->get('record_month_id');
        $recordMonthText = $request->session()->get('record_month_text');

        $request->session()->flash('batch_id', $batchId);
        $request->session()->flash('batch_text', $batchText);
        $request->session()->flash('record', $record);
        $request->session()->flash('record_month_id', $recordMonthId);
        $request->session()->flash('record_month_text', $recordMonthText);

        $recordData = Student::orderBy('course_id', 'asc')
            ->orderBy('name', 'asc')
            ->where([['batch_id', '=', $batchId], ['month', '=', $recordMonthId],]);

        //dd($studentRecord);
        return DataTables::of($recordData)
            ->addColumn('code', function (Student $student) {
                return $student->course->code;
            })
            ->addColumn('courses', function (Student $student) {
                return $student->course->name;
            })
            ->addColumn('action', function (Student $student) {
                return '
                <a href="/s/record/' . $student->id . '/edit"><i class="fas fa-edit"></i></i></a>
                &nbsp;
                <a href="/s/record/' . $student->id . '"><i class="fas fa-trash"></i></a>
                ';
            })
            ->rawColumns(['action' => 'action'])
            ->toJson();
    }

    public function createList(Request $request)
    {
        if (session()->has('batch_id', 'batch_text', 'record', 'record_month_id', 'record_month_text')) {
            $batchId = $request->session()->get('batch_id');
            $batchText = $request->session()->get('batch_text');
            $record = $request->session()->get('record');
            $recordMonthId = $request->session()->get('record_month_id');
            $recordMonthText = $request->session()->get('record_month_text');

            $batchSemester = strstr($record, '?', true);

            date_default_timezone_set('Asia/Kuala_Lumpur');
            setlocale(LC_ALL, 'ms_MY.utf8');
            $monthId = strftime('%B%Y', strtotime($recordMonthText));
            $monthText = strftime('%B %Y', strtotime($recordMonthText));

            $request->session()->flash('batch_id', $batchId);
            $request->session()->flash('batch_text', $batchText);
            $request->session()->flash('record', $record);
            $request->session()->flash('record_month_id', $recordMonthId);
            $request->session()->flash('record_month_text', $recordMonthText);

            //dd($batchId);

            $recordStudentList = Student::orderBy('course_id', 'asc')
                ->orderBy('name', 'asc')
                ->where([['batch_id', '=', $batchId], ['month', '=', $recordMonthId]])
                ->get();

            //[['batch_id', '=', $batchId], ['month', '=', $recordMonthId]]
            $pdf = PDF::loadView('students.list', compact('recordStudentList', 'batchSemester', 'monthText'))->setPaper('a4', 'landscape');

            return $pdf->stream('sem' . $batchSemester . '_bulan' . $monthId . '_list' . '.pdf');
        } else {
            //return redirect('/s');
        }
    }

    public function createPhoto(Request $request)
    {
        if (session()->has('batch_id', 'batch_text', 'record', 'record_month_id', 'record_month_text')) {
            $batchId = $request->session()->get('batch_id');
            $batchText = $request->session()->get('batch_text');
            $record = $request->session()->get('record');
            $recordMonthId = $request->session()->get('record_month_id');
            $recordMonthText = $request->session()->get('record_month_text');

            $batchSemester = strstr($record, '?', true);

            date_default_timezone_set('Asia/Kuala_Lumpur');
            setlocale(LC_ALL, 'ms_MY.utf8');
            $monthId = strftime('%B%Y', strtotime($recordMonthText));
            $monthText = strftime('%B %Y', strtotime($recordMonthText));

            $request->session()->flash('batch_id', $batchId);
            $request->session()->flash('batch_text', $batchText);
            $request->session()->flash('record', $record);
            $request->session()->flash('record_month_id', $recordMonthId);
            $request->session()->flash('record_month_text', $recordMonthText);

            //dd($batchId);

            $recordStudentList = Student::orderBy('course_id', 'asc')
                ->orderBy('name', 'asc')
                ->where([['batch_id', '=', $batchId], ['month', '=', $recordMonthId]])
                ->get();

            //[['batch_id', '=', $batchId], ['month', '=', $recordMonthId]]
            $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('students.photo', compact('recordStudentList'))->setPaper('a4', 'portrait');

            //return view('students.photo', compact('recordStudentList'));
            return $pdf->stream('sem' . $batchSemester . '_bulan' . $monthId . '_photo' . '.pdf');
        } else {
            //return redirect('/s');
        }
    }

    public function importRecord(Request $request)
    {
        $batchId = $request->session()->get('batch_id');
        $batchText = $request->session()->get('batch_text');
        $record = $request->session()->get('record');
        $recordMonthId = $request->session()->get('record_month_id');
        $recordMonthText = $request->session()->get('record_month_text');

        $batchSemester = strstr($record, '?', true);

        $request->session()->flash('batch_id', $batchId);
        $request->session()->flash('batch_text', $batchText);
        $request->session()->flash('record', $record);
        $request->session()->flash('record_month_id', $recordMonthId);
        $request->session()->flash('record_month_text', $recordMonthText);

        $recordStudentList = Student::where([['batch_id', '=', $batchId], ['month', '=', 'January2020']])->get();

        //dd($recordStudentList);

        foreach ($recordStudentList as $data){
            Student::create([
                'batch_id' => $data['batch_id'],
                'course_id' =>$data['course_id'],
                'name' => $data['name'],
                'ic_number' => $data['ic_number'],
                'bank_account_number' => $data['bank_account_number'],
                'semester' => $batchSemester,
                'allowance' => $data['allowance'],
                'ic_photo' => $data['ic_photo'],
                'bank_account_photo' => $data['bank_account_photo'],
                'month' => $recordMonthId,
                'disabilities_status' => $data['disabilities_status'],
            ]);
        }
    }
}
