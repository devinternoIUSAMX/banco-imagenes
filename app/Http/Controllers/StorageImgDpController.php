<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
//use File;

class StorageImgDpController extends Controller
{
  public function storage_names_1(){
    $array_data = array();

$code = '202004';
// filter the ones that match the filename.* 
$storage_path = url('storage/app/public/IMAGENES_DE_PRODUCTO_72_DPI/');
$matchingFiles = Storage::disk('public')->allFiles('IMAGENES_DE_PRODUCTO_72_DPI/');

// iterate through files and echo their content
foreach ($matchingFiles as $path) {
  $info = pathinfo($path);
  $name = $info['filename'];
  $url = Storage::url('file.jpg');
  if (preg_match('/'.$code.'/i', $name)) {
  $array_data[]=array("id"=>$name,"name"=>$name,"path"=>$storage_path);
  }
}
    return response()->json($array_data); 
}

  public function storage_names_search_1(Request $request){
    $array_data = array();
    $code = $request->code;

    //$array_data[]=array("code"=>$code);
    $storage_path = url('storage/IMAGENES DE PRODUCTO 72 DPI/');
    
    $matchingFiles = Storage::disk('public')->allFiles('IMAGENES DE PRODUCTO 72 DPI/');
     
    
    foreach ($matchingFiles as $path) {
      $info = pathinfo($path);
      $name = $info['filename'];
      $basename = $info['basename'];
      $publicPath_1 = $storage_path."/".$basename;
      //$url = Storage::url($basename);
      if (preg_match('/'.$code.'/i', $name)) {
      $array_data[]=array("id"=>$name,"name"=>$name,"path"=>$publicPath_1);
      }
    }

         return response()->json($array_data); 
  }
}
