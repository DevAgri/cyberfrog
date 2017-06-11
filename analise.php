<?php
include "store.php";

class Analise{
    
    private $station; 
    private $time_start; // Inicio da analise unix timestamp
    private $range; // range analisado numero de segundos
    private $medias_dias;
    
    public function __construct( $station = NULL, $time_start = NULL, $range = NULL ){
        $this->station = $station;
        $this->time_start = $time_start;
        $this->range = $range;
    }
    
    
    public function getMedias(){
        $db = new Store();
        
        $time_end = $this->time_start + $this->range; 
        
        $query = "SELECT * FROM records 
                WHERE 
                    station = '{$this->station}' AND
                    time > ".$this->time_start." AND 
                    time < ".$time_end." 
                ";
        $data = $db->getData($query);
        
        $medias = array(
            "temp_high" => 0,
            "temp_low" => 0,
            "umid_air" => 0,
            "umid_ground" => 0,
            "atm_pression" => 0,
            "lum" => 0
        );
        
        $range = count($data);
        for( $i=0; $i<$range;$i++ ){
            $medias['temp_high'] = $medias['temp_high'] + $data[$i]['temp_high'];
            $medias['temp_low'] = $medias['temp_low'] + $data[$i]['temp_low'];
            $medias['umid_air'] = $medias['umid_air'] + $data[$i]['umid_air'];
            $medias['umid_ground'] = $medias['umid_ground'] + $data[$i]['umid_ground'];
            $medias['atm_pression'] = $medias['atm_pression'] + $data[$i]['atm_pression'];
            $medias['lum'] = $medias['lum'] + $data[$i]['lum'];
        }
        
        $medias['temp_high'] = $medias['temp_high'] / $range;
        $medias['temp_low'] = $medias['temp_low'] / $range;
        $medias['umid_air'] = $medias['umid_air'] / $range;
        $medias['umid_ground'] = $medias['umid_ground'] / $range;
        $medias['atm_pression'] = $medias['atm_pression']  / $range;
        $medias['lum'] = $medias['lum'] / $range;
        
        return $medias;
    }
    
}