<?php

namespace App\Http\Controllers;

use App\Batch;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\File;

class BatchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('batches.index');
    }

    public function grabBatch1()
    {
        $batchData1 = Batch::whereRaw('SUBSTRING(batch, 1,  1) = 1');
        Return DataTables::of($batchData1)
            ->addColumn('action', function(Batch $batch) {
            return '
                <a href="/b/'. $batch->id .'/edit"><i class="fas fa-edit"></i></i></a>
                &nbsp;
                <a href="/b/'. $batch->id .'"><i class="fas fa-trash"></i></a>
                ';
        })
            ->rawColumns(['action' => 'action'])
            ->toJson();
    }

    public function grabBatch2()
    {
        $batchData2 = Batch::whereRaw('SUBSTRING(batch, 1,  1) = 2');
        Return DataTables::of($batchData2)
            ->addColumn('action', function(Batch $batch) {
                return '
                <a href="/b/'. $batch->id .'/edit"><i class="fas fa-edit"></i></i></a>
                &nbsp;
                <a href="/b/'. $batch->id .'"><i class="fas fa-trash"></i></a>
                ';
            })
            ->rawColumns(['action' => 'action'])
            ->toJson();
    }

    public function create()
    {
        $thisYear = Carbon::today()->format('Y');
        $nextYear = Carbon::today()->addYear()->format('Y');

        return view('batches.create', compact('thisYear', 'nextYear'));
    }

    public function store()
    {
        $batchData = request()->validate([
            'batch' => ['required', 'string', 'max:255', 'unique:batches'],
            'status' => '',
            'm1' => '',
            'm2' => '',
            'm3' => '',
            'm4' => '',
            'm5' => '',
            'm6' => '',
            'm7' => '',
            'm8' => '',
            'm9' => '',
            'm10' => '',
            'm11' => '',
            'm12' => '',
            'm13' => '',
            'm14' => '',
            'm15' => '',
            'm16' => '',
            'm17' => '',
            'm18' => '',
        ]);

        $batch = request('batch');
        $batchSession = strstr($batch, '/', true);
        $batchYear = substr($batch, 2);

        if ($batchSession == 1) {
            $month = 1;
        } elseif ($batchSession == 2) {
            $month = 7;
        }

        $tempStartDate = Carbon::createFromDate($batchYear, $month, 1);
        $startDate = $tempStartDate->format('FY');

        $tempEndDate = $tempStartDate->addMonths(17);
        $endDate = $tempEndDate->format('FY');

        $period = CarbonPeriod::create($startDate, '1 month', $endDate);
        $countVariable = 1;

        foreach ($period as $key => $date) {
            $ {"m" . $countVariable++} = $date->format("FY");
        }

        /*$batchFolderName = str_replace('/', '.', $batch);
        $batchFolderPath = public_path() . '/record/' . $batchFolderName;
        File::makeDirectory($batchFolderPath, true, true);*/

        Batch::create([
            'batch' => $batchData['batch'],
            'm1' => $m1,
            'm2' => $m2,
            'm3' => $m3,
            'm4' => $m4,
            'm5' => $m5,
            'm6' => $m6,
            'm7' => $m7,
            'm8' => $m8,
            'm9' => $m9,
            'm10' => $m10,
            'm11' => $m11,
            'm12' => $m12,
            'm13' => $m13,
            'm14' => $m14,
            'm15' => $m15,
            'm16' => $m16,
            'm17' => $m17,
            'm18' => $m18,
        ]);

        return redirect('/b/create')->with('success', 'New Batch Created');
    }

    public function getBatches1()
    {
        $batchData1= Batch::whereRaw('SUBSTRING(batch, 1,  1) = 1')->get();

        return response()->json($batchData1);
    }

    public function getBatches2()
    {
        $batchData2 = Batch::whereRaw('SUBSTRING(batch, 1,  1) = 2')->get();

        return response()->json($batchData2);
    }

    public function getRecords(Request $request)
    {
        $recordData = array(
            array(
                'id' => '1?' . $request->batch . '',
                'semester' => 'Semester 1'
            ),
            array(
                'id' => '2?' . $request->batch . '',
                'semester' => 'Semester 2'
            ),
            array(
                'id' => '3?' . $request->batch . '',
                'semester' => 'Semester 3'
            ),
            //"Industrial Training" => '4?' . $batch . ''
        );

        return response()->json($recordData);
    }

    public function getRecordMonths(Request $request)
    {
        $tempRecord = $request->record;
        $batch = substr($tempRecord, 2);
        $session = strstr($batch, '/', true);
        $year = substr($batch, 2);
        $semester = strstr($tempRecord, '?', true);
        $newYearSemester = $year + 1;

        if ($session == 1) {
            if ($semester == 1) {
                $recordMonthData = array(
                    array(
                        'id' => 'January' . $year . '',
                        'month' => 'January ' . $year . ''
                    ),
                    array(
                        'id' => 'February' . $year . '',
                        'month' => 'February ' . $year . ''
                    ),
                    array(
                        'id' => 'March' . $year . '',
                        'month' => 'March ' . $year . ''
                    ),
                    array(
                        'id' => 'April' . $year . '',
                        'month' => 'April ' . $year . ''
                    ),
                    array(
                        'id' => 'May' . $year . '',
                        'month' => 'May ' . $year . ''
                    ),
                    array(
                        'id' => 'June' . $year . '',
                        'month' => 'June ' . $year . ''
                    ),
                );
            } elseif ($semester == 2) {
                $recordMonthData = array(
                    array(
                        'id' => 'July' . $year . '',
                        'month' => 'July ' . $year . ''
                    ),
                    array(
                        'id' => 'August' . $year . '',
                        'month' => 'August ' . $year . ''
                    ),
                    array(
                        'id' => 'September' . $year . '',
                        'month' => 'September ' . $year . ''
                    ),
                    array(
                        'id' => 'October' . $year . '',
                        'month' => 'October ' . $year . ''
                    ),
                    array(
                        'id' => 'November' . $year . '',
                        'month' => 'November ' . $year . ''
                    ),
                    array(
                        'id' => 'December' . $year . '',
                        'month' => 'December ' . $year . ''
                    ),
                );
            } elseif ($semester == 3) {
                $recordMonthData = array(
                    array(
                        'id' => 'January' . $newYearSemester . '',
                        'month' => 'January ' . $newYearSemester . ''
                    ),
                    array(
                        'id' => 'February' . $newYearSemester . '',
                        'month' => 'February ' . $newYearSemester . ''
                    ),
                    array(
                        'id' => 'March' . $newYearSemester . '',
                        'month' => 'March ' . $newYearSemester . ''
                    ),
                    array(
                        'id' => 'April' . $newYearSemester . '',
                        'month' => 'April ' . $newYearSemester . ''
                    ),
                    array(
                        'id' => 'May' . $newYearSemester . '',
                        'month' => 'May ' . $newYearSemester . ''
                    ),
                    array(
                        'id' => 'June' . $newYearSemester . '',
                        'month' => 'June ' . $newYearSemester . ''
                    ),
                );
            }
        } elseif ($session == 2) {
            if ($semester == 1) {
                $recordMonthData = array(
                    array(
                        'id' => 'July' . $year . '',
                        'month' => 'July ' . $year . ''
                    ),
                    array(
                        'id' => 'August' . $year . '',
                        'month' => 'August ' . $year . ''
                    ),
                    array(
                        'id' => 'September' . $year . '',
                        'month' => 'September ' . $year . ''
                    ),
                    array(
                        'id' => 'October' . $year . '',
                        'month' => 'October ' . $year . ''
                    ),
                    array(
                        'id' => 'November' . $year . '',
                        'month' => 'November ' . $year . ''
                    ),
                    array(
                        'id' => 'December' . $year . '',
                        'month' => 'December ' . $year . ''
                    ),
                );
            } elseif ($semester == 2) {
                $recordMonthData = array(
                    array(
                        'id' => 'January' . $newYearSemester . '',
                        'month' => 'January ' . $newYearSemester . ''
                    ),
                    array(
                        'id' => 'February' . $newYearSemester . '',
                        'month' => 'February ' . $newYearSemester . ''
                    ),
                    array(
                        'id' => 'March' . $newYearSemester . '',
                        'month' => 'March ' . $newYearSemester . ''
                    ),
                    array(
                        'id' => 'April' . $newYearSemester . '',
                        'month' => 'April ' . $newYearSemester . ''
                    ),
                    array(
                        'id' => 'May' . $newYearSemester . '',
                        'month' => 'May ' . $newYearSemester . ''
                    ),
                    array(
                        'id' => 'June' . $newYearSemester . '',
                        'month' => 'June ' . $newYearSemester . ''
                    ),
                );
            } elseif ($semester == 3) {
                $recordMonthData = array(
                    array(
                        'id' => 'July' . $newYearSemester . '',
                        'month' => 'July ' . $newYearSemester . ''
                    ),
                    array(
                        'id' => 'August' . $newYearSemester . '',
                        'month' => 'August ' . $newYearSemester . ''
                    ),
                    array(
                        'id' => 'September' . $newYearSemester . '',
                        'month' => 'September ' . $newYearSemester . ''
                    ),
                    array(
                        'id' => 'October' . $newYearSemester . '',
                        'month' => 'October ' . $newYearSemester . ''
                    ),
                    array(
                        'id' => 'November' . $newYearSemester . '',
                        'month' => 'November ' . $newYearSemester . ''
                    ),
                    array(
                        'id' => 'December' . $newYearSemester . '',
                        'month' => 'December ' . $newYearSemester . ''
                    ),
                );
            }
        }

        return response()->json($recordMonthData);
    }
}
