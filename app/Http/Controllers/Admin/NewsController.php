<?php

namespace App\Http\Controllers\Admin;

use App\Models\News\Category;
use App\Models\News\News;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = News::latest()->paginate(10);
        return \view('admin.news.index',compact('data'))
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
        $categories = Category::all();
        return \view('admin.news.create',compact('categories'));
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
            'subject' => 'required',
//            'preview_picture' => 'image|mimes:jpg,png,jpeg,gif,svg',
//            'detail_picture' => 'image|mimes:jpg,png,jpeg,gif,svg',
        ]);

        $subject = $request->input('subject');
        $slug = $request->input('slug');

        if( $slug == '') {
            $slug = Str::slug($subject,'-');
        }
        $pathPreviewPic = '';
        if( $request->file('preview_picture') ) {
            $name = $request->file('preview_picture')->getClientOriginalName();
            $pathPreviewPic = $request->file('preview_picture')->store('images/news');
        }
        $pathDetailPic = '';
        if( $request->file('detail_picture') ) {
            $name = $request->file('preview_picture')->getClientOriginalName();
            $pathDetailPic = $request->file('preview_picture')->store('images/news');
        }
//        Category::create($request->all());
        $newsModel = new News();
        $newsModel->subject = $subject;
        $newsModel->slug = $slug;
        $newsModel->preview_text = $request->input('preview_text');
        $newsModel->detail_text = $request->input('detail_text');
        $newsModel->preview_picture = $pathPreviewPic;
        $newsModel->detail_picture = $pathDetailPic;
        $newsModel->id_category = $request->input('idcategory');
        $newsModel->save();

        return redirect()->route('admin.news.index')
            ->with('success','News created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function show(News $news)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\news  $news
     * @return \Illuminate\Http\Response
     */
    public function edit(News $news)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\news  $news
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, news $News)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\news  $news
     * @return \Illuminate\Http\Response
     */
    public function destroy(News $news)
    {
        //
    }
}
