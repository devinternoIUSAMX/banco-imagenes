<?php

namespace App\Http\Controllers;
use App\Http\Controllers\DropBoxImgController;

use Illuminate\Http\Request;
use Kunnu\Dropbox\DropboxApp;
use Kunnu\Dropbox\Dropbox;
use GuzzleHttp\Client;
use App\Models\User;

class DropBoxPdfController extends Controller
{
    public function allFileDropboxPdf(Request $request){
        $itemData = array();
        $itemData2 = array();
        $array_data = array();
        $array_total = array();
        $options = array(); 
         
        $type = $request->type ?? 0;
        $code = $request->code ?? 0;
        $quantity = $request->quant ?? 0;
        $view = $request->view ?? 0;        
        $count = 1;
        $total = 0;
        $sum = 0;
        $i = 0;

        if ($view == 0) {
            $code = $request->code.".pdf";
        }else{
            $code = $code."_".$view.".pdf"; 
        }
        
        $dropboxKey ="poryms6kbeheedh";
        $dropboxSecret ="y2qkczqhvafuhdh";
        $token = (new DropBoxImgController)->getToken();
       // $dropboxToken=$token['access_token'];

        $user = User::find(1);
        $dropboxToken=$user->dropbox_token;

        try {
            $app = new DropboxApp($dropboxKey,$dropboxSecret,$dropboxToken);
            $dropbox = new Dropbox($app);

            if ($type == 0) {
                return response()->json(['error'=>'Not Found'],404);
            }else{
                //there is a type of search
                if ($type == 1) {
                    //tipo certificado
                    return $this->certDropboxPdf($request);
                }else if ($type == 2) {
                    //Garantias
                    return $this->guaranteeDropboxPdf($request);
                }else if ($type == 3){
                    //FICHAS 
                    return $this->dataSheetDropboxPdf($request);
                }else if ($type == 4){
                   //Certificados 
                   return $this->handBookDropboxPdf($request);
                }else if ($type == 5){
                   //Presentaciones 
                   return $this->introDropboxPdf($request);
                }else if ($type == 6){
                    //Todos
                    if (empty($code)) {
                         https://videoconferencia.telmex.com/j/1246619158
                    }else{
                        // Si hay codigo
                        if ($view == 0) {
                            $listFolderContents = $dropbox->search("/Aplicaciones",$code);
                        }else{
                            //$options= ['max_results' => 1];         
                            $listFolderContents = $dropbox->search("/Aplicaciones",$code);
                        }

                        $items = $listFolderContents->getItems();
                        if (count($items) === 0) {
                            return response()->json(['error'=>'Not Found'],404);
                        }else{ 
                            // si hay items
                            foreach ($items as $key => $value) {
                                $itemData[$key] = $value->getData()['metadata'];
                                /*$result = array_reverse(array_values(array_column(
                                    array_reverse($itemData),
                                    null,
                                    'name'
                              )));*/
                            }

                            usort($itemData, function($a, $b){return strnatcasecmp($a["name"], $b["name"]);});
                            foreach ($itemData as $key2 => $value2) {  
   
                                $id   = $value2['id'];
                                $name = $value2['name'];
                                $path = $value2['path_lower'];
                                $size = (float)$value2['size'];
                                $file = $dropbox->getTemporaryLink($path);
                                $link = $file->getLink();
                                $pieces = explode("/", $path);
                                $type_file = ucfirst($pieces[2]); // piece1
                                            
                              
                              if ($quantity == 0) {
                  
                                      $total = $count++;
                                      $sum += $size/1000; 
                                      $array_data[]=array("id"=>$id,"name"=>$name,"size"=>$size,"path"=>$link,"path_lower"=>$path,"type_file"=>$type_file,"type"=>"file","status"=>true,"message"=>"succes");
                        
                  
                              }else{
                                  if($i >= $quantity) {
                                      break;
                                  }else{
                                    $total = $count++;
                                    $sum += $size/1000; 
                                    $array_data[]=array("id"=>$id,"name"=>$name,"size"=>$size,"path"=>$link,"path_lower"=>$path,"type_file"=>$type_file,"type"=>"file","status"=>true,"message"=>"succes");
                                    $i++;
                                  }
                              }
                              
                             }
                             $sum_format = number_format($sum, 2, '.', ' ');    
                             $array_total[]=array("total"=>$total,"sum"=>$sum_format,"type"=>"info","status"=>true,"message"=>"succes");
                        }
                        $output = array_merge($array_data,$array_total);        
                        return response()->json($output, 200);
                    }
                }else{
                    return response()->json(['error'=>'Not Found'],404);
                }
            }

        } catch (Exception $e) {
            return response()->json(['error' => 'Internal Server Error' ], 500);
        }


    }

