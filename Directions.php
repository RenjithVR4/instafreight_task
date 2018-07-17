<?php

// function decodeRoute(encoded) {
//     var len = encoded.length;
//     var index = 0;
//     var array = [];
//     var lat = 0;
//     var lng = 0;
//     var ele = 0;

//     while (index < len) {
//         var b;
//         var shift = 0;
//         var result = 0;
//         do {
//             b = encoded.charCodeAt(index++) - 63;
//             result |= (b & 0x1f) << shift;
//             shift += 5;
//         } while (b >= 0x20);
//         var deltaLat = ((result & 1) ? ~(result >> 1) : (result >> 1));
//         lat += deltaLat;

//         shift = 0;
//         result = 0;
//         do {
//             b = encoded.charCodeAt(index++) - 63;
//             result |= (b & 0x1f) << shift;
//             shift += 5;
//         } while (b >= 0x20);
//         var deltaLon = ((result & 1) ? ~(result >> 1) : (result >> 1));
//         lng += deltaLon;

//         array.push([lng * 1e-5, lat * 1e-5]);
//     }

//     return array;
// }

class Point
{
  /** @var float */
  private $lat;
  
  /** @var float */
  private $lng;
  
  /**
   * @param float $lat
   * @param float $lng
   */
  public function __construct($lat, $lng)
  {
    $this->lat = $lat;
    $this->lng = $lng;
  }
  
  /**
   * @return string
   */
  public function __toString()
  {
    return '(' . $this->lat . ', ' . $this->lng . ')';
  }
}

class RouteDecoder
{
  /**
   * @param string $encodedRoute
   * @return Point[]
   */
  public function decode($encodedRoute)
  {
    // @TODO port decodeRoute from Javascript

    $len = strlen($encodedRoute);
    $stringset = str_split($encodedRoute);
    $index = 0;
    $array = array();
    $lat = 0;
    $lng = 0;
    $ele = 0;

    while ($index < $len)
    {
      $b = null;

      $shift = 0;
      $result = 0;

      do
      {
        $b = ord($stringset[$index++]) - 63;
        $result |= ($b & 0x1f) << $shift;
        $shift += 5;
      }
      while ($b >= 0x20);
    
    
      $deltaLat = ($result & 1) ? ~$result >> 1 : $result >> 1;
      $lat += $deltaLat;


      $shift = 0;
      $result = 0;

      do
      {
        $b = ord($stringset[$index++]) - 63;
        $result |= ($b & 0x1f) << $shift;
        $shift += 5;
      }
      while ($b >= 0x20);

      $deltaLon = ($result & 1) ? ~$result >> 1 : $result >> 1;
      $lng += $deltaLon;

      $array[] =  array($lng * 1e-5, $lat * 1e-5);
    

    }

    return $array;

  }
}

$routeDecoder = new RouteDecoder();
$pointset = $routeDecoder->decode('mkk_Ieg_qAiPePsHd[}CzMq@`CaAfCwCvLyApG[xBKZyCpPaDjQ');

echo 'Route has ', sizeof($pointset), ' points', PHP_EOL;

foreach ($pointset as $points)
{
  foreach($points as $point)
  {
    echo $point, PHP_EOL;
  }
  
}
