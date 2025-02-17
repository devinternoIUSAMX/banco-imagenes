<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kunnu\Dropbox\DropboxApp;
use Kunnu\Dropbox\Dropbox;
use GuzzleHttp\Client;
use App\Models\User;

use SoapClient;

class DropBoxImgController extends Controller
{

    public function listDropboxNew(Request $request)
    {   
        session()->start();
        $itemData = array();
        $itemData2 = array();
        $array_data = array();
        $array_total = array();
        $options = array();
        
        $code = $request->code ?? 0;
        $quantity = $request->quant ?? 0; 
        $view = $request->view ?? 0;
        $count = 1;
        $total = 0;
        $sum = 0;
        $i = 0;

        if ($view == 0) {
            $code = $request->code;
        }else{
            $code = $code."_".$view.".jpg"; 
        }
        
        $dropboxKey ="poryms6kbeheedh";
        $dropboxSecret ="y2qkczqhvafuhdh";
        $token = $this->getToken();
        $dropboxToken=$token['access_token'];
        //$dropboxToken='sl.BO7IYSv7rhAPR97K-eLnExVMLzvbXZ83oU5WOPVVFu1tHHPZM5jd2p4W4qKKgvo6G8xZkJJItnnh6vTeaz7aHTsEZilTaD_87YGxBlpiTW_ii2gtGefndmgS5ztoCYvKWdt0voQ';
        
        $user = User::find(1);
        //$dropboxToken=$user->dropbox_token;
        //return $dropboxToken;

        try {
       // $app = new DropboxApp($dropboxKey,$dropboxSecret,$dropboxToken);
        $app = new DropboxApp($dropboxKey,$dropboxSecret,$dropboxToken);
        $dropbox = new Dropbox($app);

        //return response()->json(['error' => $dropbox ], 404);
        
        if (empty($code)) {
           return response()->json(['error' => 'Not Found' ], 404);
        }else{

        
        if ($view == 0) {
            $listFolderContents = $dropbox->search("/Aplicaciones/IMAGENES",$code);
            //$listFolderContents = $dropbox->search("/",$code);
        }else{
            $options= ['max_results' => 1];         
            $listFolderContents = $dropbox->search("/Aplicaciones/IMAGENES",$code,$options);
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
              //$sum += $size/1000;             
           
             if ($quantity == 0) {
                $total = $count++;
                $sum += $size/1000; 
                $array_data[]=array("id"=>$id,"name"=>$name,"size"=>$size,"path"=>$link,"type_file"=>"Productos","type"=>"file","status"=>true,"message"=>"succes");
            
            }else{
                
                if($i >= $quantity) {
                    break;
                }else{
                  $total = $count++;
                  $sum += $size/1000;
                  $array_data[]=array("id"=>$id,"name"=>$name,"size"=>$size,"path"=>$link,"type_file"=>"Productos","type"=>"file","status"=>true,"message"=>"succes");
                  $i++;
                }
            }
   
         }
        $sum_format = number_format($sum, 2, '.', ' ');    
        $array_total[]=array("total"=>$total,"sum"=>$sum_format,"type"=>"info","status"=>true,"message"=>"succes");
        }

         $output = array_merge($array_data,$array_total);
         return response()->json($output); 
       } 
     } catch (Exception $e) {
         return response()->json(['error' => 'Internal Server Error' ], 500);
     }
    }


    public function getToken()
    {
        $dropboxKey ="poryms6kbeheedh";
        $dropboxSecret ="y2qkczqhvafuhdh";
    try {
        $client = new \GuzzleHttp\Client();
        $res = $client->request("POST", "https://{$dropboxKey}:{$dropboxSecret}@api.dropbox.com/oauth2/token", [
            'form_params' => [
                'grant_type' => 'refresh_token',
               // 'refresh_token' => 'VfdJwm336J0AAAAAAAAAAVdHNZ1tDiFNu1buJJYHU2oxgnDKo_zNbKlmM1wC3S-d',
               'refresh_token' => 'nnvS5xYRi9cAAAAAAAAAASsVh-hjF-hb0oV2uYjJDe2i9dIu2lSb-rncy7_-P1yL',
            ]
        ]);
        if ($res->getStatusCode() == 200) {

            return json_decode($res->getBody(), TRUE);

        } else {
            return false;
        }
    }
    catch (Exception $e) {
        $this->logger->error("[{$e->getCode()}] {$e->getMessage()}");
        return false;
    }
   }

}