<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use App\Models\Product;
use App\Models\Role;
use App\Models\Shop;
use App\Models\Shop_content;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class shopController extends Controller
{
    public function viewAll(){ //view all shop names in directory

    }
    public function view($id){
        $products = Shop::join('shop_contents', 'shop_contents.shop_id', '=', 'shops.id')
            ->join('products', 'shop_contents.product_id', '=', 'products.id')
            ->with(['shop_content', 'product'])
            ->where('shops.id', '=', $id)
            ->orderBy('products.created_at')
            ->get([
                'products.description as description',
                'products.price as price', 
                'products.id as id',
                'products.category_id as category_id',
                'products.user_id as user_id',
                'products.name as name',
                'products.product_image as product_image'
            ]);
        $shop=Shop::where('id', '=', $id)->first();
        $categories=Shop::join('shop_contents', 'shop_contents.shop_id', '=', 'shops.id')
            ->join('products', 'shop_contents.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->with(['category', 'product', 'shop_content'])
            ->get([
                'categories.name as name',
                'categories.id as id',
            ]);
        return view('shop.view', [
            'products' => $products,
            'user' => Auth::user(),
            'shop'=>$shop,
            'categories'=>$categories,
        ]);
    }
    // public function view(Request $request, $id){ //view contents of individual shop. passes both $products in shop and $shop (like shop name, etc)
    //     $filter = $request->input('filter');

    //     if($filter){ //using scopes declared in product model --- most purchased, high to low price, low to high price
            // if($filter == "priceAsc"){
            //     $products = Shop::select('products.description as description', 'products.price as price')
            //         ->with(['shop_content', 'product'])
            //         ->join('shop_contents', 'shop_contents.shop_id', '=', 'shops.id')
            //         ->join('products', 'shop_contents.product_id', '=', 'products.id')
            //         ->where('shop_id', '=', $id)
            //         ->priceAsc()
            //         ->get();
    //         }
    //         if($filter == "priceDesc"){
    //             // $products = Product::priceDesc()
    //             //     ->get();
    //             $products = Shop::select('products.description as description', 'products.price as price')
    //                 ->with(['shop_content', 'product'])
    //                 ->join('shop_contents', 'shop_contents.shop_id', '=', 'shops.id')
    //                 ->join('products', 'shop_contents.product_id', '=', 'products.id')
    //                 ->where('shop_id', '=', $id)
    //                 ->priceDesc()
    //                 ->get();
    //         }
    //     }

    //     else{
    //         $products = Product::orderBy('created_at')->where('shop_id', '=', $id)->get();
    //     }

    //     return view('shop.view', [
    //         'products' => $products,
    //         'user' => Auth::user(),
    //     ]);
    // }

    public function viewCat($id, $category_id){ //if a category is selected
        $products = Shop::with(['shop_content', 'product'])
            ->join('shop_contents', 'shop_contents.shop_id', '=', 'shops.id')
            ->join('products', 'shop_contents.product_id', '=', 'products.id')
            ->where('shop_id', '=', $id)
            ->where('category_id', '=', $category_id)
            ->get();
    
        return view('shop.category', [
            'products' => $products,
        ]);
    }

    public function edit(){ //edit shop contents

    }

    public function update(){

    }

    public function create(){ //create shop
        return view('shop.create');
    }

    public function store(Request $request){ //save info after creation
        
        $user=Auth::user();
        $person = User::where('id', '=', $user->id)->first();
        if($person->role_id==1){
            $request->validate([
                'title' => 'required|max:50',
                'banner' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $maint = new Maintenance();
            $maint->on = false;
            $maint->save();
                
            $shop = new Shop();
            $shop->shopName = $request->input('title');
            $shop->banner_image = $request->input('banner');
            $shop->user_id = Auth::id();
            $shop->maintenance_id=$maint->getId();
            $shop->save();

            $user = User::where('id', '=', Auth::id())->first();
            $userRole = Role::getOwner(); //automatically a normal customer, unless they register a shop, in which case, get switched over to 
            $user->role()->associate($userRole);
            $user->save();
            
            return redirect()->route('shop.view', $shop->id);
            // return redirect()->route('shop.addProducts')->with('success', "Successfully created a new album entry: {$shop->title} ");
        }
        else{
            return redirect()->route('home')->with('error', 'You already have a shop');
        }


        
    }
}
