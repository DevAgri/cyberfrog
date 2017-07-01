<?php
include "analise.php";

$db = new Store();

$get = $_GET;

$do = ( !empty($get['do']) ) ? $get['do'] : "start";

// Carrega a pagina inicial
if( $do == 'start' ){
    header("Location: index.html"); 
    die();
}

// Carrega os dados da estação
if( $do == 'load-station' ){
    $query = "SELECT * FROM records WHERE station = '{$get['station']}'";
    
    $data = $db->getData($query);
    
    $html = "";
    for( $i=0;$i<count($data); $i++ ){
        $html .= "<tr><td>".date('d/m/Y H:i', $data[$i]['time'])."</td>";
        $html .= "<td>{$data[$i]['temp_high']}</td>";
        $html .= "<td>{$data[$i]['temp_low']}</td>";
        $html .= "<td>{$data[$i]['umid_air']}</td>";
        $html .= "<td>{$data[$i]['umid_ground']}</td>";
        $html .= "<td>{$data[$i]['atm_pression']}</td>";
        $html .= "<td>{$data[$i]['lum']}</td></tr>";
    }
    echo $html;
}

// Carrega os dado da analise
if( $do == 'show-analise' ){
    @$get['data_inicio'];
    
    $first_day = time() - (86400*15);
    $last_day = time();
    
    $analise = new Analise('ST-0001', $first_day, $last_day) ;
    
    $medias = $analise->getMedias();
    
    $risk_index = 0;
    
    if( $medias['temp_high'] < 31 && $medias['temp_high'] > 17 ){
        $risk_index = $risk_index + 1;
    }
    
    if( $medias['temp_low'] < 31 && $medias['temp_low'] > 17 ){
        $risk_index = $risk_index + 1;
    }
    
    if( $medias['umid_air'] < 14 && $medias['umid_air'] > 70 ){
        $risk_index = $risk_index + 1;
    }
    
    if( $medias['umid_ground'] < 14 && $medias['umid_ground'] > 80 ){
        $risk_index = $risk_index + 1;
    }
    
    $risk_index = ($risk_index*100)/5;
    
    $html = "<tr><td><center>ST-0001</center></td>";
    $html .= "<td><center>".date('d/m/Y H:i', $first_day)."</center></td>";
    $html .= "<td><center>".date('d/m/Y H:i', $last_day)."</center></td>";
    $html .= "<td><center>".$risk_index."%</center></td></tr>";
    
    echo $html;
    
}