<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Helpers\Helper;
use App\Category;
use App\Product;
use App\Orderitems;
use Illuminate\Support\Facades\Validator;
use Session;
use File;
use DB;

class ProductController extends Controller
{   
    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show Users List.
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function productListView()
    {   
        
        return view('admin.user.product_list');
    }

    public function getProductlist(){
        $data = [];
        $getProduct = Product::leftjoin('category', 'category.id', '=', 'product.category_id')->select('product.*', 'category.name')->orderby('product.id','desc')->get()->toArray();
        
        if(count($getProduct) > 0){
            foreach ($getProduct as $product) {
                $date_time = date('d-m-Y H:i', strtotime($product['created_at']));
                $data[] = [$product['id'],$date_time, $product['image_url'], $product['title'], $product['name'], $product['product_description'], $product['product_price'], $product['product_status']."-".$product['id'], Helper::encrypt($product['id'])];
            }
        }

        return response()->json($data);
    }

    public function addProductUpdate(Request $request){
        $id = Helper::decrypt($request->product_update_id);
        if($request->title == ""){
            $msg = 'Please enter product name.';
            return Redirect::back()->with('message',$msg);
        }
        else if($request->product_description == ""){
            $msg = 'Please enter product description.';
            return Redirect::back()->with('message',$msg);
        }
        else if($request->product_price == ""){
            $msg = 'Please enter product price.';
            return Redirect::back()->with('message',$msg);
        }
        else if($request->category_id == ""){
            $msg = 'Please enter category name.';
            return Redirect::back()->with('message',$msg);
        }
        else if($request->image_url == ""){
            $msg = 'Please enter image.';
            return Redirect::back()->with('message',$msg);
        }
        else{
            
        if($id == ''){
            $this->validate($request, [
            'uploadFile' => 'required | max:9048',
        ]);
            if($request->hasFile('uploadFile'))
            {
                $allowedfileExtension=['jpeg','jpg','png','gif'];
                $image = $request->file('uploadFile');
                $filename = $image->getClientOriginalName();
                $extension = $image->getClientOriginalExtension();
                $check=in_array($extension,$allowedfileExtension);

                if($check)
                {
                    $name = time().'.'.$image->getClientOriginalExtension();
                    $image->move(public_path('cms_media').'/productimage', $name);
                    $newProduct = new Product();
                    $newProduct->category_id = $request->category_id;
                    $newProduct->product_description = $request->product_description;
                    $newProduct->title = $request->title;
                    $newProduct->product_price = $request->product_price;
                    $newProduct->image_url = $name;
                    $newProduct->product_status = $request->product_status;
                    $newProduct->save();
                    $msg = 'Product Added successfully.';
                        
                }else{
                    $msg = "File must be a image and it's should be jpeg,jpg,png,gif.";
                }
            }             
        }
        else{
            $checkproduct = Orderitems::where('product_id', $id)->first();
               $product_status = 'Active';
        if(empty($checkproduct)){
            $product_status = $request->product_status;
        } 
            if($request->hasFile('uploadFile'))
            {
               $this->validate($request, [
            'uploadFile' => 'required | max:9048',
        ]); 
                $allowedfileExtension=['jpeg','jpg','png','gif'];
                $image = $request->file('uploadFile');
                $filename = $image->getClientOriginalName();
                $extension = $image->getClientOriginalExtension();
                $check=in_array($extension,$allowedfileExtension);

                if($check)
                {   
                    $mediaPath = Product::select('image_url')->where('id', $id)->first();
                    $type = 'productimage';
                    $filePath = public_path("cms_media/{$type}/{$mediaPath->image_url}");
                    if (File::exists($filePath)) {
                    unlink($filePath);
                    }
                    $name = time().'.'.$image->getClientOriginalExtension();
                    $image->move(public_path('cms_media').'/productimage', $name);
                    Product::where('id',$id)->update(["category_id"=>$request->category_id,"title"=>$request->title,"product_description"=>$request->product_description,"product_price"=>$request->product_price,"image_url"=>$name,"product_status"=>$product_status]);
                    $msg = 'Product Updated successfully.';
                        
                }else{
                    $msg = "File must be a image and it's should be jpeg,jpg,png,gif.";
                }
            }   
            else{
                
             Product::where('id',$id)->update(["category_id"=>$request->category_id,"title"=>$request->title,"product_description"=>$request->product_description,"product_price"=>$request->product_price,"image_url"=>$request->image_url,"product_status"=>$product_status]);
             $msg = 'Product Updated successfully.';
        }
    }
        return Redirect::back()->with('message',$msg);
    }
        return Redirect::back()->with('error','Something wrong to update order.');
    }

    public function productStatuscheck($id,$status){
         $checkproduct = Orderitems::where('product_id', $id)->first();
        if(empty($checkproduct)){
            Product::where('id', $id)->update(["product_status"=>$status]);
        $msg = 'Product is Inactive Successfully.';
        if($status == "Active"){
            $msg = 'Product is Active Successfully';
        }
    }
    else{
        $msg = "You cannot change this Product status because user used this product.";
        }
        return response()->json(['status' => 'Success!','status_code' => 200,'msg' => $msg]);
    }

    public function getproductcategoryDetail(){
        $productcategory = Category::all();
        
        $output = '<option value="">Select</option>';
     foreach($productcategory as $category)
     {
      $output .= '<option value="'.$category->id.'">'.$category->name.'</option>';
     }
     echo $output;
    }
  
    public function deleteProduct($id)
    {   
         $productid = Helper::decrypt($id);
        $checkproduct = Orderitems::where('product_id', $productid)->first();
        if(empty($checkproduct)){
        $mediaPath = Product::select('image_url')->where('id', $productid)->first();
                    $type = 'productimage';
                    $filePath = public_path("cms_media/{$type}/{$mediaPath->image_url}");
                    if (File::exists($filePath)) {
                    unlink($filePath);
                    }
                    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
                    DB::table('product')->where('id', $productid)->delete();
                    DB::statement('SET FOREIGN_KEY_CHECKS=1;');        
                    $msg = "Product deleted successfully.";
        }
        else{
            $msg = "You cannot delete this Product because user used this product.";
        }
            Session::flash('message', $msg);
            $data = [];
            return response()->json($data);
    }

    public function deletemultiProduct($id)
    {   
        $mulproductids = explode(',', $id);
        $pusharray = array();
        $itemd_not_avi = "";
        $checkexits = array();
        for($i=0;$i<count($mulproductids);$i++)
        {   
            $checkproduct = Orderitems::where('product_id', $mulproductids[$i])->first();
            $mediaPath = Product::select('title','image_url')->where('id', $mulproductids[$i])->first();
            if(empty($checkproduct)){
            
                    $type = 'productimage';
                    $filePath = public_path("cms_media/{$type}/{$mediaPath->image_url}");
                    if (File::exists($filePath)) {
                    unlink($filePath);
                    }
                    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
                    DB::table('product')->where('id', $mulproductids[$i])->delete();
                    DB::statement('SET FOREIGN_KEY_CHECKS=1;');        
                    
        }
        else{

                $pusharray[] = $checkexits;
                $itemd_not_avi = $mediaPath->title." ".$itemd_not_avi;
            
        }    
        }
        if(sizeof($pusharray)) {
            $msg = $itemd_not_avi."You cannot delete this Product because user used this product,another product deleted";
        }
        else{$msg = "All Product deleted successfully.";}
        
                    Session::flash('message', $msg);
            $data = [];
             return response()->json($data);
    }

    public function getProductDetails($id){
        return Helper::getProductAllDetails($id);
    }
}
