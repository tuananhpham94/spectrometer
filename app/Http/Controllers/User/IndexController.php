<?php

namespace App\Http\Controllers\User;
require_once("lib/Tinify/Exception.php");
require_once("lib/Tinify/ResultMeta.php");
require_once("lib/Tinify/Result.php");
require_once("lib/Tinify/Source.php");
require_once("lib/Tinify/Client.php");
require_once("lib/Tinify.php");
use App\Http\Controllers\Controller;
use App\Kiwifruit;
use App\Models\User;
use App\ScannedItem;
use App\Spectrometer;
use App\TempLamb;
use App\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class IndexController extends Controller
{
    public function index()
    {
        if(Auth::check()){
            $user = Auth::user();

            $kiwifruits = Kiwifruit::where('user_id', $user->id)->get();
            $scannedItems = ScannedItem::where('user_id', $user->id)->get();
            $tempLambs = [];
            foreach($scannedItems as $scannedItem){
                $tempLambs[] = TempLamb::where('scanned_item_id', $scannedItem->id)->get();
            }

            return view('pages.user.index', [ 'kiwifruits' => $kiwifruits, 'scannedItems' => $scannedItems,'tempLambs' => $tempLambs
            ]);
        } else {
            return view('pages.user.index');
        }
    }

    public function getUpload(){
        $types = Type::where('type', Type::where('name', 'MEAT')->first()->id)->get();
        return view('pages.user.upload', ['types' => $types]);
    }

    public function postUpload(Request $request){
        $path = 'images/'.time() . '.' . $request->image->getClientOriginalExtension();
        \Tinify\setKey("cRBOIBNVcVK-m_wvOYOFGaErQSkvEIkZ");
//        \Tinify\fromFile($request->image)->toFile($path);
        $resizedImage = \Tinify\fromFile($request->image)->resize(array(
            'method' => "scale",
            'width' => 200
        ))->toFile($path);

        ScannedItem::create([
            'name' => $request->name,
            'spectrometer_id' => Spectrometer::where('name', 'NIRScan')->first()->id,
            'image' => $path,
            'type' => $request->type,
            'user_id' => Auth::user()->id,
            'cut_location' => $request->location,
            'other_information' => $request->information
        ]);
        $user = Auth::user();
        $kiwifruits = Kiwifruit::where('user_id', $user->id)->get();
        $scannedItems = ScannedItem::where('user_id', $user->id)->get();
        $tempLambs = [];
        foreach($scannedItems as $scannedItem){
            $tempLambs[] = TempLamb::where('scanned_item_id', $scannedItem->id)->get();
        }

        return view('pages.user.index', [ 'kiwifruits' => $kiwifruits, 'scannedItems' => $scannedItems,'tempLambs' => $tempLambs
        ]);
    }

    public function getUploadFile(){
        $scanned_items = ScannedItem::where('user_id', Auth::user()->id)->get();
        return view('pages.user.uploadfile', ['scanned_items' => $scanned_items]);
    }

    public function postUploadFile(Request $request){
        for($i=0; $i<count($request->fileToUpload); $i++){
            $filename = time().$i.'.'.$request->fileToUpload[$i]->getClientOriginalExtension();
            $request->fileToUpload[$i]->move(public_path('csv'), $filename);

            TempLamb::create([
                'name' => $request->nameOfFile[$i],
                'excel_file' => 'csv/' . $filename,
                'scanned_item_id' => $request->item
            ]);
        }
        $user = Auth::user();
        $kiwifruits = Kiwifruit::where('user_id', $user->id)->get();
        $scannedItems = ScannedItem::where('user_id', $user->id)->get();
        $tempLambs = [];
        foreach($scannedItems as $scannedItem){
            $tempLambs[] = TempLamb::where('scanned_item_id', $scannedItem->id)->get();
        }

        return view('pages.user.index', [ 'kiwifruits' => $kiwifruits, 'scannedItems' => $scannedItems,'tempLambs' => $tempLambs
        ]);
    }
}
