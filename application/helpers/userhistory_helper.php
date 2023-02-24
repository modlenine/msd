<?php
class userhistory{
    private $ci;
    function __construct(){
        $this->ci =&get_instance();
        date_default_timezone_set("Asia/Bangkok");
    }
    function userhis(){
        return $this->ci;
    }
}

function uhis()
{
    $obj = new userhistory();
    return $obj->userhis();
}
//Setting Helper


function saveHistory($templatename="" , $itemid = "" , $dataareaid = "" , $detail , $menu="" , $actionType="" , $ip="")
{
    if($detail != ""){
        $arInsertHistory = array(
            "temhis_templatename" => $templatename ,
            "temhis_itemid" => $itemid , 
            "temhis_dataareaid" => $dataareaid ,
            "temhis_user" => getUser()->Fname." ".getUser()->Lname,
            "temhis_ecode" => getUser()->ecode,
            "temhis_deptcode" => getUser()->DeptCode,
            "temhis_datetime" => date("Y-m-d H:i:s"),
            "temhis_detail" => $detail,
            "temhis_menu" => $menu ,
            "temhis_type" => $actionType ,
            "temhis_ip" => $ip
        );
        uhis()->db->insert("msd_template_history" , $arInsertHistory);
        return "บันทึกประวัติสำเร็จ";
    }else{
        return "บันทึกประวัติไม่สำเร็จ";
    }
}

?>