    public function certDropboxPdf(Request $request){
        $itemData = array();
        $itemData2 = array();
        $array_data = array();
        $array_total = array();
        $options = array(); 
        
        
        $code = $request->code ?? 0;
        $quantity = $request->quant ?? 0;
        $view = $request->view ?? 0;
        //$view = 0;
        $count = 1;
        $total = 0;
        $sum = 0;
        $i = 0;

        if ($view == 0) {
            $code = $request->code.".pdf";
        }else{
            $code = $code."_".$view.".pdf"; 
        }
        
        $dropboxKey ="poryms6kbeheedh";
        $dropboxSecret ="y2qkczqhvafuhdh";
        $token = (new DropBoxImgController)->getToken();
       // $dropboxToken=$token['access_token'];

        $user = User::find(1);
        $dropboxToken=$user->dropbox_token;

        
    try {
            $app = new DropboxApp($dropboxKey,$dropboxSecret,$dropboxToken);
            $dropbox = new Dropbox($app);
        
        if (empty($code)) {
            $array_data[]=array("id"=>'1',"name"=>'Not found',"size"=>'1',"path"=>'_',"path_lower"=>'_',"type_file"=>"_","type"=>"file","status"=>true,"message"=>"error");
        }else{
        
        if ($view == 0) {
            $listFolderContents = $dropbox->search("/Aplicaciones/CERTIFICACIONES",$code);
        }else{
            $options= ['max_results' => 1];         
            $listFolderContents = $dropbox->search("/Aplicaciones/CERTIFICACIONES",$code,$options);
        }
        
        $items = $listFolderContents->getItems();

        if (count($items) === 0) {
            return response()->json(['error' => 'Not Found' ], 404); 
        }else{  
            
             
        foreach ($items as $key => $value) {
            $itemData[$key] = $value->getData()['metadata'];
            $result = array_reverse(array_values(array_column(
                array_reverse($itemData),
                null,
                'name'
          )));
        } 
       
        usort($result, function($a, $b){return strnatcasecmp($a["name"], $b["name"]);});
        foreach ($result as $key2 => $value2) {  
   
              $id   = $value2['id'];
              $name = $value2['name'];
              $path = $value2['path_lower'];
              $size = (float)$value2['size'];
              $file = $dropbox->getTemporaryLink($path);
              $link = $file->getLink();
                          
            
            if ($quantity == 0) {

                    $total = $count++;
                    $sum += $size/1000; 
                    $array_data[]=array("id"=>$id,"name"=>$name,"size"=>$size,"path"=>$link,"path_lower"=>$path,"type_file"=>"Certificaciones","type"=>"file","status"=>true,"message"=>"succes");
      

            }else{
                if($i >= $quantity) {
                    break;
                }else{
                  $total = $count++;
                  $sum += $size/1000; 
                  $array_data[]=array("id"=>$id,"name"=>$name,"size"=>$size,"path"=>$link,"path_lower"=>$path,"type_file"=>"Certificaciones","type"=>"file","status"=>true,"message"=>"succes");
                  $i++;
                }
            }
            
           }
        $sum_format = number_format($sum, 2, '.', ' ');    
        $array_total[]=array("total"=>$total,"sum"=>$sum_format,"type"=>"info","status"=>true,"message"=>"succes");
        }
        
        $output = array_merge($array_data,$array_total);
        
        return response()->json($output, 200); 
      }   
    } catch (Exception $e) {
            return response()->json(['error' => 'Internal Server Error' ], 500);
    }
    }

