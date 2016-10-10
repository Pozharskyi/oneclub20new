<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 17.08.2016
 * Time: 17:23
 */

namespace App\Http\Controllers\Delivery\Novaposhta;

use App\Http\Controllers\Controller;

class NPDeliveryPointsController extends Controller
{
    private $np;

    public function __construct()
    {
        $this->np = NPConfigController::getInstance();
    }

    public function actionGetNPCities() {

        $data = $this->np->getCities();
        $cities_data = $data['data'];

        $cities = array();

        foreach( $cities_data as $city ) {

            $cities[$city['Ref']] = $city['DescriptionRu'];
        }

        return view('delivery\nova_poshta\cities', [ 'cities' => $cities ]);
    }

    public function actionGetDeliveryPointsByCity( $city_id ) {

        $data = $this->np->getWarehouses( $city_id );
        $points_data = $data['data'];

        $points = array();

        foreach( $points_data as $point ) {

            $points[$point['Ref']] = $point['DescriptionRu'];
        }
        
        return view('delivery\nova_poshta\delivery', [ 'points' => $points ]);
    }

}