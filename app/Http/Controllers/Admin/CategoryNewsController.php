<?php

namespace App\Http\Controllers\Admin;

use App\Models\News\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Support\Str;

class CategoryNewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Category::latest()->paginate(10);
        return \view('admin.news.category.index',compact('data'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
//        dd('create');
        return \view('admin.news.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required',
        ]);

        $name = $request->input('name');
        $slug = $request->input('slug');

        if( $slug == '') {
            $slug = Str::slug($name,'-');
        }
//        Category::create($request->all());
        $catModel = new Category();
        $catModel->name = $name;
        $catModel->slug = $slug;

        $catModel->save();
        return redirect()->route('admin.news.category.index')
            ->with('success','Category created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CategoryNews  $categoryNews
     * @return \Illuminate\Http\Response
     */
    public function show(Category $categoryNews)
    {
        //
        dd('show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CategoryNews  $categoryNews
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
  //      dd('edit');
        return view('admin.news.category.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CategoryNews  $categoryNews
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required',
        ]);

        $category->update($request->all());

        return redirect()->route('admin.news.category.index')
            ->with('success','Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CategoryNews  $categoryNews
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
        $category->delete();

        return redirect()->route('admin.news.category.index')
            ->with('success','Category deleted successfully');
    }
}