    public function guaranteeDropboxPdf(Request $request){
        $itemData = array();
        $itemData2 = array();
        $array_data = array();
        $array_total = array();
        $options = array(); 
        
        
        $code = $request->code ?? 0;
        $quantity = $request->quant ?? 0;
        $view = $request->view ?? 0;
        //$view = 0;
        $count = 1;
        $total = 0;
        $sum = 0;
        $i = 0;

        if ($view == 0) {
            $code = $request->code.".pdf";
        }else{
            $code = $code."_".$view.".pdf"; 
        }
        
        $dropboxKey ="poryms6kbeheedh";
        $dropboxSecret ="y2qkczqhvafuhdh";
        $token = (new DropBoxImgController)->getToken();
       // $dropboxToken=$token['access_token'];

        $user = User::find(1);
        $dropboxToken=$user->dropbox_token;

        
    try {
            $app = new DropboxApp($dropboxKey,$dropboxSecret,$dropboxToken);
            $dropbox = new Dropbox($app);
        
        if (empty($code)) {
            $array_data[]=array("id"=>'1',"name"=>'Not found',"size"=>'1',"path"=>'_',"path_lower"=>'_',"type_file"=>"_","type"=>"file","status"=>true,"message"=>"error");   
            return $array_data; 
        }else{
        
        if ($view == 0) {
            $options= ['file_extensions' => 'pdf']; 
            $listFolderContents = $dropbox->search("/Aplicaciones/GARANTIAS",$code);
        }else{
            $options= ['max_results' => 1];         
            $listFolderContents = $dropbox->search("/Aplicaciones/GARANTIAS",$code,$options);
        }
        
        $items = $listFolderContents->getItems();

        if (count($items) === 0) {
            return response()->json(['error'=>'Not Found'],404);
        }else{  
            
             
        foreach ($items as $key => $value) {
            $itemData[$key] = $value->getData()['metadata'];
            $result = array_reverse(array_values(array_column(
                array_reverse($itemData),
                null,
                'name'
          )));
        } 
       
        usort($result, function($a, $b){return strnatcasecmp($a["name"], $b["name"]);});
        foreach ($result as $key2 => $value2) {  
   
              $id   = $value2['id'];
              $name = $value2['name'];
              $path = $value2['path_lower'];
              $size = (float)$value2['size'];
              $file = $dropbox->getTemporaryLink($path);
              $link = $file->getLink();
                          
            
            if ($quantity == 0) {

                    $total = $count++;
                    $sum += $size/1000; 
                    $array_data[]=array("id"=>$id,"name"=>$name,"size"=>$size,"path"=>$link,"path_lower"=>$path,"type_file"=>"Garantias","type"=>"file","status"=>true,"message"=>"succes");
      

            }else{
                if($i >= $quantity) {
                    break;
                }else{
                  $total = $count++;
                  $sum += $size/1000; 
                  $array_data[]=array("id"=>$id,"name"=>$name,"size"=>$size,"path"=>$link,"path_lower"=>$path,"type_file"=>"Garantias","type"=>"file","status"=>true,"message"=>"succes");
                  $i++;
                }
            }
            
           }
        $sum_format = number_format($sum, 2, '.', ' ');    
        $array_total[]=array("total"=>$total,"sum"=>$sum_format,"type"=>"info","status"=>true,"message"=>"succes");
        }
        
        $output = array_merge($array_data,$array_total);
        
        return response()->json($output, 200); 
      }   
    } catch (Exception $e) {
            return response()->json(['error' => 'Internal Server Error' ], 500);
    }
    }

    
    public function dataSheetDropboxPdf(Request $request){
        session()->start();
        $itemData = array();
        $itemData2 = array();
        $array_data = array();
        $array_total = array();
        $options = array(); 
        
        
        $code = $request->code ?? 0;
        $quantity = $request->quant ?? 0;
        $view = $request->view ?? 0;
        //$view = 0;
        $count = 1;
        $total = 0;
        $sum = 0;
        $i = 0;

        if ($view == 0) {
            $code = $request->code.".pdf";
        }else{
            $code = $code."_".$view.".pdf"; 
        }
        
        $dropboxKey ="poryms6kbeheedh";
        $dropboxSecret ="y2qkczqhvafuhdh";
        $token = (new DropBoxImgController)->getToken();
       // $dropboxToken=$token['access_token'];

        $user = User::find(1);
        $dropboxToken=$user->dropbox_token;

        
    try {
            $app = new DropboxApp($dropboxKey,$dropboxSecret,$dropboxToken);
            $dropbox = new Dropbox($app);
        
        if (empty($code)) {
            return response()->json(['error'=>'Not Found'],404);
        }else{
        
        if ($view == 0) {
            $listFolderContents = $dropbox->search("/Aplicaciones/FICHAS",$code);
        }else{
            $options= ['max_results' => 1];         
            $listFolderContents = $dropbox->search("/Aplicaciones/FICHAS",$code,$options);
        }
        
        $items = $listFolderContents->getItems();

        if (count($items) === 0) {
            $array_data[]=array("id"=>'1',"name"=>'Not found',"size"=>'1',"path"=>'_',"path_lower"=>'_',"type_file"=>"_","type"=>"file","status"=>true,"message"=>"error");   
            return $array_data;      
        }else{  
            
             
        foreach ($items as $key => $value) {
            $itemData[$key] = $value->getData()['metadata'];
            $result = array_reverse(array_values(array_column(
                array_reverse($itemData),
                null,
                'name'
          )));
        } 
       
        usort($result, function($a, $b){return strnatcasecmp($a["name"], $b["name"]);});
        foreach ($result as $key2 => $value2) {  
   
              $id   = $value2['id'];
              $name = $value2['name'];
              $path = $value2['path_lower'];
              $size = (float)$value2['size'];
              $file = $dropbox->getTemporaryLink($path);
              $link = $file->getLink();
                          
            
            if ($quantity == 0) {

                    $total = $count++;
                    $sum += $size/1000; 
                    $array_data[]=array("id"=>$id,"name"=>$name,"size"=>$size,"path"=>$link,"type_file"=>"Fichas","type"=>"file","status"=>true,"message"=>"succes");
      

            }else{
                if($i >= $quantity) {
                    break;
                }else{
                  $total = $count++;
                  $sum += $size/1000; 
                  $array_data[]=array("id"=>$id,"name"=>$name,"size"=>$size,"path"=>$link,"type_file"=>"Fichas","type"=>"file","status"=>true,"message"=>"succes");
                  $i++;
                }
            }
            
           }
        $sum_format = number_format($sum, 2, '.', ' ');    
        $array_total[]=array("total"=>$total,"sum"=>$sum_format,"type"=>"info","status"=>true,"message"=>"succes");
        }
        
        $output = array_merge($array_data,$array_total);
        
        return response()->json($output, 200); 
      }   
    } catch (Exception $e) {
            return response()->json(['error' => 'Internal Server Error' ], 500);
    }
    }

