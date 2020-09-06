<?php

namespace App\Http\Controllers;

use App\Author;
use App\Book;
use Illuminate\Http\Request;

class AuthorController extends Controller
{

    public function index()
    {
        $authors = Author::with('books')->get()->toJson(JSON_PRETTY_PRINT);
        return response($authors, 200);
    }

    public function create(Request $request)
    {
        $request->validate([
            'name'=>'required|string',
            'surname'=>'required|string'
        ]);
        try {
            $author = new Author([
                'name' => $request->name,
                'surname' => $request->surname
            ]);
            $author->save();
            return $author;

        } catch(Exception $ex) {
            return response()->json(['error', 'Failed to create new author'], 403);
        }
    }

    public function show($id)
    {
        if (Author::where('id', $id)->exists()) {
            $author = Author::where('id', $id)->with('books')->get()->toJson(JSON_PRETTY_PRINT);
            return response($author, 200);
        } else {
            return response()->json([
                "message" => "Author not found"
            ], 404);
        }
    }

    public function update(Request $author)
    {
        if (Author::where('id', $author->id)->exists()) {
            $oldAuthor = Author::find($author->id);

            $oldAuthor->name = is_null($author->name) ? $oldAuthor->name : $author->name;
            $oldAuthor->surname = is_null($author->surname) ? $oldAuthor->surname : $author->surname;
            $oldAuthor->save();

            return response()->json([
                "message" => "Author updated successfully"
            ], 200);
        } else {
            return response()->json([
                "message" => "Author not found"
            ], 404);
        }
    }


    public function delete(Request $request)
    {
        if(Author::where('id', $request->id)->exists()) {
            $author = Author::find($request->id);
            $author->delete();

            return response()->json([
                "message" => "Author deleted"
            ], 202);
        } else {
            return response()->json([
                "message" => "Author not found"
            ], 404);
        }
    }
}
