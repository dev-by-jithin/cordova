<?php

namespace App\Http\Controllers;

use App\Models\Post;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function getPosts(Request $request)
    {
        $query = $request->get('query');

        $data = DB::table('posts');

        if(!is_null($query)){

            $posts = $data->where('title', 'like', '%'.$query.'%');

            return response($posts->paginate(10), 200);
        }

        return response($data->paginate(10), 200);
    }


    public function store(Request $request)
    {
        $fields = $request->all();

        $errors = Validator::make($fields, [
            'title' => 'required',
            'content' => 'required'
        ]);

        if($errors->fails()){

            return response([
                $errors->errors()->all()
            ], 422);
        }

        $post = Post::create([
            'title' => $fields['title'],
            'content' => $fields['content']
        ]);

        return response([
            'post' => $post,
            'message' => 'The post has been created.'
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $fields = $request->all();

        $errors = Validator::make($fields, [
            'title' => 'required',
            'content' => 'required'
        ]);

        if($errors->fails()){
            return response($errors->errors()->all(), 422);
        }

        Post::where('id', $id)->update([
            'title' => $fields['title'],
            'content' => $fields['content']
        ]);

        return response([
            'message' => 'The post has been updated.'
        ], 200);
    }

    public function destroy(Request $request, $id)
    {
        Post::where('id', $id)->delete();

        return response(['message' => 'The post has been deleted'], 200);
    }

    public function uploadImage(Request $request)
    {
        $fields = $request->all();

        $errors = Validator::make($fields, [
            'postId' => 'required',
            'image' => 'required|image|max:2000'
        ]);

        if($errors->fails()){
            return response($errors->errors()->all(), 422);
        }

        if($request->hasFile('image')){
            
            $image = $request->file('image');

            $input['file'] = time().'.'.$image->getClientOriginalExtension();

            Storage::disk('public')
            ->put('images/'.$input['file'], file_get_contents($image));

            $imageURL = url('/').'/storage/images/'.$input['file'];

            Post::where('id', $fields['postId'])->update([
                'image' => $imageURL
            ]);

            return response(['message' => 'Image has been uploaded.']);
        }
    }
}
