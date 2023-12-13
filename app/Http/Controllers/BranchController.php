<?php

namespace App\Http\Controllers;

use App\Models\branch ;
use Illuminate\Http\Request;


class BranchController extends Controller
{
    public function index(){
        $branches = branch::all();
        return view('branches.index', compact('branches'));
    }

  function branchValidate(Request $request){
        $validated = $request->validate([
            
            'branch_name' => 'required|string|max:255',
            'address' => 'required|string',
            'city_id' => 'required|integer',
            'zip_code' => 'required|string|max:20',
            'manager_id' => 'required|integer',
        ]);
        return $validated;
    }
   public function branchCreate(Request $request){
       
        Branch::create(BranchController::branchValidate($request));
        return redirect()->route('branches.index')->with('success', 'Branch created successfully!');
    }

 public   function branchUpdate(Request $request, $branchId){
        $branch = Branch::findOrFail($branchId);
    
        $fields = ['branch_name', 'address', 'city_id', 'zip_code', 'manager_id'];
    
        foreach ($fields as $field) {
            if ($request->filled($field)) {
                $branch->$field = BranchController::branchValidate($request);
            }
        }
    
        $branch->save();
        return redirect()->route('profiles.index')->with('success', 'Branch updated successfully!');
    }
   public function branchDestroy($branchId){
    $deleteRequest = Branch::find($branchId);
   if(!auth()->user()->can('delete', $deleteRequest)){
    return(abort(403, 'Unauthorized access.'));
   }
   $deleteRequest->delete();
   // permanently delete the profile:
    //  $deleteRequest->forceDelete();
    return redirect()->route('profiles.index')->with('success', 'Branch deleted successfully!');

   }
    
}
