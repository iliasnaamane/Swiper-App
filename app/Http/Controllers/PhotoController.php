<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Photo;
use URL;

class PhotoController extends Controller
{
    /**
     * Generates random filename
     * @param string $filename original filename
     * @return string randomized filename with extension
     */
    protected function randomFilename($filename)
    {
        return (uniqid() . "." . pathinfo($filename, PATHINFO_EXTENSION));
    }

    /**
     * Converts GPS coordinate in EXIF format to numeric one, acceptable by Google Maps
     * @param $exifCoord
     * @param $hemi
     * @return int
     */
    protected function getGps($exifCoord, $hemi)
    {

        $degrees = count($exifCoord) > 0 ? $this->gps2Num($exifCoord[0]) : 0;
        $minutes = count($exifCoord) > 1 ? $this->gps2Num($exifCoord[1]) : 0;
        $seconds = count($exifCoord) > 2 ? $this->gps2Num($exifCoord[2]) : 0;

        $flip = ($hemi == 'W' or $hemi == 'S') ? -1 : 1;

        return $flip * ($degrees + $minutes / 60 + $seconds / 3600);

    }

    /**
     * Converts GPS coordinate in EXIF format to numeric one, acceptable by Google Maps
     * Helper function
     * @param $coordPart
     * @return float|int
     */
    protected function gps2Num($coordPart)
    {

        $parts = explode('/', $coordPart);

        if (count($parts) <= 0)
            return 0;

        if (count($parts) == 1)
            return $parts[0];

        return floatval($parts[0]) / floatval($parts[1]);
    }
    public function soustractWithMultipleFive($x){
        if($x < 5) {
            return 5-$x;
        }
        else {
            return 5-$x%5;
        }
    }
    /**
     * Index page
     * @return mixed
     */
    public function index()
    {
        
        $url = URL::previous();
        $max = Photo::max('id');

        /*if (strpos($url, 'map/') !== false) {
            $arrayUrl = explode("/", $url);
            $idPhoto = $arrayUrl[4];
            $idSlide = Photo::where('id','>',$idPhoto)->get()->count();
            $page = intval($idSlide/5);
            $offset = $idSlide-$idSlide%5;

            $photos = Photo::orderBy("created_at", "desc")->offset($offset)->limit(5)->get();
            $initialSlide = $idSlide%5;
          
           
            return view('index', compact("photos","page","initialSlide")); 
        } 
        else {
            $page = 1;
            $initialSlide=0;*/
            $photos = Photo::orderBy("created_at", "desc")->limit(5)->get();
            return view('index', compact("photos",'max'));  
        
      
        

    }

    /**
     * Upload form
     * @return mixed
     */
    public function create()
    {
        return view('form');
    }

    /**
     * Map page
     * @param Photo $photo
     * @return mixed
     */
    public function map(Photo $photo)
    {
        return view('map', compact('photo'));
    }

    /**
     * Store procedure
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:50',
            'description' => 'required|max:350',
            'file' => 'required|image:jpeg,png'
        ]);

        $destinationPath = public_path("photos/original");
        $iphonePath = public_path("photos/iphone");

        $filename = $this->randomFilename($request->file("file")->getClientOriginalName());

        $request->file("file")->move($destinationPath, $filename);

        $img = \Image::make($destinationPath . "/" . $filename);
        $exif = $img->exif();
        $img->orientate()->backup();

        $img->heighten(736)->save($iphonePath . "/" . $filename, 90);
        $img->reset();

       

        $photo = new Photo([
            'title' => $request->input('title'),
            'description' => $request->input('description')
        ]);

        if (isset($exif["GPSLongitude"], $exif["GPSLatitude"], $exif['GPSLongitudeRef'], $exif['GPSLatitudeRef'])) {
            $photo->lng = $this->getGps($exif["GPSLongitude"], $exif['GPSLongitudeRef']);
            $photo->lat = $this->getGps($exif["GPSLatitude"], $exif['GPSLatitudeRef']);
        }

        $photo->filename = $filename;
        list($width, $height) = getimagesize($iphonePath . "/" . $filename);
        if($width > $height) {
            $photo->type = 'landscape';
        }
        else {
            $photo->type = "vertical";
        }
        $photo->save();

        return redirect()->route('index');
    }

    /**
     * Lazy load for cards
     * @param Request $request
     * @return mixed
     */
    public function cards(Request $request)
    {
        $offset = 5 * $request->input("page", 0);

        $photos = Photo::orderBy("created_at", "desc")->offset($offset)->limit(5)->get();

        $response = [];

        foreach ($photos as $card) {
            $response[] = view("card", compact('card'))->render();

        }

        return response()->json($response);
    }

    /**
     * Lazy load for previous cards
     * @param Request $request
     * @return mixed
     */
    public function previousCards(Request $request)
    {
       $offset = $request->input("currentSlide",0)-1 ;
        $countPhotos = Photo::get()->count();

        $photos = Photo::orderBy("created_at", "asc")->offset()->limit(5)->get();

        $response = [];

        foreach ($photos as $card) {
            $response[] = view("card", compact('card'))->render();
        }

        return response()->json($response);
    }
}
