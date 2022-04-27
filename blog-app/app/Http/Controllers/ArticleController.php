<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Photo;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;
//use http\Env\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

//use \Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
//        $this->middleware("isAdmin")->except('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()

    {
//        if (Auth::user()->role == 0){
//            $articles = Article::orderBy('id','desc')->paginate(10);
//        }else{
//            $articles = Article::where("user_id",Auth::id())->orderBy('id','desc')->paginate(10);
//        }



        $articles = Article::when(Auth::user()->role != 0,function ($query){
           $query->where('user_id',Auth::id());
        })->when(\request()->search,function ($query){
            $search_key = \request()->search;
            $query->where("title","LIKE","%$search_key%")->orWhere("description","LIKE","%$search_key%")->paginate(5);
        })->with(["getUser","getPhotos"])->orderBy('id','desc')->paginate(10);

        return view("article.index",compact('articles'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view("article.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreArticleRequest  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Request|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {

//        if (!$request->hasFile("photo")){
//            return redirect()->back()->withErrors(["photo.*"=>"The photo field is required"]);
//        }

        $request->validate(
            [
//                'title'=>"required|max:255|min:5",
//                'description'=>"required|min:5",
                'photo.*'=>"mimes:jpg,jpeg,png"
            ]
        );

        if ($request->hasFile("photo")){
            $fileNameArr = [];
            $files = $request->file("photo");
            foreach ($files as $file){

                $newFileName = uniqid()."_profile.".$file->getClientOriginalExtension();
                $dir = "public/article/";
                $file->StoreAs($dir,$newFileName);
                array_push($fileNameArr,$newFileName);
//            Storage::putFileAs($dir,$file,$newFileName);
//            Storage::put("/public/news",$f);
            }
        }
//        return $request;

        $arr = scandir(public_path("/storage/article"));

        $article = new Article;
        $article->title = $request->title;
        $article->description = $request->description;
        $article->user_id = Auth::id();
        $article->save();

        if ($request->hasFile("photo")){
            //        ef = each file
            foreach ($fileNameArr as $ef){
                $photo = new Photo();
                $photo->article_id = $article->id;
                $photo->location = $ef;
                $photo->save();
            }
        }


        return view("article.create",compact("arr"));
//        return redirect()->route("article.create")->with("status",compact("arr"));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {

        return view("article.show",compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return Article|\Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        return view("article.edit",compact('article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateArticleRequest  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        $request->validate([
            'title'=>"required|max:255|min:5",
            'description'=>"required|min:5",
        ]);
        $article->title = $request->title;
        $article->description = $request->description;
        $article->save();


        return redirect()->route("article.index")->with("status","$request->title is updated.");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return Article|\Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        if (\Illuminate\Support\Facades\Gate::allows('article-delete',$article)){
            if (isset($article->getPhotos)){
                $dir = "public/article/";
                foreach ($article->getPhotos as $p){
                    Storage::delete($dir.$p->location);
                }
                $toDel = $article->getPhotos->pluck('id');
                Photo::destroy($toDel);

            }
            $title = $article->title;
            $article->delete();

            return redirect()->route("article.index")->with("status"," $title is deleted");

        }
        return abort(404);

    }

//    public function search(\Illuminate\Http\Request $request){
//
////        return $request;
//        $search_key = $request->search;
//        $articles = Article::where("title","LIKE","%$search_key%")->orWhere("description","LIKE","%$search_key%")->paginate(5);
//        return view("article.index",compact('articles'));
//    }

}
