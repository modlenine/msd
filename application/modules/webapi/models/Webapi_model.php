<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Webapi_model extends CI_Model {
    
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->db_prodplan = $this->load->database("mssql_prodplan" , true);
        date_default_timezone_set("Asia/Bangkok");
    }

    public function getMachineList()
    {
        $received_data = json_decode(file_get_contents("php://input"));

        if($received_data->action == "getMachine_fac234"){
            $lastjobrun = [];
           
            $sql = $this->db_prodplan->query("SELECT 
            a.wrkctrid as mach_name,
            a.prodfactory,
            a.enummatchinetype,
            case
                when a.enummatchinetype = 0 then 'NONE'
                when a.enummatchinetype = 1 then 'MIXER'
                when a.enummatchinetype = 2 then 'EXTRUDER'
                when a.enummatchinetype = 3 then 'BUSS'
                when a.enummatchinetype = 4 then 'FARREL'
                when a.enummatchinetype = 5 then 'TE75'
                when a.enummatchinetype = 6 then 'TE58'
                when a.enummatchinetype = 7 then 'TE96'
                when a.enummatchinetype = 8 then 'GRINDER'
                when a.enummatchinetype = 9 then 'VIBRATOR'
                when a.enummatchinetype = 10 then 'PACKING'
                when a.enummatchinetype = 11 then 'OVEN'
                when a.enummatchinetype = 12 then 'OUTSOURCE'
                when a.enummatchinetype = 13 then 'RM PREPARE'
            end as factory ,
            b.name as mach_desc
            from slc_wrkctrfactable a
                left join wrkctrtable b on a.wrkctrid = b.wrkctrid
            where 
            (
                b.recid IN (SELECT MAX(recid) as recid FROM wrkctrtable GROUP BY wrkctrid)
            ) 
            and a.prodfactory in (2 , 3 , 4)
            and a.enummatchinetype not in (11,1)
            -- and a.enummatchinetype not in (7 , 5)
            group by a.wrkctrid , a.prodfactory , a.enummatchinetype , b.name
            order by a.prodfactory asc");

            foreach($sql->result() as $rs){
                if($this->getLastJobRun_fac234($rs->mach_name) != "null"){
                    $lastjobrun[] = $this->getLastJobRun_fac234($rs->mach_name)->row();
                }else{
                    $lastjobrun[] = "";
                }

            }

            $output = array(
                "msg" => "ดึงข้อมูลเครื่องจักรโรง 2 3 4 สำเร็จ",
                "status" => "Select Data Success",
                "machine_list" => $sql->result(),
                "lastjobrun" => $lastjobrun
            );
            echo json_encode($output);
        }else{
            $output = array(
                "msg" => "ดึงข้อมูลเครื่องจักรโรง 2 3 4 สำเร็จ",
                "status" => "Select Data Success",
            );
            echo json_encode($output);
        }

    }


    private function getLastJobRun_fac234($machine)
    {

        if($machine != ""){

            $mainFormnoArray = [];
            $resultData="";
            $sql = $this->db->query("SELECT
            fam_autoid,
            fam_formno,
            fam_prodid,
            fam_machinename,
            fam_machine,
            fam_productcode,
            fam_batchnumber,
            fam_output,
            fam_mis,
            ptwo_pagestatus
            FROM farrel_main 
            WHERE fam_machine = '$machine' AND fam_machine != ''
            AND ptwo_pagestatus = 'Start' ");

            if($sql->num_rows() != 0){
                foreach($sql->result() as $rs){
                    $mainFormnoArray[] = $rs->fam_formno;
                }

                $output = "";
                $nocount = 1 ;
                $count = count($mainFormnoArray);
                foreach($mainFormnoArray as $rs){
                    if($count == $nocount){
                        $output .= " '$rs' ";
                    }else{
                        $output .= " '$rs', ";
                    }
                    $nocount++; 
                }
    
    
                $sql2 = $this->db->query("SELECT
                far_detail_formno,
                far_main_formno,
                far_worktime,
                far_datetime
                FROM farrel_detail WHERE far_main_formno IN ($output)
                GROUP BY far_datetime ORDER BY far_datetime DESC LIMIT 1");
    
                $condition = "";
                if($sql2->num_rows() != 0){
                    $lastJobMainform = $sql2->row()->far_main_formno;
                    $condition = "fam_formno = '$lastJobMainform' ";
                }else{
                    $lastJobMainform = "";
                    $condition = "fam_machine = '$machine' ";
                }
    
                $sql3 = $this->db->query("SELECT
                fam_autoid,
                fam_formno,
                fam_prodid,
                fam_machinename,
                fam_machine,
                fam_productcode,
                fam_batchnumber,
                fam_output,
                fam_mis,
                ptwo_pagestatus
                FROM farrel_main 
                WHERE $condition AND ptwo_pagestatus = 'start' ");

                $resultData = $sql3;

            }else{
                $resultData = "null";
            }

            return $resultData;

        }

    }


    public function loadHistoryList_fac234()
    {
        $received_data = json_decode(file_get_contents("php://input"));
        if($received_data->action == "loadHistoryList_fac234"){
            $machine = $received_data->machine;

            if($received_data->search != ""){

                $search = $received_data->search;
                $idArr = explode(" ", $search);

                $context = " CONCAT(fam_prodid,' ', 
                            fam_batchnumber,' ', 
                            fam_productcode,' ',
                            fam_formno,' ',
                            fam_machinename) "; 

                $condition = " $context LIKE '%" . implode("%' OR $context LIKE '%", $idArr) . "%' AND ";

            }else{
                $condition = "";
            }

            $sql = $this->db->query("SELECT
            farrel_main.fam_autoid,
            farrel_main.fam_formno,
            farrel_main.fam_prodid,
            farrel_main.fam_machinename,
            farrel_main.fam_machine,
            farrel_main.fam_productcode,
            farrel_main.fam_batchnumber,
            farrel_main.ptwo_pagestatus,
            farrel_main.ptwo_datetimestart
            FROM
            farrel_main
            WHERE $condition
            farrel_main.fam_machine = '$machine' and ptwo_pagestatus in ('Start' , 'Stop' , 'Wait Start')
            ORDER BY
            farrel_main.fam_autoid DESC;");


            $output = array(
                "msg" => "ดึงประวัติการเดินเครื่องสำเร็จ",
                "status" => "Select Data Success",
                "result" => $sql->result()
            );
        }else{
            $output = array(
                "msg" => "ดึงประวัติการเดินเครื่องไม่สำเร็จ",
                "status" => "Select Data Not Success",
            );
        }

        echo json_encode($output);
    }



    
    

}

/* End of file ModelName.php */

?>