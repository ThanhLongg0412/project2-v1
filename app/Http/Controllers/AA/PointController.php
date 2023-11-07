<?php

namespace App\Http\Controllers\AA;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PointController extends Controller
{
    function indexClass(){
        $class_subjects = DB::table('class_subjects')
        ->join('classes', 'class_subjects.class_id', '=', 'classes.class_id')
        ->join('subjects', 'class_subjects.subject_id', '=', 'subjects.subject_id')
        ->select('class_subjects.*', 'classes.*', 'subjects.*')
        ->paginate(10);
        $classes = DB::table('classes')->get();
        $subjects = DB::table('subjects')->get();
        return view('academic_affairs.points.index_class', ['class_subjects' => $class_subjects, 'classes' => $classes, 'subjects' => $subjects]);
    }

    function indexSubject(Request $request){
        $class_id = $request->input('class_id');
        $class_subjects = DB::table('class_subjects')
            ->where('class_subjects.class_id', '=', $class_id)
            ->join('classes', 'class_subjects.class_id', '=', 'classes.class_id')
            ->join('subjects', 'class_subjects.subject_id', '=', 'subjects.subject_id')
            ->select('classes.*', 'subjects.*', 'class_subjects.*')
            ->paginate(10);
        $classes = DB::table('classes')->get();
        $subjects = DB::table('subjects')->get();
        return view('academic_affairs.points.index_subject', ['class_subjects' => $class_subjects, 'classes' => $classes, 'subjects' => $subjects]);
    }

    function indexPoint(Request $request){
        $cs_id = $request->input('cs_id');
        $points = DB::table('points')
            ->join('class_subject_students', 'points.css_id', '=', 'class_subject_students.css_id')
            ->join('users', 'class_subject_students.id', '=', 'users.id')
            ->join('class_subjects', 'class_subject_students.cs_id', '=', 'class_subjects.cs_id')
            ->where('class_subject_students.cs_id', '=', $cs_id)
            ->select('points.*', 'class_subject_students.*', 'users.*', 'class_subjects.*')->get();
        $class_subject_students = DB::table('class_subject_students')->get();
        $users = DB::table('users')->get();
        $class_subjects = DB::table('class_subjects')->get();
        return view('academic_affairs.points.index_point', ['class_subject_students' => $class_subject_students, 'class_subjects' => $class_subjects, 'users' => $users, 'points' => $points]);
    }

    public function saveData(Request $request)
    {
        $pointId = $request->input('pointId');
        $theory = $request->input('theory');
        $practice = $request->input('practice');
        $asm = $request->input('asm');
        $result = $request->input('result');

        DB::table('points')
            ->where('point_id', $pointId)
            ->update([
                'theory' => $theory,
                'practice' => $practice,
                'asm' => $asm,
                'result' => $result
            ]);

        return response()->json(['success' => true]);
    }
}
