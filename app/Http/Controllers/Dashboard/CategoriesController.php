<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $request = request();

        // $categories = Category::leftJoin('categories as parents', 'parents.id', '=', 'categories.parent_id')
        //     ->select([
        //         'categories.*',
        //         'parents.name as parent_name'
        //     ])
        //     ->filter($request->query())
        //     ->orderBy('categories.name')
        //     ->paginate();

        $categories = Category::filter($request->query())->orderBy('categories.name')->paginate();
        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parents = Category::all();
        $category = new Category();
        return view('dashboard.categories.create', compact('parents', 'category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $request->merge([
            'slug' => Str::slug($request->post('name'))
        ]);

        $data =  $request->except('image');

        $data['image'] = $this->uploadImage($request);

        // Mass assignment
        Category::create($data);

        //PRG (POST REDIRET GET)
        return Redirect::route('dashboard.categories.index')->with([
            'message' => 'Category Created.',
            'type' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $category = Category::findOrFail($id);
        } catch (Exception $e) {
            return redirect()->route('dashboard.categories.index')->with([
                'message' => 'Record not found!',
                'type' => 'info'
            ]);
        }
        // SELECT * FROM categories WHERE id <> $id
            // AND (parent_id IS NULL OR parent_id <> $id)
        $parents = Category::where('id', '<>', $id)
            ->where(function ($query) use ($id) {
                $query->whereNull('parent_id')
                    ->orWhere('parent_id', '<>', $id);
            })->get();
        return view('dashboard.categories.edit', compact('category', 'parents'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        $category = Category::findOrFail($id);

        $old_image = $category->image;

        $data =  $request->except('image');

        $new_image = $this->uploadImage($request);
        if ($new_image) {
            $data['name'] = $new_image;
        }

        $category->update($data);

        if ($old_image && $new_image) {
            Storage::disk('public')->delete($old_image);
        }

        return redirect()->route('dashboard.categories.index')->with([
            'message' => 'Updated Successfully',
            'type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->back()->with([
            'message' => 'Deleted Successfully',
            'type' => 'success'
        ]);
    }

    protected function uploadImage(Request $request) {
        if (!$request->hasFile('image')) return;
        $file = $request->file('image');
        $path = $file->storeAs('uploads', rand().'_'.time().'_'.$file->getClientOriginalName(), [
            'disk' => 'public'
        ]);
        return $path;
    }

    public function trash ()
    {
        $categories = Category::onlyTrashed()->filter(request()->query())->paginate();
        return view('dashboard.categories.trash', compact('categories'));
    }

    public function restore (Request $request, $id) {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();
        return redirect()->route('dashboard.categories.trash')->with([
            'message' => 'Record Successfully Retrieved!',
            'type' => 'success'
        ]);
    }

    public function forceDelete($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();

        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        return redirect()->route('dashboard.categories.trash')->with([
            'message' => 'Record Permanently Deleted!',
            'type' => 'error'
        ]);
    }
}
