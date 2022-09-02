<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kunnu\Dropbox\DropboxApp;
use Kunnu\Dropbox\Dropbox;
use GuzzleHttp\Client;

class DropBoxImgController extends Controller
{
    public function listDropbox(Request $request)
    //public function listDropbox()
    {   
        $itemData = array();
        $itemData2 = array();
        $array_data = array();
        $code = $request->code;
        //$code = "202004";
        $dropboxKey ="mq4f0sikodckz15";
        $dropboxSecret ="xb4tc0xsjuctyc1";
        $dropboxToken="sl.BOi1j3WWJFzRrXWalhbidqvyv3Vj2GfA_dWmZgJjRhABde55BL3sZ0BK87Lg1EoCK7huMoq-2T7C29kDky8V5ohfgyTVG161x3NMDdRc4PWCwwCGTgfvVo3F1q5a3steO0dn4hU";
        //$dropboxToken= $this->authDrop();

        $app = new DropboxApp($dropboxKey,$dropboxSecret,$dropboxToken);
        $dropbox = new Dropbox($app);

        $listFolderContents = $dropbox->search("/",$code);
        $items = $listFolderContents->getItems();

        foreach ($items as $key => $value) {
            $itemData[$key] = $value->getData()['metadata'];
             foreach ($itemData as $key2 => $value2) {
        
                  //$itemData2[$key2] = $value2['name'];
                  $id   = $value2['id'];
                  $name = $value2['name'];
                  $itemData2[$key2] = $value2['path_display'];
                  $path = $value2['path_lower'];
                  $thumbPath = "no thumb";
                  $thumbHasExt = strpos($path, '.');
                  $file = $dropbox->getTemporaryLink($path);
                  $link = $file->getLink();
        
                  $array_data[]=array("id"=>$id,"name"=>$name,"path"=>$link);
       ;
             }
        }
        return response()->json($array_data);      
    }
}
