namespace App\Http\Controllers\Settings;

use App\Models\Settings\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Exception;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $categories = Category::orderBy('id', 'desc')->get();
            return DataTables::of($categories)
                ->addIndexColumn()
                ->editColumn('status', fn($row) => $row->status ? 1 : 0)
                ->addColumn('action', fn($row) => '')
                ->make(true);
        }

        return view('Settings.category.index');
    }

    public function create()
    {
        return view('Settings.category.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100|unique:categories,name',
            'status' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            $category = Category::create([
                'name' => $request->name,
                'status' => $request->status ?? 1,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Category added successfully!',
                'data' => $category
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('Settings.category.edit', compact('category'));
    }

 
    public function destroy(Category $category)
    {
        try {
            $category->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Category deleted successfully!'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }

    public function toggleStatus(Category $category)
    {
        try {
            $category->status = !$category->status;
            $category->save();
            return response()->json(['status' => 'success', 'message' => 'Status updated successfully!']);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
