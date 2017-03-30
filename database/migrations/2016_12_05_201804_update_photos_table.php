<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Photo;
class UpdatePhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('photos', function ($table) {
            
            $table->string('type',45);
            
        });
        $photos = Photo::get();
        foreach ($photos as  $photo) {
            list($width, $height) = getimagesize(public_path("photos/iphone") . "/" . $photo->filename);
            if($width > $height) {
                $photo->type = 'landscape';
            }
            else {
                $photo->type = "vertical";
            }
            $photo->save();

        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