    public function handBookDropboxPdf(Request $request){
        session()->start();
        $itemData = array();
        $itemData2 = array();
        $array_data = array();
        $array_total = array();
        $options = array(); 
        
        
        $code = $request->code ?? 0;
        $quantity = $request->quant ?? 0;
        $view = $request->view ?? 0;
        //$view = 0;
        $count = 1;
        $total = 0;
        $sum = 0;
        $i = 0;

        if ($view == 0) {
            $code = $request->code.".pdf";
        }else{
            $code = $code."_".$view.".pdf"; 
        }
        
        $dropboxKey ="poryms6kbeheedh";
        $dropboxSecret ="y2qkczqhvafuhdh";
        $token = (new DropBoxImgController)->getToken();
      //  $dropboxToken=$token['access_token'];

        $user = User::find(1);
        $dropboxToken=$user->dropbox_token;

        
    try {
            $app = new DropboxApp($dropboxKey,$dropboxSecret,$dropboxToken);
            $dropbox = new Dropbox($app);
        
        if (empty($code)) {
            $array_data[]=array("id"=>'1',"name"=>'Not found',"size"=>'1',"path"=>'_',"path_lower"=>'_',"type_file"=>"_","type"=>"file","status"=>true,"message"=>"error");   
            return $array_data; 
        }else{
        
        if ($view == 0) {
            $listFolderContents = $dropbox->search("/Aplicaciones/MANUALES",$code);
        }else{
            $options= ['max_results' => 1];         
            $listFolderContents = $dropbox->search("/Aplicaciones/MANUALES",$code,$options);
        }
        
        $items = $listFolderContents->getItems();

        if (count($items) === 0) {
            return response()->json(['error'=>'Not Found'],404);      
        }else{  
            
             
        foreach ($items as $key => $value) {
            $itemData[$key] = $value->getData()['metadata'];
            $result = array_reverse(array_values(array_column(
                array_reverse($itemData),
                null,
                'name'
          )));
        } 
       
        usort($result, function($a, $b){return strnatcasecmp($a["name"], $b["name"]);});
        foreach ($result as $key2 => $value2) {  
   
              $id   = $value2['id'];
              $name = $value2['name'];
              $path = $value2['path_lower'];
              $size = (float)$value2['size'];
              $file = $dropbox->getTemporaryLink($path);
              $link = $file->getLink();
                          
            
            if ($quantity == 0) {

                    $total = $count++;
                    $sum += $size/1000; 
                    $array_data[]=array("id"=>$id,"name"=>$name,"size"=>$size,"path"=>$link,"type_file"=>"Manuales","type"=>"file","status"=>true,"message"=>"succes");
      

            }else{
                if($i >= $quantity) {
                    break;
                }else{
                  $total = $count++;
                  $sum += $size/1000; 
                  $array_data[]=array("id"=>$id,"name"=>$name,"size"=>$size,"path"=>$link,"type_file"=>"Manuales","type"=>"file","status"=>true,"message"=>"succes");
                  $i++;
                }
            }
            
           }
        $sum_format = number_format($sum, 2, '.', ' ');    
        $array_total[]=array("total"=>$total,"sum"=>$sum_format,"type"=>"info","status"=>true,"message"=>"succes");
        }
        
        $output = array_merge($array_data,$array_total);
        
        return response()->json($output, 200); 
      }   
    } catch (Exception $e) {
            return response()->json(['error' => 'Internal Server Error' ], 500);
    }
    }

