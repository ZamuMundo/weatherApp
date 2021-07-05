<?php

namespace App\Http\Controllers;

use App\Http\Requests\CityRequest;
use Illuminate\Support\Facades\Http;
use App\Repositories\ApiOpenWeatherMapRepository;
use Illuminate\Support\Collection;
use Ramsey\Uuid\Type\Decimal;

class HomeController extends Controller
{

    /**
     * @param App\Repositories\ApiOpenWeatherMapRepository
     */
    public function __construct(ApiOpenWeatherMapRepository $apiOpenWeatherMapRepository)
    {
        $this->apiOpenWeatherMapRepository = $apiOpenWeatherMapRepository;
    }

    /**
     * View Index
     * @return View index
     */
   public function index()
   {

        return view('index');
   }

   /**
    * @param CityRequest Request
    *
    *@return Json response
    */
   public function city(CityRequest $request)
   {

       $weather = $this->apiOpenWeatherMapRepository->getApiWeather($request->city);

       $status = json_decode($weather->status());

       $body = json_decode($weather->body());

       if ($request->ajax() and $status !=200) {

        return response()->json([
            'status'        =>  $status,
            ]);
       }

        if ($request->ajax() and $status==200) {

            $date_rain = $this->historyWeather($body->name);

            return response()->json([
                'status'        =>  $status,
                'city'          => $body->name,
                'country'       => $body->sys->country,
                'temp'          => $body->main->temp,
                'tempMin'       => $body->main->temp_min,
                'tempMax'       => $body->main->temp_max,
                'weather'       => $body->weather[0]->main,
                'description'   => $body->weather[0]->description,
                'icon'          => $body->weather[0]->icon,
                'sunrise'       => date('H:m:s', $body->sys->sunrise),
                'sunset'        => date('H:m:s', $body->sys->sunset),
                'lastDayRain'   => $date_rain,
            ]);
      }

   }

   /**
    * Esta funcion esta enlazada a la principal para comprobar el historial de lluvia, 5 días, incluye el actual
    * En la Documentación comenta que hay una profundidad máxima.
    *  La ruta para verlo es /history
    * @param String $city
    *
    * @return Date $date_rain
    */
   public function historyWeather($city)
   {
        date_default_timezone_set("Europe/Madrid");

        $now = now();

        $response = $this->apiOpenWeatherMapRepository->getApiWeather($city); //Cambiar la ciudad Copenhagen

        $body = json_decode($response->body());

        $date_rain = '';

        for ($i=0; $i <=4 ; $i++) {

            if($this->apiOpenWeatherMapRepository->getApiHistoryRain($body->coord->lat, $body->coord->lon, strtotime($now."- $i days")) ){
                $date_rain = date("d-M-Y", strtotime($now."- $i days") );
                break;
            }
        }

        if ($date_rain=='') {
            $date_rain = "No hay registro de día lluvioso.";
        }

       return $date_rain;
   }
}
