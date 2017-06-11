<?php
class Store{
    private $db, $result;
    
    public function __construct(){
        $this->db = new SQLite3('frog.db');
    }
    
    public function insertData($data){
        $now = time();
        
        $query = "INSERT INTO records 
                    (station, time, temp_low, temp_high, umid_air, umid_ground, atm_pression, lum)
                VALUES
                    ('ST-0001', 
                    $now,
                    {$data[0]},
                    {$data[1]},
                    {$data[2]},
                    {$data[3]},
                    {$data[4]},
                    {$data[5]}
                )";
        if( $this->db->exec($query) ){
            return true;
        }else{
            echo $this->db->lastErrorMsg();
        }
    }
    
    function getData( $query ){
        $result = $this->db->query($query);
        if( $result !== false ){
            $data = array();
            while( $row = $result->fetchArray() ){
                $data[] = $row;
            }
            return $data;
        }else{
            return $this->db->lastErrorMsg();
        }
    }
}