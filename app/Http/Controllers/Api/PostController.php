<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Models\Media;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\PostDetailResource;

class PostController extends Controller
{

    // return posts data, also can filter with category and searchKey
    public function index(Request $request)
    {
        $query = Post::with('user','category','image')->orderBy('created_at','desc');

        if ($request->categoryId) {
            $query->where('category_id',$request->categoryId);
        };

        if ($request->searchKey) {
            $query->where(function($q) use($request)
            {
                $q->where('title', 'like', '%'.$request->searchKey.'%')
                  ->orwhere('description', 'like', '%'.$request->searchKey.'%');
            });
        };

        $posts = $query->paginate(10);

        return PostResource::collection($posts)->additional(['message' => 'Success']);
    }


    // return specify post detail
    public function showDetail($id)
    {
        $post = Post::with('user','category','image')->where('id', $id)->firstOrFail();
        return ResponseHelper::response(new PostDetailResource($post));
    }


    // return login user posts
    public function showUserPosts(Request $request)
    {
        $query = Post::with('user', 'category', 'image')->orderBy('created_at','desc')->where('user_id', Auth::user()->id);

        if ($request->categoryId) {
            $query->where('category_id',$request->categoryId);
        };

        if ($request->searchKey) {
            $query->where(function($q) use($request)
            {
                $q->where('title', 'like', '%'.$request->searchKey.'%')
                  ->orwhere('description', 'like', '%'.$request->searchKey.'%');
            });
        };

        $posts = $query->paginate(10);

        return PostResource::collection($posts)->additional(['message' => 'Success']);
    }


    // create post
    public function create(Request $request)
    { 
        // validation
        $request->validate($this->validation,$this->message);

        // to protect storing data to db not success
        DB::beginTransaction();
        
        try {

            $post = Post::create([
                'title' => $request->title,
                'description' => $request->description,
                'category_id' => $request->category_id,
                'user_id' => Auth::user()->id,
            ]);
    
            if ($request->hasFile('image')) {  

                $imgName = uniqid() . '_' . $request->file('image')->getClientOriginalName();
                $request->file('image')->storeAs('public/media', $imgName);
    
                Media::create([
                    'file_name' => $imgName,
                    'file_type' => 'image',
                    'model_id' => $post->id,
                    'model_type' => Post::class,
                ]);
            }

            DB::commit();
    
            return ResponseHelper::response(message: 'Post Creating Success!');

        } catch (Exception $err) {

            DB::rollback();
            
            return ResponseHelper::response(message: $err->getMessage(), status: 500);

        }
    }



    protected $validation = [
        'title' => 'required|string',
        'description' => 'required|string',
        'category_id' => 'required',
        'image' => 'mimes:png,jpg,jpeg,webp',
    ];

    protected $message = [
        'category_id.required' => 'The category field is required',
    ];
}
