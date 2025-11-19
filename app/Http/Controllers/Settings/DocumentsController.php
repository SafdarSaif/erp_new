<?php

namespace App\Http\Controllers\Settings;

use App\Models\Settings\Documents;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Models\Academics\University;

class DocumentsController extends Controller
{
        public function index(){
            if (request()->ajax()) {
                $bloodgroup = Documents::orderBy('id', 'desc')->get();

                return DataTables::of($bloodgroup)
                    ->addIndexColumn()
                    ->editColumn('status', fn($row) => $row->status ? 1 : 0)
                    ->addColumn('action', fn($row) => '')
                    ->make(true);
            }

            return view('Settings.documents.index');
        }

        public function create(){
            $universities = University::where('status',1)->get();
            return view('Settings.documents.create',compact('universities'));
        }
}
