<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Helpers\Helper;
use App\Category;
use App\Product;
use App\Orderitems;
use Session;
use File;
use DB;

class CategoryController extends Controller
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
    public function categoryListView()
    {   
        
        return view('admin.user.category_list');
    }

    public function getCategorylist(){
        $data = [];
        $getCategory = Category::select('category.*')->orderby('id','desc')->get()->toArray();
        
        if(count($getCategory) > 0){
            foreach ($getCategory as $category) {
                $date_time = date('d-m-Y H:i', strtotime($category['created_at']));
                $data[] = [$category['id'],$date_time, $category['name'], $category['category_status']."-".$category['id'], Helper::encrypt($category['id'])];
            }
        }

        return response()->json($data);
    }

    public function addCategoryUpdate(Request $request){
        $id = Helper::decrypt($request->category_update_id);
        if($request->name == ""){
            $msg = 'Please enter category name.';
            return Redirect::back()->with('message',$msg);
        }
        else{
        if($id == ''){
            $newCategory = new Category();
                    $newCategory->name = $request->name;
                    $newCategory->category_status = $request->category_status;
                    $newCategory->save();
            $msg = 'Category Added successfully.';
            
        }
        else{
             Category::where('id',$id)->update(["name"=>$request->name,"category_status"=>$request->category_status]);
             $msg = 'Category Updated successfully.';
        }
        return Redirect::back()->with('message',$msg);
    }
        return Redirect::back()->with('error','Something wrong to update order.');
    }

    public function categoryStatuscheck($id,$status){
        Category::where('id', $id)->update(["category_status"=>$status]);
        //Product::where('category_id', $id)->update(["product_status"=>$status]);
        $msg = 'Category is Inactive Successfully.';
        if($status == "Active"){
            $msg = 'Category is Active Successfully';
        }
        return response()->json(['status' => 'Success!','status_code' => 200,'msg' => $msg]);
    }

    public function deleteCategory($id)
    {   
        $pusharray = array();
        $itemd_not_avi = "";
        $checkexits = array();
        $categoryid = Helper::decrypt($id);
        
        
        $productidllist = Product::where('category_id', $categoryid)->get()->toArray();
        
        foreach ($productidllist as $value) {
            $checkproduct = Orderitems::where('product_id', $value['id'])->first();
        if(empty($checkproduct)){
            $mediaPath = Product::select('image_url')->where('id', $value['id'])->first();
                    $type = 'productimage';
                    $filePath = public_path("cms_media/{$type}/{$mediaPath->image_url}");
                    if (File::exists($filePath)) {
                    unlink($filePath);
                    }
                    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
                    DB::table('product')->where('id', $value['id'])->delete();
                    DB::statement('SET FOREIGN_KEY_CHECKS=1;'); 
                    }

        else{

                $pusharray[] = $checkexits;
            
        }    
        }
              if(sizeof($pusharray)) {
            $msg = "You cannot delete this category because user used this category";
        } 
           else{ DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('category')->where('id', $categoryid)->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); 
        $msg = "Category deleted successfully."; }
            Session::flash('message', $msg);
            $data = [];
            return response()->json($data);
    }

    public function deletemultiCategory($id)
    {   
        $pusharray = array();
        $itemd_not_avi = "";
        $checkexits = array();
        $mulcategoryids = explode(',', $id);
        for($i=0;$i<count($mulcategoryids);$i++)
        {
            
        $checkproduct = Product::where('category_id', $mulcategoryids[$i])->first();
            if(empty($checkproduct)){
        $productidllist = Product::where('category_id', $mulcategoryids[$i])->get()->toArray();

        foreach ($productidllist as $value) {
            $checkproduct = Orderitems::where('product_id', $value['id'])->first();
             $mediaPath = Product::select('image_url')->where('id', $value['id'])->first();
                    $type = 'productimage';
                    $filePath = public_path("cms_media/{$type}/{$mediaPath->image_url}");
                    if (File::exists($filePath)) {
                    unlink($filePath);
                    }
                    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
                    DB::table('product')->where('id', $value['id'])->delete();
                    DB::statement('SET FOREIGN_KEY_CHECKS=1;'); 
                }
                    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('category')->where('id', $mulcategoryids[$i])->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); 
        } 
        else{

                $pusharray[] = $checkexits;
            
        }    
         
        }
        if(sizeof($pusharray)) {
            $msg = $itemd_not_avi."You cannot delete this category because user used this category,another category deleted";
        }
        else{$msg = "Category deleted successfully.";}
                    Session::flash('message', $msg);
            $data = [];
             return response()->json($data);
    }

    public function getCategoryDetails($id){
        return Helper::getCategoryAllDetails($id);
    }
}
