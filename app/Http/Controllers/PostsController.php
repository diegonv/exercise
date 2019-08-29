<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Posts;
use Auth;
use Illuminate\Support\Facades\Validator;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Posts::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:80',
            'subtitle' => 'required|string|max:80',
            'content' => 'required|string|max:255'
        ]);
    
        if ($validator->fails())
        {
            return response()->json(['error' => $validator->errors()->all()], 400);
        }

        $post = new Posts();
        $post->title = $request->title;
        $post->subtitle = $request->subtitle;
        $post->content = $request->content;
        $post->user_id = auth()->guard('api')->user()->id;
        $post->save();
        return $post;
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
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:80',
            'subtitle' => 'required|string|max:80',
            'content' => 'required|string|max:255'
        ]);
    
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $post = Posts::find($id);
        if (!$post) {
            return response()->json(['error' => "Not Found"], 404);
        }   

        $post->title = $request->title;
        $post->subtitle = $request->subtitle;
        $post->content = $request->content;
        $post->save();
        return $post;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Posts::destroy($id);
        if ($post) {
            return response()->json(null, 204);
        }   
        return response()->json(['error' => "Not Found"], 404);
    }
}
