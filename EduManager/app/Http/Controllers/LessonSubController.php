<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\LessonSub;

class LessonSubController extends Controller
{
    public function index()
    {
        if (!Session::has("type") && !Session::has("message")) {
            Session::flash('type', 'info');
            Session::flash('message', 'Quản lý bài học');
        }
        $subjects = DB::table('Subjects')->select('Sym_Sub', 'Name_Sub')->get();
        return view('lessonSub.index', compact('subjects'));
    }
    public function showSubjects(Request $request)
    {
        if ($request->ajax()) {
            $symSubject = $request->input('symSubject');
            $data = DB::table('LessonSubjectView')->where('Ký hiệu môn học', $symSubject)->get();
            $Id_Sub = DB::table('Subjects')->where('Sym_Sub', $symSubject)->value('Id_Sub');
            foreach ($data as $each) {
                $ids = DB::table('LessonSub')
                    ->join('Subjects', 'Subjects.Id_Sub', '=', 'LessonSub.FK_Id_Sub')
                    ->where('Sym_Sub', $symSubject)
                    ->where('Les_Unit', $each->{"Bài học"})
                    ->select('Id_Les', 'FK_Id_LS')->get();
                $each->ids = $ids;
            }

            return response()->json([
                'status' => 'success',
                'data' => $data,
                'Id_Sub' => $Id_Sub,
            ]);
        }
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->input('data');
            $Id_Sub = DB::table('Subjects')->where('Sym_Sub', $data['symSubject'])->value('Id_Sub');
            $data['Id_Sub'] = $Id_Sub;

            $newData = [];
            foreach ($data['lessons'] as $index => $lesson) {
                LessonSub::create([
                    'Les_Unit' => $data['lesUnit'],
                    'Les_Name' => $data['lesName'],
                    'FK_Id_Sub' => $Id_Sub,
                    'FK_Id_LS' => $lesson['FK_Id_LS'],
                    'NumHour' => $lesson['NumHour'],
                ]);
            }

            return response()->json([
                'status' => 'success',
                'data' => $newData,
            ]);
        }
    }
    public function checkAmount(Request $request)
    {
        if ($request->ajax()) {
            $symSubject = $request->input('symSubject');
            $Id_Sub = DB::table('Subjects')->where('Sym_Sub', $symSubject)->value('Id_Sub');
            $flag = true;

            $theoryNumHour = $request->input('theoryNumHour');
            $exerciseNumHour = $request->input('exerciseNumHour');
            $practiceNumHour = $request->input('practiceNumHour');

            $usedTheoryAmount = DB::table('LessonSub')->select(DB::raw('SUM(NumHour) as UsedAmount'))->where('FK_Id_Sub', $Id_Sub)->where('FK_Id_LS', 1)->value('UsedAmount');
            $usedExerciseAmount = DB::table('LessonSub')->select(DB::raw('SUM(NumHour) as UsedAmount'))->where('FK_Id_Sub', $Id_Sub)->where('FK_Id_LS', 2)->value('UsedAmount');
            $usedPracticeAmount = DB::table('LessonSub')->select(DB::raw('SUM(NumHour) as UsedAmount'))->where('FK_Id_Sub', $Id_Sub)->where('FK_Id_LS', 3)->value('UsedAmount');

            $totalTheory = DB::table('EduProgramView')->where("Mã môn học", $Id_Sub)->value("Lý thuyết");
            $totalExercise = DB::table('EduProgramView')->where("Mã môn học", $Id_Sub)->value("Bài tập");
            $totalPractice = DB::table('EduProgramView')->where("Mã môn học", $Id_Sub)->value("Thực hành");

            if ($theoryNumHour + $usedTheoryAmount > $totalTheory) {
                $flag = false;
                return response()->json([
                    'status' => 'success',
                    'flag' => $flag,
                    'message' => "Số giờ lý thuyết vượt quá số giờ lý thuyết của môn học."
                ]);
            } else if ($exerciseNumHour + $usedExerciseAmount > $totalExercise) {
                $flag = false;
                return response()->json([
                    'status' => 'success',
                    'flag' => $flag,
                    'message' => "Số giờ bài tập vượt quá số giờ bài tập của môn học."
                ]);
            } else if ($practiceNumHour + $usedPracticeAmount > $totalPractice) {
                $flag = false;
                return response()->json([
                    'status' => 'success',
                    'flag' => $flag,
                    'message' => "Số giờ thực hành vượt quá số giờ thực hành của môn học."
                ]);
            } else {
                return response()->json([
                    'status' => 'success',
                    'flag' => $flag,
                ]);
            }
        }
    }
    public function update(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->input('data');

            DB::table('LessonSub')
                ->whereIn('Id_Les', $data['idLes'])
                ->update([
                    'NumHour' => DB::raw("CASE
                                    WHEN FK_Id_LS = 1 THEN " . $data['theory'] . "
                                    WHEN FK_Id_LS = 2 THEN " . $data['exercise'] . "
                                    WHEN FK_Id_LS = 3 THEN " . $data['practice'] . "
                                END"),
                    'Les_Unit' => $data['lesUnit'],
                    'Les_Name' => $data['lesName']
                ]);

            return response()->json('success');
        }
    }
    public function destroy(Request $request)
    {
        if ($request->ajax()) {
            $idLes = $request->input('idLes');
            LessonSub::whereIn('Id_Les', $idLes)->delete();
            return response()->json('success');
        }
    }

    public function checkDuplicatedStore(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->input('data');
            $Id_Sub = DB::table('Subjects')->where('Sym_Sub', $data['symSubject'])->value('Id_Sub');

            $existsLessonUnit = LessonSub::where('FK_Id_Sub', $Id_Sub)->where('Les_Unit', $data['lesUnit'])->exists();
            $existsLessonName = LessonSub::where('FK_Id_Sub', $Id_Sub)->where('Les_Name', $data['lesName'])->exists();
            if ($existsLessonUnit && $existsLessonName) {
                return response()->json([
                    'status' => 'success',
                    'flag' => 1,
                    'message' => [
                        'Tên bài học đã tồn tại.',
                        'Tiêu đề bài học đã tồn tại.'
                    ]
                ]);
            } else if ($existsLessonName) {
                return response()->json([
                    'status' => 'success',
                    'flag' => 2,
                    'message' => 'Tiêu đề bài học đã tồn tại.'
                ]);
            }
            if ($existsLessonUnit) {
                return response()->json([
                    'status' => 'success',
                    'flag' => 3,
                    'message' => 'Tên bài học đã tồn tại.'
                ]);
            } else {
                return response()->json([
                    'status' => 'success',
                    'flag' => 0,
                ]);
            }
        }
    }
    public function checkDuplicatedUpdate(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->input('data');

            $existsLessonUnit = LessonSub::whereNotIn('Id_Les', $data['idLes'])->where('Les_Unit', $data['lesUnit'])->exists();
            $existsLessonName = LessonSub::whereNotIn('Id_Les', $data['idLes'])->where('Les_Name', $data['lesName'])->exists();
            if ($existsLessonUnit && $existsLessonName) {
                return response()->json([
                    'status' => 'success',
                    'flag' => 1,
                    'message' => [
                        'Tên bài học đã tồn tại.',
                        'Tiêu đề bài học đã tồn tại.'
                    ],
                    'lesName' => $data['lesName'],
                    'lesUnit' => $data['lesUnit'],
                ]);
            } else if ($existsLessonName) {
                return response()->json([
                    'status' => 'success',
                    'flag' => 2,
                    'message' => 'Tiêu đề bài học đã tồn tại.',
                    'lesName' => $data['lesName'],
                    'lesUnit' => $data['lesUnit'],
                ]);
            }
            if ($existsLessonUnit) {
                return response()->json([
                    'status' => 'success',
                    'flag' => 3,
                    'message' => 'Tên bài học đã tồn tại.',
                    'lesName' => $data['lesName'],
                    'lesUnit' => $data['lesUnit'],
                ]);
            } else {
                return response()->json([
                    'status' => 'success',
                    'flag' => 0,
                    'lesName' => $data['lesName'],
                    'lesUnit' => $data['lesUnit'],
                ]);
            }
        }
    }
}
