<?php

namespace App\Http\Controllers;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all(); // Modify based on your needs
        return view('employees.index', compact('employees'));
    }
    function validateEntries(Request $request){
        return $request->validate([
            'job_title_id' => 'required|integer',
            'salary' => 'required|numeric',
            'branch_id' => 'required|integer',
            'profile_id' => 'required|integer',
        ]) ;
    }
    public function employeeCreate(Request $request){
        Employee::create(EmployeeController::validateEntries($request));
        return redirect()->route('employees.index')->with('success', 'Employee created successfully!');
    }
    public function employeeUpdate(Request $request, $employeeId){
        $employee= Employee::findOrFail($employeeId);
        $fields= ['job_title_id', 'salary','branch_id' ];
        foreach($fields as $field){
            if($request->filled($field)){
                $employee->$field = EmployeeController::validateEntries($request->get($field));
}
        }
        $employee->update($request->all());
        return redirect()->route('employees.index')->with('success','Employee updated successfully!');
    }
}