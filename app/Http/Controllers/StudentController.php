<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Batch;
use Illuminate\View\View;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $this->authorize('viewAny', Student::class);
        $students = Student::all();
        return view("students.index")->with("students", $students);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->authorize('create', Student::class);
        $batches = auth()->user()->role === 'teacher' 
        ? auth()->user()->teacherBatches 
        : Batch::all();

    
    return view('students.create', compact('batches'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', Student::class);
        $validated = $request->validate([
            'batch_id' => 'required|exists:batches,id',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'mobile' => 'required|string|max:20',
        ]);
            // Add other validation rules
        
        if (auth()->user()->role === 'teacher') {
            $batch = Batch::findOrFail($validated['batch_id']);
            if ($batch->teacher_id !== auth()->id()) {
                abort(403, 'Unauthorized action');
            }
        }
        Student::create($validated);
        return redirect('students')->with("flash_message", "Student Added!");
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student): View
    {
        $this->authorize('view', $student);
        return view("students.show")->with("students", $student);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student): View
    {
        $this->authorize('update', $student);
        if (auth()->user()->role === 'teacher' && 
        $student->batch->teacher_id !== auth()->id()) {
        abort(403);
    }

        return view('students.edit', compact('students'))->with('students', $student);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student): RedirectResponse
    {
        $this->authorize('update', $student);
        $input = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:students,email,'.$student->id,
            

            // Add other validation rules
        ]);
        $student->update($input);
        return redirect("students")->with("flash_message", "Student Updated!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student): RedirectResponse
    {
        $this->authorize('delete', $student);
        $student->delete();
        return redirect("students")->with("flash_message", "Student deleted!");
    }
}