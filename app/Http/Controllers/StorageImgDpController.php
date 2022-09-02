<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use File;

class StorageImgDpController extends Controller
{
    public function storage_names(){
        $array_data = array();
    
    $code = '202004';
    // filter the ones that match the filename.* 
    $storage_path = url('storage/app/IMAGENES DE PRODUCTO 72 DPI/');
    $matchingFiles = Storage::disk('public')->allFiles('IMAGENES DE PRODUCTO 72 DPI/');
    
    // iterate through files and echo their content
    foreach ($matchingFiles as $path) {
      $info = pathinfo($path);
      $name = $info['filename'];
      if (preg_match('/'.$code.'/i', $name)) {
      $array_data[]=array("name"=>$name,"ff"=>$storage_path);
      }
    }
        return response()->json($array_data); 
    }
    
        public function storage_names_search(Request $request){
          $array_data = array();
          //$code = "202004";
          $code = $request->code;
          $storage_path = url('storage/app/IMAGENES DE PRODUCTO 72 DPI/');
          $matchingFiles = Storage::disk('public')->allFiles('IMAGENES DE PRODUCTO 72 DPI/');
    
            // iterate through files and echo their content
            foreach ($matchingFiles as $path) {
               $info = pathinfo($path);
               $name = $info['filename'];
               $basename = $file['basename'];
               $file_path = $storage_path.$basename;
               if (preg_match('/'.$code.'/i', $name)) {
                $array_data[]=array("name"=>$name,"basename"=>$basename,"file_path"=>$file_path);
                 }
                 }
    
                 return response()->json($array_data); 
      
          }
    
}
