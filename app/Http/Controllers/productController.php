<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Cart_content;
use App\Models\Category;
use App\Models\Invoice_content;
use App\Models\Product;
use App\Models\Shop;
use App\Models\Shop_content;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class productController extends Controller
{
    public function view($id){ //view individual product page
        $product=Product::where('id', '=', $id)->first();
        return view('product.view',[
            'product'=>$product,
        ]);
    }

    public function edit($id){     
        $product=Product::where('id', '=', $id)->first();
        $this->authorize('editProduct', [User::class, $product]);
        return view('product.edit',[
            'product'=>$product,
        ]);
    }

    public function update(Request $request, $id){
        $product=Product::where('id', '=', $id)->first();
        $this->authorize('editProduct', [User::class, $product]);
        $request->validate([
            'name'=>'required|max:50',
            'price'=>'required|numeric',
            'description'=>'required:max:1000',
            'product_photo'=>'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category'=>'required|max:30',
            'tags'=>'nullable|max:100'
        ]);
        if(null !== $product->product_image){
            $filename = $product->product_image;
            if(is_file('public/product_images/'.$filename)){
                unlink(storage_path('public/product_images/'.$filename));
            }
        }

        if(null !== $request->file('product_photo')){ //this outer statement is redundant
            if($request->hasFile('product_photo')){
                $path= $request->file('product_photo');
                $img = base64_encode(file_get_contents($request->file('product_photo')));
                $filename = time(). '.' .$path->getClientOriginalExtension();
                Storage::put($filename, base64_decode($img));
                Storage::move($filename, 'public/shop_banners/' . $filename);
                $product->product_image = $filename;
            }
        }
        $tags = $request->input('tags');
        if($product->tagStr !== $tags){ // if updated tagstr is different
            Tag::where('product_id','=',$id)->delete(); // delete old tags from tags table
            $product->tagStr = $tags;
            if(isset($tags) && !empty($tags)){
                foreach (explode(',', $tags) as $tag) {
                    $newTag = new Tag();
                    $newTag->name = $tag;
                    $newTag->product_id=$product->id;
                    $newTag->save();
                }
            }
        }
        
        $product->name=$request->input('name');
        $product->price=$request->input('price');
        $product->description=$request->input('description');
        
        $cat_input = ucfirst($request->input('category'));
        $category=Category::firstorCreate(['name'=>$cat_input]);

        $product->category_id=$category->id;
        
        
        $product->save();

        return redirect()->route('product.view', $product->id)->with('success', "Successfully updated product: {$product->name} ");

    }

    public function create(){
        $this->authorize('owner', User::class);
        return view('product.create');
    }

    public function store(Request $request){
        if ($request->user()->cannot('owner', User::class)) {
            redirect()->route('home')->with('error', 'You cannot create a product if you do not own a shop');
        }
        else{
            $request->validate([
                'name'=>'required|max:50',
                'price'=>'required|numeric',
                'description'=>'required:max:1000',
                'product_photo'=>'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'category'=>'required|max:30',
                'tags'=>'nullable|max:100'
            ]);
            $cat_input = ucfirst($request->input('category'));
            // $match = Category::where('name', '=', $cat_input)->count();
            // if($match>0){
            //     $category = Category::where('name', '=', $cat_input)->first();
            // }
            // else{
            //     $category = new Category();
            //     $category->name=$cat_input;
            //     $category->save();
            // }
            $category=Category::firstorCreate(['name'=>$cat_input]);

            $shop = Auth::user()->shop;

            $product= new Product();
            $product->user_id=Auth::user()->id; //stores creator
            $product->name=$request->input('name');
            $product->price=$request->input('price');
            $product->description=$request->input('description');
            if(null !== $request->file('product_photo')){
                if($request->hasFile('product_photo')){
                    $path= $request->file('product_photo');
                    $img = base64_encode(file_get_contents($request->file('product_photo'))); // don't need to base decode. 
                    // leaving base decode function just in case i need it for something
                    $filename = time(). '.' .$path->getClientOriginalExtension();
                    Storage::put($filename, base64_decode($img)); //decoding what I just encoded
                    Storage::move($filename, 'public/product_images/' . $filename);
                    $product->product_image = $filename;
                }
            }
            $product->category_id=$category->id;
            $product->save();
            
            $tags = $request->input('tags');
            $product->tagStr=$tags;
            if(isset($tags) && !empty($tags)){
                foreach (explode(',', $tags) as $tag) {
                    $newTag = new Tag();
                    $newTag->name = $tag;
                    $newTag->product_id=$product->id;
                    $newTag->save();
                }
            }


            $archive = new Shop_content();
            $archive->product_id=$product->id;
            $archive->shop_id=$shop->id;
            $archive->save();

            return redirect()->route('shop.view', $shop->id)->with('success', "Successfully created a new product entry: {$product->name} ");
        }


    }
    public function delete($id){ 
        $product = Product::where('id', '=', $id)->first();
        $this->authorize('editProduct', [User::class, $product]);
        return view('product.delete',[
            'product'=>$product,
        ]);
    }

    public function deleteFinal($id){
        $product = Product::where('id', '=', $id)->first();
        $this->authorize('editProduct', [User::class, $product]);
        $shop_id=$product->shop_contents->getId();
        $shop = Shop::where('id', '=', $shop_id)->first();
        // $affectedRows = User::where('votes', '>', 100)->delete();
        // delete tags associated with product id
        // delete it from shop contents
        // delete it from invoice contents
        //delete it from cart contents
        //delete it from bookmarks
        //delete product

        Tag::where('product_id','=',$id)->delete();
        Shop_content::where('product_id','=',$id)->delete();
        Invoice_content::where('product_id','=',$id)->delete();
        Cart_content::where('product_id','=',$id)->delete();
        Bookmark::where('product_id','=',$id)->delete();
        Product::where('id','=',$id)->delete();

        return redirect()->route('shop.view', $shop->id)->with('success', "Successfully deleted product entry: {$product->name} ");
    }
}
