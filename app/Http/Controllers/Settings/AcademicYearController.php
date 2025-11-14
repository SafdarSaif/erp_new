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
    public function index()
    {
        try {
            if (request()->ajax()) {
                $data = AcademicYear::all();
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->make(true);
            }
            return view('Settings.index');
        } catch (Exception $e) {
            Log::error('AcademicYearController@index - Error fetching list', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->view('errors.500', [], 500);
        }
    }

    public function create()
    {
        try {
            if (Auth::user()->hasPermissionTo('create academic years')) {
                return view('Settings.create');
            } else {
                Log::warning('Unauthorized access to create academic year', [
                    'user_id' => Auth::id(),
                    'user_name' => Auth::user()->name ?? 'Guest',
                ]);
                return response()->view('errors.403', [], 403);
            }
        } catch (Exception $e) {
            Log::error('AcademicYearController@create - Exception', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->view('errors.500', [], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            if (Auth::user()->hasPermissionTo('create academic years')) {
                Log::info('AcademicYearController@store - Request received', [
                    'user_id' => Auth::id(),
                    'data' => $request->all(),
                ]);

                $store = AcademicYear::firstOrCreate(
                    ['name' => $request->name],
                    ['name' => $request->name]
                );

                Log::info('AcademicYearController@store - Academic year created', [
                    'academic_year' => $store->name,
                    'created_by' => Auth::id(),
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => "{$store->name} created successfully",
                ]);
            }

            Log::warning('Unauthorized store attempt', ['user_id' => Auth::id()]);
            return response()->view('errors.403', [], 403);
        } catch (Exception $e) {
            Log::error('AcademicYearController@store - Exception', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => $request->all(),
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Error while storing academic year: ' . $e->getMessage(),
            ]);
        }
    }

    public function edit($id)
    {
        try {
            if (Auth::user()->hasPermissionTo('edit academic years')) {
                $academicYear = AcademicYear::findOrFail($id);
                return view('Settings.edit', compact('academicYear'));
            }

            Log::warning('Unauthorized edit attempt', ['user_id' => Auth::id()]);
            return response()->view('errors.403', [], 403);
        } catch (Exception $e) {
            Log::error('AcademicYearController@edit - Exception', [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Error while editing academic year: ' . $e->getMessage(),
            ]);
        }
    }

    public function update($id, Request $request)
    {
        try {
            if (Auth::user()->hasPermissionTo('edit academic years')) {
                Log::info('AcademicYearController@update - Request received', [
                    'id' => $id,
                    'data' => $request->all(),
                ]);

                $update = AcademicYear::where('id', $id)->update(['name' => $request->name]);

                Log::info('AcademicYearController@update - Update successful', [
                    'academic_year_id' => $id,
                    'updated_by' => Auth::id(),
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => "{$request->name} updated successfully",
                ]);
            }

            Log::warning('Unauthorized update attempt', ['user_id' => Auth::id()]);
            return response()->view('errors.403', [], 403);
        } catch (Exception $e) {
            Log::error('AcademicYearController@update - Exception', [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Error while updating academic year: ' . $e->getMessage(),
            ]);
        }
    }

    public function status($id)
    {
        try {
            if (Auth::check() && Auth::user()->hasPermissionTo('edit academic years')) {
                $academicYear = AcademicYear::findOrFail($id);
                $academicYear->status = $academicYear->status == 1 ? 0 : 1;
                $academicYear->save();

                Log::info('AcademicYearController@status - Status updated', [
                    'id' => $id,
                    'new_status' => $academicYear->status,
                    'updated_by' => Auth::id(),
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => "{$academicYear->name} status updated successfully!",
                ]);
            }

            Log::warning('Unauthorized status update attempt', ['user_id' => Auth::id()]);
            return response()->view('errors.403', [], 403);
        } catch (Exception $e) {
            Log::error('AcademicYearController@status - Exception', [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Error while updating status: ' . $e->getMessage(),
            ]);
        }
    }

    public function delete($id)
    {
        try {
            $academicYear = AcademicYear::destroy($id);

            if ($academicYear) {
                Log::info('AcademicYearController@delete - Record deleted', [
                    'id' => $id,
                    'deleted_by' => Auth::id(),
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Data deleted successfully!',
                ]);
            }

            Log::warning('Delete failed - record not found', ['id' => $id]);
            return response()->json([
                'status' => 'error',
                'message' => 'Academic Year not found',
            ]);
        } catch (Exception $e) {
            Log::error('AcademicYearController@delete - Exception', [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Error while deleting: ' . $e->getMessage(),
            ]);
        }
    }
}
