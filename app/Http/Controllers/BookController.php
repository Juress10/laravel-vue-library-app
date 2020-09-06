<?php

namespace App\Http\Controllers;

use App\Author;
use App\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{

    public function index()
    {
        $books = Book::with('author')->get()->toJson(JSON_PRETTY_PRINT);
        return response($books, 200);
    }

    public function create(Request $request)
    {
        try {
            $book = new Book([
                'title' => $request->title,
                'is_borrowed' => $request->is_borrowed
            ]);
            $book->author()->associate(Author::find($request->author['id']));
            $book->save();
            return $book;

        } catch(Exception $ex) {
            return response()->json(['error', 'Failed to create new book'], 403);
        }
    }

    public function show($id)
    {
        if (Book::where('id', $id)->exists()) {
            $book = Book::where('id', $id)->with('author')->get()->toJson(JSON_PRETTY_PRINT);
            return response($book, 200);
        } else {
            return response()->json([
                "message" => "Book not found"
            ], 404);
        }
    }

    public function update(Request $newBook)
    {
        if (Book::where('id', $newBook->id)->exists()) {
            $book = Book::find($newBook->id);

            $book->title = is_null($newBook->title) ? $book->title : $newBook->title;
            $book->is_borrowed = is_null($newBook->is_borrowed) ? $book->is_borrowed : $newBook->is_borrowed;
            $book->author()->associate(Author::find($newBook->author['id']));
            $book->save();

            return response()->json([
                "message" => "Book updated successfully"
            ], 200);
        } else {
            return response()->json([
                "message" => "Book not found"
            ], 404);
        }
    }

    public function delete(Request $request)
    {
        if(Book::where('id', $request->id)->exists()) {
            $book = Book::find($request->id);
            $book->delete();

            return response()->json([
                "message" => "Book deleted"
            ], 202);
        } else {
            return response()->json([
                "message" => "Book not found"
            ], 404);
        }
    }
}
