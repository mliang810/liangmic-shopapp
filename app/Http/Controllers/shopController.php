<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Cart_content;
use App\Models\Invoice_content;
use Illuminate\Support\Facades\Storage;
use App\Models\Maintenance;
use App\Models\Product;
use App\Models\Role;
use App\Models\Shop;
use App\Models\Shop_content;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class shopController extends Controller
{
    public function viewAll(){ //view all shop names in directory
        $shops = Shop::all();
        return view('shop.index',[
            'shops'=>$shops,
        ]);
    }
    public function view($id){
        $products = Shop::with(['shop_content']) //product
            ->join('shop_contents', 'shop_contents.shop_id', '=', 'shops.id')
            ->join('products', 'shop_contents.product_id', '=', 'products.id')
            ->where('shops.id', '=', $id)
            ->orderBy('products.created_at')
            ->get([
                'products.description as description',
                'products.price as price', 
                'products.id as id',
                'products.category_id as category_id',
                'products.user_id as user_id',
                'products.name as name',
                'products.product_image as product_image',
            ]);
        $shop=Shop::where('id', '=', $id)->first();
        $categories=Shop::join('shop_contents', 'shop_contents.shop_id', '=', 'shops.id')
            ->join('products', 'shop_contents.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            // ->with(['category', 'product', 'shop_content'])
            ->with('shop_content') //product
            ->where('shop_contents.shop_id','=', $shop->id)
            ->groupBy('categories.id')
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

    public function viewCat($id, $category_id){ //if a category is selected -- can combine with view function if you have time to do optional vars. maybe change cat id to cat name too
        $products = Shop::with(['shop_content']) //product
            ->join('shop_contents', 'shop_contents.shop_id', '=', 'shops.id')
            ->join('products', 'shop_contents.product_id', '=', 'products.id')
            ->where('shops.id', '=', $id)
            ->where('products.category_id', '=', $category_id)
            ->orderBy('products.created_at')
            ->get([
                'products.description as description',
                'products.price as price', 
                'products.id as id',
                'products.category_id as category_id',
                'products.user_id as user_id',
                'products.name as name',
                'products.product_image as product_image',
            ]);
        $shop=Shop::where('id', '=', $id)->first();
        $categories=Shop::join('shop_contents', 'shop_contents.shop_id', '=', 'shops.id')
            ->join('products', 'shop_contents.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            // ->with(['category', 'product', 'shop_content'])
            ->with('shop_content') //product
            ->groupBy('categories.id')
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

    // NOTE: SWITCH THIS TO JAVASCRIPT LATER...UNNECCESSARY
    public function edit_on($id){ //edit shop contents 
        //if edit_mode == 0, not editing. if its 1, editing feautures become apparent. 
        // directions for editing become visible
        $shop=Shop::where('id', '=', $id)->first();
        $shop->edit_mode=1;
        $shop->save();
        return redirect()->route('shop.view', $shop->id);
        
    }

    public function edit_off($id){
        $shop=Shop::where('id', '=', $id)->first();
        $shop->edit_mode=0;
        $shop->save();
        return redirect()->route('shop.view', $shop->id);
    }

    public function update($id, Request $request){
        $shop = Shop::where('id', '=', $id)->first();
        $this->authorize('editMyShop', [User::class, $shop]);
        $request->validate([
            'banner_image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'shopName' => 'required|max:50',
            'shopDescription'=>'nullable|max:250',
        ]);

        if(null !== $shop->banner_image){ //if theres already an image, delete it from the directory before replacing it
            $filename = $shop->banner_image;
            if(is_file('public/shop_banners/'.$filename)){
                unlink(storage_path('public/shop_banners/'.$filename));
            }
        }

        // $this->authorize('editMyShop', [$user, $shop]);
        if(null !== $request->file('banner_image')){
            if($request->hasFile('banner_image')){
                // $path= $request->file('banner_image');    //Get file from the browser 
                // $img = Image::make($path)->encode();  // Resize and encode to required type ->resize(500,500)      
                // $filename = time(). '.' .$path->getClientOriginalExtension();  //Provide the file name with extension 
                // //Put file with own name
                // Storage::put($filename, $img);
                // //Move file to your location 
                // Storage::move($filename, 'public/shop_banners' . $filename);
                            
                // //now insert file name  into database 
                // $shop->banner_image = $filename;
                $path= $request->file('banner_image');
                $img = base64_encode(file_get_contents($request->file('banner_image')));
                $filename = time(). '.' .$path->getClientOriginalExtension();
                Storage::put($filename, base64_decode($img));
                Storage::move($filename, 'public/shop_banners/' . $filename);
                $shop->banner_image = $filename;
            }
        }
        else{
            $shop->banner_image = null;
        }
        $shop->shopName = $request->input('shopName');
        $shop->shopDescription = $request->input('shopDescription');
        $shop->save();

        return redirect()->route('shop.view', $shop->id);
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
                'description'=>'nullable|max:250',
            ]);

            $maint = new Maintenance();
            $maint->on = false;
            $maint->save();
                
            $shop = new Shop();
            $shop->shopName = $request->input('title');
            if(null !== $request->file('banner')){
                if($request->hasFile('banner')){
                    $path= $request->file('banner');
                    $img = base64_encode(file_get_contents($request->file('banner'))); // don't need to base decode. 
                    // leaving base decode function just in case i need it for something
                    $filename = time(). '.' .$path->getClientOriginalExtension();
                    Storage::put($filename, base64_decode($img)); //decoding what I just encoded
                    Storage::move($filename, 'public/shop_banners/' . $filename);
                    $shop->banner_image = $filename;
                }
            }
            $shop->user_id = Auth::id();
            $shop->shopDescription=$request->input('description');
            $shop->maintenance_id=$maint->getId();
            $shop->edit_mode=0;
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

    public function delete($id){
        $shop = Shop::where('id', '=', $id)->first();
        $this->authorize('editMyShop', [User::class, $shop]);
        return view('shop.delete',[
            'shop'=>$shop,
        ]);
    }
    public function deleteFinal($id){
        $shop = Shop::where('id', '=', $id)->first();
        $this->authorize('editMyShop', [User::class, $shop]);
        
        $shop_contents = Shop_content::where('shop_id','=', $id)->all();
        foreach($shop_contents as $entry){
            $prodID = $entry->product_id;
            Tag::where('product_id','=',$prodID)->delete();
            Shop_content::where('product_id','=',$prodID)->delete();
            Invoice_content::where('product_id','=',$prodID)->delete();
            Cart_content::where('product_id','=',$prodID)->delete();
            Bookmark::where('product_id','=',$prodID)->delete();
            Product::where('id','=',$prodID)->delete();
        }
        Shop_content::where('shop_id','=', $id)->delete();
        Shop::where('id', '=', $id)->delete();
        $user = Auth::user();
        $user->role_id = 1; //change user back to a shopper, rather than shop owner
        $user->save();

        return redirect()->route('home', $shop->id)->with('success', "Successfully deleted your shop: {$shop->name} ");
    }
}