    public function introDropboxPdf(Request $request){
        session()->start();
        $itemData = array();
        $itemData2 = array();
        $array_data = array();
        $array_total = array();
        $options = array(); 
        
        
        $code = $request->code ?? 0;
        $quantity = $request->quant ?? 0;
        $view = $request->view ?? 0;
        //$view = 0;
        $count = 1;
        $total = 0;
        $sum = 0;
        $i = 0;

        if ($view == 0) {
            $code = $request->code.".pdf";
        }else{
            $code = $code."_".$view.".pdf"; 
        }
        
        $dropboxKey ="poryms6kbeheedh";
        $dropboxSecret ="y2qkczqhvafuhdh";
        $token = (new DropBoxImgController)->getToken();
        //$dropboxToken=$token['access_token'];

        $user = User::find(1);
        $dropboxToken=$user->dropbox_token;

        
    try {
            $app = new DropboxApp($dropboxKey,$dropboxSecret,$dropboxToken);
            $dropbox = new Dropbox($app);
        
        if (empty($code)) {
            $array_data[]=array("id"=>'1',"name"=>'Not found',"size"=>'1',"path"=>'_',"path_lower"=>'_',"type_file"=>"_","type"=>"file","status"=>true,"message"=>"error");   
        return $array_data; 
        }else{
        
        if ($view == 0) {
            $listFolderContents = $dropbox->search("/Aplicaciones/PRESENTACIONES",$code);
        }else{
            $options= ['max_results' => 1];         
            $listFolderContents = $dropbox->search("/Aplicaciones/PRESENTACIONES",$code,$options);
        }
        
        $items = $listFolderContents->getItems();

        if (count($items) === 0) {
            $array_data[]=array("id"=>'1',"name"=>'Not found',"size"=>'1',"path"=>'_',"path_lower"=>'_',"type_file"=>"_","type"=>"file","status"=>true,"message"=>"error");   
        return $array_data;       
        }else{  
            
             
        foreach ($items as $key => $value) {
            $itemData[$key] = $value->getData()['metadata'];
            $result = array_reverse(array_values(array_column(
                array_reverse($itemData),
                null,
                'name'
          )));
        } 
       
        usort($result, function($a, $b){return strnatcasecmp($a["name"], $b["name"]);});
        foreach ($result as $key2 => $value2) {  
   
              $id   = $value2['id'];
              $name = $value2['name'];
              $path = $value2['path_lower'];
              $size = (float)$value2['size'];
              $file = $dropbox->getTemporaryLink($path);
              $link = $file->getLink();
                          
            
            if ($quantity == 0) {

                    $total = $count++;
                    $sum += $size/1000; 
                    $array_data[]=array("id"=>$id,"name"=>$name,"size"=>$size,"path"=>$link,"type_file"=>"Presentaciones","type"=>"file","status"=>true,"message"=>"succes");
      

            }else{
                if($i >= $quantity) {
                    break;
                }else{
                  $total = $count++;
                  $sum += $size/1000; 
                  $array_data[]=array("id"=>$id,"name"=>$name,"size"=>$size,"path"=>$link,"type_file"=>"Presentaciones","type"=>"file","status"=>true,"message"=>"succes");
                  $i++;
                }
            }
            
           }
        $sum_format = number_format($sum, 2, '.', ' ');    
        $array_total[]=array("total"=>$total,"sum"=>$sum_format,"type"=>"info","status"=>true,"message"=>"succes");
        }
        
        $output = array_merge($array_data,$array_total);
        
        return response()->json($output, 200); 
      }   
    } catch (Exception $e) {
            return response()->json(['error' => 'Internal Server Error' ], 500);
    }
    }
}