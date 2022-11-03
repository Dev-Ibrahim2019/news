<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\TempNews;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $request = request();
        $news = News::with('category')->filter($request->query())->latest()->get();
        return view('dashboard.news.index', compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(News $news)
    {
        $category_news = News::with(['category']);
        $news = new News();
        return view('dashboard.news.create', compact('news', 'category_news'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(News::rules());
        $request->merge([
            'slug' => Str::slug($request->post('title'))
        ]);
        // dd($request->post('news_images'));
        $data = $request->except(['image', 'news_images']);
        $data['image'] = $this->uploadingImage($request);

        $news = new News();
        if ($request->hasFile('news_images')) {
            foreach($request->file('news_images') as $file) {
                $path = $file->storeAs('uploads/news', rand().'_'.time().'_'.$file->getClientOriginalName(), [
                'disk' => 'public'
                ]);
                $news->images()->create([
                    'news_images' => $path
                ]);
            }
        }
        News::create($data);
        return Redirect::route('dashboard.news.index')->with([
            'message' => 'News Created!',
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
            $news = News::with('category')
            ->where('id', '<>', $id)
            ->where(function ($query) use ($id) {
                $query->whereNull('category_id')
                ->orWhere('category_id', '<>', $id);
            })->findOrFail($id);
        } catch (Exception $e) {
            return redirect()->route('dashboard.news.index')->with([
                'message' => 'Record not found!',
                'type' => 'info'
            ]);
        }
        return view('dashboard.categories.edit', compact('news'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate(News::rules());

        $news = News::findOrFail($id);

        $old_image = $news->image;

        $data =  $request->except('image');

        $new_image = $this->uploadImage($request);
        if ($new_image) {
            $data['name'] = $new_image;
        }

        $news->update($data);

        if ($old_image && $new_image) {
            Storage::disk('public')->delete($old_image);
        }

        return redirect()->route('dashboard.news.index')->with([
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
    public function destroy(News $news)
    {
        // $news->delete();
        // return redirect()->back()->with([
        //     'message' => 'Deleted Successfully',
        //     'type' => 'success'
        // ]);
        $isDeleted = $news->delete();
        if ($isDeleted) {
            return response()->json([
                'title'=>'Success',
                'text'=>'Admin Deleted successfully',
                'icon'=>'success'
            ], Response::HTTP_OK);
        }else {
            return response()->json([
                'title'=>'Failed',
                'text'=>'Failed to delete',
                'icon'=>'error'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function uploadingImage(Request $request) {
        if (!$request->hasFile('image')) return;
        $file = $request->file('image');
        $path = $file->storeAs('uploads', rand().'_'.time().'_'.$file->getClientOriginalName(), [
            'disk' => 'public'
        ]);
        return $path;

        // if (!$request->hasFile('news_images')) return ;
        // foreach($request->file('news_images') as $file) {
        //     $path = $file->storeAs('uploads/news', rand().'_'.time().'_'.$file->getClientOriginalName(), [
        //         'disk' => 'public'
        //     ]);
        //     return $path;
        // }

        // if (!$request->hasFile($image)) return ;

        // // if(is_array($image))
        // foreach($request->file($image) as $file) {
        //     $path = $file->storeAs('uploads/news', rand().'_'.time().'_'.$file->getClientOriginalName(), [
        //         'disk' => 'public'
        //     ]);
        //     if (is_array($file)){
        //             $news = new News();
        //             $news->images()->create([
        //                 'news_images' => $path
        //             ]);
        //     }
        //     return $path;
        // }


    }


    public function trash() {
        $news = News::onlyTrashed()->filter(request()->query())->paginate();
        return view('dashboard.news.trash', compact('news'));
    }

    public function restore(Request $request, $id) {
        $news = News::onlyTrashed()->findOrFail($id);
        $news->restore();
        return redirect()->route('dashboard.news.trash')->with([
            'message' => 'News Successfully Retrieved!',
            'type' => 'success'
        ]);
    }

    public function forceDelete(News $news) {
        $news->onlyTrashed->forceDelete();
        if ($news->image) {
            Storage::disk('public')->delete($news->image);
        }

        return redirect()->route('dashboard.news.trash')->with([
            'message' => 'News Permanently Deleted!',
            'type' => 'error'
        ]);
    }

}
