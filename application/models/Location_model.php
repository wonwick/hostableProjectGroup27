<?php

class Location_model extends CI_Model
{





//
//    function employeeLocation()
//    {
//        $this->db->select('EmpID');
//        $this->db->from('employee');
//        $this->db->where('EmpID','e1');
//        $a = $this->db->get()->result_array();
//        $data['results'] = $a;
//
//        $sql = mysql_query ("SELECT zip, city FROM zips WHERE city LIKE '%{$query}%' OR zip LIKE '%{$query}%'");
//        return $a;
//
//
//    }




    public function getLocations($type)  {



        $query = "SELECT * FROM location WHERE TimeStamp IN (SELECT max(TimeStamp) FROM location GROUP BY EmpID ) ORDER BY TimeStamp DESC ";

        $result = $this->db->query($query);
        if ($result->num_rows()>0) {

            return $result->result_array();

        }
    }

}









