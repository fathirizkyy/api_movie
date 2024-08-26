<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $movies=Movie::with('genre')->get()->map(function($movie){
            return[
                'id' => $movie->id,
            'title' => $movie->title,
            'sinopsis' => $movie->sinopsis,
            'rilis' => $movie->rilis,
            'genre' => $movie->genre, // Memindahkan genre ke atas
            'created_at' => $movie->created_at,
            'updated_at' => $movie->updated_at,
            ];
        });
        if($movies->isEmpty()){
            return response()->json([
                'message'=>'data tidak tersedia',
            ]);
        }

        return response()->json([
            $movies,200
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data=New Movie();
        $rules=[
            'title'=>'required',
            'sinopsis'=>'required',
            'rilis'=>'required',
            'genre_id'=>'required'
        ];
        $validator=Validator::make($request->all(),$rules);

        if($validator->fails()){
            return response()->json([
                'message'=>'anda belum mengisi seluruh kolom',
                'error'=>$validator->errors()
            ],422);
        }
        $data->title=$request->title;
        $data->sinopsis=$request->sinopsis;
        $data->rilis=$request->rilis;
        $data->genre_id=$request->genre_id;
        $data->save();
        return response()->json([
            'message'=>'berhasil menambahkan data',
            'data'=>$data
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $movie=Movie::with('genre')->find($id);
        
        if(is_null($movie)){
            return response()->json([
                'message'=>'movie not found'
            ],404);
        }
        $data=[
            'id' => $movie->id,
            'title' => $movie->title,
            'sinopsis' => $movie->sinopsis,
            'rilis' => $movie->rilis,
            'genre' => $movie->genre, // Memindahkan genre ke atas
            'created_at' => $movie->created_at,
            'updated_at' => $movie->updated_at,
        ];

        return response()->json([
                $data,200
            ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $rules=$request->validate([
            'title'=>'sometimes',
            'sinopsis'=>'sometimes',
            'rilis'=>'sometimes',
            'genre_id'=>'sometimes'
        ]);

        $movie=Movie::with('genre')->find($id);
        if(is_null($movie)){
            return response()->json([
                'messsage'=>'movie not found'
            ],404);
        }
        $movie->update($rules);
        $data=[
            'id' => $movie->id,
            'title' => $movie->title,
            'sinopsis' => $movie->sinopsis,
            'rilis' => $movie->rilis,
            'genre' => $movie->genre, // Memindahkan genre ke atas
            'created_at' => $movie->created_at,
            'updated_at' => $movie->updated_at,
        ];

        return response()->json($data,200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $movie=Movie::find($id);
        if(is_null($movie)){
            return response()->json([
                'message'=>'movie not found'
            ],404);
        }

        $movie->delete();
        return response()->json([
            'message'=>'data berhasil di hapus'
        ]);
    }
}
