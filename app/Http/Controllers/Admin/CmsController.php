<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\SiteMedia;
use App\SitePages;
use App\Helpers\Helper;
use Session;
use File;


class CmsController extends Controller
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
    public function cmsDetailsView()
    {   
        $cms_data = array();
        // $getImages = SiteMedia::where('media_type','Image')->get();
        $getImages = SiteMedia::all();
        if($getImages){
            foreach ($getImages as $k => $v) {

                if($v->media_type == 'Image')
                    $cms_data['images'][] = ['media_name' =>$v->media_name, 'media_type' =>$v->media_type,'id' =>Helper::encrypt($v->id)];
                elseif($v->media_type == 'Video')
                    $cms_data['videos'][] = ['media_name' =>$v->media_name, 'media_type' =>$v->media_type,'id' =>Helper::encrypt($v->id)];
                else
                    $cms_data['logo'][] = ['media_name' =>$v->media_name, 'media_type' =>$v->media_type,'id' =>Helper::encrypt($v->id)];

            }
        }

        $getPrivacyPolicy = SitePages::where('page_title','Privacy Policy')->first();
        if($getPrivacyPolicy){

            $cms_data['Policy'] = ['page_title' =>$getPrivacyPolicy->page_title, 'page_content' =>$getPrivacyPolicy->page_content];
        }

        $getTerm = SitePages::where('page_title','Terms & Condition')->first();
        if($getTerm){

            $cms_data['Term'] = ['page_title' =>$getTerm->page_title, 'page_content' =>$getTerm->page_content];
        }

        $getshopkeeperno = SitePages::where('page_title','Shop Keeper Details')->first();
        $cms_data['Shopkeeperno'] = ['page_title' =>'', 'page_content' =>''];
        if(!empty($getshopkeeperno)){

            $cms_data['Shopkeeperno'] = ['page_title' =>$getshopkeeperno->page_title, 'page_content' =>$getshopkeeperno->page_content];
        }
        

        $getshopkeeperemail = SitePages::where('page_title','Shop Keeper Email')->first();
        $cms_data['Shopkeeperemail'] = ['page_title' =>'', 'page_content' =>''];
        if(!empty($getshopkeeperemail)){

            $cms_data['Shopkeeperemail'] = ['page_title' =>$getshopkeeperemail->page_title, 'page_content' =>$getshopkeeperemail->page_content];
        }

        //echo "<pre>";print_r($cms_data); exit;
        return view('admin.user.cms_details',['cms_data'=>$cms_data]);
    }

    public function imagesUploadPost(Request $request)
    {   
        $is_valid = 0;
        $this->validate($request, [
            'uploadFile' => 'required | max:2048',
        ]);
        if($request->hasFile('uploadFile'))
        {
            $allowedfileExtension=['jpeg','jpg','png','gif'];
            $files = $request->file('uploadFile');
            foreach($files as $key => $value){
                $filename = $value->getClientOriginalName();
                $extension = $value->getClientOriginalExtension();
                $check=in_array($extension,$allowedfileExtension);
                if($check)
                {
                        $imageName = time(). $key . '.' . $value->getClientOriginalExtension();
                        $value->move(public_path('cms_media').'/images', $imageName);
                        $mediamodel= new SiteMedia();
                        $mediamodel->media_name=$imageName;
                        $mediamodel->media_type="Image";
                        $mediamodel->save();
                        $is_valid = 1;
                }else{
                    $msg = "File must be a image and it's should be jpeg,jpg,png,gif.";
                }
            }
        }
        if($is_valid == 1){
            return Redirect::back()->with('message','Images Uploaded SuccessFully.');
        }else{
            return Redirect::back()->with('error',"File must be a image and it's should be jpeg,jpg,png,gif.");
        }
    }

    public function videoUploadPost(Request $request)
    {
        // request()->validate([
        //     'uploadVideo1' => 'required',
        //     'uploadVideo2' => 'required'
        // ]);
        $is_valid = 0;
        $allowedfileExtension=['flv','mp4','3gp','mov','avi'];

        $video1 = $request->file('uploadVideo1');
        $video2 = $request->file('uploadVideo2');
        if($video1){
            $extension = $video1->getClientOriginalExtension();
            $check=in_array($extension,$allowedfileExtension);
            if($check)
            {
                $videoName = rand().'.'.$video1->getClientOriginalExtension();
                $video1->move(public_path('cms_media').'/videos', $videoName);

                $mediamodel= new SiteMedia();
                $mediamodel->media_name = $videoName;
                $mediamodel->media_type = "Video";
                $mediamodel->save();

                $is_valid = 1;
            }
            else
            {
                $msg = "File must be a video and it's should be flv,mp4,3gp,mov,avi.";
            }
        }

        if($video2){
            $extension = $video2->getClientOriginalExtension();
            $check2=in_array($extension,$allowedfileExtension);
            if($check2)
            {
                $videoName2 = rand().'.'.$video2->getClientOriginalExtension();
                $video2->move(public_path('cms_media').'/videos', $videoName2);

                $mediamodel= new SiteMedia();
                $mediamodel->media_name = $videoName2;
                $mediamodel->media_type = "Video";
                $mediamodel->save();

                $is_valid = 1;
            }
            else
            {
                $msg = "File must be a video and it's should be flv,mp4,3gp,mov,avi.";
            }
        }

        if($is_valid == 1){
            return redirect('admin/cms#video')->with('message', 'Videos Uploaded SuccessFully.');
        }else{
            return redirect('admin/cms#video')->with('error',"File must be a video and it's should be flv,mp4,3gp,mov,avi.");
        }
        
    }


    public function deleteMedia($id)
    {   
        $mediaPath = SiteMedia::select('media_name','media_type')->where('id', Helper::decrypt($id))->first();
            if($mediaPath){
                if($mediaPath->media_type == 'Video'){
                    $type = 'videos';
                    $msg = "Video deleted successfully.";
                }elseif($mediaPath->media_type == 'Logo'){
                    $type = 'logo';
                    $msg = "Logo deleted successfully.";
                }else{
                    $type = 'images';
                    $msg = "Image deleted successfully.";
                }
                $filePath = public_path("cms_media/{$type}/{$mediaPath->media_name}");
                if (File::exists($filePath)) {
                    unlink($filePath);
                }
            }
            SiteMedia::where('id', Helper::decrypt($id))->delete();
            Session::flash('message', $msg);
            $data = [];
            return response()->json($data);
    }

    public function privacyUpdatePost(Request $request)
    {

        $privacy_content = $request->privacy_content;

        $sitepages = SitePages::firstOrCreate(['page_title' =>'Privacy Policy']);
        $sitepages->page_title = 'Privacy Policy';
        $sitepages->page_content = $privacy_content;
        $sitepages->save();
        return redirect('admin/cms#policy')->with('message', 'Privacy Policy Updated SuccessFully.');  
    }

    public function termUpdatePost(Request $request)
    {

        $term_content = $request->term_content;
        
        $sitepages = SitePages::firstOrCreate(['page_title' =>'Terms & Condition']);
        $sitepages->page_title = 'Terms & Condition';
        $sitepages->page_content = $term_content;
        $sitepages->save();
        return redirect('admin/cms#condition')->with('message', 'Terms & Condition Updated SuccessFully.');
    }

    public function shopkeeperUpdatePost(Request $request)
    {
 
        //$mobile_code = $request->mobile_code;
        $shopkeeper_number = $request->shopkeeper_number;
        $shopkeeper_email = $request->shopkeeper_email;
        //$shopkeeper_details = $mobile_code.' '.$shopkeeper_number;;
        
        $sitepages = SitePages::firstOrCreate(['page_title' =>'Shop Keeper Details']);
        $sitepages->page_title = 'Shop Keeper Details';
        $sitepages->page_content = $shopkeeper_number;
        $sitepages->save();

        $siteemailpages = SitePages::firstOrCreate(['page_title' =>'Shop Keeper Email']);
        $siteemailpages->page_title = 'Shop Keeper Email';
        $siteemailpages->page_content = $shopkeeper_email;
        $siteemailpages->save();
        return redirect('admin/cms#shopkeeper')->with('message', 'Shop Keeper Details Updated SuccessFully.');
    }
    public function logoUploadPost(Request $request)
    { 
        $validator = Validator::make($request->all(), [
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($validator->fails())
        {
            return redirect('admin/cms#logo')->withErrors($validator);
        }
        $mediamodel = SiteMedia::where('media_type','Logo')->first();
        if ($request->hasFile('logo')) {
            if($mediamodel){
            $logo = public_path("cms_media/logo/{$mediamodel->media_name}");
                if (File::exists($logo)) {
                    unlink($logo);
                }
            }
            $image = $request->file('logo');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('cms_media').'/logo';
            $image->move($destinationPath, $name);
            $mediamodel = SiteMedia::firstOrCreate(['media_type'=>'Logo']);
            $mediamodel->media_name=$name;
            $mediamodel->save();
            return redirect('admin/cms#logo')->with('message', 'Logo Uploaded SuccessFully.');
        }
    }

}
