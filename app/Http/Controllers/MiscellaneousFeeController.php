<?php

namespace App\Http\Controllers;

use App\Models\MiscellaneousFee;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MiscellaneousFeeController extends Controller
{
    public function create($id){
        $student = Student::with('feeStructures')->findOrFail($id);
        return view('accounts.fee.create_miscellaneous_fee',compact('id','student'));
    }

    public function edit($id){
        $mescellaneousFee = MiscellaneousFee::where('id',$id)->first();
        return view('accounts.fee.edit_miscellaneous_fee',compact('id','mescellaneousFee'));
    }

    public function update(Request $request){
        try{
            $validator = Validator::make($request->all(),[
                'head'=>'required|string',
                'amount'=>'required|integer|min:0',
                'semester'=>'required|string',
                'id'=>'required|exists:miscellaneous_fees,id'
            ]);
             if ($validator->fails()) {
                    return response()->json([
                        'status' => 'error',
                        'message' => $validator->errors()->first()
                    ], 422);
                }
             $miscellaneous = MiscellaneousFee::where('id',$request->id)->update([
                'head' => $request->head,
                'semester' => $request->semester,
                'amount' => $request->amount,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Miscellaneous fee updated successfully!',
                'data' => $miscellaneous
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'status'=>'error',
                'message'=>$e->getMessage()
            ]);
        }
    }

    public function store(Request $request){
        try{
            $validator = Validator::make($request->all(),[
                'head'=>'required|string',
                'amount'=>'required|integer|min:0',
                'semester'=>'required|string',
                'student_id'=>'required|exists:students,id'
            ]);
             if ($validator->fails()) {
                    return response()->json([
                        'status' => 'error',
                        'message' => $validator->errors()->first()
                    ], 422);
                }
             $miscellaneous = MiscellaneousFee::create([
                'head' => $request->head,
                'student_id' => $request->student_id,
                'semester' => $request->semester,
                'amount' => $request->amount,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Miscellaneous fee added successfully!',
                'data' => $miscellaneous
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'status'=>'error',
                'message'=>$e->getMessage()
            ]);
        }
    }
}
