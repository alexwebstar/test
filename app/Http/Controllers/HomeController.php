<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Validator;
use PDOException;

class HomeController extends Controller
{
    public function index()
    {
        return view('home.index', []);
    }

    public function get()
    {
        $data = Comment::withDepth()->get()->toTree();

        return response()->json(['data' => $data]);
    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->only(['parent_id', 'name', 'comment']), [
            'parent_id' => 'nullable|integer',
            'name' => 'required|string|max:255',
            'comment' => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json(['status' => 'error', 'message' => $validator->errors()], 200);
        }

        $data = new Comment();
        $data->parent_id = $request->parent_id;
        $data->name = $request->name;
        $data->comment = $request->comment;

        try {

            $data->save();
            $data->hasMoved();
            $data = Comment::withDepth()->get()->toTree();

        } catch (PDOException $e) {

            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 200);
        }

        return response()->json(['status' => 'ok', 'data' => $data], 200);
    }
}
