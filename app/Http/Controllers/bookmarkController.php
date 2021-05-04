<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class bookmarkController extends Controller
{
    public function view(){
        $bookmarks = Bookmark::where('user_id', '=', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('bookmark.index',[
            'bookmarks'=>$bookmarks,
        ]);
    }
    public function addBookmark($id){
        $count = Bookmark::where('product_id', '=', $id)->count();
        if($count===0){
            $bookmark = new Bookmark();
            $bookmark->product_id=$id;
            $bookmark->user_id=Auth::id();
            $bookmark->save();

            return redirect()->route('product.view', $id)->with('success', "Successfully added this product to your bookmarks ");
            }
        else{
            return redirect()->route('product.view', $id)->with('error', "Already in your bookmarks");
        }

    }   
    public function edit(){ //lets you add a note to bookmarks? not relevant rn

    }
    public function update(){ //relevant when we include notes for bookmarks

    }
    public function delete($id){
        $bookmark = Bookmark::where('id', '=', $id)->first();
        return view('bookmark.delete',[
            'bookmark'=>$bookmark,
        ]);
    }

    public function deleteFinal($id){
        $bookmark = Bookmark::where('id','=',$id)->first();
        Bookmark::where('id','=',$id)->delete();
        return redirect()->route('bookmark.index')->with('success', "Successfully deleted bookmark entry: {$bookmark->product->name} ");
    }
}
