<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Settings\AcademicYear;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class AcademicYearController extends Controller
{
    public function index(){
        if(Auth::user()->hasPermissionTo('view academic years')){
            try{
                if(request()->ajax()){
                    $data = AcademicYear::all();
                    return DataTables::of($data)
                    ->addIndexColumn()
                    ->make(true);
                }
                return view('settings.index');
            }catch(Exception $e){
                Log::warning('something wrong',[$e->getMessage()]);
                return response()->view('errors.403', [], 403);
            }
        }else{
            return response()->view('errors.403', [], 403);
        }
    }

    public function create(){
        try{
            if(Auth::user()->hasPermissionTo('create academic years')){
                return view('settings.create');
            }else{
                return response()->view('errors.403', [], 403);
            }
        }catch(Exception $e){
            Log::warning('error while creatig new academic year',[$e->getMessage()]);
        }
    }

    public function store(Request $request){
        try{
            if(Auth::user()->hasPermissionTo('create academic years')){
                Log::info('store academic years start',[$request->all]);

                    $store = AcademicYear::firstOrCreate(
                    ['name' => $request->name],
                    ['name' => $request->name]
                    );

                return response()->json([
                    'status' => 'success',
                    'message' => $store->name.' created successfull'
                ]);
            }else{
                return response()->view('errors.403', [], 403);
            }

        }catch(Exception $e){
            Log::warning('error while storing new academic year',[$e->getMessage()]);
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function edit($id){
        try{
            if(Auth::user()->hasPermissionTo('edit academic years')){
                $academicYear = AcademicYear::findOrFail($id);
                return view('settings.edit',compact('academicYear'));
            }else{
                return response()->view('errors.403', [], 403);
            }
        }catch(Exception $e){
                Log::warning('error while editing academic year',[$e->getMessage()]);
                return response()->json([
                    'status' => 'error',
                    'message' => $e->getMessage(),
                ]);
        }
    }

    public function update($id,Request $request){
        try{
            if(Auth::user()->hasPermissionTo('edit academic years')){
                Log::info('update academic years start',[$request->all]);
                $update = AcademicYear::where('id',$id)->update(['name'=>$request->name]);
                return response()->json([
                    'status' => 'success',
                    'message' => $request->name.' updated successfull'
                ]);
            }else{
                return response()->view('errors.403', [], 403);
            }
        }catch(Exception $e){
            Log::warning('error while updating academic year',[$e->getMessage()]);
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function status($id)
    {
        if (Auth::check() && Auth::user()->hasPermissionTo('edit academic years')) {
            try {
                $academicYear = AcademicYear::findOrFail($id);
                if ($academicYear) {
                $academicYear->status = $academicYear->status == 1 ? 0 : 1;
                $academicYear->save();
                return response()->json([
                    'status' => 'success',
                    'message' => $academicYear->name . ' status updated successfully!',
                ]);
                } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Academic Year not found',
                ]);
                }
            } catch (\Exception $e) {
                return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                ]);
            }
        }
    }

    public function delete($id){
        try{
            $academicYear = AcademicYear::destroy($id);
            if ($academicYear) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data deleted successfully!',
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Academic Year not found',
                ]);
            }
        }catch(Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                ]);
        }
    }
}
