<?php

namespace App\Http\Controllers;

use App\Course;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('courses.index');
    }

    public function create()
    {
        return view('courses.create');
    }

    public function store()
    {
        $courseData = request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'course_code' => ['required', 'string', 'max:3'],
        ]);

        //dd(strtoupper($courseData['name']));

        Course::create([
            'name' => strtoupper($courseData['name']),
            'code' => $courseData['course_code'],
        ]);

        return redirect('/c/create')->with('success', 'New Course Created');
    }

    public function getCourse()
    {
        $courseData = Course::all();

        //dd($studentRecord);
        Return DataTables::of($courseData)
            ->addColumn('action', function(Course $course) {
                return '
                <a href="/c/'. $course->id .'/edit"><i class="fas fa-edit"></i></i></a>
                &nbsp;
                <a href="/c/'. $course->id .'"><i class="fas fa-trash"></i></a>
                ';
            })
            ->rawColumns(['action' => 'action'])
            ->toJson();
    }
}
