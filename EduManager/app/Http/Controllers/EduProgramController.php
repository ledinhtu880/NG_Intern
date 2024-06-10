<?php

namespace App\Http\Controllers;

use App\Http\Requests\EduProgram\EduProgramStoreRequest;
use App\Http\Requests\EduProgram\EduProgramUpdateRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\EduProgram;
use App\Models\Subject;

class EduProgramController extends Controller
{
    public function index()
    {
        if (!Session::has("type") && !Session::has("message")) {
            Session::flash('type', 'info');
            Session::flash('message', 'Quản lý môn học');
        }
        $data = DB::table('EduProgramView')->get();
        return view('eduProgram.index', compact('data'));
    }
    public function create()
    {
        return view('eduProgram.create');
    }
    public function store(EduProgramStoreRequest $request)
    {
        $validator = $request->validated();

        $subjectID = DB::select('exec GetNextSubjectId')[0]->NewSubjectId;
        Subject::create([
            'Id_Sub' => $subjectID,
            'Sym_Sub' => $validator['Sym_Sub'],
            'Name_Sub' => $validator['Name_Sub'],
        ]);

        $lessons = [
            ['FK_Id_LS' => 1, 'NumHour' => $validator['Theory']],
            ['FK_Id_LS' => 2, 'NumHour' => $validator['Exercise']],
            ['FK_Id_LS' => 3, 'NumHour' => $validator['Practice']],
        ];

        foreach ($lessons as $lesson) {
            EduProgram::createLesson($subjectID, $lesson['FK_Id_LS'], $lesson['NumHour']);
        }

        return redirect()->route('eduProgram.index')->with([
            'message' => 'Thêm môn học thành công.',
            'type' => 'success',
        ]);
    }
    public function edit(String $id)
    {
        $subject = Subject::find($id);
        $eduProgram = EduProgram::where('FK_Id_Sub', $subject->Id_Sub)->select('FK_Id_LS', 'NumHour')->get();

        $lessonTypes = [
            1 => 'Theory',
            2 => 'Exercise',
            3 => 'Practice',
        ];

        foreach ($eduProgram as $item) {
            $subject[$lessonTypes[$item->FK_Id_LS]] = $item->NumHour;
        }

        return view('eduProgram.edit', compact('subject'));
    }
    public function update(EduProgramUpdateRequest $request)
    {
        $validator = $request->validated();

        $eduProgram = DB::table('EduProgram')->where('FK_Id_Sub', $request->Id_Sub)->get();
        Subject::where('Id_Sub', $request->Id_Sub)->update([
            'Sym_Sub' => $validator['Sym_Sub'],
            'Name_Sub' => $validator['Name_Sub'],
        ]);
        foreach ($eduProgram as $each) {
            if ($each->FK_Id_LS == 1) {
                EduProgram::where('FK_Id_Sub', $request->Id_Sub)->where('FK_Id_LS', 1)->update(['NumHour' => $validator['Theory']]);
            } else if ($each->FK_Id_LS == 2) {
                EduProgram::where('FK_Id_Sub', $request->Id_Sub)->where('FK_Id_LS', 2)->update(['NumHour' => $validator['Exercise']]);
            } else if ($each->FK_Id_LS == 3) {
                EduProgram::where('FK_Id_Sub', $request->Id_Sub)->where('FK_Id_LS', 3)->update(['NumHour' => $validator['Practice']]);
            }
        }
        return redirect()->route('eduProgram.index')->with([
            'message' => 'Sửa môn học thành công.',
            'type' => 'success',
        ]);
    }
    public function destroy(Request $request)
    {
        $exists = DB::table('LessonSub')->where('FK_Id_Sub', $request->id)->exists();
        if ($exists) {
            return redirect()->route('EduProgram.index')->with([
                'message' => 'Phải xóa bài học trước khi xóa môn học.',
                'type' => 'warning',
            ]);
        } else {
            EduProgram::where('FK_Id_Sub', $request->id)->delete();
            Subject::where('Id_Sub', $request->id)->delete();
            return redirect()->route('eduProgram.index')->with([
                'message' => 'Xóa môn học thành công.',
                'type' => 'success',
            ]);
        }
    }
}
