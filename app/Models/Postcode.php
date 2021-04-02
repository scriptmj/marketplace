<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class Postcode extends Model
{
    protected $table = "4pp";
    use HasFactory;

    // public function getLat(){
    //     return $this->latitude;
    // }

    // public function getLong(){
    //     return $this->longitude;
    // }

    public function getDistance(Postcode $userLocation, Postcode $itemLocation){
        $delta_lat = $userLocation->latitude - $itemLocation->latitude;
        $delta_lon = $userLocation->longitude - $itemLocation->longitude;

        $earth_radius = 6372.795477598;

        $alpha    = $delta_lat/2;
        $beta     = $delta_lon/2;
        $a        = sin(deg2rad($alpha)) * sin(deg2rad($alpha)) + cos(deg2rad($itemLocation->latitude)) * cos(deg2rad($userLocation->latitude)) * sin(deg2rad($beta)) * sin(deg2rad($beta)) ;
        $c        = asin(min(1, sqrt($a)));
        $distance = 2*$earth_radius * $c;
        $distance = round($distance, 4);

        return $this->measure = $distance;
    }

    public function getPostcodesByDistance($distance){
        $query = "SELECT id FROM (
            SELECT *, 
                (
                    (
                        (
                            acos(
                                sin(( $this->latitude * pi() / 180))
                                *
                                sin(( `latitude` * pi() / 180)) + cos(( $this->latitude * pi() /180 ))
                                *
                                cos(( `latitude` * pi() / 180)) * cos((( $this->longitude - `longitude`) * pi()/180)))
                        ) * 180/pi()
                    ) * 60 * 1.1515 * 1.609344
                )
            as distance FROM `4pp`
        ) 4pp
        WHERE distance <= $distance;";
        $postcodesWithinRange = DB::select($query);
        $postcodeIDs = new Collection();
        foreach($postcodesWithinRange as $postcode){
            $postcodeIDs->push($postcode->id);
        }
        return $postcodeIDs;
    }

}
