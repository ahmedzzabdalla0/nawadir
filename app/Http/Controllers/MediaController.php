<?php

namespace App\Http\Controllers;

use App\Models\ImageType;
use Faker\Provider\File;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class MediaController extends Controller
{
    //
    private $isApiRequest;

    public function __construct(Request $request)
    {
        parent::__construct();
        $this->isApiRequest = ControllersService::isApiRoute($request);
    }

    public function index()
    {
        $media = Media::with(['user'])->get();
        if ($this->isApiRequest) {
            return ControllersService::generateArraySuccessResponse($media, "Success");
        } else {
            return view('', ['media' => $media]);
        }
    }
    public function saveMultiFileJsonNew(Request $request)
    {
        $this->validate($request,['uploaded_files.*'=>'image']);

        $temp=session('tempMultiImage');
        if(! is_array($temp)){
            $temp=[];
        }
        $files=[];
        $urls=[];
        if($request->oldData){
            $data=json_decode($request->oldData);
            if(is_array($data)){
                $files=$data;
                foreach ($data as $d){
                    $urls[]=url('uploads/'.$d);
                }
            }
        }


        if(is_array($request->uploaded_files)){
            foreach ($request->uploaded_files as $key=>$file){
                if($name=self::SaveFileM($file)){
                    $files[]=$name;
                    $urls[]=['index'=>$request->indexing[$key],'file'=>$name];
                    session(['tempMultiImage'=>$temp]);
                }else{
                    return ['status'=>0,'errors'=>'ERROR'];
                }
            }

            return ['result'=>json_encode($files),'resultNames'=>$files,'files'=>$urls,'status'=>1];
        }

        return ['status'=>0,'errors'=>'ERROR'];

    }
    public static function SaveFileM($file){
        if (isset($file)){
            $name=time().'_'.rand(1,999999999).'.'.$file->getClientOriginalExtension();

            $path=realpath('public/uploads')?realpath('public/uploads'):realpath('uploads');

            $originalImage= $file;
            $img = Image::make($originalImage);
            $originalPath = $path.'/';
            $detSize=ImageType::where('name','details')->first();
            $img->fit($detSize->width,$detSize->height);
            $img->save($originalPath.$name);
            return $name;
        }
        return '';

    }

    public function saveFileJson(Request $request)
    {

        $this->validate($request,['uploaded_file'=>'image']);

        $temp=session('tempImage');
        if(! is_array($temp)){
            $temp=[];
        }
        if($name=self::SaveFile($request->uploaded_file)){
            $temp[]=$name;
            session(['tempImage'=>$temp]);
            return ['filelink'=>asset('uploads/'.$name),'file_name'=>$name,'status'=>1];
        }else{
            return ['status'=>0,'errors'=>'ERROR'];
        }

    }
    public function saveVideoJson(Request $request)
    {

        $this->validate($request,['uploaded_file'=>'mimes:mp4']);

        $temp=session('tempImage');
        if(! is_array($temp)){
            $temp=[];
        }
        if($name=self::SaveVideo($request->uploaded_file)){
            $temp[]=$name;
            session(['tempImage'=>$temp]);
            return ['filelink'=>asset('uploads/'.$name),'file_name'=>$name,'status'=>1];
        }else{
            return ['status'=>0,'errors'=>'ERROR'];
        }

    }
    public function saveMultiFileJson(Request $request)
    {
        $this->validate($request,['uploaded_files.*'=>'image']);

        $temp=session('tempMultiImage');
        if(! is_array($temp)){
            $temp=[];
        }
        $files=[];
        $urls=[];
        if($request->oldData){
            $data=json_decode($request->oldData);
            if(is_array($data)){
                $files=$data;
                foreach ($data as $d){
                    $urls[]=url('uploads/'.$d);
                }
            }
        }


        if(is_array($request->uploaded_files)){
            foreach ($request->uploaded_files as $file){
                if($name=self::SaveFile($file)){
                    $files[]=$name;
                    $urls[]=asset('uploads/'.$name);
                    session(['tempMultiImage'=>$temp]);
                }else{
                    return ['status'=>0,'errors'=>'ERROR'];
                }
            }

            return ['result'=>json_encode($files),'resultNames'=>$files,'links'=>$urls,'my_server'=>url('/'),'status'=>1];
        }

        return ['status'=>0,'errors'=>'ERROR'];

    }
    public function saveMultiFileJson1(Request $request)
    {
        $this->validate($request,['uploaded_files.*'=>'image']);

        $temp=session('tempMultiImage');
        if(! is_array($temp)){
            $temp=[];
        }
        $files=[];
        $urls=[];
        $widths=[];
        $heights=[];
        if($request->oldData){
            $data=json_decode($request->oldData);
            $width_data=explode(',',$request->oldWidth);
            $height_data=explode(',',$request->oldHeight);

            if(is_array($data)){
                $files=$data;
                for ($i = 0;$i<count($data); $i++){
                    $urls[]=url('uploads/'.$data[$i]);
                    $widths[]=$width_data[$i];
                    $heights[]=$height_data[$i];
                }
            }
        }


        if(is_array($request->uploaded_files)){
            foreach ($request->uploaded_files as $file){
                if($name=self::SaveFile1($file)){
                    $files[]=$name[0];
                    $urls[]=asset('uploads/'.$name[0]);
                    $widths[]=$name[1];
                    $heights[]=$name[2];
                    session(['tempMultiImage'=>$temp]);
                }else{
                    return ['status'=>0,'errors'=>'ERROR'];
                }
            }

            return ['result'=>json_encode($files),'resultNames'=>$files,'links'=>$urls,'widths'=>$widths,'heights'=>$heights,'my_server'=>url('/'),'status'=>1];
        }

        return ['status'=>0,'errors'=>'ERROR'];

    }


    public function deleteUnUsedFile($image){
        $temp=$this->session('tempImage');
        if(is_array($image)){
            if(is_array($temp))
                foreach ($temp as $t){
                    if(array_search($t,$image) === false){
                        try{
                            unlink("./uploads/".$t);
                            unlink("./uploads/thumbnail/".$t);

                        }catch (\Exception $e){}
                    }

                }
            $this->session(['tempImage'=>[]]);
            return true;
        }else{
            if(is_array($temp))
                foreach ($temp as $t){
                    if($t != $image){
                        try{
                            unlink("./uploads/".$t);
                            unlink("./uploads/thumbnail/".$t);

                        }catch (\Exception $e){}
                    }

                }
            $this->session(['tempImage'=>[]]);
            return true;
        }

    }


    public function deleteUnUsedFiles($images){
        $temp=$this->session('tempMultiImage');
        if(is_array($temp))
            foreach ($temp as $t){
                if(! in_array($t,$images)){
                    try{
                        unlink("./uploads/".$t);
                        unlink("./uploads/thumbnail/".$t);

                    }catch (\Exception $e){}
                }

            }
        $this->session(['tempMultiImage'=>[]]);
        return true;
    }



    public function show(Request $request, $id)
    {
        $request->request->add(['id' => $id]);
        $this->validate($request, Media::$getRoles);

        $media = Media::with('user')->find($id);
        if ($this->isApiRequest) {
        } else {
            return view('', ['media' => $media]);
        }
    }

    public static function saveImageDirectly(Request $request, $objectType, $key = "image")
    {
        $file = $request->file($key);
        return self::SaveFile($file);
    }

    public static function saveVideoDirectly(Request $request, $objectType)
    {
        $file = $request->file('video');
        return self::storeVideo($file, $objectType, mt_rand(1, 9999), false);
    }

    public function saveImage(Request $request, $objectType, $objectId)
    {
        $file = $request->file('image');
        $fileURL = $this->storeImage($file, $objectType, $objectId, true);

        $media = new Media();
        $media->url = $fileURL;
        $media->type = "Image";
    }


    public function saveImages(Request $request, $objectType, $objectId)
    {
        $mediaContent = array();
        $files = $request->file('image');
        foreach ($files as $file) {
            $fileURL = $this->storeImage($file, $objectType, $objectId, true);

            $media = new Media();
            $media->url = $fileURL;
            $media->type = "Image";
            $mediaContent[] = $media;
        }
        return $mediaContent;
    }

    private static function storeImage($image, $objectType, $objectId, $withSubFolder)
    {
        return Storage::disk('public')->put('images/' . $objectType, $image);
    }
    public static function SaveFile($file){
        if (isset($file)){
            $name=time().'_'.rand(1,999999999).'.'.$file->getClientOriginalExtension();

            $path=realpath('public/uploads')?realpath('public/uploads'):realpath('uploads');

            $originalImage= $file;
            $thumbnailImage = Image::make($originalImage);
            $thumbnailPath = $path.'/thumbnail/';
            $originalPath = $path.'/';
            $thumbnailImage->save($originalPath.$name);
            $thumbnailImage->widen(150);;
            $thumbnailImage->save($thumbnailPath.$name);

//            $file->move('uploads', $name);
            return $name;
        }
        return '';

    }
    public static function SaveFile1($file){
        if (isset($file)){
            $name=time().'_'.rand(1,999999999).'.'.$file->getClientOriginalExtension();

            $path=realpath('public/uploads')?realpath('public/uploads'):realpath('uploads');

            $originalImage= $file;
            $thumbnailImage = Image::make($originalImage);
            $width = $thumbnailImage->width();
            $height = $thumbnailImage->height();
//            $thumbnailPath = $path.'/thumbnail/';
            $originalPath = $path.'/';
            $thumbnailImage->save($originalPath.$name);
//            $thumbnailImage->widen(150);;
//            $thumbnailImage->save($thumbnailPath.$name);

//            $file->move('uploads', $name);
            return [$name,$width,$height];
        }
        return '';

    }
    public static function saveVideo($file){
        if (isset($file)){
            $name=time().'_'.rand(1,999999999).'.'.$file->getClientOriginalExtension();
            $file->move('uploads', $name);
            return $name;
        }
        return '';

    }

    public function DeleteFile($file,$path=''){
        File::delete($path.'/'.$file);
        return true;
    }
    private static function storeVideo($video, $objectType, $objectId, $withSubFolder)
    {
        return Storage::disk('public')->put('videos/' . $objectType, $video);
    }

    private static function my_public_path($path = '')
    {
        return public_path() . "/" . env('PUBLIC_PATH', 'uploads') . $path;
    }

}
