<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Machine_model extends CI_Model
{


    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Bangkok");
        $this->db3 = $this->load->database("prodplan", true);
        $this->db4 = $this->load->database("mssql_prodplan", true);
    }






/////////////////////////////////////////////////////////////////////////////////
////////setting.html ส่วนของบริหารจัดการข้อมูลหน้า Setting page
////////////////////////////////////////////////////////////////////////////////
    public function saveMachineTemplate()
    {
        if ($this->input->post("machineName")) {
            $arsave_machinetemplate = array(
                "mat_column_name" => $this->input->post("runscreenName"),
                "mat_machine_name" => $this->input->post("machineName"),
                "mat_machine_type" => $this->input->post("runscreenType"),
                "mat_userpost" => getUser()->Fname." ".getUser()->Lname,
                "mat_ecodepost" => getUser()->ecode,
                "mat_datetime" => date("Y-m-d H:i:s")
            );
            $this->db->insert("machine_template" , $arsave_machinetemplate);

            $output = array(
                "machine_name" => $this->input->post("mat_machine_name"),
                "column_name" => $this->input->post("mat_column_name"),
                "status" => "insert success"
            );

            echo json_encode($output);
            
        } else {
            echo "ไม่มีข้อมูล";
        }
    }


    public function getListMachineTemp()
    {
        $machineName = "";
        if($this->input->post("machineName")){
            $machineName = $this->input->post("machineName");
            $sql = $this->db->query("SELECT
            machine_template.mat_machine_name
            FROM
            machine_template
            WHERE mat_machine_name like '%$machineName%' group by mat_machine_name ORDER BY mat_autoid DESC LIMIT 5 
            ");

            if($sql->num_rows() == 0){
                $output = '
                <div class="list-group">
                    <a href="javascript:void(0)" class="list-group-item list-group-item-action list-group-item-info getDataFromTemp"
                        data_mat_machine_name="'.$machineName.'"
                    >'.$machineName.'</a>
                ';
            }else{
                $output = '<div class="list-group">';
                foreach($sql->result() as $rs){
                    $output .='
                    <a href="javascript:void(0)" class="list-group-item list-group-item-action list-group-item-light getDataFromTemp"
                        data_mat_machine_name="'.$rs->mat_machine_name.'"
                    >'.$rs->mat_machine_name.'</a>
                    ';
                }
                $output .='</div>';
            }

            

            echo $output;
        }
    }



    public function checkDuplicateRunscreen()
    {
        $machineName = "";
        $runscreenName = "";
        $runscreenType = "";

        if($this->input->post("machineName")){
            $machineName = $this->input->post("machineName");
            $runscreenName = $this->input->post("runscreenName");
            $runscreenType = $this->input->post("runscreenType");

            $sql = $this->db->query("SELECT
            machine_template.mat_column_name,
            machine_template.mat_machine_name,
            machine_template.mat_machine_type
            FROM
            machine_template
            WHERE mat_column_name = '$runscreenName' AND mat_machine_name = '$machineName' AND mat_machine_type = '$runscreenType' 
            ");
            if($sql->num_rows() > 0){
                $output = array(
                    "msg" => "พบข้อมูลซ้ำในระบบ",
                    "status" => "notok"
                );
            }else{
                $output = array(
                    "msg" => "ไม่พบข้อมูลซ้ำในระบบ",
                    "status" => "ok"
                );
            }
            echo json_encode($output);
        }
    }


 


    public function getRunscreenMaster()
    {
        $sql = $this->db->query("SELECT
        runscreen_master.run_autoid,
        runscreen_master.run_name,
        runscreen_master.run_userpost,
        runscreen_master.run_ecodepost,
        runscreen_master.run_datetime,
        runscreen_master.run_type
        FROM
        runscreen_master
        order by run_autoid desc
        ");

            $output = '
            <h5>Run screen Master</h5>
                <div class="table-responsive">
                    <table id="runscreen_master_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Run screen</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                    ';
        foreach($sql->result() as $rs){
            $output .= '
            <tr>
                <td>' . $rs->run_name . '</td>
                <td>
                <i class="icon-line-chevrons-right iconMachineEdit" 
                    data_run_name = "'.$rs->run_name.'"
                    data_run_type = "'.$rs->run_type.'" 
                ></i></td>
            </tr>
            ';
        }

            $output .= '
                        </tbody>
                    </table>
                </div>
                ';

        echo $output;


    }




    public function getRunscreenMasterNew_arrayNull($action)
    {

        $sql = $this->db->query("SELECT
            runscreen_master.run_autoid,
            runscreen_master.run_name,
            runscreen_master.run_minvalue,
            runscreen_master.run_maxvalue,
            runscreen_master.run_spoint,
            runscreen_master.run_linenum,
            runscreen_master.run_type
            FROM
            runscreen_master
            order by run_autoid desc
            ");

        

        $output = '';

        if($action != "edit_template"){
            $output .= '<ul class="list-group runScMaster">';
                foreach ($sql->result() as $rs) {
                    $output .= '
                    <a href="#" id="runScMaster_attr"
                    data_run_autoid = "' . $rs->run_autoid . '"
                    data_run_name = "' . $rs->run_name . '"
                    data_run_minvalue = "' . $rs->run_minvalue . '"
                    data_run_maxvalue = "' . $rs->run_maxvalue . '"
                    data_run_spoint = "' . $rs->run_spoint . '"
                    data_run_linenum = "' . $rs->run_linenum . '"
                    data_run_type = "'.$rs->run_type.'"
                    ><li class="list-group-item mb-1 runScMasLi">
                    <span>' . $rs->run_name . '</span><br>
                    <span><b>Min : </b>'.conNumToText($rs->run_minvalue).'</span>&nbsp;&nbsp;<span><b>Max : </b>'.conNumToText($rs->run_maxvalue).'</span><br>
                    <span><b>SPoint : </b>'.conNumToText($rs->run_spoint).'</span>&nbsp;&nbsp;<span><b>Type : </b>'.$rs->run_type.'</span>
                    <i class="icon-caret-right1 runScMasI"></i>
                    </li></a>
                ';
                }
            $output .= '</ul>';
            echo $output;
        }else{
            $output .= '<ul class="list-group runScMaster">';
                foreach ($sql->result() as $rs) {
                    $output .= '
                    <a href="javascript:void(0)" id="runScMaster_attr_edit" class="runScMaster_attr_edit"
                    data_run_autoid = "' . $rs->run_autoid . '"
                    data_run_name = "' . $rs->run_name . '"
                    data_run_minvalue = "' . $rs->run_minvalue . '"
                    data_run_maxvalue = "' . $rs->run_maxvalue . '"
                    data_run_spoint = "' . $rs->run_spoint . '"
                    data_run_linenum = "' . $rs->run_linenum . '"
                    data_run_type = "'.$rs->run_type.'"
                    ><li class="list-group-item mb-1 runScMasLi_edit">
                    <span>' . $rs->run_name . '</span><br>
                    <span><b>Min : </b>'.conNumToText($rs->run_minvalue).'</span>&nbsp;&nbsp;<span><b>Max : </b>'.conNumToText($rs->run_maxvalue).'</span><br>
                    <span><b>SPoint : </b>'.conNumToText($rs->run_spoint).'</span>&nbsp;&nbsp;<span><b>Type : </b>'.$rs->run_type.'</span>
                    <i class="icon-caret-right1 runScMasI_edit"></i>
                    </li></a>
                ';
                }
            $output .= '</ul>';
            echo $output;
        }
        

    }



    public function getRunscreenMasterNew_search()
    {
        if($this->input->post("searchMasterRun") != ""){
            $searchMasterRun = $this->input->post("searchMasterRun");
            $condition = " where run_name like '%$searchMasterRun%' OR run_type like '%$searchMasterRun%' ";
        }else{
            $condition = "";
        }

        $sql = $this->db->query("SELECT
            runscreen_master.run_autoid,
            runscreen_master.run_name,
            runscreen_master.run_minvalue,
            runscreen_master.run_maxvalue,
            runscreen_master.run_spoint,
            runscreen_master.run_linenum,
            runscreen_master.run_type
            FROM
            runscreen_master
            $condition
            order by run_autoid desc
            ");

        

        $output = '';
        if($this->input->post("action") != "edit_template"){
            $output .= '<ul class="list-group runScMaster">';
                foreach ($sql->result() as $rs) {
            
                    $output .= '
                    <a href="#" id="runScMaster_attr"
                    data_run_autoid = "' . $rs->run_autoid . '"
                    data_run_name = "' . $rs->run_name . '"
                    data_run_minvalue = "' . $rs->run_minvalue . '"
                    data_run_maxvalue = "' . $rs->run_maxvalue . '"
                    data_run_spoint = "' . $rs->run_spoint . '"
                    data_run_linenum = "' . $rs->run_linenum . '"
                    data_run_type = "'.$rs->run_type.'"
                    ><li class="list-group-item mb-1 runScMasLi">
                    <span>' . $rs->run_name . '</span><br>
                    <span><b>Min : </b>'.conNumToText($rs->run_minvalue).'</span>&nbsp;&nbsp;<span><b>Max : </b>'.conNumToText($rs->run_maxvalue).'</span><br>
                        <span><b>SPoint : </b>'.conNumToText($rs->run_spoint).'</span>&nbsp;&nbsp;<span><b>Type : </b>'.conNumToText($rs->run_type).'</span>
                    <i class="icon-caret-right1 runScMasI"></i>
                    </li></a>
                ';
                }
            $output .= '</ul>';
            echo $output;
        }else{
            $output .= '<ul class="list-group runScMaster_edit">';
                foreach ($sql->result() as $rs) {
            
                    $output .= '
                    <a href="javascript:void(0)" id="runScMaster_attr_edit" class="runScMaster_attr_edit"
                    data_run_autoid = "' . $rs->run_autoid . '"
                    data_run_name = "' . $rs->run_name . '"
                    data_run_minvalue = "' . $rs->run_minvalue . '"
                    data_run_maxvalue = "' . $rs->run_maxvalue . '"
                    data_run_spoint = "' . $rs->run_spoint . '"
                    data_run_linenum = "' . $rs->run_linenum . '"
                    data_run_type = "'.$rs->run_type.'"
                    ><li class="list-group-item mb-1 runScMasLi_edit">
                    <span>' . $rs->run_name . '</span><br>
                    <span><b>Min : </b>'.conNumToText($rs->run_minvalue).'</span>&nbsp;&nbsp;<span><b>Max : </b>'.conNumToText($rs->run_maxvalue).'</span><br>
                        <span><b>SPoint : </b>'.conNumToText($rs->run_spoint).'</span>&nbsp;&nbsp;<span><b>Type : </b>'.conNumToText($rs->run_type).'</span>
                    <i class="icon-caret-right1 runScMasI_edit"></i>
                    </li></a>
                ';
                }
            $output .= '</ul>';
            echo $output;
        }
    }




    public function countTotalRunmaster()
    {
        $dataUse = $this->input->post("dataUse");
        if($dataUse == ""){
            $sql = $this->db->query("SELECT run_linenum FROM runscreen_master");
            $countTotalRunmaster = $sql->num_rows();

            $output = array(
                "msg" => "นับข้อมูลเรียบร้อยแล้ว",
                "status" => "Count Data Success",
                "countdata" => $countTotalRunmaster
            );

            echo json_encode($output);
        }else{
            $sql = $this->db->query("SELECT run_linenum FROM runscreen_master WHERE run_linenum NOT IN ($dataUse)");
            $countTotalRunmaster = $sql->num_rows();

            $output = array(
                "msg" => "นับข้อมูลเรียบร้อยแล้ว",
                "status" => "Count Data Success",
                "countdata" => $countTotalRunmaster
            );

            echo json_encode($output);
        }
        
    }




    public function countTotalRunTemp()
    {
        $templatename = "";
        $countTotalTemp = "";
        if($this->input->post("templatename") != ""){
            $templatename = $this->input->post("templatename");
            $sql = $this->db->query("SELECT mat_linenum FROM machine_template_temp WHERE mat_machine_name = '$templatename' ");
            $countTotalTemp = $sql->num_rows();
            $output = array(
                "msg" => "นับจำนวน Runscreen ในตาราง Temp เรียบร้อยแล้ว",
                "status" => "Count Data Success",
                "countdata" => $countTotalTemp
            );
        }else{
            $output = array(
                "msg" => "นับจำนวน Runscreen ในตาราง Temp เรียบร้อยแล้ว",
                "status" => "Count Data Success",
                "countdata" => 0
            );
        }
        

        echo json_encode($output);
    }






    public function getRunscreenMasterNew2()
    {

        if($this->input->post("linenumUsed") != ""){

            $searchMasterRun = $this->input->post("searchMasterRun");
            $linenum = $this->input->post("linenumUsed");

            $sql = $this->db->query("SELECT
            runscreen_master.run_autoid,
            runscreen_master.run_name,
            runscreen_master.run_minvalue,
            runscreen_master.run_maxvalue,
            runscreen_master.run_spoint,
            runscreen_master.run_linenum,
            runscreen_master.run_type
            FROM
            runscreen_master
            WHERE run_linenum NOT IN ($linenum)
            AND run_name LIKE '%$searchMasterRun%'
            order by run_autoid desc
            ");
            $output = '';

            if($this->input->post("action") != "edit_template"){
                $output .= '<ul class="list-group runScMaster">';
                    foreach ($sql->result() as $rs) {
                
                        $output .= '
                        <a href="#" id="runScMaster_attr"
                        data_run_autoid = "' . $rs->run_autoid . '"
                        data_run_name = "' . $rs->run_name . '"
                        data_run_minvalue = "' . $rs->run_minvalue . '"
                        data_run_maxvalue = "' . $rs->run_maxvalue . '"
                        data_run_spoint = "' . $rs->run_spoint . '"
                        data_run_linenum = "' . $rs->run_linenum . '"
                        data_run_type = "'.$rs->run_type.'"
                        ><li class="list-group-item mb-1 runScMasLi">
                        <span>' . $rs->run_name . '</span><br>
                        <span><b>Min : </b>'.conNumToText($rs->run_minvalue).'</span>&nbsp;&nbsp;<span><b>Max : </b>'.conNumToText($rs->run_maxvalue).'</span><br>
                        <span><b>SPoint : </b>'.conNumToText($rs->run_spoint).'</span>&nbsp;&nbsp;<span><b>Type : </b>'.conNumToText($rs->run_type).'</span>
                        <i class="icon-caret-right1 runScMasI"></i>
                        </li></a>
                    ';
                    }
                $output .= '</ul>';
                echo $output;
            }else{
                $output .= '<ul class="list-group runScMaster_edit">';
                    foreach ($sql->result() as $rs) {
                
                        $output .= '
                        <a href="javascript:void(0)" id="runScMaster_attr_edit" class="runScMaster_attr_edit"
                        data_run_autoid = "' . $rs->run_autoid . '"
                        data_run_name = "' . $rs->run_name . '"
                        data_run_minvalue = "' . $rs->run_minvalue . '"
                        data_run_maxvalue = "' . $rs->run_maxvalue . '"
                        data_run_spoint = "' . $rs->run_spoint . '"
                        data_run_linenum = "' . $rs->run_linenum . '"
                        data_run_type = "'.$rs->run_type.'"
                        ><li class="list-group-item mb-1 runScMasLi_edit">
                        <span>' . $rs->run_name . '</span><br>
                        <span><b>Min : </b>'.conNumToText($rs->run_minvalue).'</span>&nbsp;&nbsp;<span><b>Max : </b>'.conNumToText($rs->run_maxvalue).'</span><br>
                        <span><b>SPoint : </b>'.conNumToText($rs->run_spoint).'</span>&nbsp;&nbsp;<span><b>Type : </b>'.conNumToText($rs->run_type).'</span>
                        <i class="icon-caret-right1 runScMasI_edit"></i>
                        </li></a>
                    ';
                    }
                $output .= '</ul>';
                echo $output;
            }
        }else{
            $this->getRunscreenMasterNew_search();
        }

        

    }





    public function truncate_machine_template_temp()
    {
        if($this->db->truncate('machine_template_temp'))
        {
            //ลบไฟล์ออกจาก server
            $getfile = $this->db->query("SELECT ted_template_image FROM msd_template_detail_temp");

            if($getfile->num_rows() != 0){
                //ลบรูปภาพออกจาก Folder
                if($getfile->row()->ted_template_image != ""){
                    $path = $_SERVER['DOCUMENT_ROOT']."/intsys/msd/upload/images_template_temp/".$getfile->row()->ted_template_image;
                    if(file_exists($path) != 0){
                        unlink($path);
                    }
                    
                }
            }
            
            $this->db->truncate('msd_template_detail_temp');

            $output = array(
                "msg" => "Clear machine_template_temp successfuly",
                "status" => "Truncate successfuly"
            );

            echo json_encode($output);
        }
    }



    public function saveDataToMachineTemplate()
    {

        // insert itemcode to msd_template_detail
        if($this->input->post("itemid") != ""){
            $itemid = $this->input->post("itemid");
            $itemidOld = $this->input->post("itemidOld");
            $templatename = $this->input->post("templatename");
            $templatenameOld = $this->input->post("templatenameOld");
            $dataareaid = $this->input->post("dataareaid");
            $dataareaidOld = $this->input->post("dataareaidOld");

            $arUpdateTemplateDetailTemp = array(
                "ted_template_itemuse" => $itemid,
                "ted_template_dataareaid" => $dataareaid
            );
            $this->db->where("ted_template_name" , $templatename);
            $this->db->update("msd_template_detail_temp" , $arUpdateTemplateDetailTemp);
        }

        // Insert data to machine template table
        $sql = $this->db->query("SELECT
        machine_template_temp.mat_column_name,
        machine_template_temp.mat_machine_name,
        machine_template_temp.mat_machine_type,
        machine_template_temp.mat_min_value,
        machine_template_temp.mat_max_value,
        machine_template_temp.mat_spoint_value,
        machine_template_temp.mat_linenum,
        machine_template_temp.mat_master_linenum,
        machine_template_temp.mat_userpost,
        machine_template_temp.mat_ecodepost,
        machine_template_temp.mat_datetime
        FROM
        machine_template_temp
        WHERE mat_machine_name = '$templatename' ");

        foreach($sql->result() as $rs){
            $arSaveToMachineTemplate = array(
                "mat_column_name" => $rs->mat_column_name,
                "mat_machine_name" => $rs->mat_machine_name,
                "mat_machine_type" => $rs->mat_machine_type,
                "mat_min_value" => $rs->mat_min_value,
                "mat_max_value" => $rs->mat_max_value,
                "mat_spoint_value" => $rs->mat_spoint_value,
                "mat_linenum" => $rs->mat_linenum,
                "mat_master_linenum" => $rs->mat_master_linenum,
                "mat_userpost" => getUser()->Fname." ".getUser()->Lname,
                "mat_ecodepost" => getUser()->ecode,
                "mat_datetime" => date("Y-m-d H:i:s")
            );
            $this->db->insert("machine_template" , $arSaveToMachineTemplate);
        }


        $this->db->where("mat_machine_name" , $templatename);
        $this->db->delete("machine_template_temp");
        // Insert data to machine template table

        $sql2 = $this->db->query("SELECT
        msd_template_detail_temp.ted_template_name,
        msd_template_detail_temp.ted_template_image,
        msd_template_detail_temp.ted_template_itemuse,
        msd_template_detail_temp.ted_template_user,
        msd_template_detail_temp.ted_template_ecode,
        msd_template_detail_temp.ted_template_deptcode,
        msd_template_detail_temp.ted_template_datetime,
        msd_template_detail_temp.ted_template_user_modi,
        msd_template_detail_temp.ted_template_ecode_modi,
        msd_template_detail_temp.ted_template_deptcode_modi,
        msd_template_detail_temp.ted_template_datetime_modi,
        msd_template_detail_temp.ted_template_remark,
        msd_template_detail_temp.ted_template_dataareaid,
        msd_template_detail_temp.ted_template_bomid
        FROM
        msd_template_detail_temp
        WHERE ted_template_name = '$templatename' ");

        foreach($sql2->result() as $rs){
            $arSaveToTemplateDetail = array(
                "ted_template_name" => $rs->ted_template_name,
                "ted_template_image" => $rs->ted_template_image,
                "ted_template_itemuse" => $rs->ted_template_itemuse,
                "ted_template_remark" => $rs->ted_template_remark,
                "ted_template_dataareaid" => $rs->ted_template_dataareaid,
                "ted_template_bomid" => $rs->ted_template_bomid,
                "ted_template_user" => getUser()->Fname." ".getUser()->Lname,
                "ted_template_ecode" => getUser()->ecode,
                "ted_template_deptcode" => getUser()->DeptCode,
                "ted_template_datetime" => date("Y-m-d H:i:s")
            );
            $this->db->insert("msd_template_detail" , $arSaveToTemplateDetail);
        }

        // Check Copy Data
        if($templatenameOld != "" && $itemidOld != "" && $dataareaidOld != ""){

            $getBomTemplateOld = $this->db->query("SELECT
            b_bomid,
            b_linenum,
            b_rawmaterial,
            b_bomqty,
            b_bomqtyuse,
            b_bomqtyusemix,
            b_bombalance,
            b_bomtype,
            b_bomstatus
            FROM msd_template_bom
            WHERE b_templatename = '$templatenameOld' AND b_itemid = '$itemidOld' AND b_dataareaid = '$dataareaidOld'
            ORDER BY b_autoid ASC
            ");

            foreach($getBomTemplateOld->result() as $rs){
                $arCopyBom = array(
                    "b_templatename" => $templatename,
                    "b_dataareaid" => $dataareaid,
                    "b_itemid" => $itemid,
                    "b_bomid" => $rs->b_bomid,
                    "b_linenum" => $rs->b_linenum,
                    "b_rawmaterial" => $rs->b_rawmaterial,
                    "b_bomqty" => $rs->b_bomqty,
                    "b_bomqtyuse" => $rs->b_bomqtyuse,
                    "b_bomqtyusemix" => $rs->b_bomqtyusemix,
                    "b_bombalance" => $rs->b_bombalance,
                    "b_bomtype" => $rs->b_bomtype,
                    "b_bomstatus" => $rs->b_bomstatus,
                    "b_ecode" => getUser()->ecode
                );
                $this->db->insert("msd_template_bom" , $arCopyBom);
            }

            $getFeederTemplateOld = $this->db->query("SELECT
            faf_bomid,
            faf_feedername,
            faf_rawmaterial,
            faf_value,
            faf_inlet
            FROM msd_template_feeder
            WHERE faf_templatename = '$templatenameOld' AND faf_dataareaid = '$dataareaidOld' AND faf_itemid = '$itemidOld'
            ORDER BY faf_autoid ASC
            ");

            foreach($getFeederTemplateOld->result() as $rs){
                $rawmaterial = $rs->faf_rawmaterial;
                $sqlgetbomautoid = $this->db->query("SELECT b_autoid FROM msd_template_bom WHERE b_rawmaterial = '$rawmaterial' AND b_templatename = '$templatename' AND b_dataareaid = '$dataareaid' AND b_itemid = '$itemid' ");
                $bautoid = null;
                if($sqlgetbomautoid->num_rows() != 0){
                    $bautoid = $sqlgetbomautoid->row()->b_autoid;
                }

                $arCopyFeeder = array(
                    "faf_bomid" => $rs->faf_bomid,
                    "faf_templatename" => $templatename,
                    "faf_dataareaid" => $dataareaid,
                    "faf_itemid" => $itemid,
                    "faf_feedername" => $rs->faf_feedername,
                    "faf_rawmaterial" => $rs->faf_rawmaterial,
                    "faf_value" => $rs->faf_value,
                    "faf_inlet" => $rs->faf_inlet,
                    "faf_userpost" => getUser()->Fname." ".getUser()->Lname,
                    "faf_ecodepost" => getUser()->ecode,
                    "faf_deptcodepost" => getUser()->DeptCode,
                    "faf_datetime" => date("Y-m-d H:i:s"),
                    "faf_b_autoid" => $bautoid
                );
                $this->db->insert("msd_template_feeder" , $arCopyFeeder);
            }
        }

        $getfile = @$sql2->row()->ted_template_image;

        if($getfile != ""){
            $pathFrom = $_SERVER['DOCUMENT_ROOT']."/intsys/msd/upload/images_template_temp/".$getfile;
            $pathTo = $_SERVER['DOCUMENT_ROOT']."/intsys/msd/upload/images_template/".$getfile;
            $path = $_SERVER['DOCUMENT_ROOT']."/intsys/msd/upload/images_template_temp/".$getfile;
            if(file_exists($path) != 0){
                @copy($pathFrom , $pathTo);
                @unlink($path);
            }
            
        }
        $this->db->where("ted_template_name" , $templatename);
        $this->db->delete("msd_template_detail_temp");

        //save History Zone
        $detail = "สร้าง Template ใหม่";
        $itemidHis = $this->input->post("itemid");
        $dataareaidHis = $this->input->post("dataareaid");
        $menu = "สร้าง Template";
        $actionType = "create data";
        $ip = $this->input->ip_address();

        if($this->input->post("itemidOld") != ""){
            $oldtemplateHis = $this->input->post("templatenameOld");
            $detail = "สร้าง Template ใหม่โดยการ Copy Template ต้นฉบับชื่อ : $oldtemplateHis";
        }
        $historyRsponse = saveHistory($templatename , $itemidHis , $dataareaidHis , $detail , $menu , $actionType , $ip);
        

        $output = array(
            "msg" => "บันทึกข้อมูลสำเร็จ",
            "status" => "Insert Success",
            "historyRes" => $historyRsponse
        );

        echo json_encode($output);
    }



    public function checkEditTemplateDuplicate()
    {
        if($this->input->post("checkTname") != ""){
            $checkTname = $this->input->post("checkTname");

            // Check Old data
            $checkOldData = $this->db->query("SELECT
            mat_machine_name
            FROM
            machine_template
            WHERE mat_machine_name = '$checkTname'
            GROUP BY mat_machine_name");

            if($checkOldData->num_rows() != 0){
                $output = array(
                    "msg" => "ไม่สามารถเปลี่ยนเป็นชื่อนี้ได้เนื่องจากชื่อซ้ำในระบบ",
                    "status" => "Found Duplicate Template Name"
                );
                
            }else{
                $output = array(
                    "msg" => "สามารถใช้ชื่อนี้ได้",
                    "status" => "Not Found Duplicate Template Name"
                );
            }
            
        }else{
            $output = array(
                "msg" => "ไม่มีการเปลี่ยนแปลงชื่อ Template",
                "status" => "Non Effect"
            );
        }

        echo json_encode($output);
    }




    public function saveDataToMachineTemplate_edit()
    {

        // Delete data From Template table Frist
        
        if($this->input->post("oldtemplate") != ""){
            //เช็ค Template เดิม
            $oldtemplate = $this->input->post("oldtemplate");
            $editfile = $this->input->post("editfile");
            $templatename = $this->input->post("templatename");
            $checkTname = $this->input->post("checkTname");
            $checkItemId = $this->input->post("checkItemId");
            $templatememo = $this->input->post("templatememo");
            $dataareaid = $this->input->post("dataareaid");

            if($checkTname != ""){
                //ตรวจสอบว่ามีการเปลี่ยนแปลงชื่อ Template หรือไม่ ถ้ามีการเปลี่ยนแปลง

                // Updata in Temp table คือให้ทำการอัพเดตใน Temp table ให้เสร็จก่อน
                $selectTemp = $this->db->query("SELECT mat_autoid , mat_machine_name FROM machine_template_temp WHERE mat_machine_name = '$oldtemplate' ORDER BY mat_autoid ASC");

                foreach($selectTemp->result() as $rs){
                    $arUpdateNewTemplateName = array(
                        "mat_machine_name" => $checkTname
                    );
                    $this->db->where("mat_machine_name" , $rs->mat_machine_name);
                    $this->db->update("machine_template_temp",$arUpdateNewTemplateName);
                }

                // Manage File
                // $getFileOnDetailTable = $this->db->query("SELECT ted_template_image FROM msd_template_detail WHERE ted_template_name = '$oldtemplate' ");
                // if($getFileOnDetailTable->num_rows() != 0){
                //     $path = $_SERVER['DOCUMENT_ROOT']."/intsys/msd/upload/images_template/".$getFileOnDetailTable->row()->ted_template_image;
                //     unlink($path);
                    
                // }

                
                // อัพเดต Table Detail 
                if($checkItemId != ""){//ตรวจสอบก่อนว่า Itemid มีการเปลี่ยนแปลงไหม
                    // Update Template Name in msd_template_detail
                    $arUpdateTemplateNameDetail = array(
                        "ted_template_name" =>$checkTname,
                        "ted_template_itemuse" => strtoupper($checkItemId),
                        "ted_template_remark" => $templatememo,
                        "ted_template_dataareaid" => $dataareaid
                    );
                    $this->db->where("ted_template_name" , $oldtemplate);
                    $this->db->update("msd_template_detail_temp" , $arUpdateTemplateNameDetail);
                }else{
                    // Update Template Name in msd_template_detail
                    $arUpdateTemplateNameDetail = array(
                        "ted_template_name" =>$checkTname,
                        "ted_template_remark" => $templatememo,
                        "ted_template_dataareaid" => $dataareaid
                    );
                    $this->db->where("ted_template_name" , $oldtemplate);
                    $this->db->update("msd_template_detail_temp" , $arUpdateTemplateNameDetail);
                }



                
            }else{
                $arupdateRemark = array(
                    "ted_template_remark" => $templatememo,
                    "ted_template_dataareaid" => $dataareaid
                );
                $this->db->where("ted_template_name" , $oldtemplate);
                $this->db->update("msd_template_detail_temp" , $arupdateRemark);
            }






            if($checkItemId != ""){

                if($checkTname != ""){
                    $arUpdateItemID = array(
                        "ted_template_itemuse" => strtoupper($checkItemId),
                        "ted_template_name" =>$checkTname,
                        "ted_template_dataareaid" => $dataareaid
                    );
                    $this->db->where("ted_template_name" , $oldtemplate);
                    $this->db->update("msd_template_detail_temp" , $arUpdateItemID);
                }else{
                    $arUpdateItemID = array(
                        "ted_template_itemuse" => strtoupper($checkItemId),
                        "ted_template_dataareaid" => $dataareaid
                    );
                    $this->db->where("ted_template_name" , $oldtemplate);
                    $this->db->update("msd_template_detail_temp" , $arUpdateItemID);
                }
            }



            $this->db->where("mat_machine_name" , $oldtemplate);
            $this->db->delete("machine_template");

            $this->db->where("ted_template_name" , $oldtemplate);
            $this->db->delete("msd_template_detail");



            // Insert data to machine template table
            $sql = $this->db->query("SELECT
            machine_template_temp.mat_column_name,
            machine_template_temp.mat_machine_name,
            machine_template_temp.mat_machine_type,
            machine_template_temp.mat_min_value,
            machine_template_temp.mat_max_value,
            machine_template_temp.mat_spoint_value,
            machine_template_temp.mat_linenum,
            machine_template_temp.mat_master_linenum,
            machine_template_temp.mat_userpost,
            machine_template_temp.mat_ecodepost,
            machine_template_temp.mat_datetime
            FROM
            machine_template_temp
            WHERE mat_machine_name = '$templatename'
            ORDER BY  mat_linenum ASC");

            foreach($sql->result() as $rs){
                $arSaveToMachineTemplate = array(
                    "mat_column_name" => $rs->mat_column_name,
                    "mat_machine_name" => $rs->mat_machine_name,
                    "mat_machine_type" => $rs->mat_machine_type,
                    "mat_min_value" => conPrice($rs->mat_min_value),
                    "mat_max_value" => conPrice($rs->mat_max_value),
                    "mat_spoint_value" => conPrice($rs->mat_spoint_value),
                    "mat_linenum" => $rs->mat_linenum,
                    "mat_master_linenum" => $rs->mat_master_linenum,
                    "mat_userpost" => getUser()->Fname." ".getUser()->Lname,
                    "mat_ecodepost" => getUser()->ecode,
                    "mat_datetime" => date("Y-m-d H:i:s")
                );
                $this->db->insert("machine_template" , $arSaveToMachineTemplate);
            }
            // $this->db->truncate("machine_template_temp");
            // Insert data to machine template table

            $sql2 = $this->db->query("SELECT
            msd_template_detail_temp.ted_template_name,
            msd_template_detail_temp.ted_template_image,
            msd_template_detail_temp.ted_template_itemuse,
            msd_template_detail_temp.ted_template_dataareaid,
            msd_template_detail_temp.ted_template_bomid,
            msd_template_detail_temp.ted_template_user,
            msd_template_detail_temp.ted_template_ecode,
            msd_template_detail_temp.ted_template_deptcode,
            msd_template_detail_temp.ted_template_datetime,
            msd_template_detail_temp.ted_template_user_modi,
            msd_template_detail_temp.ted_template_ecode_modi,
            msd_template_detail_temp.ted_template_deptcode_modi,
            msd_template_detail_temp.ted_template_datetime_modi,
            msd_template_detail_temp.ted_template_remark
            FROM
            msd_template_detail_temp
            WHERE ted_template_name = '$templatename' ");

            foreach($sql2->result() as $rs){
                $arSaveToTemplateDetail = array(
                    "ted_template_name" => $rs->ted_template_name,
                    "ted_template_image" => $rs->ted_template_image,
                    "ted_template_itemuse" => strtoupper($rs->ted_template_itemuse),
                    "ted_template_remark" => $rs->ted_template_remark,
                    "ted_template_dataareaid" => $rs->ted_template_dataareaid,
                    "ted_template_bomid" => $rs->ted_template_bomid,
                    "ted_template_user" => getUser()->Fname." ".getUser()->Lname,
                    "ted_template_ecode" => getUser()->ecode,
                    "ted_template_deptcode" => getUser()->DeptCode,
                    "ted_template_datetime" => date("Y-m-d H:i:s")
                );
                $this->db->insert("msd_template_detail" , $arSaveToTemplateDetail);

                // Update data on bom and feeder template
                if($oldtemplate != ""){
                    $arupdate = array(
                        "b_templatename" => $rs->ted_template_name,
                        "b_itemid" => strtoupper($rs->ted_template_itemuse),
                        "b_dataareaid" => $rs->ted_template_dataareaid
                    );
                    $this->db->where("b_templatename" , $oldtemplate);
                    $this->db->update("msd_template_bom" , $arupdate);
                }

                if($oldtemplate != ""){
                    $arupdate2 = array(
                        "faf_templatename" => $rs->ted_template_name,
                        "faf_itemid" => strtoupper($rs->ted_template_itemuse),
                        "faf_dataareaid" => $rs->ted_template_dataareaid
                    );
                    $this->db->where("faf_templatename" , $oldtemplate);
                    $this->db->update("msd_template_feeder" , $arupdate2);
                }

            }
            // $this->db->truncate("msd_template_detail_temp");

            $getfile = $sql2->row()->ted_template_image;

            // $pathFrom = $_SERVER['DOCUMENT_ROOT']."/intsys/msd/upload/images_template_temp/".$getfile;
            // $pathTo = $_SERVER['DOCUMENT_ROOT']."/intsys/msd/upload/images_template/".$getfile;

            if($editfile != ""){

                $pathFrom = $_SERVER['DOCUMENT_ROOT']."/intsys/msd/upload/images_template_temp/".$getfile;
                $pathTo = $_SERVER['DOCUMENT_ROOT']."/intsys/msd/upload/images_template/".$getfile;

                if(file_exists($pathFrom) != 0){
                    @copy($pathFrom,$pathTo);
                    @unlink($pathFrom);
                }
                
            }else{
                if($getfile != ""){
                    $pathFrom = $_SERVER['DOCUMENT_ROOT']."/intsys/msd/upload/images_template_temp/".$getfile;
                    if(file_exists($pathFrom) != 0){
                        unlink($pathFrom);
                    }
                }

            }

            //Delete Data on Temp Table
            $this->db->where("mat_machine_name",$templatename);
            $this->db->delete("machine_template_temp");

            $this->db->where("ted_template_name",$templatename);
            $this->db->delete("msd_template_detail_temp");



            // History
            $templatenameHis = $oldtemplate;
            $itemidHis = $checkItemId;
            $detail = "แก้ไข Template สำเร็จ Template เดิม : $templatenameHis ";
            $actionType = "edit data";
            $ip = $this->input->ip_address();
            $menu = "Edit Template";
            saveHistory($templatenameHis , $itemidHis , $dataareaid  , $detail , $menu , $actionType , $ip);

            
            $output = array(
                "msg" => "บันทึกข้อมูลสำเร็จ",
                "status" => "Insert Success",
                "image" => $getfile,
                "checkfile" => file_exists($pathFrom),
                "pathform" => $pathFrom,
                "templatememo" => $templatememo
            );

            echo json_encode($output);
        }


    }




    public function uploadImageCopyToTemp()
    {

        // Upload file Zone
        $ted_template_image = $_FILES["ted_template_image"]["name"];
        $create_new_template_otherImage = $_FILES["create_new_template_otherImage"]["name"];
        $fileno = 1;

        $create_copy_template_name = $this->input->post("create_new_template_name");
        $oldFile = $this->input->post("ted_template_image_copy");

        foreach ($ted_template_image as $key => $value) {
            if ($_FILES["ted_template_image"]["tmp_name"][$key] != "") {

                // ถ้ามีการอัพไฟล์ใหม่ให้ทำการลบไฟล์เก่า

                // Check New หรือว่า Copy
                if($this->input->post("check_new_types") == "copy"){
                    // จะทำการลบรูปที่มาจาก Template ต้นฉบับออกเนื่องจาก Template ปลายทางที่ Copy มานั้นจะใช้ไฟล์รุปของ Template ต้นฉบับเลย
                    if($oldFile != ""){
                        $pathCheck = $_SERVER['DOCUMENT_ROOT']."/intsys/msd/upload/images_template_temp/".$oldFile;
                        if(file_exists($pathCheck) != 0){
                            unlink($pathCheck);
                        }
                    }

                }else if($this->input->post("check_new_types") == "new"){
                    // Check Image On Temptable

                    $sqlgetImage = $this->db->query("SELECT ted_template_image FROM msd_template_detail_temp WHERE ted_template_name = '$create_copy_template_name' ");

                    if($sqlgetImage->num_rows() != 0){
                        $templateImage = $sqlgetImage->row()->ted_template_image;
                        if($templateImage == ""){
                            $time = date("H-i-s"); //ดึงเวลามาก่อน
                            $path_parts = pathinfo($value);
                            $date = date_create();
                            $dateTimeStamp = date_timestamp_get($date);
                
                            if($path_parts['extension'] == "jpeg"){
                                $filename_type = "jpg";
                            }else{
                                $filename_type = $path_parts['extension'];
                            }
                            
                            $file_name_date = substr_replace($value,  $create_copy_template_name . "-" . $dateTimeStamp ."-".$fileno .".". $filename_type, 0);
                            $file_name_s = substr_replace($value,  $create_copy_template_name . "-" . $dateTimeStamp ."-".$fileno, 0);
                            // Upload file
                            $file_tmp = $_FILES["ted_template_image"]["tmp_name"][$key];
                
                
                            if($path_parts['extension'] == "jpeg" || $path_parts['extension'] == "jpg"){
                                $newWidth = 1000;
                                resize($newWidth, "upload/images_template_temp/" . $file_name_s , $file_tmp );
                            }else{
                                move_uploaded_file($file_tmp, "upload/images_template_temp/" . $file_name_date);
                            }
                            // move_uploaded_file($file_tmp, "upload/images/" . $file_name_date);
                            // correctImageOrientation($file_tmp);
                
                
                            $arfiles = array(
                                "ted_template_image" => $file_name_date
                            );
                            $this->db->where("ted_template_name" , $create_copy_template_name);
                            $this->db->update("msd_template_detail_temp", $arfiles);
                
                            $fileno++;
                        }else{
                            $pathFrom = $_SERVER['DOCUMENT_ROOT']."/intsys/msd/upload/images_template_temp/".$templateImage;
                            $pathTo = $_SERVER['DOCUMENT_ROOT']."/intsys/msd/upload/images_template/".$templateImage;
                            @copy($pathFrom , $pathTo);
                            @unlink($pathFrom);
                        }
                    }
                } 
    
            }
        }

        //อัพโหลดรูปของ Template Image & Template memo
        $fileInput_other = "create_new_template_otherImage";
        uploadImageTemplate_other($fileInput_other , $create_copy_template_name);

        if($this->input->post("create_new_template_memo") != ""){
            $arupdateTemplateRemark = array(
                "ted_template_remark" => $this->input->post("create_new_template_memo")
            );
            $this->db->where("ted_template_name" , $create_copy_template_name);
            $this->db->where("ted_template_ecode" , getUser()->ecode);
            $this->db->update("msd_template_detail_temp" , $arupdateTemplateRemark);
        }
        

        $output = array(
            "msg" => "อัพโหลดไฟล์เสร็จแล้ว",
            "status" => "Upload File Success",
            "itemid" => $this->input->post("create_new_template_itemid"),
            "templatename" => $this->input->post("create_new_template_name"),
        );
        echo json_encode($output);
    }





    public function saveRunScrToTempTable()
    {
        // Upload file Zone
        $file_name = $_FILES["ted_template_image"]["name"];
        $fileno = 1;

        $create_new_template_name = $this->input->post("create_new_template_name");
        $create_new_template_itemid = $this->input->post("create_new_template_itemid");
        $run_name_use = $this->input->post("run_name_use");
        $run_type_use = $this->input->post("run_type_use");
        $run_minvalue_use = $this->input->post("run_minvalue_use");
        $run_maxvalue_use = $this->input->post("run_maxvalue_use");
        $run_spoint_use = $this->input->post("run_spoint_use");
        $run_linenum_use = $this->input->post("run_linenum_use");
        $dataareaid = $this->input->post("create_template_dataareaid");


        foreach ($file_name as $key => $value) {
            if ($_FILES["ted_template_image"]["tmp_name"][$key] != "") {

                // Check ข้อมูลบน msd_template_detail_temp ว่ามีการบันทึกไปหรือยัง
                $checkDataDuplicate = $this->db->query("SELECT ted_template_name FROM msd_template_detail_temp WHERE ted_template_name = '$create_new_template_name' ");
                if($checkDataDuplicate->num_rows() == 0){
                    $time = date("H-i-s"); //ดึงเวลามาก่อน
                    $path_parts = pathinfo($value);
                    $date = date_create();
                    $dateTimeStamp = date_timestamp_get($date);
        
                    if($path_parts['extension'] == "jpeg"){
                        $filename_type = "jpg";
                    }else{
                        $filename_type = $path_parts['extension'];
                    }
                    
                    $file_name_date = substr_replace($value,  $create_new_template_name . "-" . $dateTimeStamp ."-".$fileno .".". $filename_type, 0);
                    $file_name_s = substr_replace($value,  $create_new_template_name . "-" . $dateTimeStamp ."-".$fileno, 0);
                    // Upload file
                    $file_tmp = $_FILES["ted_template_image"]["tmp_name"][$key];
        
        
                    
        
                    if($path_parts['extension'] == "jpeg" || $path_parts['extension'] == "jpg"){
                        $newWidth = 1000;
                        resize($newWidth, "upload/images_template_temp/" . $file_name_s , $file_tmp );
                    }else{
                        move_uploaded_file($file_tmp, "upload/images_template_temp/" . $file_name_date);
                    }
                    // move_uploaded_file($file_tmp, "upload/images/" . $file_name_date);
                    // correctImageOrientation($file_tmp);
        
        
                    $arfiles = array(
                        "ted_template_name" => $create_new_template_name,
                        "ted_template_image" => $file_name_date,
                        "ted_template_itemuse" => strtoupper($create_new_template_itemid),
                        "ted_template_user" => getUser()->Fname . " " . getUser()->Lname,
                        "ted_template_ecode" => getUser()->ecode,
                        "ted_template_deptcode" => getUser()->DeptCode,
                        "ted_template_datetime" => date("Y-m-d H:i:s")
                    );
                    $this->db->insert("msd_template_detail_temp", $arfiles);
        
                    $fileno++;
                }
    
            }else{
                $checkDataDuplicate = $this->db->query("SELECT ted_template_name FROM msd_template_detail_temp WHERE ted_template_name = '$create_new_template_name' ");
                if($checkDataDuplicate->num_rows() == 0){
                    $arfiles = array(
                        "ted_template_name" => $create_new_template_name,
                        "ted_template_itemuse" => $create_new_template_itemid,
                        "ted_template_user" => getUser()->Fname . " " . getUser()->Lname,
                        "ted_template_ecode" => getUser()->ecode,
                        "ted_template_deptcode" => getUser()->DeptCode,
                        "ted_template_datetime" => date("Y-m-d H:i:s"),
                        "ted_template_dataareaid" => $dataareaid
                    );
                    $this->db->insert("msd_template_detail_temp", $arfiles);
                }
            }
        }

        $lineNumber = getRunLinenumTemplate($create_new_template_name);


        $arSaveToTempTable = array(
            "mat_machine_name" => $create_new_template_name,
            "mat_column_name" => $run_name_use,
            "mat_machine_type" => $run_type_use,
            "mat_min_value" => $run_minvalue_use,
            "mat_max_value" => $run_maxvalue_use,
            "mat_spoint_value" => $run_spoint_use,
            "mat_linenum" => $lineNumber,
            "mat_master_linenum" => $run_linenum_use,
            "mat_userpost" => getUser()->Fname." ".getUser()->Lname,
            "mat_ecodepost" => getUser()->ecode,
            "mat_datetime" => date("Y-m-d H:i:s"),
        );
        //Check duplicate runscreen
        $checkDupRunscreen = $this->db->query("SELECT mat_column_name FROM machine_template_temp WHERE mat_machine_name = '$create_new_template_name' AND mat_column_name = '$run_name_use' ");
        if($checkDupRunscreen->num_rows() == 0){
            $this->db->insert("machine_template_temp" , $arSaveToTempTable);
        }
        $output = array(
            "msg" => "บันทึกข้อมูลสำเร็จ",
            "status" => "Insert Success",
            "templatename" => $create_new_template_name
        );

        echo json_encode($output);
    }



    public function uploadImageOnly_edit()
    {

        // Check File in Folder
        $getFile = $this->db->query("SELECT ted_template_image FROM msd_template_detail_temp");
        if($getFile->num_rows() != 0){
            if($getFile->row()->ted_template_image != "" || $getFile->row()->ted_template_image != null){
                $pathCheck = $_SERVER['DOCUMENT_ROOT']."/intsys/msd/upload/images_template_temp/".$getFile->row()->ted_template_image;
                if(file_exists($pathCheck) != 0){
                    unlink($pathCheck);
                }
            }
        }




        // Upload file Zone
        $file_name = $_FILES["select_edit_template_image"]["name"];
        $fileno = 1;

        $select_edit_template_name = $this->input->post("select_check_templatename");

        foreach ($file_name as $key => $value) {
            if ($_FILES["select_edit_template_image"]["tmp_name"][$key] != "") {

                    $time = date("H-i-s"); //ดึงเวลามาก่อน
                    $path_parts = pathinfo($value);
                    $date = date_create();
                    $dateTimeStamp = date_timestamp_get($date);
        
                    if($path_parts['extension'] == "jpeg"){
                        $filename_type = "jpg";
                    }else{
                        $filename_type = $path_parts['extension'];
                    }
                    
                    $file_name_date = substr_replace($value,  $select_edit_template_name . "-" . $dateTimeStamp ."-".$fileno .".". $filename_type, 0);
                    $file_name_s = substr_replace($value,  $select_edit_template_name . "-" . $dateTimeStamp ."-".$fileno, 0);
                    // Upload file
                    $file_tmp = $_FILES["select_edit_template_image"]["tmp_name"][$key];
        
        
                    
        
                    if($path_parts['extension'] == "jpeg" || $path_parts['extension'] == "jpg"){
                        $newWidth = 1000;
                        resize($newWidth, "upload/images_template_temp/" . $file_name_s , $file_tmp );
                    }else{
                        move_uploaded_file($file_tmp, "upload/images_template_temp/" . $file_name_date);
                    }
                    // move_uploaded_file($file_tmp, "upload/images/" . $file_name_date);
                    // correctImageOrientation($file_tmp);
        
        
                    $arfiles = array(
                        "ted_template_image" => $file_name_date,
                        "ted_template_user" => getUser()->Fname . " " . getUser()->Lname,
                        "ted_template_ecode" => getUser()->ecode,
                        "ted_template_deptcode" => getUser()->DeptCode,
                        "ted_template_datetime" => date("Y-m-d H:i:s")
                    );
                    $this->db->where("ted_template_name" , $select_edit_template_name);
                    $this->db->update("msd_template_detail_temp", $arfiles);
        
                    $fileno++;
                
    
            }
        }

        $output = array(
            "msg" => "อัพเดตรูปภาพสำเร็จ",
            "status" => "Update Image Success",
            "templatename" => $select_edit_template_name
        );

        echo json_encode($output);
    }



    




    public function saveRunScrToTempTable_edit()
    {
        // Upload file Zone
        $file_name = $_FILES["select_edit_template_image"]["name"];
        $fileno = 1;

        $select_edit_template_name = $this->input->post("select_check_templatename");
        $select_edit_template_itemid = $this->input->post("select_edit_template_itemid");
        $run_name_use_edit = $this->input->post("run_name_use_edit");
        $run_type_use_edit = $this->input->post("run_type_use_edit");
        $run_minvalue_use_edit = $this->input->post("run_minvalue_use_edit");
        $run_maxvalue_use_edit = $this->input->post("run_maxvalue_use_edit");
        $run_spoint_use_edit = $this->input->post("run_spoint_use_edit");
        $run_linenum_use_edit = $this->input->post("run_linenum_use_edit");

        foreach ($file_name as $key => $value) {
            if ($_FILES["select_edit_template_image"]["tmp_name"][$key] != "") {

                // Check ข้อมูลบน msd_template_detail_temp ว่ามีการบันทึกไปหรือยัง
                $checkDataDuplicate = $this->db->query("SELECT ted_template_name FROM msd_template_detail_temp WHERE ted_template_name = '$select_edit_template_name' ");
                if($checkDataDuplicate->num_rows() == 0){
                    $time = date("H-i-s"); //ดึงเวลามาก่อน
                    $path_parts = pathinfo($value);
        
                    if($path_parts['extension'] == "jpeg"){
                        $filename_type = "jpg";
                    }else{
                        $filename_type = $path_parts['extension'];
                    }
                    
                    $file_name_date = substr_replace($value,  $select_edit_template_name . "-" . $time ."-".$fileno .".". $filename_type, 0);
                    $file_name_s = substr_replace($value,  $select_edit_template_name . "-" . $time ."-".$fileno, 0);
                    // Upload file
                    $file_tmp = $_FILES["select_edit_template_image"]["tmp_name"][$key];
        
        
                    
        
                    if($path_parts['extension'] == "jpeg" || $path_parts['extension'] == "jpg"){
                        $newWidth = 1000;
                        resize($newWidth, "upload/images_template_temp/" . $file_name_s , $file_tmp );
                    }else{
                        move_uploaded_file($file_tmp, "upload/images_template_temp/" . $file_name_date);
                    }
                    // move_uploaded_file($file_tmp, "upload/images/" . $file_name_date);
                    // correctImageOrientation($file_tmp);
        
        
                    $arfiles = array(
                        "ted_template_name" => $select_edit_template_name,
                        "ted_template_image" => $file_name_date,
                        "ted_template_itemuse" => strtoupper($select_edit_template_itemid),
                        "ted_template_user" => getUser()->Fname . " " . getUser()->Lname,
                        "ted_template_ecode" => getUser()->ecode,
                        "ted_template_deptcode" => getUser()->DeptCode,
                        "ted_template_datetime" => date("Y-m-d H:i:s")
                    );
                    $this->db->insert("msd_template_detail_temp", $arfiles);
        
                    $fileno++;
                }
    
            }else{
                $checkDataDuplicate = $this->db->query("SELECT ted_template_name FROM msd_template_detail_temp WHERE ted_template_name = '$select_edit_template_name' ");
                if($checkDataDuplicate->num_rows() == 0){
                    $arfiles = array(
                        "ted_template_name" => $select_edit_template_name,
                        "ted_template_itemuse" => $select_edit_template_itemid,
                        "ted_template_user" => getUser()->Fname . " " . getUser()->Lname,
                        "ted_template_ecode" => getUser()->ecode,
                        "ted_template_deptcode" => getUser()->DeptCode,
                        "ted_template_datetime" => date("Y-m-d H:i:s")
                    );
                    $this->db->insert("msd_template_detail_temp", $arfiles);
                }
            }
        }

        $lineNumber = getRunLinenumTemplate($select_edit_template_name);


        $arSaveToTempTable = array(
            "mat_machine_name" => $select_edit_template_name,
            "mat_column_name" => $run_name_use_edit,
            "mat_machine_type" => $run_type_use_edit,
            "mat_min_value" => $run_minvalue_use_edit,
            "mat_max_value" => $run_maxvalue_use_edit,
            "mat_spoint_value" => $run_spoint_use_edit,
            "mat_linenum" => $lineNumber,
            "mat_master_linenum" => $run_linenum_use_edit,
            "mat_userpost" => getUser()->Fname." ".getUser()->Lname,
            "mat_ecodepost" => getUser()->ecode,
            "mat_datetime" => date("Y-m-d H:i:s"),
        );

        $this->db->insert("machine_template_temp" , $arSaveToTempTable);
        $output = array(
            "msg" => "บันทึกข้อมูลสำเร็จ",
            "status" => "Insert Success",
            "templatename" => $select_edit_template_name
        );

        echo json_encode($output);
    }




    public function loadRunScrFromTempTable()
    {
        if($this->input->post("templatename") != ""){
            $templatename = $this->input->post("templatename");
            $searchSelectRun = $this->input->post("searchSelectRun");

            $sql = $this->db->query("SELECT
            machine_template_temp.mat_autoid,
            machine_template_temp.mat_column_name,
            machine_template_temp.mat_machine_name,
            machine_template_temp.mat_machine_type,
            machine_template_temp.mat_min_value,
            machine_template_temp.mat_max_value,
            machine_template_temp.mat_spoint_value,
            machine_template_temp.mat_linenum,
            machine_template_temp.mat_master_linenum,
            machine_template_temp.mat_select_status
            FROM
            machine_template_temp
            WHERE mat_machine_name = '$templatename'
            AND mat_column_name LIKE '%$searchSelectRun%'
            ORDER BY mat_linenum ASC
            ");
            $output = '';

            if($this->input->post("action") != "edit_template"){
                $output .= '<ul class="list-group runScMasterTemp">';
                foreach ($sql->result() as $rs) {
                    $calMatlineNumUp = $rs->mat_linenum - 1;
                    $calMatlineNumDown = $rs->mat_linenum + 1;
                    // $checkOrderRun = $this->db->query("SELECT mat_linenum FROM machine_template_temp WHERE mat_linenum ='$calMatlineNumUp' ");

                    // $checkOrderRun2 = $this->db->query("SELECT mat_linenum FROM machine_template_temp WHERE mat_linenum ='$calMatlineNumDown' ");

                    $checkUpItem = $this->db->query("SELECT mat_linenum FROM machine_template_temp ORDER BY mat_linenum ASC LIMIT 1");
                    $checkDownItem = $this->db->query("SELECT mat_linenum FROM machine_template_temp ORDER BY mat_linenum DESC LIMIT 1");

                    $displayI = "";
                    $displayI2 = "";

                    if($rs->mat_linenum == $checkUpItem->row()->mat_linenum){
                        $displayI = 'style="display:none;" ';
                    }

                    if($rs->mat_linenum == $checkDownItem->row()->mat_linenum){
                        $displayI2 = 'style="display:none;" ';
                    }


                    $output .= '<a>
                    <li class="list-group-item mb-1 runScMasTempLi">
                    <span>' . $rs->mat_column_name . '</span><br>
                    <span><b>Min : </b>'.conNumToText($rs->mat_min_value).'</span>&nbsp;&nbsp;<span><b>Max : </b>'.conNumToText($rs->mat_max_value).'</span><br>
                    <span><b>SPoint : </b>'.conNumToText($rs->mat_spoint_value).'</span>&nbsp;&nbsp;<span><b>Type : </b>'.conNumToText($rs->mat_machine_type).'</span>
                        <i class="icon-caret-left1 runScMasTempI"
                            data_mat_autoid = "'.$rs->mat_autoid.'"
                            data_mat_master_linenum = "'.$rs->mat_master_linenum.'"
                            data_mat_machine_name = "'.$rs->mat_machine_name.'"
                        ></i>

                        <button type="button" style="width:100%;" class="button button-border button-border-thin button-small button-amber runScMasTempIedit"
                            data_mat_autoid = "'.$rs->mat_autoid.'"
                            data_mat_master_linenum = "'.$rs->mat_master_linenum.'"
                            data_mat_machine_name = "'.$rs->mat_machine_name.'"
                            data_mat_min_value = "'.valueFormat($rs->mat_min_value).'"
                            data_mat_max_value = "'.valueFormat($rs->mat_max_value).'"
                            data_mat_spoint_value = "'.valueFormat($rs->mat_spoint_value).'"
                            data_mat_column_name = "'.$rs->mat_column_name.'"
                            data_mat_machine_type = "'.$rs->mat_machine_type.'"
                        ><i class="icon-edit2 iEdit"></i> แก้ไข</button>

                        <i class="icon-caret-up1 runScUpI" '.$displayI.'
                            data_mat_autoid = "'.$rs->mat_autoid.'"
                            data_mat_master_linenum = "'.$rs->mat_master_linenum.'"
                            data_mat_linenum = "'.$rs->mat_linenum.'"
                            data_mat_machine_name = "'.$rs->mat_machine_name.'"
                        ></i>

                        <i class="icon-caret-down1 runScDownI" '.$displayI2.'
                            data_mat_autoid = "'.$rs->mat_autoid.'"
                            data_mat_master_linenum = "'.$rs->mat_master_linenum.'"
                            data_mat_linenum = "'.$rs->mat_linenum.'"
                            data_mat_machine_name = "'.$rs->mat_machine_name.'"
                        ></i>

                    </li></a>
                    ';
                }
                $output .= '</ul>';
                echo $output;
            }else{
                $output .= '<ul class="list-group runScMasterTemp_edit">';
                foreach ($sql->result() as $rs) {

                    $checkUpItem = $this->db->query("SELECT mat_linenum FROM machine_template_temp ORDER BY mat_linenum ASC LIMIT 1");
                    $checkDownItem = $this->db->query("SELECT mat_linenum FROM machine_template_temp ORDER BY mat_linenum DESC LIMIT 1");

                    $displayI = "";
                    $displayI2 = "";
                    $checkedRun = "";

                    if($rs->mat_select_status == "Active"){
                        if($rs->mat_linenum == $checkUpItem->row()->mat_linenum){
                            $displayI = 'style="display:none;" ';
                        }
    
                        if($rs->mat_linenum == $checkDownItem->row()->mat_linenum){
                            $displayI2 = 'style="display:none;" ';
                        }

                        $checkedRun = ' checked="checked" ';


                    }else{
                        $displayI = 'style="display:none;" ';
                        $displayI2 = 'style="display:none;" ';
                        $checkedRun = "";
                    }




                    $output .= '<a>
                    <li id="runScMasTempLi_edit_'.$rs->mat_autoid.'" class="list-group-item mb-1 runScMasTempLi_edit">
                    <span>' . $rs->mat_column_name . '</span><br>
                    <span><b>Min : </b>'.conNumToText($rs->mat_min_value).'</span>&nbsp;&nbsp;<span><b>Max : </b>'.conNumToText($rs->mat_max_value).'</span><br>
                    <span><b>SPoint : </b>'.conNumToText($rs->mat_spoint_value).'</span>&nbsp;&nbsp;<span><b>Type : </b>'.conNumToText($rs->mat_machine_type).'</span>
                        <i class="icon-caret-left1 runScMasTempI_edit"
                            data_mat_autoid = "'.$rs->mat_autoid.'"
                            data_mat_master_linenum = "'.$rs->mat_master_linenum.'"
                            data_mat_machine_name = "'.$rs->mat_machine_name.'"
                        ></i>

                        <button type="button" style="width:100%;" class="button button-border button-border-thin button-small button-amber runScMasTempIedit_edit"
                            data_mat_autoid = "'.$rs->mat_autoid.'"
                            data_mat_master_linenum = "'.$rs->mat_master_linenum.'"
                            data_mat_machine_name = "'.$rs->mat_machine_name.'"
                            data_mat_min_value = "'.valueFormat($rs->mat_min_value).'"
                            data_mat_max_value = "'.valueFormat($rs->mat_max_value).'"
                            data_mat_spoint_value = "'.valueFormat($rs->mat_spoint_value).'"
                            data_mat_column_name = "'.$rs->mat_column_name.'"
                            data_mat_machine_type = "'.$rs->mat_machine_type.'"
                        ><i class="icon-edit2 iEdit"></i> แก้ไข</button>

                        <i class="icon-caret-up1 runScUpI_edit" '.$displayI.'
                            data_mat_autoid = "'.$rs->mat_autoid.'"
                            data_mat_master_linenum = "'.$rs->mat_master_linenum.'"
                            data_mat_linenum = "'.$rs->mat_linenum.'"
                            data_mat_machine_name = "'.$rs->mat_machine_name.'"
                        ></i>

                        <i class="icon-caret-down1 runScDownI_edit" '.$displayI2.'
                            data_mat_autoid = "'.$rs->mat_autoid.'"
                            data_mat_master_linenum = "'.$rs->mat_master_linenum.'"
                            data_mat_linenum = "'.$rs->mat_linenum.'"
                            data_mat_machine_name = "'.$rs->mat_machine_name.'"
                        ></i>

                        <input '.$checkedRun.' type="radio" id="selectRunActive_'.$rs->mat_autoid.'" name="selectRunActive"  class="selectRunActive" 
                            data_mat_autoid = "'.$rs->mat_autoid.'"
                            data_mat_master_linenum = "'.$rs->mat_master_linenum.'"
                            data_mat_linenum = "'.$rs->mat_linenum.'"
                            data_mat_machine_name = "'.$rs->mat_machine_name.'"
                        >

                    </li></a>
                    ';
                }
                $output .= '</ul>';
                echo $output;
            }
            
        }
    }






    public function save_frm_edit_runscreen_newtemplate()
    {
        $arr_edit_runscreen_newtemplate = array(
            "mat_min_value" => conPrice($this->input->post("editRSC_min")),
            "mat_max_value" => conPrice($this->input->post("editRSC_max")),
            "mat_spoint_value" => conPrice($this->input->post("editRSC_spoint"))
        );
        $this->db->where("mat_autoid" , $this->input->post("editRSC_autoid"));
        $this->db->update("machine_template_temp" , $arr_edit_runscreen_newtemplate);

        $output = array(
            "msg" => "อัพเดต ข้อมูลเรียบร้อยแล้ว",
            "status" => "Update Success",
            "templatename" => $this->input->post("editRSC_templatename")
        );

        echo json_encode($output);
    }




    public function delRunScrFromTempTable()
    {
        if($this->input->post("data_mat_autoid") != ""){
            $data_mat_autoid = $this->input->post("data_mat_autoid");
            $this->db->where("mat_autoid" , $data_mat_autoid);
            $this->db->delete("machine_template_temp");


            // หลังจากลบ Runscreen ออกแล้วให้ทำการอัพเดต Linenumber ใหม่
            
            // $countRow = $this->db->query("SELECT mat_column_name , mat_autoid FROM machine_template_temp");
            // $i = 1;
            // foreach($countRow->result() as $rs){
            //     $arUpdate = array(
            //         "mat_linenum" => $i
            //     );
            //     $this->db->where("mat_autoid" , $rs->mat_autoid);
            //     $this->db->update("machine_template_temp" , $arUpdate);
            //     $i++;
            // }
            

            $output = array(
                "msg" => "Delete already",
                "status" => "Delete Success"
            );
        }
        echo json_encode($output);
    }




    public function updateLinenumDown()
    {
        if($this->input->post("data_mat_linenum") != ""){

            $data_mat_linenum = $this->input->post("data_mat_linenum");
            $data_mat_autoid = $this->input->post("data_mat_autoid");

            $query = $this->db->query("SELECT mat_autoid , mat_linenum , mat_machine_name , mat_column_name FROM machine_template_temp ORDER BY mat_linenum ASC");

            $queryMatLine = $this->db->query("SELECT mat_linenum FROM machine_template_temp ORDER BY mat_linenum ASC");
            
            foreach($queryMatLine->result() as $rs){
                $output[] = $rs->mat_linenum;
            }

            
            $result = array_search($data_mat_linenum , $output); //return position array
            // echo json_encode($result);
            $j = $result+1;
            $moveArray = moveElementInArray($output, $result, $j);
            // echo json_encode($moveArray);
            $i = 0;
            foreach($query->result() as $rs){
                $arUpdate = array(
                    "mat_linenum" => $moveArray[$i]
                );
                $this->db->where("mat_autoid" , $rs->mat_autoid);
                $this->db->update("machine_template_temp" , $arUpdate);
                $i++;
            }

            $outputJson = array(
                "msg" => "เลื่อนตำแหน่งเรียบร้อย",
                "status" => "Change Position Success",
                "templatename" => $query->row()->mat_machine_name,
                "now" => $result,
                "to" => $j,
                "array" => $moveArray
            );

            echo json_encode($outputJson);
                  
        }
    }



    public function updateLinenumUp()
    {

        if($this->input->post("data_mat_linenum") != ""){

            $data_mat_linenum = $this->input->post("data_mat_linenum");
            $data_mat_autoid = $this->input->post("data_mat_autoid");

            $query = $this->db->query("SELECT mat_autoid , mat_linenum , mat_machine_name , mat_column_name FROM machine_template_temp ORDER BY mat_linenum ASC");

            $queryMatLine = $this->db->query("SELECT mat_linenum FROM machine_template_temp ORDER BY mat_linenum ASC");
            
            foreach($queryMatLine->result() as $rs){
                $output[] = $rs->mat_linenum;
            }

            
            $result = array_search($data_mat_linenum , $output); //return position array
            // echo json_encode($result);
            $j = $result-1;
            $moveArray = moveElementInArray($output, $result, $j);
            // echo json_encode($moveArray);
            
            $i = 0;
            foreach($query->result() as $rs){
                $arUpdate = array(
                    "mat_linenum" => $moveArray[$i]
                );
                $this->db->where("mat_autoid" , $rs->mat_autoid);
                $this->db->update("machine_template_temp" , $arUpdate);
                $i++;
            }

            $outputJson = array(
                "msg" => "เลื่อนตำแหน่งเรียบร้อย",
                "status" => "Change Position Success",
                "templatename" => $query->row()->mat_machine_name,
                "now" => $result,
                "to" => $j,
                "array" => $moveArray,
                "autoid" =>$data_mat_autoid
            );

            echo json_encode($outputJson);
                  
        }
    }








    public function getMachineTemp()
    {
        $machineName = "";
        if($this->input->post("machineName")){
            $machineName = $this->input->post("machineName");

            $sql = $this->db->query("SELECT
            machine_template.mat_column_name,
            machine_template.mat_machine_name,
            machine_template.mat_autoid
            FROM
            machine_template
            WHERE mat_machine_name = '$machineName' ORDER BY mat_autoid DESC 
            ");
                    $output = '
                    <h5>Machine Template '.$machineName.'</h5>
                        <div class="table-responsive">
                            <table id="machineTemplate" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Run screen</th>
                                    </tr>
                                </thead>
                                <tbody>
                            ';
                foreach($sql->result() as $rs){
                    $output .= '
                    <tr>
                        <td><i class="icon-line-chevrons-left iconMachineDel" data_mat_autoid = "'.$rs->mat_autoid.'" data_mat_machine_name="'.$rs->mat_machine_name.'"></i></td>
                        <td>' . $rs->mat_column_name . '</td>
                    </tr>
                    ';
                }
                    $output .= '
                                </tbody>
                            </table>
                        </div>
                        ';
                    echo $output;
            
        }
    }



    public function deleteRunscreenFromTemp()
    {
        $matautoid = "";
        if($this->input->post("runscreenAutoid")){
            $matautoid = $this->input->post("runscreenAutoid");
            $this->db->where("mat_autoid" , $matautoid);
            $this->db->delete("machine_template");

            $output = array(
                "status" => "DeleteSuccess"
            );

        }else{
            $output = array(
                "status" => "DeleteNotSuccess"
            );
        }
        echo json_encode($output);
    }




    public function runscreenManagement()
    {
        $sql = $this->db->query("SELECT
        runscreen_master.run_autoid,
        runscreen_master.run_name,
        runscreen_master.run_minvalue,
        runscreen_master.run_maxvalue,
        runscreen_master.run_spoint,
        runscreen_master.run_userpost,
        runscreen_master.run_ecodepost,
        runscreen_master.run_datetime,
        runscreen_master.run_type
        FROM
        runscreen_master
        ORDER BY run_autoid DESC
        ");

            $output = '
            <h4><u>รายการ Runscreen ทั้งหมด</u></h4>
                <div class="table-responsive">
                    <table id="runscreenManage">
                        <thead>
                            <tr>
                                <th>Run Screen</th>
                                <th>Min</th>
                                <th>Max</th>
                                <th>S Point</th>
                                <th>Run Type</th>
                                <th class="runManageBtn">#</th>
                            </tr>
                        </thead>
                        <tbody>
                    ';
        foreach($sql->result() as $rs)
        {

            $output .= '
                    <tr>
                        <td>' . $rs->run_name . '</td>
                        <td>' . $rs->run_minvalue . '</td>
                        <td>' . $rs->run_maxvalue . '</td>
                        <td>' . $rs->run_spoint . '</td>
                        <td>' . $rs->run_type . '</td>
                        <td>
                        <i class="icon-edit2 iconRunEdit"
                            data_run_name = "'.$rs->run_name.'" 
                            data_run_autoid="'.$rs->run_autoid.'"
                            data_run_type="'.$rs->run_type.'"
                            data_run_min="'.$rs->run_minvalue.'"
                            data_run_max="'.$rs->run_maxvalue.'"
                            data_run_spoint="'.$rs->run_spoint.'"
                        ></i>
                        <i class="icon-trash-alt iconRunDel" data_run_autoid="'.$rs->run_autoid.'" ></i>
                        </td>
                    </tr>
                    ';
        }

            $output .= '
                        </tbody>
                    </table>
                </div>
                ';
            echo $output;
    }






    public function saveRunscreen()
    {
        if($this->input->post("run_name") != ""){
            $getRunLinenum = getRunLinenum();
            $arSaveRunscreen = array(
                "run_name" => $this->input->post("run_name"),
                "run_minvalue" => conPrice($this->input->post("run_minvalue")),
                "run_maxvalue" => conPrice($this->input->post("run_maxvalue")),
                "run_spoint" => conPrice($this->input->post("run_spoint")),
                "run_linenum" => $getRunLinenum,
                "run_userpost" => getUser()->Fname." ".getUser()->Lname,
                "run_ecodepost" => getUser()->ecode,
                "run_datetime" => date("Y-m-d H:i:s"),
                "run_type" => $this->input->post("run_type")
            );

            $this->db->insert("runscreen_master" , $arSaveRunscreen);
            // History zone
            $menu = "เพิ่ม Runscreen";
            $runnameHis = $this->input->post("run_name");
            $runTypeHis = $this->input->post("run_type");
            $detail = "สร้าง Runscreen ใหม่ Runscreen Name : $runnameHis"."&nbsp;&nbspประเภท : $runTypeHis";
            $actionType = "create data";
            $ip = $this->input->ip_address();
            saveHistory($templatename = "" , $itemid = "" , $dataareaid = "" , $detail , $menu , $actionType , $ip);

            $output = array(
                "msg" => "บันทึกข้อมูลสำเร็จ",
                "status" => "insert success"
            );
        }else{
            $output = array(
                "msg" => "ไม่พบข้อมูล บันทึกข้อมูลไม่สำเร็จ",
                "status" => "insert not success"
            );
        }
        echo json_encode($output);
    }




    public function checkDupRunManage()
    {
        $runnameCheck = $this->input->post("run_name");
        $runTypeCheck = $this->input->post("run_type");
        if($this->input->post("run_name") != ""){
            $sql = $this->db->query("SELECT
            runscreen_master.run_name
            FROM
            runscreen_master
            WHERE run_name = '$runnameCheck' and run_type = '$runTypeCheck'
            ");
            if($sql->num_rows() > 0){
                $output = array(
                    "msg" => "พบข้อมูลซ้ำในระบบ",
                    "status" => "Found Duplicate Data"
                );
            }else{
                $output = array(
                    "msg" => "ไม่พบข้อมูลซ้ำในระบบ",
                    "status" => "Not Found Duplicate Data"
                );
            }
            echo json_encode($output);
        }
    }



    public function checkDupEditRunManage()
    {
        $runnameCheck = $this->input->post("edit_run_name");
        $runTypeCheck = $this->input->post("edit_run_type");
        if($this->input->post("edit_run_name") != ""){
            $sql = $this->db->query("SELECT
            runscreen_master.run_name
            FROM
            runscreen_master
            WHERE run_name = '$runnameCheck' and run_type = '$runTypeCheck'
            ");

            // History 
            $detail = "แก้ไข Runscreen สำเร็จ ($runnameCheck)";
            $menu = "Edit run screen";
            $actionType = "edit data";
            $ip = $this->input->ip_address();
            saveHistory($templatename = "" , $itemid = "" , $dataareaid = "" , $detail , $menu , $actionType , $ip);

            $output = array(
                "msg" => "Pass",
                "status" => "Pass"
            );
            echo json_encode($output);
        }
    }





    public function editRunscreen()
    {
        if($this->input->post("edit_run_name") != ""){
            $arSaveRunscreen = array(
                "run_name" => $this->input->post("edit_run_name"),
                "run_minvalue" => conPrice($this->input->post("edit_run_minvalue")),
                "run_maxvalue" => conPrice($this->input->post("edit_run_maxvalue")),
                "run_spoint" => conPrice($this->input->post("edit_run_spoint")),
                "run_userpost" => getUser()->Fname." ".getUser()->Lname,
                "run_ecodepost" => getUser()->ecode,
                "run_datetime" => date("Y-m-d H:i:s"),
                "run_type" => $this->input->post("edit_run_type")
            );
            $this->db->where("run_autoid" , $this->input->post("edit_run_autoid"));
            $this->db->update("runscreen_master" , $arSaveRunscreen);

            $output = array(
                "msg" => "บันทึกการแก้ไขข้อมูลสำเร็จ",
                "status" => "Update success"
            );
        }else{
            $output = array(
                "msg" => "ไม่พบข้อมูล บันทึกการแก้ไขข้อมูลไม่สำเร็จ",
                "status" => "Update not success"
            );
        }
        echo json_encode($output);
    }



    public function delRunscreen()
    {
        $runautoid = "";
        if($this->input->post("runAutoid")){
            $runautoid = $this->input->post("runAutoid");
            $this->db->where("run_autoid" , $runautoid);
            $this->db->delete("runscreen_master");

            //History Section
            $detail = "ลบ Runscreen ID : $runautoid สำเร็จ";
            $menu = "Delete Runscreen";
            $actionType = "delete data";
            $ip = $this->input->ip_address();
            saveHistory($templatename = "" , $itemid = "" , $dataareaid = "" , $detail , $menu , $actionType , $ip);

            $output = array(
                "msg" => "ลบข้อมูลสำเร็จ",
                "status" => "Delete success"
            );
        }else{
            $output = array(
                "msg" => "ลบข้อมูลไม่สำเร็จ",
                "status" => "Delete not success"
            );
        }
        echo json_encode($output);
    }


    public function copyTemplate()
    {

            $sql = $this->db->query("SELECT
            mat_machine_name,
            count(mat_column_name)as items
            FROM
                machine_template 
            group by mat_machine_name ORDER BY mat_autoid DESC");

            $output = '
            <table id="copyTemplateTable" class="table table-bordered" cellspacing="0" style="width:100%">
                <thead class="text-center">
                    <tr>
                        <th>ชื่อ Template</th>
                        <th>จำนวน RunScreen</th>
                        <th>#</th>
                        <th>#</th>
                        <th>#</th>
                    </tr>
                </thead>
                <tbody>
            ';
        
            foreach ($sql->result() as $rs) {
                if(getdataTemDetail($rs->mat_machine_name)->num_rows() == 0){
                    $temImage = "";
                    $temProdCode = "";
                }else{
                    $temImage = getdataTemDetail($rs->mat_machine_name)->row()->ted_template_image;
                    $temProdCode = getdataTemDetail($rs->mat_machine_name)->row()->ted_template_itemuse;
                }
    
    
                $output .= '
                <tr>
                    <td class="text-nowrap">' . $rs->mat_machine_name . '</td>
                    <td>' . $rs->items . '</td>
                    <td class="text-center"><i class="icon-copy copyIcon" data-toggle="modal" data-target=""
                        data_mat_machine_name = "'.$rs->mat_machine_name.'"
                    ></i></td>
                    <td class="text-center"><i class="icon-edit iconTemEdit" data-toggle="modal" data-target=""
                        data_mat_machine_name = "'.$rs->mat_machine_name.'"
                        data_matchine_image = "'.$temImage.'"
                        data_matchine_prodcode = "'.$temProdCode.'"
                    ></i></td>
                    <td class="text-center"><i class="icon-trash iconTemDel" data-toggle="modal" data-target=""
                        data_mat_machine_name = "'.$rs->mat_machine_name.'"
                    ></i></td>
                </tr>
            ';
            }
        
                $output .= '
                </tbody>
            </table>
            ';
        
                echo $output;

    }






    public function saveCopyTemplate()
    {
        if($this->input->post("newTemplatename") != ""){
            $oldTemplatename = $this->input->post("oldTemplatename");
            $newTemplatename = $this->input->post("newTemplatename");
            //Query old template
            $sqlOldTem = $this->db->query("SELECT
            machine_template.mat_column_name,
            machine_template.mat_machine_name,
            machine_template.mat_machine_type,
            machine_template.mat_min_value,
            machine_template.mat_max_value
            FROM
            machine_template
            WHERE
            machine_template.mat_machine_name = '$oldTemplatename' ");

            foreach($sqlOldTem->result_array() as $rs){
                $arnewTemplateName = array(
                    "mat_column_name" => $rs['mat_column_name'],
                    "mat_machine_name" => $newTemplatename,
                    "mat_min_value" => $rs['mat_min_value'],
                    "mat_max_value" => $rs['mat_max_value'],
                    "mat_machine_type" => $rs['mat_machine_type']
                );
                $this->db->insert("machine_template" , $arnewTemplateName);
            }

            $output = array(
                "msg" => "Copy ข้อมูลสำเร็จ",
                "status" => "Copy Data Success"
            );

            echo json_encode($output);
        }
    }



    public function delTemplate()
    {
        $matchinename = "";
        if($this->input->post("matchinename")){
            $matchinename = $this->input->post("matchinename");

            //ลบข้อมูลที่ Table machine_template
            $this->db->where("mat_machine_name" , $matchinename);
            $this->db->delete("machine_template");
            //ลบข้อมูลที่ Table machine_template


            //ลบรูปภาพออกจาก Folder
            $path = $_SERVER['DOCUMENT_ROOT']."/intsys/msd/upload/images_template/".getImageMachineBox($matchinename);
            unlink($path);
            $this->db->where("ted_template_name" , $matchinename);
            $this->db->delete("msd_template_detail");
            //ลบรูปภาพออกจาก Folder

            $output = array(
                "msg" => "ลบ Template เรียบร้อยแล้ว",
                "status" => "Delete Template Successfuly"
            );

            echo json_encode($output);
        }
    }



    public function loadTemplateBox()
    {
        getMachineBox();
    }

    public function loadDataTemplate()
    {
        if($this->input->post("templatename") != ""){
            $templatename = $this->input->post("templatename");

            $query = $this->db->query("SELECT
            msd_template_detail.ted_autoid,
            msd_template_detail.ted_template_name,
            msd_template_detail.ted_template_image,
            msd_template_detail.ted_template_itemuse,
            msd_template_detail.ted_template_remark,
            msd_template_detail.ted_template_dataareaid
            FROM
            msd_template_detail
            WHERE ted_template_name = '$templatename'
            ");

            $sqlgetTemplateOtherImage = $this->db->query("SELECT
            temi_imagename,
            temi_imagepath,
            temi_autoid
            FROM msd_template_image
            WHERE temi_templatename = '$templatename' ORDER BY temi_autoid ASC
            ");



            $row = $query->row();
            $dataareaid = @$row->ted_template_dataareaid;
            if($query->num_rows() != 0){
                $output = array(
                    "msg" => "ดึงข้อมูลสำเร็จ",
                    "status" => "Select Data Success",
                    "ted_template_name" => $row->ted_template_name,
                    "ted_template_image" => $row->ted_template_image,
                    "ted_template_itemuse" => $row->ted_template_itemuse,
                    "ted_template_remark" => $row->ted_template_remark,
                    "ted_template_dataareaid" => $dataareaid,
                    "templateOtherImage" => $sqlgetTemplateOtherImage->result()
                );

                echo json_encode($output);
            }else{
                $output = array(
                    "msg" => "ดึงข้อมูลไม่สำเร็จ",
                    "status" => "Select Data Not Success",
                    "ted_template_name" => "",
                    "ted_template_image" => "",
                    "ted_template_itemuse" => "",
                    "templateOtherImage" => null
                );
                echo json_encode($output);
            }
        }
    }






/////////////////////////////////////////////
////////////Template detail page
public function temDetail()
{
    $machinename = "";

    if($this->input->post("machinename")){

        $machinename = $this->input->post("machinename");

        $sql = $this->db->query("SELECT
        machine_template.mat_autoid,
        machine_template.mat_column_name,
        machine_template.mat_machine_name,
        machine_template.mat_min_value,
        machine_template.mat_max_value,
        machine_template.mat_spoint_value,
        machine_template.mat_userpost,
        machine_template.mat_ecodepost,
        machine_template.mat_datetime
        FROM
        machine_template
        WHERE mat_machine_name = '$machinename' ORDER BY mat_autoid ASC
        ");
    
            $output = '
            <h5>Run Screen List</h5>
                <div class="table-responsive">
                    <table id="tempDetail" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Run screen</th>
                                <th>Min value</th>
                                <th>Max value</th>
                                <th>S Point Value</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                    ';
        foreach($sql->result() as $rs)
        {
           if($rs->mat_min_value <= 0){
            $minValue = "";
           }else{
            $minValue = $rs->mat_min_value;
           }

           if($rs->mat_max_value <= 0){
            $maxValue = "";
           }else{
            $maxValue = $rs->mat_max_value;
           }

           if($rs->mat_spoint_value <= 0){
            $spointValue = "";
           }else{
            $spointValue = $rs->mat_spoint_value;
           }

            $output .= '
                    <tr>
                        <td>' . $rs->mat_column_name . '</td>
                        <td>'.$minValue.'</td>
                        <td>'.$maxValue.'</td>
                        <td>'.$spointValue.'</td>
                        <td>
                        <i class="icon-edit2 iconEditMinMax" data-target="#min_max_md" data-toggle="modal" 
                        data_run_name = "'.$rs->mat_column_name.'" 
                        data_run_autoid="'.$rs->mat_autoid.'" 
                        data_run_machinename="'.$rs->mat_machine_name.'"
                        data_minvalue ="'.$rs->mat_min_value.'"
                        data_maxvalue ="'.$rs->mat_max_value.'"
                        data_spointvalue = "'.$rs->mat_spoint_value.'"
                        >
                        
                        </i>
                        </td>
                    </tr>
                    ';
        }
    
            $output .= '
                        </tbody>
                    </table>
                </div>
                ';
            echo $output;
    }

}





//////////////////////////////////////////
///////////Save Min max
public function saveMinMax()
{

    if($this->input->post("minMaxAutoid") != ""){
        $arMinMax = array(
            "mat_min_value" => $this->input->post("minvalue"),
            "mat_max_value" => $this->input->post("maxvalue"),
            "mat_spoint_value" => $this->input->post("spointvalue"),
        );
        $this->db->where("mat_autoid" , $this->input->post("minMaxAutoid"));
        $this->db->update("machine_template" , $arMinMax);

        $output = array(
            "msg" => "บันทึกข้อมูล Min and Max value สำเร็จแล้ว",
            "status" => "Update success",
            "machineName" => $this->input->post("minMaxMachinename")
        );
    }else{
        $output = array(
            "msg" => "บันทึกไม่สำเร็จ เนื่องจากกรอกข้อมูลไม่ครบถ้วน",
            "status" => "Update not success"
        );
    }

    echo json_encode($output);
}


public function loadLinenumFromTemp()
{
    $sql = $this->db->query("SELECT mat_autoid , mat_column_name , mat_linenum FROM machine_template_temp ORDER BY mat_linenum ASC");
    if($sql->num_rows() != 0){
        foreach($sql->result() as $rs)
        {
            $output[] = array(
                "line no." => $rs->mat_linenum,
                "id" => $rs->mat_autoid,
                "name" => $rs->mat_column_name
            );
        }
        echo json_encode($output);
    }else{
        return false;
    }
    
}


public function loadOldTemplate()
{
    if($this->input->post("templatename") != ""){
        $templatename = $this->input->post("templatename");

        $sql = $this->db->query("SELECT
        machine_template.mat_autoid,
        machine_template.mat_machine_name,
        msd_template_detail.ted_template_itemuse,
        msd_template_detail.ted_template_image,
        msd_template_detail.ted_template_dataareaid,
        msd_template_detail.ted_template_bomid
        FROM
        machine_template
        LEFT JOIN msd_template_detail ON msd_template_detail.ted_template_name = machine_template.mat_machine_name
        WHERE mat_machine_name LIKE '%$templatename%' OR ted_template_itemuse Like '%$templatename%'
        GROUP BY
        machine_template.mat_machine_name
        ORDER BY
        machine_template.mat_autoid DESC");

        $output = '';
        $output .= '<ul class="list-group oldTemplateUl">';
            foreach ($sql->result() as $rs) {
                if($rs->ted_template_itemuse == ""){
                    $item = "ยังไม่ได้กำหนด";
                }else{
                    $item = $rs->ted_template_itemuse;
                }
                $output .= '
                <a href="javascript:void(0)" class="oldTemplateLi" 
                    data_templatename = "'.$rs->mat_machine_name.'"
                    data_template_image = "'.$rs->ted_template_image.'"
                    data_template_itemuse = "'.$rs->ted_template_itemuse.'"
                    data_areaid="'.$rs->ted_template_dataareaid.'"
                    data_bomid="'.$rs->ted_template_bomid.'"
                ><li class="list-group-item mb-1">'.$rs->mat_machine_name." / ".$item.'</li></a>
            ';
            }
        $output .= '</ul>';
        echo $output;
    }


}


public function loadRunscreen()
{
    if($this->input->post("templatename") != ""){
        $templatename = $this->input->post("templatename");

        $sql = $this->db->query("SELECT
        machine_template.mat_autoid,
        machine_template.mat_column_name,
        machine_template.mat_machine_name,
        machine_template.mat_machine_type,
        machine_template.mat_min_value,
        machine_template.mat_max_value,
        machine_template.mat_spoint_value,
        machine_template.mat_linenum,
        machine_template.mat_master_linenum
        FROM
        machine_template
        WHERE mat_machine_name = '$templatename'
        ORDER BY mat_linenum ASC
        ");

        $output = '<ul class="list-group runScMasterTemp">';
        foreach ($sql->result() as $rs) {
            $calMatlineNumUp = $rs->mat_linenum - 1;
            $calMatlineNumDown = $rs->mat_linenum + 1;
            // $checkOrderRun = $this->db->query("SELECT mat_linenum FROM machine_template_temp WHERE mat_linenum ='$calMatlineNumUp' ");

            // $checkOrderRun2 = $this->db->query("SELECT mat_linenum FROM machine_template_temp WHERE mat_linenum ='$calMatlineNumDown' ");

            $checkUpItem = $this->db->query("SELECT mat_linenum FROM machine_template ORDER BY mat_linenum ASC LIMIT 1");
            $checkDownItem = $this->db->query("SELECT mat_linenum FROM machine_template ORDER BY mat_linenum DESC LIMIT 1");

            $displayI = "";
            $displayI2 = "";

            if($rs->mat_linenum == $checkUpItem->row()->mat_linenum){
                $displayI = 'style="display:none;" ';
            }

            if($rs->mat_linenum == $checkDownItem->row()->mat_linenum){
                $displayI2 = 'style="display:none;" ';
            }

            $output .= '<a>
            <li class="list-group-item mb-1 runScMasTempLi">
            <span>' . $rs->mat_column_name . '</span><br>
            <span><b>Min : </b>'.conNumToText($rs->mat_min_value).'</span>&nbsp;&nbsp;<span><b>Max : </b>'.conNumToText($rs->mat_max_value).'</span><br>
            <span><b>SPoint : </b>'.conNumToText($rs->mat_spoint_value).'</span>&nbsp;&nbsp;<span><b>Type : </b>'.$rs->mat_machine_type.'</span>
                <i class="icon-caret-left1 runScMasTempI"
                    data_mat_autoid = "'.$rs->mat_autoid.'"
                    data_mat_master_linenum = "'.$rs->mat_master_linenum.'"
                    data_mat_machine_name = "'.$rs->mat_machine_name.'"
                ></i>

                <i class="icon-edit2 runScMasTempIedit"
                    data_mat_autoid = "'.$rs->mat_autoid.'"
                    data_mat_master_linenum = "'.$rs->mat_master_linenum.'"
                    data_mat_machine_name = "'.$rs->mat_machine_name.'"
                    data_mat_min_value = "'.valueFormat($rs->mat_min_value).'"
                    data_mat_max_value = "'.valueFormat($rs->mat_max_value).'"
                    data_mat_spoint_value = "'.valueFormat($rs->mat_spoint_value).'"
                    data_mat_column_name = "'.$rs->mat_column_name.'"
                    data_mat_machine_type = "'.$rs->mat_machine_type.'"
                ></i>

                <i class="icon-caret-up1 runScUpI" '.$displayI.'
                    data_mat_autoid = "'.$rs->mat_autoid.'"
                    data_mat_master_linenum = "'.$rs->mat_master_linenum.'"
                    data_mat_linenum = "'.$rs->mat_linenum.'"
                    data_mat_machine_name = "'.$rs->mat_machine_name.'"
                ></i>

                <i class="icon-caret-down1 runScDownI" '.$displayI2.'
                    data_mat_autoid = "'.$rs->mat_autoid.'"
                    data_mat_master_linenum = "'.$rs->mat_master_linenum.'"
                    data_mat_linenum = "'.$rs->mat_linenum.'"
                    data_mat_machine_name = "'.$rs->mat_machine_name.'"
                ></i>

            </li></a>
            ';
        }
        $output .= '</ul>';
        echo $output;
    }
}




public function copyOriTemplateToTemp()
{

    // Check data From temp table
    if($this->db->truncate('machine_template_temp'))
    {
        //ลบไฟล์ออกจาก server
        $getfile = $this->db->query("SELECT ted_template_image FROM msd_template_detail_temp");
        if($getfile->num_rows() != 0){
            if($getfile->row()->ted_template_image != ""){
                //ลบรูปภาพออกจาก Folder
                $path = $_SERVER['DOCUMENT_ROOT']."/intsys/msd/upload/images_template_temp/".$getfile->row()->ted_template_image;
                unlink($path);
            } 
        }
        $this->db->truncate('msd_template_detail_temp');
    }


    $templatename = $this->input->post("templatename");
    $template_newname = $this->input->post("template_newname");
    $itemused = $this->input->post("itemused");
    $template_image = $this->input->post("template_image");
    $data_template_image = $this->input->post("data_template_image");
    $data_template_itemuse = $this->input->post("data_template_itemuse");
    $conImageOriginal = "";

    if($data_template_image != ""){

        $path_parts = pathinfo($data_template_image);
        $file_type = $path_parts['extension'];
        $date = date_create();
        $dateTimeStamp = date_timestamp_get($date);

        $conImageOriginal = $template_newname."-$dateTimeStamp.".$file_type;
        $pathFrom = $_SERVER['DOCUMENT_ROOT']."/intsys/msd/upload/images_template/".$data_template_image;
        $pathTo = $_SERVER['DOCUMENT_ROOT']."/intsys/msd/upload/images_template_temp/".$conImageOriginal;
        @copy($pathFrom , $pathTo);
    }

    $selectData = $this->db->query("SELECT
    machine_template.mat_column_name,
    machine_template.mat_machine_name,
    machine_template.mat_machine_type,
    machine_template.mat_min_value,
    machine_template.mat_max_value,
    machine_template.mat_spoint_value,
    machine_template.mat_linenum,
    machine_template.mat_master_linenum
    FROM
        machine_template 
    WHERE
        mat_machine_name = '$templatename' 
    ORDER BY
        mat_linenum ASC");

    // Save data to temp table
    foreach($selectData->result() as $rs){
        $arsaveToTemp = array(
            "mat_column_name" => $rs->mat_column_name,
            "mat_machine_name" => $template_newname,
            "mat_machine_type" => $rs->mat_machine_type,
            "mat_min_value" => $rs->mat_min_value,
            "mat_max_value" => $rs->mat_max_value,
            "mat_spoint_value" => $rs->mat_spoint_value,
            "mat_linenum" => $rs->mat_linenum,
            "mat_master_linenum" => $rs->mat_master_linenum,
            "mat_userpost" => getUser()->Fname." ".getUser()->Lname,
            "mat_ecodepost" => getUser()->ecode,
            "mat_datetime" => date("Y-m-d H:i:s")
        );
        $masterlinenum[] = $rs->mat_master_linenum;
        $this->db->insert("machine_template_temp" , $arsaveToTemp);
    }


    $sqlGetTemplateDetail = $this->db->query("SELECT
    ted_template_bomid,
    ted_template_dataareaid
    FROM msd_template_detail
    WHERE ted_template_name = '$templatename' AND ted_template_itemuse = '$data_template_itemuse'
    ");
    $bomid = '';
    $dataareaid = '';
    if($sqlGetTemplateDetail->num_rows() != 0){
        $bomid = $sqlGetTemplateDetail->row()->ted_template_bomid;
        $dataareaid = $sqlGetTemplateDetail->row()->ted_template_dataareaid;
    }
    $arsaveToDetailTemp = array(
        "ted_template_name" => $template_newname,
        "ted_template_itemuse" => $data_template_itemuse,
        "ted_template_bomid" => $bomid,
        "ted_template_dataareaid" => $dataareaid,
        "ted_template_image" => $conImageOriginal,
        "ted_template_user" => getUser()->Fname." ".getUser()->Lname,
        "ted_template_ecode" => getUser()->ecode,
        "ted_template_deptcode" => getUser()->DeptCode,
        "ted_template_datetime" => date("Y-m-d H:i:s")
    );
    $this->db->insert("msd_template_detail_temp" , $arsaveToDetailTemp);

    $output = array(
        "msg" => "บันทึกข้อมูลลง Machine Template Temp เรียบร้อยแล้ว",
        "status" => "Insert Success",
        "masterlinenum" => $masterlinenum
    );
    echo json_encode($output);

}




public function copyOriTemplateToTemp_edit()
{

    
    $templatename = $this->input->post("templatename");
    $itemuse = $this->input->post("itemuse");
    $template_image = $this->input->post("template_image");

    $selectData = $this->db->query("SELECT
    machine_template.mat_column_name,
    machine_template.mat_machine_name,
    machine_template.mat_machine_type,
    machine_template.mat_min_value,
    machine_template.mat_max_value,
    machine_template.mat_spoint_value,
    machine_template.mat_linenum,
    machine_template.mat_master_linenum
    FROM
        machine_template 
    WHERE
        mat_machine_name = '$templatename' 
    ORDER BY
        mat_autoid ASC");

    // Save data to temp table
    foreach($selectData->result() as $rs){
        $arsaveToTemp = array(
            "mat_column_name" => $rs->mat_column_name,
            "mat_machine_name" => $templatename,
            "mat_machine_type" => $rs->mat_machine_type,
            "mat_min_value" => $rs->mat_min_value,
            "mat_max_value" => $rs->mat_max_value,
            "mat_spoint_value" => $rs->mat_spoint_value,
            "mat_linenum" => $rs->mat_linenum,
            "mat_master_linenum" => $rs->mat_master_linenum,
            "mat_userpost" => getUser()->Fname." ".getUser()->Lname,
            "mat_ecodepost" => getUser()->ecode,
            "mat_datetime" => date("Y-m-d H:i:s")
        );
        $masterlinenum[] = $rs->mat_master_linenum;
        $this->db->insert("machine_template_temp" , $arsaveToTemp);
    }



    $sqlGetTemplateDetail = $this->db->query("SELECT
    ted_template_bomid,
    ted_template_dataareaid
    FROM msd_template_detail
    WHERE ted_template_name = '$templatename' AND ted_template_itemuse = '$itemuse'
    ");
    $bomid = '';
    $dataareaid = '';
    if($sqlGetTemplateDetail->num_rows() != 0){
        $bomid = $sqlGetTemplateDetail->row()->ted_template_bomid;
        $dataareaid = $sqlGetTemplateDetail->row()->ted_template_dataareaid;
    }
    $arsaveToDetailTemp = array(
        "ted_template_name" => $templatename,
        "ted_template_itemuse" => $itemuse,
        "ted_template_bomid" => $bomid,
        "ted_template_dataareaid" => $dataareaid,
        "ted_template_image" => $template_image,
        "ted_template_user" => getUser()->Fname." ".getUser()->Lname,
        "ted_template_ecode" => getUser()->ecode,
        "ted_template_deptcode" => getUser()->DeptCode,
        "ted_template_datetime" => date("Y-m-d H:i:s")
    );
    $this->db->insert("msd_template_detail_temp" , $arsaveToDetailTemp);

    if($template_image != ""){
        $pathFrom = $_SERVER['DOCUMENT_ROOT']."/intsys/msd/upload/images_template/".$template_image;
        $pathTo = $_SERVER['DOCUMENT_ROOT']."/intsys/msd/upload/images_template_temp/".$template_image;
        @copy($pathFrom , $pathTo);
    }
    

    $output = array(
        "msg" => "บันทึกข้อมูลลง Machine Template Temp เรียบร้อยแล้ว",
        "status" => "Insert Success",
        "masterlinenum" => $masterlinenum
    );
    echo json_encode($output);

}



public function checkTemplateNameDuplicate()
{
    if($this->input->post("template_newname") != ""){
        $templatename = $this->input->post("template_newname");
        $sql = $this->db->query("SELECT mat_machine_name FROM machine_template WHERE mat_machine_name = '$templatename' GROUP BY mat_machine_name ");

        $resultCheck = $sql->num_rows();
        if($resultCheck != 0){
            $output = array(
                "msg" => "ชื่อนี้ซ้ำในระบบ",
                "status" => "Found Duplicate Template Name"
            );
            echo json_encode($output);
        }else{
            $output = array(
                "msg" => "ชื่อนี้สามารถใช้ได้",
                "status" => "Not Found Duplicate Template Name"
            );
            echo json_encode($output);
        }
    }
}




public function loadRunscreenFromTemplate()
{
    if($this->input->post("templatename") != ""){

        $templatename = $this->input->post("templatename");
        $select_edit_searchRunscreenMaster = $this->input->post("select_edit_searchRunscreenMaster");

        $sql = $this->db->query("SELECT
        machine_template.mat_autoid,
        machine_template.mat_column_name,
        machine_template.mat_machine_name,
        machine_template.mat_machine_type,
        machine_template.mat_min_value,
        machine_template.mat_max_value,
        machine_template.mat_spoint_value,
        machine_template.mat_linenum,
        machine_template.mat_master_linenum
        FROM
        machine_template
        WHERE mat_machine_name = '$templatename' 
        AND mat_column_name LIKE '%$select_edit_searchRunscreenMaster%'
        ORDER BY mat_linenum ASC");

        $output = '';
        $output .= '<ul class="list-group runScSelectTemplate">';
            foreach ($sql->result() as $rs) {
        
                $output .= '
                <a href="javascript:void(0)" id="">
                <li class="list-group-item mb-1 runScSelectLi">
                    <div>
                        <span>' . $rs->mat_column_name . '</span>
                    </div>
                    <div>
                        <span><b>Min : </b>'.conNumToText($rs->mat_min_value).'</span>&nbsp;&nbsp;<span><b>Max : </b>'.conNumToText($rs->mat_max_value).'</span>
                        <span><b>SPoint : </b>'.conNumToText($rs->mat_spoint_value).'</span>&nbsp;&nbsp;<span><b>Type : </b>'.$rs->mat_machine_type.'</span>
                    </div>
                </li></a>
            ';
            }
        $output .= '</ul>';
        echo $output;
    }
}


public function deleteTemplate()
{
    if($this->input->post("templatename") != ""){
        $templatename = $this->input->post("templatename");
        $filename = $this->input->post("filename");



        // Delete template other image
        $sqlgetOtherImage = $this->db->query("SELECT
        msd_template_image.temi_autoid,
        msd_template_image.temi_imagename,
        msd_template_image.temi_imagepath,
        msd_template_image.temi_templatename
        FROM
        msd_template_image
        WHERE temi_templatename = '$templatename'
        ");

        if($sqlgetOtherImage->num_rows() != 0){
            foreach($sqlgetOtherImage->result() as $rs){
                $path = $_SERVER['DOCUMENT_ROOT']."/intsys/msd/".$rs->temi_imagepath.$rs->temi_imagename;
                unlink($path);
            }

            $this->db->where("temi_templatename" , $templatename);
            $this->db->delete("msd_template_image");
        }

        // Unlink File
        if($filename != ""){
            $path = $_SERVER['DOCUMENT_ROOT']."/intsys/msd/upload/images_template/".$filename;
            unlink($path);
        }
        
        // Delete template table machine_template
        $this->db->where("mat_machine_name" , $templatename);
        $this->db->delete("machine_template");


        // Delete msd_template_detail
        $this->db->where("ted_template_name" , $templatename);
        $this->db->delete("msd_template_detail");

        // Delete msd_template_detail
        $this->db->where("faf_templatename" , $templatename);
        $this->db->delete("msd_template_feeder");

        // Delete msd_template_detail
        $this->db->where("b_templatename" , $templatename);
        $this->db->delete("msd_template_bom");

        // History
        $detail = "ลบ Template $templatename สำเร็จ";
        $menu = "Delete Template";
        $actionType = "delete data";
        $ip = $this->input->ip_address();
        saveHistory($templatename , $itemid = "" , $dataareaid = "" , $detail , $menu , $actionType , $ip);

        $output = array(
            "msg" => "ลบ Template สำเร็จ",
            "status" => "Delete Template Success"
        );

        echo json_encode($output);
    }
}



public function loadItemidFormTable()
{
    if($this->input->post("itemid") != ""){
        $itemid = $this->input->post("itemid");
        $sql = $this->db4->query("SELECT TOP 50
            itemid 
        FROM
            prodtable WHERE itemid LIKE '%$itemid%' 
        GROUP BY
            itemid 
        ORDER BY
            itemid ASC");

        $output = '';
        $output .= '<ul class="list-group itemidUl">';
            foreach ($sql->result() as $rs) {
        
                $output .= '
                <a href="javascript:void(0)" id="itemidA"
                    data_itemid = "'.$rs->itemid.'"
                ><li class="list-group-item mb-1 itemidLi">
                <span>' . $rs->itemid . '</span><br>
                </li></a>
            ';
            }
        $output .= '</ul>';
        echo $output;
    }
}


public function loadItemidFormTable_edit()
{
    if($this->input->post("itemid") != ""){
        $itemid = $this->input->post("itemid");
        $sql = $this->db4->query("SELECT TOP 50
            itemid 
        FROM
            prodtable WHERE itemid LIKE '%$itemid%' 
        GROUP BY
            itemid 
        ORDER BY
            itemid ASC");

        $output = '';
        $output .= '<ul class="list-group itemidUl_edit">';
            foreach ($sql->result() as $rs) {
        
                $output .= '
                <a href="javascript:void(0)" id="itemidA_edit"
                    data_itemid = "'.$rs->itemid.'"
                ><li class="list-group-item mb-1 itemidLi_edit">
                <span>' . $rs->itemid . '</span><br>
                </li></a>
            ';
            }
        $output .= '</ul>';
        echo $output;
    }
}



public function save_edittemplate_editrun()
{
    if($this->input->post("editRSC_autoid_edit") != ""){
        $arupdateRunscreen = array(
            "mat_min_value" => conPrice($this->input->post("editRSC_min_edit")),
            "mat_max_value" => conPrice($this->input->post("editRSC_max_edit")),
            "mat_spoint_value" => conPrice($this->input->post("editRSC_spoint_edit")),
        );

        $this->db->where("mat_autoid" , $this->input->post("editRSC_autoid_edit"));
        $this->db->update("machine_template_temp" , $arupdateRunscreen);

        $output = array(
            "msg" => "อัพเดต Runscreen สำเร็จ",
            "status" => "Update Success",
            "templatename" => $this->input->post("editRSC_templatename_edit")
        );
    }else{
        $output = array(
            "msg" => "อัพเดต Runscreen ไม่สำเร็จ",
            "status" => "Update Not Success",
            "templatename" => ""
        );
    }

    echo json_encode($output);
}



public function countTotalRunMasterShow()
{
    if($this->input->post("templatename") != ""){
        $templatename = $this->input->post("templatename");
        $sql = $this->db->query("SELECT mat_column_name FROM machine_template WHERE mat_machine_name = '$templatename' ");
        $output = '';

        $output .=$sql->num_rows();

        echo $output;
    }
}


public function getRunscreenMasterNew()
{
    echo "test";
}


public function overall_template()
{
    if($this->input->post("templatename") != ""){
        $templatename = $this->input->post("templatename");

        $sql = $this->db->query("SELECT 
        mat_column_name , 
        mat_machine_type ,
        mat_min_value ,
        mat_max_value ,
        mat_spoint_value
        FROM machine_template WHERE mat_machine_name = '$templatename' ORDER BY mat_linenum ASC ");

        $output = '';

        $output .='
        <h4 class="text-center">Total : '.$sql->num_rows().' รายการ</h4>
        <div id="submaindatadiv" class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <th style="width:90%;">Run Screen</th>
                    <th>Min</th>
                    <th>Max</th>
                    <th>SPoint</th>
                    <th>Type</th>
                </thead>
        ';

        $output .='
                <tbody>   
        ';

        foreach($sql->result() as $rs){
            $output .='
                <tr>
                    <td>'.$rs->mat_column_name.'</td>
                    <td>'.valueFormat($rs->mat_min_value).'</td>
                    <td>'.valueFormat($rs->mat_max_value).'</td>
                    <td>'.valueFormat($rs->mat_spoint_value).'</td>
                    <td>'.$rs->mat_machine_type.'</td>
                </tr>
            ';
        }

        $output .='
                </tbody>
        ';

        $output .='
            </table>
        </div>
        ';

        echo $output;
    }
}



public function del_dataFromTemptableBy_templatename()
{
    $templatename = "";
    if($this->input->post("templatename") != ""){
        $templatename = $this->input->post("templatename");
        $ecode = $this->input->post("ecode");
        
        // Check Template ว่ามีข้อมูลใน Temptable ไหม
        $sql = $this->db->query("SELECT mat_machine_name FROM machine_template_temp WHERE mat_machine_name = '$templatename' AND mat_ecodepost = '$ecode' ");
        if($sql->num_rows() != 0){
            $this->db->where("mat_machine_name" , $templatename);
            $this->db->delete("machine_template_temp");
        }


        //Check Template Detail ว่ามีข้อมูลอยู่ไหม
        $sql2 = $this->db->query("SELECT ted_template_name , ted_template_image FROM msd_template_detail_temp WHERE ted_template_name = '$templatename' AND ted_template_ecode = '$ecode' ");

        $templateimage = "";
        if($sql2->num_rows() != 0){
            // Check File ว่ามีการอัพโหลดภาพมาแล้วหรือยัง
            $templateimage = $sql2->row()->ted_template_image;
            if($templateimage != ""){
                $path = $_SERVER['DOCUMENT_ROOT']."/intsys/msd/upload/images_template_temp/".$templateimage;
                if(file_exists($path) != 0){
                    unlink($path);
                }  
            }

            $this->db->where("ted_template_name" , $templatename);
            $this->db->delete("msd_template_detail_temp");
        }

        $output = array(
            "msg" => "ล้างข้อมูลใน Temp Table Template ".$templatename."เรียบร้อยแล้ว",
            "status" => "Clear Data Already"
        );
        echo json_encode($output);
    }
}



public function checkDataOnTemptable()
{
    $templatename = "";
    if($this->input->post("templatename") != ""){
        $templatename = $this->input->post("templatename");
        $sql = $this->db->query("SELECT
        msd_template_detail_temp.ted_template_name,
        msd_template_detail_temp.ted_template_image,
        msd_template_detail_temp.ted_template_itemuse,
        machine_template_temp.mat_column_name
        FROM
        msd_template_detail_temp
        INNER JOIN machine_template_temp ON machine_template_temp.mat_machine_name = msd_template_detail_temp.ted_template_name
        WHERE ted_template_name = '$templatename' ");

        if($sql->num_rows() != 0){

            $this->db->where("mat_machine_name" , $templatename);
            $this->db->delete("machine_template_temp");

            $templateimage = $sql->row()->ted_template_image;
            if($templateimage != ""){
                $path = $_SERVER['DOCUMENT_ROOT']."/intsys/msd/upload/images_template_temp/".$templateimage;
                unlink($path);
            }

            $this->db->where("ted_template_name" , $templatename);
            $this->db->delete("msd_template_detail_temp");


            $output = array(
                "msg" => "พบข้อมูล Template ".$templatename."เดิมบน Temp table",
                "status" => "Found Data",
                "templatename" => $templatename,
                "process" => "Done"
            );
        }else{
            $output = array(
                "msg" => "ไม่พบข้อมูล Template ".$templatename."เดิมบน Temp table",
                "status" => "Not Found Data",
                "templatename" => $templatename,
                "process" => "Done"
            );
        }

        echo json_encode($output);
    }
}


public function del_dataFromTemptable_whenReloadPageByEcode()
{
    $ecode = "";
    if($this->input->post("ecode") != ""){
        $ecode = $this->input->post("ecode");
        // Check Template ว่ามีข้อมูลใน Temptable ไหม
        $sql = $this->db->query("SELECT mat_machine_name FROM machine_template_temp WHERE mat_ecodepost = '$ecode' ");
        if($sql->num_rows() != 0){
            $this->db->where("mat_ecodepost" , $ecode);
            $this->db->delete("machine_template_temp");
        }


        //Check Template Detail ว่ามีข้อมูลอยู่ไหม
        $sql2 = $this->db->query("SELECT ted_template_name , ted_template_image FROM msd_template_detail_temp WHERE ted_template_ecode = '$ecode' ");

        $templateimage = "";
        if($sql2->num_rows() != 0){
            // Check File ว่ามีการอัพโหลดภาพมาแล้วหรือยัง
            $templateimage = $sql2->row()->ted_template_image;
            if($templateimage != ""){
                $path = $_SERVER['DOCUMENT_ROOT']."/intsys/msd/upload/images_template_temp/".$templateimage;
                if(file_exists($path) != 0){
                    unlink($path);
                }   
            }

            $this->db->where("ted_template_ecode" , $ecode);
            $this->db->delete("msd_template_detail_temp");
        }

        $output = array(
            "msg" => "ลบข้อมูลที่ค้างออกหมดแล้ว",
            "status" => "Clear data by ecode already"
        );

        echo json_encode($output);
    }
}




public function checkDataTempBefore()
{
    $templatename = "";
    $ecode = "";

    if($this->input->post("templatename") != ""){
        $templatename = $this->input->post("templatename");
        $ecode = $this->input->post("ecode");
        $sql = $this->db->query("SELECT
                msd_template_detail_temp.ted_template_name,
                msd_template_detail_temp.ted_template_image,
                msd_template_detail_temp.ted_template_itemuse,
                machine_template_temp.mat_column_name,
                machine_template_temp.mat_machine_type,
                machine_template_temp.mat_linenum,
                machine_template_temp.mat_ecodepost,
                machine_template_temp.mat_userpost
                FROM
                msd_template_detail_temp
                INNER JOIN machine_template_temp ON machine_template_temp.mat_machine_name = msd_template_detail_temp.ted_template_name
                WHERE ted_template_name = '$templatename' ");
        
        // Check ว่า Template นี้มีคนอื่นกำลังแก้ไขอยู่หรือไม่
        $msgOutput = "";
        $statusOutput = "";
        if($sql->num_rows() != 0){
            // เช็คว่าใช่ user ตัวเองไหมที่แก้ไขค้างอยู่
            if($sql->row()->mat_ecodepost != $ecode){
                $msgOutput = "Template นี้กำลังถูกแก้ไขโดยคุณ ".$sql->row()->mat_userpost;
                $statusOutput = "Found other user edit template";
            }else{
                $msgOutput = "พบ Template ค้างในรายการแก้ไข ระบบกำลังลบ...";
                $statusOutput = "Clear data";
            }
        }else{
            $msgOutput = "ไม่พบความผิดปกติ เข้าสู่ขั้นตอนต่อไปได้";
            $statusOutput = "Ok";
        }

        $output = array(
            "msg" => $msgOutput,
            "status" => $statusOutput
        );

        echo json_encode($output);
    }
}


public function deleteOtherImage()
{
    if($this->input->post("data_autoid") != ""){
        // Unlink file
        $filepath = $this->input->post("data_path");
        $filename = $this->input->post("data_image");
        $autoid = $this->input->post("data_autoid");
        $path = $_SERVER['DOCUMENT_ROOT']."/intsys/msd/".$filepath.$filename;
        unlink($path);

        $this->db->where("temi_autoid" , $autoid);
        $this->db->delete("msd_template_image");

        $output = array(
            "msg" => "ลบรูป Template อื่นๆ เรียบร้อยแล้ว",
            "status" => "Delete Data Success"
        );
    }else{
        $output = array(
            "msg" => "ลบรูป Template อื่นๆ ไม่สำเร็จ",
            "status" => "Delete Data Not Success"
        );
    }
    echo json_encode($output);
}


public function loadTemplateOtherImage()
{
    if($this->input->post("templatename") != ""){
        $templatename = $this->input->post("templatename");
        $sql = $this->db->query("SELECT
        msd_template_image.temi_autoid,
        msd_template_image.temi_imagename,
        msd_template_image.temi_imagepath,
        msd_template_image.temi_templatename
        FROM
        msd_template_image
        WHERE temi_templatename = '$templatename' ORDER BY temi_autoid ASC
        ");

        $output = array(
            "msg" => "ดึงข้อมูลรูปภาพสำเร็จ",
            "status" => "Select Data Success",
            "templateOtherImage" => $sql->result()
        );
    }else{
        $output = array(
            "msg" => "ดึงข้อมูลรูปภาพไม่สำเร็จ",
            "status" => "Select Data Not Success",
            "templateOtherImage" => null
        );
    }
    echo json_encode($output);
}



public function saveOtherImage_edit()
{
    if($this->input->post("select_edit_template_name") != ""){

        $otherImagepath = $this->input->post("select_checkOtherImagePath");
        $old_templatename = $this->input->post("select_check_templatename");
        $new_templatename = $this->input->post("select_edit_template_name");
        $new_templatename_change = $this->input->post("select_edit_template_name_new");

        if($otherImagepath != "" && $old_templatename != $new_templatename){
            // $sqlgetOtherImage = $this->db->query("SELECT
            // temi_imagename,
            // temi_imagepath,
            // temi_templatename
            // FROM msd_template_image WHERE temi_templatename = '$old_templatename' AND temi_imagepath = '$otherImagepath'
            // ");

            // foreach($sqlgetOtherImage->result() as $rs){
            //     $path = $_SERVER['DOCUMENT_ROOT']."/intsys/msd/".$rs->temi_imagepath.$rs->temi_imagename;
            //     unlink($path);
            // }
            $arupdateNewTemplate = array(
                "temi_templatename" => $new_templatename
            );
            $this->db->where("temi_templatename" , $old_templatename);
            $this->db->update("msd_template_image" , $arupdateNewTemplate);

            // save new data to table
            // $fileInput = "select_edit_template_otherImage";
            // uploadImageTemplate_other($fileInput , $new_templatename);
            
        }else if($old_templatename == $new_templatename){
            // save new data to table
            $fileInput = "select_edit_template_otherImage";
            uploadImageTemplate_other($fileInput , $new_templatename);
        }



        $output = array(
            "msg" => "บันทึกรูปภาพอื่นๆของ Template สำเร็จ",
            "status" => "Insert Data Success"
        );

    }else{
        $output = array(
            "msg" => "บันทึกรูปภาพอื่นๆของ Template ไม่สำเร็จ",
            "status" => "Insert Data Not Success",
        );
    }

    echo json_encode($output);
}


public function setActiveRun()
{
    if($this->input->post("data_mat_autoid")){
        $data_mat_autoid = $this->input->post("data_mat_autoid");
        $data_mat_machine_name = $this->input->post("data_mat_machine_name");

        // Clear data active = null
        $this->db->set('mat_select_status' , null);
        $this->db->where("mat_machine_name" , $data_mat_machine_name);
        $this->db->update('machine_template_temp');

        $this->db->set('mat_select_status' , 'Active');
        $this->db->where('mat_autoid' , $data_mat_autoid);
        $this->db->update('machine_template_temp');

        $output = array(
            "msg" => "อัพเดต Active Runscreen สำเร็จ",
            "status" => "Update Data Success"
        );
    }else{
        $output = array(
            "msg" => "อัพเดต Active Runscreen ไม่สำเร็จ",
            "status" => "Update Data Not Success"
        );
    }
    echo json_encode($output);
}







/////////////////////////////////////////////////////////////////////////////////
////////setting.html ส่วนของบริหารจัดการข้อมูลหน้า Setting page
////////////////////////////////////////////////////////////////////////////////



public function updateData()
{
    $sqlget = $this->db->query("SELECT * 
    FROM machine_template 
    WHERE mat_master_linenum in ('62') AND mat_machine_name LIKE '%24TEK96-1%' GROUP BY  mat_machine_name
    ");

    $getTemplate = $this->db->query("SELECT
            b.mat_machine_name,
            b.mat_linenum 
        FROM
            ( SELECT MAX( mat_linenum ) AS mat_linenum FROM machine_template WHERE mat_machine_name LIKE '%24TEK96-1%' GROUP BY mat_machine_name ) a
            LEFT JOIN ( SELECT * FROM machine_template ) b ON a.mat_linenum = b.mat_linenum 
        WHERE
            mat_machine_name LIKE '%24TEK96-1%' 
        GROUP BY
            mat_machine_name
    ");

    $output = array(
        "msg" => "ดึงข้อมูลสำเร็จ",
        "status" => "Select Data Success",
        "result" => $sqlget->result(),
        "result2" => $getTemplate->result()
    );

    echo json_encode($output);

    // $array_masterlinenum = array('88' , '89' , '90' , '91' , '198' , '199' , '200');

    // // $this->db->select('*');
    // // $this->db->from('machine_template');
    // $this->db->where_in('mat_master_linenum',$array_masterlinenum);
    // $this->db->where('mat_userpost','Yaowaman B');
    // $this->db->like('mat_machine_name' , '23MX105-1');
    // // $this->db->delete('machine_template');

    //     $output = array(
    //     "msg" => "ดึงข้อมูลสำเร็จ",
    //     "status" => "Select Data Success",
    //     );

    // echo json_encode($output);
}


    public function get_bomversionData()
    {
        if($this->input->post("template_dataareaid")){
            $template_dataareaid = $this->input->post("template_dataareaid");
            $template_itemid = $this->input->post("template_itemid");

            $sqlgetbomversion = $this->db4->query("SELECT 
            a.itemid as bv_itemid, 
            a.bomid as bv_bomid, 
            a.active , 
            a.dataareaid ,
            a.inventdimid ,
            b.configid as bv_configid
            from bomversion a
            inner join (select * from inventdim)b on b.inventdimid = a.inventdimid
            where a.itemid = '$template_itemid' and active = 1 and a.dataareaid = '$template_dataareaid'
            group by
            a.itemid , 
            a.bomid , 
            a.active , 
            a.dataareaid ,
            a.inventdimid ,
            b.configid");

            $output = '';
            if($sqlgetbomversion->num_rows() != 0){
                $output = '<option value="">กรุณาเลือก Bom Version</option>';
                foreach($sqlgetbomversion->result() as $rs){
                    $output .='<option value="'.$rs->bv_bomid.'">Item ID : '.$rs->bv_itemid.'&nbsp&nbspConfig ID : '.$rs->bv_configid.'</option>';
                }
            }

            $output_json = array(
                "msg" => "ดึงข้อมูล Bom Version สำเร็จ",
                "status" => "Select Data Success",
                "bomversion_result" => $output
            );
        }else{
            $output_json = array(
                "msg" => "ดึงข้อมูล Bom Version ไม่สำเร็จ",
                "status" => "Select Data Not Success",
            );
        }

        echo json_encode($output_json);
    }


    public function copyFeederForBomTemplate()
    {
        if($this->input->post("templatename") != ""){
            $arvalue = [];
            $templatename = $this->input->post("templatename");
            $dataareaid = $this->input->post("template_dataareaid");
            $template_itemid = $this->input->post("template_itemid");
            $bomid = $this->input->post("template_bomid");
            $userEcodepost = getUser()->ecode;

            $this->db->where("faf_ecodepost" , $userEcodepost);
            $this->db->delete("msd_template_feeder_temp");

            $this->db->where("b_ecode" , $userEcodepost);
            $this->db->delete("msd_template_bom_temp");

            $sql = $this->db->query("SELECT
            machine_template.mat_autoid,
            machine_template.mat_column_name,
            machine_template.mat_machine_name,
            machine_template.mat_machine_type,
            machine_template.mat_linenum,
            machine_template.mat_master_linenum,
            machine_template.mat_userpost,
            machine_template.mat_ecodepost,
            machine_template.mat_datetime,
            msd_template_detail.ted_template_dataareaid
            FROM
            machine_template
            INNER JOIN msd_template_detail ON msd_template_detail.ted_template_name = machine_template.mat_machine_name
            WHERE mat_machine_type = 'Feeder' AND mat_machine_name = '$templatename' and ted_template_dataareaid = '$dataareaid'
            ");


            $sqlbom = $this->db4->query("SELECT 
            a.itemid, 
            a.bomid , 
            a.active , 
            a.approved , 
            a.inventdimid , 
            a.dataareaid ,
            b.linenum as bomlinenum,
            b.itemid as bomitemid,
            b.bomqty as bbomqty, 
            b.dataareaid ,
            c.configid
            from bomversion a
            inner join (select linenum , itemid , bomqty , bomid , dataareaid from bom)b on a.bomid = b.bomid and a.dataareaid = b.dataareaid
            inner join (select configid , dataareaid , inventdimid from inventdim)c on c.inventdimid = a.inventdimid and a.dataareaid = c.dataareaid
            where a.itemid = '$template_itemid' and a.active = '1' and a.dataareaid = '$dataareaid' and a.bomid = '$bomid'
            group by a.itemid , 
            a.bomid , 
            a.active , 
            a.approved , 
            a.inventdimid , 
            a.dataareaid , 
            b.linenum , 
            b.itemid , 
            b.bomqty ,
            b.dataareaid ,
            c.configid
            order by b.linenum asc");

            //Check Data Duplicate

            $sqlcheck1 = $this->db->query("SELECT 
            faf_templatename , 
            faf_dataareaid , 
            faf_ecodepost 
            FROM msd_template_feeder_temp
            WHERE faf_templatename = '$templatename' AND faf_dataareaid = '$dataareaid' AND faf_ecodepost = '$userEcodepost' AND faf_itemid = '$template_itemid' ");


            
            if($sqlcheck1->num_rows() == 0){
                foreach($sql->result() as $rs){
                    $arrCopyData = array(
                        "faf_templatename" => $rs->mat_machine_name,
                        "faf_dataareaid" => $rs->ted_template_dataareaid,
                        "faf_itemid" => $template_itemid,
                        "faf_feedername" => $rs->mat_column_name,
                        "faf_userpost" => getUser()->Fname." ".getUser()->Lname,
                        "faf_ecodepost" => getUser()->ecode,
                        "faf_deptcodepost" => getUser()->DeptCode,
                        "faf_datetime" => date("Y-m-d H:i:s")
                    );
                    $this->db->insert("msd_template_feeder_temp" , $arrCopyData);
                }
            }


            //Check Data Bom Duplicate
            $sqlcheckBomDup = $this->db->query("SELECT
            msd_template_bom_temp.b_autoid,
            msd_template_bom_temp.b_templatename,
            msd_template_bom_temp.b_dataareaid,
            msd_template_bom_temp.b_linenum,
            msd_template_bom_temp.b_rawmaterial,
            msd_template_bom_temp.b_ecode,
            msd_template_bom_temp.b_bomid
            FROM
            msd_template_bom_temp
            WHERE b_templatename = '$templatename' AND b_dataareaid = '$dataareaid' AND b_ecode = '$userEcodepost' and b_bomid = '$bomid'
            ");


            if($sqlcheckBomDup->num_rows() == 0){
                foreach($sqlbom->result() as $rs){
                    $arsaveBom = array(
                        "b_templatename" => $templatename,
                        "b_dataareaid" => $dataareaid,
                        "b_linenum" => $rs->bomlinenum,
                        "b_rawmaterial" => $rs->bomitemid,
                        "b_bomqty" => $rs->bbomqty,
                        "b_bombalance" => $rs->bbomqty,
                        "b_bomtype" => "original",
                        "b_bomstatus" => "active",
                        "b_ecode" => $userEcodepost,
                        "b_bomid" => $bomid,
                        "b_itemid" => $template_itemid
                    );
    
                    $this->db->insert("msd_template_bom_temp" , $arsaveBom);
                }
            }



            //Query Data From msd_template_feeder
            $sql_feeder = $this->db->query("SELECT
            msd_template_feeder_temp.faf_autoid,
            msd_template_feeder_temp.faf_b_autoid,
            msd_template_feeder_temp.faf_bomid,
            msd_template_feeder_temp.faf_templatename,
            msd_template_feeder_temp.faf_dataareaid,
            msd_template_feeder_temp.faf_itemid,
            msd_template_feeder_temp.faf_feedername,
            msd_template_feeder_temp.faf_rawmaterial,
            msd_template_feeder_temp.faf_value,
            msd_template_feeder_temp.faf_inlet,
            msd_template_feeder_temp.faf_userpost,
            msd_template_feeder_temp.faf_ecodepost,
            msd_template_feeder_temp.faf_deptcodepost,
            msd_template_feeder_temp.faf_datetime
            FROM
            msd_template_feeder_temp
            WHERE faf_templatename = '$templatename' AND faf_dataareaid = '$dataareaid' AND faf_itemid = '$template_itemid'
            ORDER BY faf_feedername ASC
            ");


            $output = '';

            if($sql->num_rows() == 0){
                $output .='<h3 class="text-center">พบข้อผิดพลาดเกี่ยวกับ Feeder กรุณาติดต่อไอที</h3>';
            }else{
                $output .='
                <div class="table-responsive">
                    <table id="feederTemplate" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <th style="width:80px;">Feeder</th>
                            <th>Raw Material</th>
                            <th style="width:90px;" class="thInlet">
                                Inlet
                            </th>
                            <th style="width:90px;">%</th>
                            <th style="width:80px;">#</th>
                        </thead>
                        <tbody>
                ';
                foreach($sql_feeder->result() as $rs){


                    $iconFeedDel = '<i id="iconFeedDel" class="icon-trash-alt iconFeedDel_template"
                        data_autoid="'.$rs->faf_autoid.'"
                        data_b_autoid="'.$rs->faf_b_autoid.'"
                        data_value="'.$rs->faf_value.'"
                        data_templatename="'.$rs->faf_templatename.'"
                        data_itemid="'.$rs->faf_itemid.'"
                        data_areaid="'.$rs->faf_dataareaid.'"
                        data_bomid="'.$rs->faf_bomid.'"
                    ></i>';

                    $output .='
                    <tr>
                        <td>'.$rs->faf_feedername.'</td>
                        <td>'.$rs->faf_rawmaterial.'</td>
                        <td>'.$rs->faf_inlet.'</td>
                        <td>'.$rs->faf_value.'</td>
                        <td>'.$iconFeedDel.'</td>
                    </tr>
                    ';
                    $arvalue[] = $rs->faf_value;
                }

                $resultSum = array_sum($arvalue);

                if($resultSum != 100){
                    $textColor = 'style="color:#CC0000;"';
                }else{
                    $textColor = 'style="color:#009900;"';
                }

                $output .='
                <tr>
                    <td colspan="2" class="text-right"><b>Total</b></td>
                    <td colspan="3" '.$textColor.'><b>'.number_format($resultSum,3).'</b></td>
                </tr>
                        </tbody>
                    </table>
                    <input hidden type="text" name="checkFeederSum_tmp" id="checkFeederSum_tmp" value="'.number_format($resultSum,3).'">
                </div>
                ';
            }
            //Query Data From msd_template_feeder




            // Query data from msd_template_bom
            $sql_bom = $this->db->query("SELECT
            msd_template_bom_temp.b_autoid,
            msd_template_bom_temp.b_templatename,
            msd_template_bom_temp.b_dataareaid,
            msd_template_bom_temp.b_linenum,
            msd_template_bom_temp.b_rawmaterial,
            msd_template_bom_temp.b_bomqty,
            msd_template_bom_temp.b_bomqtyuse,
            msd_template_bom_temp.b_bomqtyusemix,
            msd_template_bom_temp.b_bombalance,
            msd_template_bom_temp.b_bomtype,
            msd_template_bom_temp.b_bomstatus,
            msd_template_bom_temp.b_bomid,
            msd_template_bom_temp.b_itemid
            FROM
            msd_template_bom_temp
            WHERE b_templatename = '$templatename' And b_dataareaid = '$dataareaid' AND b_bomstatus != 'inactive' AND b_bomid = '$bomid' AND b_itemid = '$template_itemid'
            ");

            $output_bom = '<div class="list-group">';
            foreach($sql_bom->result() as $rs){

                $templatename = $rs->b_templatename;
                $itemid = $rs->b_itemid;
                $dataareaid = $rs->b_dataareaid;
                $rawmaterial = $rs->b_rawmaterial;
                $b_autoid = $rs->b_autoid;
                $bomforuse = $rs->b_bombalance;

                $textColor ="";
                if($bomforuse == 0){
                    $textColor = 'style="color:#CC0000"';
                }else{
                    $textColor ='';
                }

                // Check ว่ามีการจองเพื่อ Mix หรือยัง
                    if($rs->b_bomstatus == "wait confirm"){
                        $mixStatus = '<span class="badge badge-warning badge-pill ml-3 p-2 bomsum">Wait Mix !</span>';
                        $modalId = "";
                    }else{
                        $mixStatus = "";
                        $modalId = "#md_bom";
                    }
                // Check ว่ามีการจองเพื่อ Mix หรือยัง

                //////////////////////////////////
                ///// Check Dept permission
                /////////////////////////////////
                if(getUser()->DeptCode == "1007" || getUser()->DeptCode == "1002"){
                    $output_bom .='
                        <a href="javascript:void(0)" class="list-group-item list-group-item-action md_bom_template"
                            data_templatename="'.$rs->b_templatename.'"
                            data_dataareaid="'.$rs->b_dataareaid.'"
                            data_rawmaterial="'.$rs->b_rawmaterial.'"
                            data_bomqty="'.$rs->b_bomqty.'"
                            data_bomqtyuse="'.$rs->b_bomqtyuse.'"
                            data_bomsum="'.$bomforuse.'"
                            data_bombalance="'.$rs->b_bombalance.'"
                            data_bomautoid="'.$rs->b_autoid.'"
                            data_bomstatus="'.$rs->b_bomstatus.'"
                            data_itemid="'.$rs->b_itemid.'"
                            data_bomid="'.$rs->b_bomid.'"
                            data_bomtype="'.$rs->b_bomtype.'"

                        >'.$rs->b_rawmaterial.'<span class="badge badge-success badge-pill ml-3 p-2 bomtotal">'.$rs->b_bomqty.'</span>
                        <span class="badge badge-warning badge-pill ml-3 p-2 bomsum" '.$textColor.'>'.number_format($bomforuse,3).'</span>
                        '.$mixStatus.'
                        </a>
                        ';
                }else{
                        $output_bom .='
                        <a href="javascript:void(0)" class="list-group-item list-group-item-action">'.$rs->b_rawmaterial.'<span class="badge badge-success badge-pill ml-3 p-2 bomtotal">'.$rs->b_bomqty.'</span>
                        <span class="badge badge-warning badge-pill ml-3 p-2 bomsum" '.$textColor.'>'.number_format($bomforuse,3).'</span>
                        '.$mixStatus.'
                        </a>
                        ';
                }
                //////////////////////////////////
                ///// Check Dept permission
                /////////////////////////////////


            }
            $output_bom .='</div>';


            $outputData = array(
                "msg" => "ดึงข้อมูลสำเร็จ",
                "status" => "Select Data Success",
                "feederResult" => $output,
                "bomResult" => $output_bom
            );
        }else{
            $outputData = array(
                "msg" => "ดึงข้อมูลไม่สำเร็จ",
                "status" => "Select Data Not Success",
            );
        }

        echo json_encode($outputData);
    }




    public function chooseFeeder_template()
    {
        if($this->input->post("templatename") != ""){
            $templatename = $this->input->post("templatename");
            $dataareaid = $this->input->post("dataareaid");

            $sqlGetFeeder = $this->db->query("SELECT
            faf_feedername,
            faf_autoid
            FROM msd_template_feeder_temp
            WHERE faf_templatename = '$templatename' AND faf_dataareaid = '$dataareaid' AND faf_rawmaterial IS NULL
            ORDER BY faf_feedername ASC
            ");
            $html = '';
            if($sqlGetFeeder->num_rows() != 0){
                $html .= '<option value="">กรุณาเลือก Feeder</option>';
                foreach($sqlGetFeeder->result() as $rs){
                    $html .='<option value="'.$rs->faf_autoid.'">'.$rs->faf_feedername.'</option>';
                }
            }

            $output = array(
                "msg" => "ดึงข้อมูล Feeder สำเร็จ",
                "status" => "Select Data Success",
                "result" => $html
            );
        }else{
            $output = array(
                "msg" => "ดึงข้อมูล Feeder ไม่สำเร็จ",
                "status" => "Select Data Not Success",
                "result" => $html
            );
        }
        echo json_encode($output);
    }

    
    public function saveDataToFeederBom_template_tmp()
    {
        // Save Data to feeder
        if($this->input->post("chooseFeeder_template") != "" && $this->input->post("md_value_template") != ""){
            $feederid = $this->input->post("chooseFeeder_template");
            $rawmaterial = $this->input->post("md_rawmaterial_tm");
            $rawmaterial_value_use = $this->input->post("md_value_template");
            $rawmaterial_value_balance = $this->input->post("md_qtyBalance_tm");
            $rawmaterial_value_usecal = $this->input->post("md_qtyuseCal_tm");
            $rawmaterial_autoid = $this->input->post("md_autoid_tm");

            $templatename = $this->input->post("md_templatename_tm");
            $itemid = $this->input->post("md_itemid_tm");
            $dataareaid = $this->input->post("md_dataareaid_tm");
            $bomid = $this->input->post("md_bomid_tm");

            // Update feeder template tmp
            $arupdateFeeder = array(
                "faf_rawmaterial" => $rawmaterial,
                "faf_value" => $rawmaterial_value_use,
                "faf_b_autoid" => $rawmaterial_autoid,
                "faf_bomid" => $bomid
            );
            $this->db->where("faf_autoid" , $feederid);
            $this->db->update("msd_template_feeder_temp" , $arupdateFeeder);


            // Update bom template tmp
            $arupdateBom = array(
                "b_bomqtyuse" => $rawmaterial_value_usecal,
                "b_bombalance" => $rawmaterial_value_balance,
            );
            $this->db->where("b_autoid" , $rawmaterial_autoid);
            $this->db->update("msd_template_bom_temp" , $arupdateBom);

            // Getdata Feeder tmp
            $dataFeederTmp = $this->getFeederTemplate_tmp($templatename , $dataareaid , $itemid);
            // Getdata Bom tmp
            $dataBomTmp = $this->getBomTemplate_tmp($templatename , $dataareaid , $itemid , $bomid);

            $output_json = array(
                "msg" => "อัพเดตข้อมูลสำเร็จ",
                "status" => "Update Data Success",
                "dataFeederTmp" => $dataFeederTmp,
                "dataBomTmp" => $dataBomTmp,
                "templatename" => $templatename,
                "itemid" => $itemid,
                "bomid" => $bomid,
                "dataareaid" => $dataareaid
            );
        }else{
            $output_json = array(
                "msg" => "อัพเดตข้อมูลไม่สำเร็จ",
                "status" => "Update Data Not Success",
            );
        }
        echo json_encode($output_json);
    }

    private function getFeederTemplate_tmp($templatename , $dataareaid , $itemid)
    {
        if($templatename != "" && $dataareaid != "" && $itemid != ""){
            //Query Data From msd_template_feeder
            $sql_feeder = $this->db->query("SELECT
            msd_template_feeder_temp.faf_autoid,
            msd_template_feeder_temp.faf_templatename,
            msd_template_feeder_temp.faf_dataareaid,
            msd_template_feeder_temp.faf_feedername,
            msd_template_feeder_temp.faf_rawmaterial,
            msd_template_feeder_temp.faf_value,
            msd_template_feeder_temp.faf_inlet,
            msd_template_feeder_temp.faf_userpost,
            msd_template_feeder_temp.faf_ecodepost,
            msd_template_feeder_temp.faf_deptcodepost,
            msd_template_feeder_temp.faf_datetime,
            msd_template_feeder_temp.faf_b_autoid,
            msd_template_feeder_temp.faf_itemid,
            msd_template_feeder_temp.faf_bomid
            FROM
            msd_template_feeder_temp
            WHERE faf_templatename = '$templatename' AND faf_dataareaid = '$dataareaid' AND faf_itemid = '$itemid'
            ORDER BY faf_feedername ASC
            ");


            $output = '';

            if($sql_feeder->num_rows() == 0){
                $output .='<h3 class="text-center">พบข้อผิดพลาดเกี่ยวกับ Feeder กรุณาติดต่อไอที</h3>';
            }else{
                $output .='
                <div class="table-responsive">
                    <table id="feederTemplate" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <th style="width:80px;">Feeder</th>
                            <th>Raw Material</th>
                            <th style="width:90px;" class="thInlet">
                                Inlet
                            </th>
                            <th style="width:90px;">%</th>
                            <th style="width:80px;">#</th>
                        </thead>
                        <tbody>
                ';
                foreach($sql_feeder->result() as $rs){


                    $iconFeedDel = '<i id="iconFeedDel" class="icon-trash-alt iconFeedDel_template"
                        data_autoid="'.$rs->faf_autoid.'"
                        data_b_autoid="'.$rs->faf_b_autoid.'"
                        data_value="'.$rs->faf_value.'"
                        data_templatename="'.$rs->faf_templatename.'"
                        data_itemid="'.$rs->faf_itemid.'"
                        data_areaid="'.$rs->faf_dataareaid.'"
                        data_bomid="'.$rs->faf_bomid.'"
                    ></i>';

                    if($rs->faf_inlet == 0){
                        $rs->faf_inlet = "N/A";
                    }

                    $output .='
                    <tr>
                        <td>'.$rs->faf_feedername.'</td>
                        <td>'.$rs->faf_rawmaterial.'</td>
                        <td>'.$rs->faf_inlet.'</td>
                        <td>'.$rs->faf_value.'</td>
                        <td>'.$iconFeedDel.'</td>
                    </tr>
                    ';
                    $arvalue[] = $rs->faf_value;
                }

                $resultSum = array_sum($arvalue);

                if($resultSum != 100){
                    $textColor = 'style="color:#CC0000;"';
                }else{
                    $textColor = 'style="color:#009900;"';
                }

                $output .='
                <tr>
                    <td colspan="2" class="text-right"><b>Total</b></td>
                    <td colspan="3" '.$textColor.'><b>'.number_format($resultSum,3).'</b></td>
                </tr>
                        </tbody>
                    </table>
                    <input hidden type="text" name="checkFeederSumEdit_tmp" id="checkFeederSumEdit_tmp" value="'.number_format($resultSum,3).'">
                </div>
                ';
            }
            return $output;
            //Query Data From msd_template_feeder
        }
    }
    private function getBomTemplate_tmp($templatename , $dataareaid , $itemid , $bomid)
    {
        if($templatename != "" && $dataareaid != "" && $itemid != "" && $bomid !=""){
            // Query data from msd_template_bom
            $sql_bom = $this->db->query("SELECT
            msd_template_bom_temp.b_autoid,
            msd_template_bom_temp.b_templatename,
            msd_template_bom_temp.b_dataareaid,
            msd_template_bom_temp.b_linenum,
            msd_template_bom_temp.b_rawmaterial,
            msd_template_bom_temp.b_bomqty,
            msd_template_bom_temp.b_bomqtyuse,
            msd_template_bom_temp.b_bomqtyusemix,
            msd_template_bom_temp.b_bombalance,
            msd_template_bom_temp.b_bomtype,
            msd_template_bom_temp.b_bomstatus,
            msd_template_bom_temp.b_bomid,
            msd_template_bom_temp.b_itemid
            FROM
            msd_template_bom_temp
            WHERE b_templatename = '$templatename' And b_dataareaid = '$dataareaid' AND b_bomstatus != 'inactive' AND b_bomid = '$bomid' AND b_itemid = '$itemid'
            ");

            $output_bom ='';

            if($sql_bom->num_rows() != 0){
                $output_bom = '<div class="list-group">';
                foreach($sql_bom->result() as $rs){
    
                    $templatename = $rs->b_templatename;
                    $itemid = $rs->b_itemid;
                    $dataareaid = $rs->b_dataareaid;
                    $rawmaterial = $rs->b_rawmaterial;
                    $b_autoid = $rs->b_autoid;
                    $bomforuse = $rs->b_bombalance;
    
                    $textColor ="";
                    if($bomforuse == 0){
                        $textColor = 'style="color:#CC0000"';
                    }else{
                        $textColor ='';
                    }
    
                    // Check ว่ามีการจองเพื่อ Mix หรือยัง
                        if($rs->b_bomstatus == "wait confirm"){
                            $mixStatus = '<span class="badge badge-warning badge-pill ml-3 p-2 bomsum">Wait Mix !</span>';
                            $modalId = "";
                        }else{
                            $mixStatus = "";
                            $modalId = "#md_bom";
                        }
                    // Check ว่ามีการจองเพื่อ Mix หรือยัง
    
                    //////////////////////////////////
                    ///// Check Dept permission
                    /////////////////////////////////
                    if(getUser()->DeptCode == "1007" || getUser()->DeptCode == "1002"){
                        $output_bom .='
                            <a href="javascript:void(0)" class="list-group-item list-group-item-action md_bom_template"
                            data_templatename="'.$rs->b_templatename.'"
                            data_dataareaid="'.$rs->b_dataareaid.'"
                            data_rawmaterial="'.$rs->b_rawmaterial.'"
                            data_bomqty="'.$rs->b_bomqty.'"
                            data_bomqtyuse="'.$rs->b_bomqtyuse.'"
                            data_bomsum="'.$bomforuse.'"
                            data_bombalance="'.$rs->b_bombalance.'"
                            data_bomautoid="'.$rs->b_autoid.'"
                            data_bomstatus="'.$rs->b_bomstatus.'"
                            data_itemid="'.$rs->b_itemid.'"
                            data_bomid="'.$rs->b_bomid.'"
                            data_bomtype="'.$rs->b_bomtype.'"
    
                            >'.$rs->b_rawmaterial.'<span class="badge badge-success badge-pill ml-3 p-2 bomtotal">'.$rs->b_bomqty.'</span>
                            <span class="badge badge-warning badge-pill ml-3 p-2 bomsum" '.$textColor.'>'.number_format($bomforuse,3).'</span>
                            '.$mixStatus.'
                            </a>
                            ';
                    }else{
                            $output_bom .='
                            <a href="javascript:void(0)" class="list-group-item list-group-item-action">'.$rs->b_rawmaterial.'<span class="badge badge-success badge-pill ml-3 p-2 bomtotal">'.$rs->b_bomqty.'</span>
                            <span class="badge badge-warning badge-pill ml-3 p-2 bomsum" '.$textColor.'>'.number_format($bomforuse,3).'</span>
                            '.$mixStatus.'
                            </a>
                            ';
                    }
                    //////////////////////////////////
                    ///// Check Dept permission
                    /////////////////////////////////
    
    
                }
                $output_bom .='</div>';
            }else{
                $output_bom .='รายการถูก Mix ทั้งหมด';
            }



            return $output_bom;
        }
    }

    public function deleteRawmaterialOnFeederAndBom()
    {
        if($this->input->post("feederAutoid") != "" && $this->input->post("bomAutoid") != "" && $this->input->post("bomValue") != ""){
            $faf_autoid = $this->input->post("feederAutoid");
            $faf_b_autoid = $this->input->post("bomAutoid");
            $faf_value = $this->input->post("bomValue");
            $templateName = $this->input->post("templateName");
            $itemId = $this->input->post("itemId");
            $areaId = $this->input->post("areaId");
            $bomId = $this->input->post("bomId");

            // set null feeder
            $arUPdateFeeder = array(
                "faf_b_autoid" => null,
                "faf_rawmaterial" => null,
                "faf_value" => 0,
                "faf_bomid" => null
            );
            $this->db->where("faf_autoid" , $faf_autoid);
            $this->db->update("msd_template_feeder_temp" , $arUPdateFeeder);

            // Query data for cal
            $sqlBomForCalc = $this->db->query("SELECT 
            b_bomqty , 
            b_bomqtyuse , 
            b_bombalance 
            FROM msd_template_bom_temp
            WHERE b_autoid = '$faf_b_autoid'
            ");
            $bomqtyuse = 0;
            $bombalance = 0;
            if($sqlBomForCalc->num_rows() != 0){
                $bomqtyuse = floatval($sqlBomForCalc->row()->b_bomqtyuse)-floatval($faf_value);
                $bombalance = floatval($sqlBomForCalc->row()->b_bombalance)+floatval($faf_value);


            }
            // Update Bom Table
            $arUpdateBom = array(
                "b_bomqtyuse" => $bomqtyuse,
                "b_bombalance" => $bombalance
            );
            $this->db->where("b_autoid" , $faf_b_autoid);
            $this->db->update("msd_template_bom_temp" , $arUpdateBom);


            // Getdata Feeder tmp
            $dataFeederTmp = $this->getFeederTemplate_tmp($templateName , $areaId , $itemId);
            // Getdata Bom tmp
            $dataBomTmp = $this->getBomTemplate_tmp($templateName , $areaId , $itemId , $bomId);

            $output_json = array(
                "msg" => "อัพเดตข้อมูลสำเร็จ",
                "status" => "Update Data Success",
                "dataFeederTmp" => $dataFeederTmp,
                "dataBomTmp" => $dataBomTmp
            );
        }else{
            $output_json = array(
                "msg" => "อัพเดตข้อมูลไม่สำเร็จ",
                "status" => "Update Data Not Success",
            );
        }

        echo json_encode($output_json);
    }

    public function getBomForMix_template()
    {
        if($this->input->post("templatename") != "" && $this->input->post("itemid") != "" && $this->input->post("dataareaid") != ""){
            $templatename = $this->input->post("templatename");
            $itemid = $this->input->post("itemid");
            $dataareaid = $this->input->post("dataareaid");

            $sqlgetbom = $this->db->query("SELECT
            b_templatename,
            b_dataareaid,
            b_itemid,
            b_bomid,
            b_autoid,
            b_linenum,
            b_rawmaterial,
            b_bombalance,
            b_bomstatus,
            b_bomqtyuse,
            b_bomqty
            FROM msd_template_bom_temp
            WHERE b_templatename = '$templatename' AND b_itemid = '$itemid' AND b_dataareaid = '$dataareaid' AND b_bomtype != 'Mix' AND b_bombalance != 0
            ORDER BY b_linenum ASC
            ");

            $output ='<div class="list-group">';
            foreach($sqlgetbom->result() as $rs){

                if($rs->b_bomstatus == "wait confirm"){
                    $bominactive = '<span class="badge badge-warning badge-pill ml-3 p-2 bomtotal">รอยืนยันการ Mix</span>';
                }else{
                    $bominactive = '';
                }

                //ดึงข้อมูล Bom qty มาคำนวณ

                if($rs->b_bomqtyuse == 0){
                    $bomqty = $rs->b_bomqty;
                }else{
                    $bomqty = $rs->b_bombalance;
                }


                $output .='
                <a href="javascript:void(0)" class="list-group-item list-group-item-action mix_bom_tmp"
                    data_rawmaterial ="'.$rs->b_rawmaterial.'"
                    data_bomqty ="'.$rs->b_bomqty.'"
                    data_bomqtyuse="'.$rs->b_bomqtyuse.'"
                    data_bombalance="'.$rs->b_bombalance.'"
                    data_b_autoid="'.$rs->b_autoid.'"
                    data_bomstatus="'.$rs->b_bomstatus.'"
                    data_templatename="'.$rs->b_templatename.'"
                    data_itemid="'.$rs->b_itemid.'"
                    data_bomid="'.$rs->b_bomid.'"
                    data_areaid="'.$rs->b_dataareaid.'"
                >'.$rs->b_rawmaterial.'<span class="badge badge-success badge-pill ml-3 p-2 bomtotal">'.$rs->b_bombalance.'</span>'.$bominactive.'
                </a>
                ';
            }
            $output .='</div>';

            $output_json = array(
                "msg" => "ดึงข้อมูล Bom สำหรับ Mix สำเร็จ",
                "status" => "Select Data Success",
                "bomMixResult" => $output 
            );
        }else{
            $output_json = array(
                "msg" => "ดึงข้อมูล Bom สำหรับ Mix ไม่สำเร็จ",
                "status" => "Select Data Not Success",
            );
        }

        echo json_encode($output_json);
    }

    public function activeMix_tmp()
    {
  
        if ($this->input->post("b_autoid")) {
            $b_autoid = $this->input->post("b_autoid");
            $calBomqtyUseMix = $this->input->post("calBomqtyUseMix");


            // Check b_bomstatus
            $sql = $this->db->query("SELECT b_bomstatus FROM msd_template_bom_temp WHERE b_autoid = '$b_autoid' ");
            if ($sql->row()->b_bomstatus == "active") {
                $bomstatusText = "wait confirm";
            } else {
                $bomstatusText = "active";
            }

            $arActiveMix = array(
                "b_bomstatus" => $bomstatusText,
                "b_bomqtyusemix" => $calBomqtyUseMix
            );
            $this->db->where("b_autoid",  $b_autoid);
            if ($this->db->update("msd_template_bom_temp", $arActiveMix)) {
                $output = array(
                    "msg" => "อัพเดต สำเร็จ Status ปัจจุบันคือ $bomstatusText",
                    "status" => "Update Data Success",
                    "bomstatus" => $bomstatusText,
                    "bomusemix" => $calBomqtyUseMix
                );
            } else {
                $output = array(
                    "msg" => "อัพเดต ไม่สำเร็จ",
                    "status" => "Update status not success"
                );
            }
            echo json_encode($output);
        }
    }

    public function waitConfirmMix_template()
    {
        if($this->input->post("templatename") != "" && $this->input->post("itemid") != "" && $this->input->post("bomid") != "" && $this->input->post("dataareaid") != ""){

            $templatename = $this->input->post("templatename");
            $itemid = $this->input->post("itemid");
            $bomid = $this->input->post("bomid");
            $dataareaid = $this->input->post("dataareaid");

            $sql = $this->db->query("SELECT
            b_rawmaterial
            FROM
            msd_template_bom_temp
            WHERE b_templatename = '$templatename' AND b_itemid = '$itemid' AND b_bomid = '$bomid' AND b_dataareaid = '$dataareaid' AND b_bomstatus = 'wait confirm'
            ");
            $output ='';
            foreach($sql->result() as $rs){
                if($output == ''){
                    $output .= $rs->b_rawmaterial;
                }else{
                    $output .= " + ".$rs->b_rawmaterial;
                }
            }
            echo $output;
        }
    }

    public function countConfirmMix_template()
    {
        if($this->input->post("templatename") != "" && $this->input->post("itemid") != "" && $this->input->post("bomid") != "" && $this->input->post("dataareaid") != ""){

            $templatename = $this->input->post("templatename");
            $itemid = $this->input->post("itemid");
            $bomid = $this->input->post("bomid");
            $dataareaid = $this->input->post("dataareaid");

            $sql = $this->db->query("SELECT
            sum(b_bombalance)as bomsum
            FROM
            msd_template_bom_temp
            WHERE b_templatename = '$templatename' AND b_itemid = '$itemid' AND b_bomid = '$bomid' AND b_dataareaid = '$dataareaid' AND b_bomstatus = 'wait confirm'
            ");
            
            echo $sql->row()->bomsum;
        }
    }


    public function saveDataMix_template()
    {
        if ($this->input->post("templatename") != "" && $this->input->post("itemid") != "" && $this->input->post("bomid") != "" && $this->input->post("dataareaid") != "") {

            $templatename = $this->input->post("templatename");
            $itemid = $this->input->post("itemid");
            $bomid = $this->input->post("bomid");
            $dataareaid = $this->input->post("dataareaid");
            $rawmaterialmix = $this->input->post("rawmaterialmix");
            $rawmaterialmixValue = $this->input->post("rawmaterialmixValue");

            // check bom use
            $sqlCheckBom = $this->db->query("SELECT 
            b_autoid , 
            b_bomqty , 
            b_bomqtyuse 
            FROM msd_template_bom_temp 
            WHERE b_templatename = '$templatename' AND b_itemid = '$itemid' AND b_bomid = '$bomid' AND b_dataareaid = '$dataareaid' AND b_bomstatus = 'wait confirm' 
            ");

            foreach ($sqlCheckBom->result() as $brs) {
                if($brs->b_bomqtyuse != 0){
                    $bomstatus = "split mix";
                }else{
                    $bomstatus = "inactive";
                }
                $arupdateUserBom = array(
                    "b_bombalance" => 0,
                    "b_bomstatus" => $bomstatus
                );
                $this->db->where("b_autoid", $brs->b_autoid);
                $this->db->update("msd_template_bom_temp", $arupdateUserBom);
            }

            $saveMixArray = array(
                "b_templatename" => $templatename,
                "b_dataareaid" => $dataareaid,
                "b_itemid" => $itemid,
                "b_bomid" => $bomid,
                "b_rawmaterial" => $rawmaterialmix,
                "b_bomqty" => $rawmaterialmixValue,
                "b_bombalance" => $rawmaterialmixValue,
                "b_bomtype" => "Mix",
                "b_ecode" => getUser()->ecode
            );
            $this->db->insert("msd_template_bom_temp", $saveMixArray);
            $output = array(
                "msg" => "บันทึกข้อมูลสำเร็จ",
                "status" => "Insert Data Success"
            );
        } else {
            $output = array(
                "msg" => "บันทึกข้อมูลไม่สำเร็จ",
                "status" => "Insert Data Not Success"
            );
        }
        echo json_encode($output);
    }


    public function getBomMixed()
    {
        if($this->input->post("templatename") != "" && $this->input->post("itemid") != "" && $this->input->post("bomid") != "" && $this->input->post("dataareaid") != ""){

            $templatename = $this->input->post("templatename");
            $itemid = $this->input->post("itemid");
            $bomid = $this->input->post("bomid");
            $dataareaid = $this->input->post("dataareaid");

            $sql = $this->db->query("SELECT
            b_autoid,
            b_rawmaterial,
            b_bombalance,
            b_bomqty
            FROM
            msd_template_bom_temp    
            WHERE b_templatename = '$templatename' AND b_itemid = '$itemid' AND b_bomid = '$bomid' AND b_dataareaid = '$dataareaid' AND b_bomtype = 'mix'
            ");
        
            $countData = $sql->num_rows();
            if($countData == 0){
                $notify = "ยังไม่มีข้อมูลการ Mix";
            }else{
                $notify = "";
            }
        
            $output = '<div class="list-group">';
            foreach($sql->result() as $rs){
        
        
                // $mainformno = $rs->b_mainformno;
                // $prodid = $rs->b_prodid;
                // $rawmaterial = $rs->b_rawmaterial;
                // $b_autoid = $rs->b_autoid;
                // $bomforuse = $rs->b_bomqty - getBomInFeeder($mainformno , $prodid , $rawmaterial , $b_autoid);
                $bomforuse = $rs->b_bombalance;
                $textColor ="";
                if($bomforuse == 0){
                    $textColor = 'style="color:#CC0000"';
                }else{
                    $textColor ='';
                }
        
        
                if(getUser()->DeptCode == "1007" || getUser()->DeptCode == "1002"){
                    $output .='
                    <a href="javascript:void(0)" class="list-group-item list-group-item-action bommixed"
                    >'.$rs->b_rawmaterial.'
                    <span class="badge badge-success badge-pill ml-3 p-2">'.$rs->b_bomqty.'</span>
                    <input hidden type="text" name="cBomMix_total" id="cBomMix_total" value="'.$rs->b_bomqty.'">
                    <span class="badge badge-warning badge-pill ml-3 p-2 bomsum" '.$textColor.'>'.number_format($bomforuse,3).'</span>
                    <input hidden type="text" name="cBomMixUse" id="cBomMixUse" value="'.number_format($bomforuse,3).'">
                    </a>
                    ';
                }else{
                    $output .='
                    <a href="javascript:void(0)" class="list-group-item list-group-item-action">'.$rs->b_rawmaterial.'
                    <span class="badge badge-success badge-pill ml-3 p-2">'.$rs->b_bomqty.'</span>
                    <input hidden type="text" name="cBomMix_total" id="cBomMix_total" value="'.$rs->b_bomqty.'">
                    <span class="badge badge-warning badge-pill ml-3 p-2 bomsum" '.$textColor.'>'.number_format($bomforuse,3).'</span>
                    <input hidden type="text" name="cBomMixUse" id="cBomMixUse" value="'.number_format($bomforuse,3).'">
                    </a>
                    ';
                }
        
                
            }
            $output .='</div>';
            echo $output.$notify;
        }
    }


    public function getBomMixed2()
    {
        if($this->input->post("templatename") != "" && $this->input->post("itemid") != "" && $this->input->post("bomid") != "" && $this->input->post("dataareaid") != ""){
            
            $templatename = $this->input->post("templatename");
            $itemid = $this->input->post("itemid");
            $bomid = $this->input->post("bomid");
            $dataareaid = $this->input->post("dataareaid");

            $sql = $this->db->query("SELECT
            b_autoid,
            b_rawmaterial,
            b_bombalance,
            b_bomqty,
            b_bomqtyuse,
            b_bomqtyusemix,
            b_bomtype,
            b_bomstatus
            FROM
            msd_template_bom_temp    
            WHERE b_templatename = '$templatename' AND b_itemid = '$itemid' AND b_bomid = '$bomid' AND b_dataareaid = '$dataareaid' AND b_bomtype = 'mix'
            ");
        
            $countData = $sql->num_rows();
            if($countData == 0){
                $notify = "ยังไม่มีข้อมูลการ Mix";
            }else{
                $notify = "";
            }
        
            $output = '<div class="list-group">';
            foreach($sql->result() as $rs){
        
        
                // $mainformno = $rs->b_mainformno;
                // $prodid = $rs->b_prodid;
                // $rawmaterial = $rs->b_rawmaterial;
                // $b_autoid = $rs->b_autoid;
                // $bomforuse = $rs->b_bomqty - getBomInFeeder($mainformno , $prodid , $rawmaterial , $b_autoid);
                $bomforuse = $rs->b_bombalance;
                $textColor ="";
                if($bomforuse == 0){
                    $textColor = 'style="color:#CC0000"';
                }else{
                    $textColor ='';
                }
        
        
                if(getUser()->DeptCode == "1007" || getUser()->DeptCode == "1002"){
                    $output .='
                    <a href="javascript:void(0)" class="list-group-item list-group-item-action bommixed_tmp"
                        data_templatename="'.$templatename.'"
                        data_areaid="'.$dataareaid.'"
                        data_itemid="'.$itemid.'"
                        data_bomid="'.$bomid.'"
                        data_rawmaterial="'.$rs->b_rawmaterial.'"
                        data_bomqty="'.$rs->b_bomqty.'"
                        data_bomqtyusemix="'.$rs->b_bomqtyusemix.'"
                        data_bomtype="'.$rs->b_bomtype.'"
                        data_bombalance="'.$rs->b_bombalance.'"
                        data_b_autoid="'.$rs->b_autoid.'"
                        data_bomqtyuse="'.$rs->b_bomqtyuse.'"
                        data_bomstatus="'.$rs->b_bomstatus.'"
                    >'.$rs->b_rawmaterial.'
                    <span class="badge badge-success badge-pill ml-3 p-2">'.$rs->b_bomqty.'</span>
                    <input hidden type="text" name="cBomMix_total" id="cBomMix_total" value="'.$rs->b_bomqty.'">
                    <span class="badge badge-warning badge-pill ml-3 p-2 bomsum" '.$textColor.'>'.number_format($bomforuse,3).'</span>
                    <input hidden type="text" name="cBomMixUse" id="cBomMixUse" value="'.number_format($bomforuse,3).'">
                    </a>
                    ';
                }else{
                    $output .='
                    <a href="javascript:void(0)" class="list-group-item list-group-item-action">'.$rs->b_rawmaterial.'
                    <span class="badge badge-success badge-pill ml-3 p-2">'.$rs->b_bomqty.'</span>
                    <input hidden type="text" name="cBomMix_total" id="cBomMix_total" value="'.$rs->b_bomqty.'">
                    <span class="badge badge-warning badge-pill ml-3 p-2 bomsum" '.$textColor.'>'.number_format($bomforuse,3).'</span>
                    <input hidden type="text" name="cBomMixUse" id="cBomMixUse" value="'.number_format($bomforuse,3).'">
                    </a>
                    ';
                }
        
                
            }
            $output .='</div>';
            // echo $output.$notify;

            $bomresult = $this->getBomTemplate_tmp($templatename , $dataareaid , $itemid , $bomid);

            $output_json = array(
                "msg" => "ดึงข้อมูล Bom ที่ทำการ Mix สำเร็จ",
                "status" => "Select Data Success",
                "bomMixed2" => $output.$notify,
                "bomOriginal" => $bomresult,
                "bomMix2Status" => $notify
            );
        }else{
            $output_json = array(
                "msg" => "ดึงข้อมูล Bom ที่ทำการ Mix สำเร็จ",
                "status" => "Select Data Not Success",
                "bomMixed2" => $output.$notify,
                "bomOriginal" => $bomresult
            );
        }

        echo json_encode($output_json);
    }



    public function canCelMix_template()
    {

        if ($this->input->post("templatename") != "" && $this->input->post("itemid") != "" && $this->input->post("bomid") != "" && $this->input->post("dataareaid") != ""){

            $templatename = $this->input->post("templatename");
            $itemid = $this->input->post("itemid");
            $bomid = $this->input->post("bomid");
            $dataareaid = $this->input->post("dataareaid");

            // Check Bom mixed input to feeder ?
            $sqlcheck = $this->db->query("SELECT 
            b_bomqtyuse , 
            b_autoid 
            FROM msd_template_bom_temp 
            WHERE b_templatename = '$templatename' AND b_itemid = '$itemid' AND b_bomid = '$bomid' AND b_dataareaid = '$dataareaid' AND b_bomtype = 'Mix'
            ");
            $checkresult = [];
            foreach($sqlcheck->result() as $r){
                $checkresult[] = $r->b_bomqtyuse;
            }

            if(array_sum($checkresult) > 0){
                $output = array(
                    "msg" => "ยกเลิกการ Mix ไม่สำเร็จเนื่องจากพบการใส่สูตร Mix ลงไปใน Feeder",
                    "status" => "Found Mix Data In Feeder",
                );
            }else{
                // Quety ลบข้อมูลการ Mix ออกจากฐานข้อมูล
                $this->db->where("b_bomtype", "Mix");
                $this->db->where("b_templatename", $templatename);
                $this->db->where("b_itemid", $itemid);
                $this->db->where("b_bomid", $bomid);
                $this->db->where("b_dataareaid", $dataareaid);
                $this->db->delete("msd_template_bom_temp");
                // Quety ลบข้อมูลการ Mix ออกจากฐานข้อมูล


                $sql = $this->db->query("SELECT 
                b_bomqtyusemix , 
                b_autoid 
                FROM msd_template_bom_temp 
                WHERE b_templatename = '$templatename' AND b_itemid = '$itemid' AND b_bomid = '$bomid' AND b_dataareaid = '$dataareaid' 
                ");

                foreach($sql->result() as $rs){
                    if($rs->b_bomqtyusemix != 0){

                        $arrayUpdate = array(
                            "b_bombalance" => $rs->b_bomqtyusemix,
                            "b_bomqtyusemix" => 0 ,
                            "b_bomstatus" => "active"
                        );

                        $this->db->where("b_autoid", $rs->b_autoid);
                        $this->db->update("msd_template_bom_temp", $arrayUpdate);
                    }
                }

                $dataBomTemp = $this->getBomTemplate_tmp($templatename , $dataareaid , $itemid , $bomid);

                
                $output = array(
                    "msg" => "ยกเลิกการ Mix เรียบร้อยแล้ว",
                    "status" => "Update Data Success",
                    "dataBomTemp" => $dataBomTemp
                );
            }
            
        }else{
            $output = array(
                "msg" => "ยกเลิกการ Mix ไม่สำเร็จ",
                "status" => "Update Data Not Success",
            );
        }

        echo json_encode($output);
        
    }

    public function saveDataTempToTable()
    {
        if($this->input->post("templatename") != "" && $this->input->post("itemid") != "" && $this->input->post("bomid") != "" && $this->input->post("dataareaid")){
            $templatename = $this->input->post("templatename");
            $itemid = $this->input->post("itemid");
            $bomid = $this->input->post("bomid");
            $dataareaid = $this->input->post("dataareaid");

            // Get Bom Data Temp
            // $sqlgetBom = $this->db->query("SELECT *
            // FROM
            // ");
            $ecodeuser = getUser()->ecode;


            $this->db->query("INSERT INTO msd_template_bom SELECT * FROM msd_template_bom_temp 
            WHERE b_templatename = '$templatename' AND b_itemid = '$itemid' AND b_bomid = '$bomid' AND b_dataareaid = '$dataareaid' AND b_ecode = '$ecodeuser' ORDER BY b_autoid ASC");

            $this->db->query("INSERT INTO msd_template_feeder SELECT * FROM msd_template_feeder_temp
            WHERE faf_templatename = '$templatename' AND faf_itemid = '$itemid' AND faf_dataareaid = '$dataareaid' AND faf_ecodepost = '$ecodeuser' ORDER BY faf_autoid ASC
            ");

            $arupdateTemplateDetail = array(
                "ted_template_bomid" => $bomid
            );
            $this->db->where("ted_template_name" , $templatename);
            $this->db->where("ted_template_itemuse" , $itemid);
            $this->db->where("ted_template_dataareaid" , $dataareaid);
            $this->db->update("msd_template_detail" , $arupdateTemplateDetail);

            $this->db->where('b_templatename' , $templatename);
            $this->db->where('b_itemid' , $itemid);
            $this->db->where('b_bomid' , $bomid);
            $this->db->where('b_dataareaid' , $dataareaid);
            $this->db->where('b_ecode' , $ecodeuser);
            $this->db->delete('msd_template_bom_temp');

            $this->db->where('faf_templatename' , $templatename);
            $this->db->where('faf_itemid' , $itemid);
            $this->db->where('faf_dataareaid' , $dataareaid);
            $this->db->where('faf_ecodepost' , $ecodeuser);
            $this->db->delete('msd_template_feeder_temp');

            // History
            $detail = "บันทึกข้อมูล Bom & Feeder Template สำเร็จ";
            $menu = "บันทึก Bom Template";
            $actionType = "create data";
            $ip = $this->input->ip_address();
            saveHistory($templatename , $itemid , $dataareaid , $detail , $menu , $actionType , $ip);

            $output = array(
                "msg" => "บันทึกข้อมูลสำเร็จ",
                "status" => "Insert Data Success"
            );
        }else{
            $output = array(
                "msg" => "บันทึกข้อมูลไม่สำเร็จ",
                "status" => "Insert Data Not Success"
            );
        }
        echo json_encode($output);
    }

    public function saveDataTempToTable_edit()
    {
        if($this->input->post("templatename") != "" && $this->input->post("itemid") != "" && $this->input->post("bomid") != "" && $this->input->post("dataareaid")){

            $templatename = $this->input->post("templatename");
            $itemid = $this->input->post("itemid");
            $bomid = $this->input->post("bomid");
            $dataareaid = $this->input->post("dataareaid");

            // Get Bom Data Temp
            // $sqlgetBom = $this->db->query("SELECT *
            // FROM
            // ");
            $ecodeuser = getUser()->ecode;

            // Delete data frist
            $this->db->where('b_templatename' , $templatename);
            $this->db->where('b_itemid' , $itemid);
            $this->db->where('b_dataareaid' , $dataareaid);
            $this->db->delete('msd_template_bom');

            $this->db->where('faf_templatename' , $templatename);
            $this->db->where('faf_itemid' , $itemid);
            $this->db->where('faf_dataareaid' , $dataareaid);
            $this->db->delete('msd_template_feeder');



            $this->db->query("INSERT INTO msd_template_bom SELECT * FROM msd_template_bom_temp 
            WHERE b_templatename = '$templatename' AND b_itemid = '$itemid' AND b_bomid = '$bomid' AND b_dataareaid = '$dataareaid' AND b_ecode = '$ecodeuser' ORDER BY b_autoid ASC");

            $this->db->query("INSERT INTO msd_template_feeder SELECT * FROM msd_template_feeder_temp
            WHERE faf_templatename = '$templatename' AND faf_itemid = '$itemid' AND faf_dataareaid = '$dataareaid' AND faf_ecodepost = '$ecodeuser' ORDER BY faf_autoid ASC
            ");

            $arupdateTemplateDetail = array(
                "ted_template_bomid" => $bomid
            );
            $this->db->where("ted_template_name" , $templatename);
            $this->db->where("ted_template_itemuse" , $itemid);
            $this->db->where("ted_template_dataareaid" , $dataareaid);
            $this->db->update("msd_template_detail" , $arupdateTemplateDetail);

            $this->db->where('b_templatename' , $templatename);
            $this->db->where('b_itemid' , $itemid);
            $this->db->where('b_bomid' , $bomid);
            $this->db->where('b_dataareaid' , $dataareaid);
            $this->db->where('b_ecode' , $ecodeuser);
            $this->db->delete('msd_template_bom_temp');

            $this->db->where('faf_templatename' , $templatename);
            $this->db->where('faf_itemid' , $itemid);
            $this->db->where('faf_dataareaid' , $dataareaid);
            $this->db->where('faf_ecodepost' , $ecodeuser);
            $this->db->delete('msd_template_feeder_temp');

            // History
            $detail = "บันทึกการแก้ไขข้อมูล Bom & Feeder Template สำเร็จ";
            $menu = "บันทึกการแก้ไข Bom Template";
            $actionType = "edit data";
            $ip = $this->input->ip_address();
            saveHistory($templatename , $itemid , $dataareaid , $detail , $menu , $actionType , $ip);

            $output = array(
                "msg" => "บันทึกข้อมูลสำเร็จ",
                "status" => "Insert Data Success"
            );
        }else{
            $output = array(
                "msg" => "บันทึกข้อมูลไม่สำเร็จ",
                "status" => "Insert Data Not Success"
            );
        }
        echo json_encode($output);
    }

    public function getBomTemplate()
    {
        if($this->input->post("templatename") != "" && $this->input->post("itemid") != "" && $this->input->post("dataareaid") != ""){
            $templatename = $this->input->post("templatename");
            $itemid = $this->input->post("itemid");
            $dataareaid = $this->input->post("dataareaid");

            $ecodeuser = getUser()->ecode;
            //Delete Data On temp table
            // Check frist
            $sqlcheckBomTempByEcode = $this->db->query("SELECT b_ecode FROM msd_template_bom_temp WHERE b_templatename = '$templatename' AND b_itemid = '$itemid' AND b_dataareaid = '$dataareaid' ");
            if($sqlcheckBomTempByEcode->num_rows() != 0){
                $this->db->where('b_templatename' , $templatename);
                $this->db->where('b_itemid' , $itemid);
                $this->db->where('b_dataareaid' , $dataareaid);
                $this->db->delete('msd_template_bom_temp');
            }

            $sqlcheckFeederTempByEcode = $this->db->query("SELECT faf_ecodepost FROM msd_template_feeder_temp WHERE faf_templatename = '$templatename' AND faf_itemid = '$itemid' AND faf_dataareaid = '$dataareaid' ");
            if($sqlcheckFeederTempByEcode->num_rows() != 0){
                $this->db->where('faf_templatename' , $templatename);
                $this->db->where('faf_itemid' , $itemid);
                $this->db->where('faf_dataareaid' , $dataareaid);
                $this->db->delete('msd_template_feeder_temp');
            }



            $queryFeeder = $this->queryFeederTemplate($templatename , $itemid , $dataareaid);
            $queryBom = $this->queryBomTemplate($templatename , $itemid , $dataareaid);
            $queryBomMixed = $this->queryBomMixedTemplate($templatename , $itemid , $dataareaid);

            

            $output = '';
            if($queryFeeder->num_rows() == 0){
                $output .='<h3 class="text-center">พบข้อผิดพลาดเกี่ยวกับ Feeder กรุณาติดต่อไอที</h3>';
            }else{
                $output .='
                <div class="table-responsive">
                    <table id="feederTemplate" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <th style="width:80px;">Feeder</th>
                            <th>Raw Material</th>
                            <th style="width:90px;" class="thInlet">
                                Inlet
                            </th>
                            <th style="width:90px;">%</th>
                        </thead>
                        <tbody>
                ';
                foreach($queryFeeder->result() as $rs){

                    if($rs->faf_inlet == 0){
                        $rs->faf_inlet = "N/A";
                    }

                    $output .='
                    <tr>
                        <td>'.$rs->faf_feedername.'</td>
                        <td>'.$rs->faf_rawmaterial.'</td>
                        <td>'.$rs->faf_inlet.'</td>
                        <td>'.$rs->faf_value.'</td>
                    </tr>
                    ';
                    $arvalue[] = $rs->faf_value;
                }

                $resultSum = array_sum($arvalue);

                if($resultSum != 100){
                    $textColor = 'style="color:#CC0000;"';
                }else{
                    $textColor = 'style="color:#009900;"';
                }

                $output .='
                <tr>
                    <td colspan="2" class="text-right"><b>Total</b></td>
                    <td colspan="3" '.$textColor.'><b>'.number_format($resultSum,3).'</b></td>
                </tr>
                        </tbody>
                    </table>
                </div>
                ';
            }



            //Query Data From msd_template_feeder
            $output_bom = '<label><b>Bom Original</b></label>';
            $output_bom .= '<div class="list-group">';
            foreach($queryBom->result() as $rs){

                $templatename = $rs->b_templatename;
                $itemid = $rs->b_itemid;
                $dataareaid = $rs->b_dataareaid;
                $rawmaterial = $rs->b_rawmaterial;
                $b_autoid = $rs->b_autoid;
                $bomforuse = $rs->b_bombalance;

                $textColor ="";
                if($bomforuse == 0){
                    $textColor = 'style="color:#CC0000"';
                }else{
                    $textColor ='';
                }

                // Check ว่ามีการจองเพื่อ Mix หรือยัง
                    if($rs->b_bomstatus == "wait confirm"){
                        $mixStatus = '<span class="badge badge-warning badge-pill ml-3 p-2 bomsum">Wait Mix !</span>';
                        $modalId = "";
                    }else{
                        $mixStatus = "";
                        $modalId = "#md_bom";
                    }
                // Check ว่ามีการจองเพื่อ Mix หรือยัง

                //////////////////////////////////
                ///// Check Dept permission
                /////////////////////////////////
                if(getUser()->DeptCode == "1007" || getUser()->DeptCode == "1002"){
                    $output_bom .='
                        <a href="javascript:void(0)" class="list-group-item list-group-item-action">'.$rs->b_rawmaterial.'<span class="badge badge-success badge-pill ml-3 p-2 bomtotal">'.$rs->b_bomqty.'</span>
                        <span class="badge badge-warning badge-pill ml-3 p-2 bomsum" '.$textColor.'>'.number_format($bomforuse,3).'</span>
                        '.$mixStatus.'
                        </a>
                        ';
                }else{
                        $output_bom .='
                        <a href="javascript:void(0)" class="list-group-item list-group-item-action">'.$rs->b_rawmaterial.'<span class="badge badge-success badge-pill ml-3 p-2 bomtotal">'.$rs->b_bomqty.'</span>
                        <span class="badge badge-warning badge-pill ml-3 p-2 bomsum" '.$textColor.'>'.number_format($bomforuse,3).'</span>
                        '.$mixStatus.'
                        </a>
                        ';
                }
                //////////////////////////////////
                ///// Check Dept permission
                /////////////////////////////////


            }
            $output_bom .='</div>';



            $countData = $queryBomMixed->num_rows();
            if($countData == 0){
                $notify = "ยังไม่มีข้อมูลการ Mix";
            }else{
                $notify = "";
            }
        
            $output_bomMix = '<label><b>Bom Mixed</b></label>';
            $output_bomMix .= '<div class="list-group">';
            foreach($queryBomMixed->result() as $rs){
        
        
                // $mainformno = $rs->b_mainformno;
                // $prodid = $rs->b_prodid;
                // $rawmaterial = $rs->b_rawmaterial;
                // $b_autoid = $rs->b_autoid;
                // $bomforuse = $rs->b_bomqty - getBomInFeeder($mainformno , $prodid , $rawmaterial , $b_autoid);
                $bomforuse = $rs->b_bombalance;
                $textColor ="";
                if($bomforuse == 0){
                    $textColor = 'style="color:#CC0000"';
                }else{
                    $textColor ='';
                }
        
        
                if(getUser()->DeptCode == "1007" || getUser()->DeptCode == "1002"){
                    $output_bomMix .='
                    <a href="javascript:void(0)" class="list-group-item list-group-item-action">'.$rs->b_rawmaterial.'
                    <span class="badge badge-success badge-pill ml-3 p-2">'.$rs->b_bomqty.'</span>
                    <input hidden type="text" name="cBomMix_total" id="cBomMix_total" value="'.$rs->b_bomqty.'">
                    <span class="badge badge-warning badge-pill ml-3 p-2 bomsum" '.$textColor.'>'.number_format($bomforuse,3).'</span>
                    <input hidden type="text" name="cBomMixUse" id="cBomMixUse" value="'.number_format($bomforuse,3).'">
                    </a>
                    ';
                }else{
                    $output_bomMix .='
                    <a href="javascript:void(0)" class="list-group-item list-group-item-action">'.$rs->b_rawmaterial.'
                    <span class="badge badge-success badge-pill ml-3 p-2">'.$rs->b_bomqty.'</span>
                    <input hidden type="text" name="cBomMix_total" id="cBomMix_total" value="'.$rs->b_bomqty.'">
                    <span class="badge badge-warning badge-pill ml-3 p-2 bomsum" '.$textColor.'>'.number_format($bomforuse,3).'</span>
                    <input hidden type="text" name="cBomMixUse" id="cBomMixUse" value="'.number_format($bomforuse,3).'">
                    </a>
                    ';
                }
        
                
            }
            $output_bomMix .='</div>';

            $output_json = array(
                "msg" => "ดึงข้อมูล Bom Template สำเร็จ",
                "status" => "Select Data Success",
                "resultFeederTemplate" => $output,
                "resultBomTemplate" => $output_bom,
                "resultBomMixedTemplate" => $output_bomMix,
                "checkFeeder" => $queryFeeder->num_rows(),
                "checkBom" => $queryBom->num_rows(),
                "checkBomMixed" => $queryBomMixed->num_rows(),
            );
        }else{
            $output_json = array(
                "msg" => "ดึงข้อมูล Bom Template ไม่สำเร็จ",
                "status" => "Select Data Not Success",
            );
        }

        echo json_encode($output_json);
    }
    private function queryFeederTemplate($templatename , $itemid , $dataareaid)
    {
        if($templatename != "" && $itemid != "" && $dataareaid != ""){
            $sqlFeeder = $this->db->query("SELECT
            faf_autoid,
            faf_bomid,
            faf_b_autoid,
            faf_templatename,
            faf_dataareaid,
            faf_itemid,
            faf_feedername,
            faf_rawmaterial,
            faf_value,
            faf_inlet
            FROM msd_template_feeder
            WHERE faf_templatename = '$templatename' AND faf_itemid = '$itemid' AND faf_dataareaid = '$dataareaid' ORDER BY faf_autoid ASC
            ");

            return $sqlFeeder;
        }
    }
    private function queryBomTemplate($templatename , $itemid , $dataareaid)
    {
        if($templatename != "" && $itemid != "" && $dataareaid != ""){
            $sqlBom = $this->db->query("SELECT
            b_autoid,
            b_templatename,
            b_dataareaid,
            b_itemid,
            b_bomid,
            b_linenum,
            b_rawmaterial,
            b_bomqty,
            b_bomqtyuse,
            b_bomqtyusemix,
            b_bombalance,
            b_bomtype,
            b_bomstatus
            FROM msd_template_bom
            WHERE b_templatename = '$templatename' AND b_itemid = '$itemid' AND b_dataareaid = '$dataareaid' AND b_bomstatus != 'inactive' ORDER BY b_autoid ASC
            ");
            return $sqlBom;
        }
    }
    private function queryBomMixedTemplate($templatename , $itemid , $dataareaid)
    {
        if($templatename != "" && $itemid != "" && $dataareaid != ""){
            $sqlBomMixed = $this->db->query("SELECT
            b_autoid,
            b_templatename,
            b_dataareaid,
            b_itemid,
            b_bomid,
            b_linenum,
            b_rawmaterial,
            b_bomqty,
            b_bomqtyuse,
            b_bomqtyusemix,
            b_bombalance,
            b_bomtype,
            b_bomstatus
            FROM msd_template_bom
            WHERE b_templatename = '$templatename' AND b_itemid = '$itemid' AND b_dataareaid = '$dataareaid' AND b_bomtype = 'Mix' ORDER BY b_autoid ASC
            ");
            return $sqlBomMixed;
        }
    }



    public function getBomTemplateView()
    {
        if($this->input->post("templatename") != "" && $this->input->post("itemid") != "" && $this->input->post("dataareaid") != ""){
            $templatename = $this->input->post("templatename");
            $itemid = $this->input->post("itemid");
            $dataareaid = $this->input->post("dataareaid");
            $mainformno = $this->input->post("mainformno");

            $ecodeuser = getUser()->ecode;
            $sumfeedervalue = 0;
            //Delete Data On temp table
            // Check frist
            $sqlcheckBomTempByEcode = $this->db->query("SELECT b_ecode FROM msd_template_bom_temp WHERE b_ecode = '$ecodeuser' ");
            if($sqlcheckBomTempByEcode->num_rows() != 0){
                $this->db->where('b_ecode' , $ecodeuser);
                $this->db->delete('msd_template_bom_temp');
            }

            $sqlcheckFeederTempByEcode = $this->db->query("SELECT faf_ecodepost FROM msd_template_feeder_temp WHERE faf_ecodepost = '$ecodeuser' ");
            if($sqlcheckFeederTempByEcode->num_rows() != 0){
                $this->db->where('faf_ecodepost' , $ecodeuser);
                $this->db->delete('msd_template_feeder_temp');
            }



            $queryFeeder = $this->queryFeederTemplateView($templatename , $itemid , $dataareaid , $mainformno);
            $queryBom = $this->queryBomTemplateView($templatename , $itemid , $dataareaid , $mainformno);
            $queryBomMixed = $this->queryBomMixedTemplateView($templatename , $itemid , $dataareaid , $mainformno);

            

            $output = '';
            if($queryFeeder->num_rows() == 0){
                $output .='<h3 class="text-center">ไม่พบข้อมูลเนื่องจากรายการนี้ชุดข้อมูลเก่า</h3>';
            }else{
                $output .='
                <div class="table-responsive">
                    <table id="feederTemplate" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <th style="width:80px;">Feeder</th>
                            <th>Raw Material</th>
                            <th style="width:90px;" class="thInlet">
                                Inlet
                            </th>
                            <th style="width:90px;">%</th>
                        </thead>
                        <tbody>
                ';
                foreach($queryFeeder->result() as $rs){
                    // $getInlet = $this->db->query("SELECT
                    // msd_inlet.inlet_feeder_id,
                    // msd_inlet.inlet_value,
                    // farrel_feeder.faf_feedername
                    // FROM
                    // msd_inlet
                    // INNER JOIN farrel_feeder ON farrel_feeder.faf_autoid = msd_inlet.inlet_feeder_id
                    // where msd_inlet.inlet_mainformno = '$mainformno' AND faf_feedername = '$rs->faf_feedername' ");
                    if($rs->faf_inlet == "0" || $rs->faf_inlet === null){
                        $rs->faf_inlet = "N/A";
                    }
                    $output .='
                    <tr>
                        <td>'.$rs->faf_feedername.'</td>
                        <td>'.$rs->faf_rawmaterial.'</td>
                        <td>'.$rs->faf_inlet.'</td>
                        <td>'.$rs->faf_value.'</td>
                    </tr>
                    ';
                    $arvalue[] = $rs->faf_value;
                }

                $resultSum = array_sum($arvalue);

                if($resultSum != 100){
                    $textColor = 'style="color:#CC0000;"';
                }else{
                    $textColor = 'style="color:#009900;"';
                }

                $output .='
                <tr>
                    <td colspan="2" class="text-right"><b>Total</b></td>
                    <td colspan="3" '.$textColor.'><b>'.number_format($resultSum,3).'</b></td>
                </tr>
                        </tbody>
                    </table>
                    <input hidden type="text" name="checkFeederSum_tmp" id="checkFeederSum_tmp" value="'.number_format($resultSum,3).'">
                </div>
                ';

                $sumfeedervalue = $resultSum;
            }



            //Query Data From msd_template_feeder
            $output_bom = '<label><b>Bom Original</b></label>';
            $output_bom .= '<div class="list-group">';
            foreach($queryBom->result() as $rs){

                $templatename = $rs->b_templatename;
                $itemid = $rs->b_itemid;
                $dataareaid = $rs->b_dataareaid;
                $rawmaterial = $rs->b_rawmaterial;
                $b_autoid = $rs->b_autoid;
                $bomforuse = $rs->b_bombalance;

                $textColor ="";
                if($bomforuse == 0){
                    $textColor = 'style="color:#CC0000"';
                }else{
                    $textColor ='';
                }

                // Check ว่ามีการจองเพื่อ Mix หรือยัง
                    if($rs->b_bomstatus == "wait confirm"){
                        $mixStatus = '<span class="badge badge-warning badge-pill ml-3 p-2 bomsum">Wait Mix !</span>';
                        $modalId = "";
                    }else{
                        $mixStatus = "";
                        $modalId = "#md_bom";
                    }
                // Check ว่ามีการจองเพื่อ Mix หรือยัง

                //////////////////////////////////
                ///// Check Dept permission
                /////////////////////////////////
                if(getUser()->DeptCode == "1007" || getUser()->DeptCode == "1002"){
                    $output_bom .='
                        <a href="javascript:void(0)" class="list-group-item list-group-item-action">'.$rs->b_rawmaterial.'<span class="badge badge-success badge-pill ml-3 p-2 bomtotal">'.$rs->b_bomqty.'</span>
                        <span class="badge badge-warning badge-pill ml-3 p-2 bomsum" '.$textColor.'>'.number_format($bomforuse,3).'</span>
                        '.$mixStatus.'
                        </a>
                        ';
                }else{
                        $output_bom .='
                        <a href="javascript:void(0)" class="list-group-item list-group-item-action">'.$rs->b_rawmaterial.'<span class="badge badge-success badge-pill ml-3 p-2 bomtotal">'.$rs->b_bomqty.'</span>
                        <span class="badge badge-warning badge-pill ml-3 p-2 bomsum" '.$textColor.'>'.number_format($bomforuse,3).'</span>
                        '.$mixStatus.'
                        </a>
                        ';
                }
                //////////////////////////////////
                ///// Check Dept permission
                /////////////////////////////////


            }
            $output_bom .='</div>';



            $countData = $queryBomMixed->num_rows();
            if($countData == 0){
                $notify = "ยังไม่มีข้อมูลการ Mix";
            }else{
                $notify = "";
            }
        
            $output_bomMix = '<label><b>Bom Mixed</b></label>';
            $output_bomMix .= '<div class="list-group">';
            foreach($queryBomMixed->result() as $rs){
        
        
                // $mainformno = $rs->b_mainformno;
                // $prodid = $rs->b_prodid;
                // $rawmaterial = $rs->b_rawmaterial;
                // $b_autoid = $rs->b_autoid;
                // $bomforuse = $rs->b_bomqty - getBomInFeeder($mainformno , $prodid , $rawmaterial , $b_autoid);
                $bomforuse = $rs->b_bombalance;
                $textColor ="";
                if($bomforuse == 0){
                    $textColor = 'style="color:#CC0000"';
                }else{
                    $textColor ='';
                }
        
        
                if(getUser()->DeptCode == "1007" || getUser()->DeptCode == "1002"){
                    $output_bomMix .='
                    <a href="javascript:void(0)" class="list-group-item list-group-item-action">'.$rs->b_rawmaterial.'
                    <span class="badge badge-success badge-pill ml-3 p-2">'.$rs->b_bomqty.'</span>
                    <input hidden type="text" name="cBomMix_total" id="cBomMix_total" value="'.$rs->b_bomqty.'">
                    <span class="badge badge-warning badge-pill ml-3 p-2 bomsum" '.$textColor.'>'.number_format($bomforuse,3).'</span>
                    <input hidden type="text" name="cBomMixUse" id="cBomMixUse" value="'.number_format($bomforuse,3).'">
                    </a>
                    ';
                }else{
                    $output_bomMix .='
                    <a href="javascript:void(0)" class="list-group-item list-group-item-action">'.$rs->b_rawmaterial.'
                    <span class="badge badge-success badge-pill ml-3 p-2">'.$rs->b_bomqty.'</span>
                    <input hidden type="text" name="cBomMix_total" id="cBomMix_total" value="'.$rs->b_bomqty.'">
                    <span class="badge badge-warning badge-pill ml-3 p-2 bomsum" '.$textColor.'>'.number_format($bomforuse,3).'</span>
                    <input hidden type="text" name="cBomMixUse" id="cBomMixUse" value="'.number_format($bomforuse,3).'">
                    </a>
                    ';
                }
        
                
            }
            $output_bomMix .='</div>';

            $output_json = array(
                "msg" => "ดึงข้อมูล Bom Template สำเร็จ",
                "status" => "Select Data Success",
                "resultFeederTemplate" => $output,
                "resultBomTemplate" => $output_bom,
                "resultBomMixedTemplate" => $output_bomMix,
                "checkFeeder" => $queryFeeder->num_rows(),
                "checkBom" => $queryBom->num_rows(),
                "checkBomMixed" => $queryBomMixed->num_rows(),
                "feederTemplateSumValue" => $sumfeedervalue
            );
        }else{
            $output_json = array(
                "msg" => "ดึงข้อมูล Bom Template ไม่สำเร็จ",
                "status" => "Select Data Not Success",
            );
        }

        echo json_encode($output_json);
    }
    private function queryFeederTemplateView($templatename , $itemid , $dataareaid , $mainformno)
    {
        if($templatename != "" && $itemid != "" && $dataareaid != ""){
            $sqlFeeder = $this->db->query("SELECT
            faf_autoid,
            faf_bomid,
            faf_b_autoid,
            faf_templatename,
            faf_dataareaid,
            faf_itemid,
            faf_feedername,
            faf_rawmaterial,
            faf_value,
            faf_inlet
            FROM msd_template_feeder_trans
            WHERE faf_templatename = '$templatename' AND faf_itemid = '$itemid' AND faf_dataareaid = '$dataareaid' AND faf_formno = '$mainformno' ORDER BY faf_autoid ASC
            ");

            return $sqlFeeder;
        }
    }
    private function queryBomTemplateView($templatename , $itemid , $dataareaid , $mainformno)
    {
        if($templatename != "" && $itemid != "" && $dataareaid != ""){
            $sqlBom = $this->db->query("SELECT
            b_autoid,
            b_templatename,
            b_dataareaid,
            b_itemid,
            b_bomid,
            b_linenum,
            b_rawmaterial,
            b_bomqty,
            b_bomqtyuse,
            b_bomqtyusemix,
            b_bombalance,
            b_bomtype,
            b_bomstatus
            FROM msd_template_bom_trans
            WHERE b_templatename = '$templatename' AND b_itemid = '$itemid' AND b_dataareaid = '$dataareaid' AND b_formno = '$mainformno' AND b_bomstatus != 'inactive' ORDER BY b_autoid ASC
            ");
            return $sqlBom;
        }
    }
    private function queryBomMixedTemplateView($templatename , $itemid , $dataareaid , $mainformno)
    {
        if($templatename != "" && $itemid != "" && $dataareaid != ""){
            $sqlBomMixed = $this->db->query("SELECT
            b_autoid,
            b_templatename,
            b_dataareaid,
            b_itemid,
            b_bomid,
            b_linenum,
            b_rawmaterial,
            b_bomqty,
            b_bomqtyuse,
            b_bomqtyusemix,
            b_bombalance,
            b_bomtype,
            b_bomstatus
            FROM msd_template_bom_trans
            WHERE b_templatename = '$templatename' AND b_itemid = '$itemid' AND b_dataareaid = '$dataareaid' AND b_formno = '$mainformno' AND b_bomtype = 'Mix' ORDER BY b_autoid ASC
            ");
            return $sqlBomMixed;
        }
    }


    public function getBomTemplateForEdit(){
        if($this->input->post("templatename") != "" && $this->input->post("itemid") != "" && $this->input->post("dataareaid") != ""){

            $templatename = $this->input->post("templatename");
            $itemid = $this->input->post("itemid");
            $dataareaid = $this->input->post("dataareaid");
            $bomid = $this->input->post("bomid");

            $queryBomversionEdit = $this->queryBomversionEdit($itemid , $dataareaid);

            $editFeederTemplate = $this->editFeederTemplate($templatename , $itemid , $bomid , $dataareaid);
            $editBomTemplate = $this->editBomTemplate($templatename , $itemid , $bomid , $dataareaid);

            $output_json = array(
                "msg" => "ดึงข้อมูลสำหรับแก้ไข Feeder Template สำเร็จ",
                "status" => "Select Data Success",
                "rsBomVersion" => $queryBomversionEdit,
                "rsFeeder" => $editFeederTemplate,
                "rsBom" => $editBomTemplate
            );

        }else{
            $output_json = array(
                "msg" => "ดึงข้อมูลสำหรับแก้ไข Feeder Template ไม่สำเร็จ",
                "status" => "Select Data Not Success",
            );
        }
        echo json_encode($output_json);
    }
    private function queryBomversionEdit($itemid , $dataareaid)
    {
        $sqlgetbomversion = $this->db4->query("SELECT 
        a.itemid as bv_itemid, 
        a.bomid as bv_bomid, 
        a.active , 
        a.dataareaid ,
        a.inventdimid ,
        b.configid as bv_configid
        from bomversion a
        inner join (select * from inventdim)b on b.inventdimid = a.inventdimid
        where a.itemid = '$itemid' and active = 1 and a.dataareaid = '$dataareaid'
        group by
        a.itemid , 
        a.bomid , 
        a.active , 
        a.dataareaid ,
        a.inventdimid ,
        b.configid");

        $output = '';
        if($sqlgetbomversion->num_rows() != 0){
            $output = '<option value="">กรุณาเลือก Bom Version</option>';
            foreach($sqlgetbomversion->result() as $rs){
                $output .='<option value="'.$rs->bv_bomid.'">Item ID : '.$rs->bv_itemid.'&nbsp&nbspConfig ID : '.$rs->bv_configid.'</option>';
            }
        }

        return $output;

    }
    private function editFeederTemplate($templatename , $itemid , $bomid , $dataareaid)
    {
        if($templatename != "" && $itemid != "" && $bomid != "" && $dataareaid != ""){
            $this->db->where('faf_templatename' , $templatename);
            $this->db->where('faf_itemid' , $itemid);
            $this->db->where('faf_dataareaid' , $dataareaid);
            $this->db->delete('msd_template_feeder_temp');

            // $this->db->query("INSERT INTO msd_template_feeder_temp SELECT * FROM msd_template_feeder
            // WHERE faf_templatename = '$templatename' AND faf_itemid = '$itemid' AND faf_dataareaid = '$dataareaid' ORDER BY faf_autoid ASC
            // ");

            $sqlFeeder = $this->db->query("SELECT
            msd_template_feeder.faf_autoid,
            msd_template_feeder.faf_bomid,
            msd_template_feeder.faf_b_autoid,
            msd_template_feeder.faf_templatename,
            msd_template_feeder.faf_dataareaid,
            msd_template_feeder.faf_itemid,
            msd_template_feeder.faf_feedername,
            msd_template_feeder.faf_rawmaterial,
            msd_template_feeder.faf_value,
            msd_template_feeder.faf_inlet
            FROM
            msd_template_feeder
            WHERE faf_templatename = '$templatename' AND faf_itemid = '$itemid' AND faf_dataareaid = '$dataareaid' ORDER BY faf_autoid ASC
            ");

            foreach($sqlFeeder->result() as $rs){
                $arInsertTemp = array(
                    "faf_autoid" => $rs->faf_autoid,
                    "faf_bomid" => $rs->faf_bomid,
                    "faf_b_autoid" => $rs->faf_b_autoid,
                    "faf_templatename" => $rs->faf_templatename,
                    "faf_dataareaid" => $rs->faf_dataareaid,
                    "faf_itemid" => $rs->faf_itemid,
                    "faf_feedername" => $rs->faf_feedername,
                    "faf_rawmaterial" => $rs->faf_rawmaterial,
                    "faf_value" => $rs->faf_value,
                    "faf_inlet" => $rs->faf_inlet,
                    "faf_userpost" => getUser()->Fname." ".getUser()->Lname,
                    "faf_ecodepost" => getUser()->ecode,
                    "faf_deptcodepost" => getUser()->DeptCode,
                    "faf_datetime" => date("Y-m-d H:i:s")
                );
                $this->db->insert("msd_template_feeder_temp" , $arInsertTemp);
            }

            $resultFeederTemp_edit = $this->getFeederTemplate_tmp($templatename , $dataareaid , $itemid);
            return $resultFeederTemp_edit;
        }
    }
    private function editBomTemplate($templatename , $itemid , $bomid , $dataareaid){
        if($templatename != "" && $itemid != "" && $bomid != "" && $dataareaid != ""){
            $this->db->where('b_templatename' , $templatename);
            $this->db->where('b_itemid' , $itemid);
            $this->db->where('b_dataareaid' , $dataareaid);
            $this->db->where('b_bomid' , $bomid);
            $this->db->delete('msd_template_bom_temp');

            // $this->db->query("INSERT INTO msd_template_bom_temp SELECT * FROM msd_template_bom
            // WHERE b_templatename = '$templatename' AND b_itemid = '$itemid' AND b_bomid = '$bomid' AND b_dataareaid = '$dataareaid' ORDER BY b_autoid ASC");

            $sqlgetBom = $this->db->query("SELECT
            msd_template_bom.b_autoid,
            msd_template_bom.b_templatename,
            msd_template_bom.b_dataareaid,
            msd_template_bom.b_itemid,
            msd_template_bom.b_bomid,
            msd_template_bom.b_linenum,
            msd_template_bom.b_rawmaterial,
            msd_template_bom.b_bomqty,
            msd_template_bom.b_bomqtyuse,
            msd_template_bom.b_bomqtyusemix,
            msd_template_bom.b_bombalance,
            msd_template_bom.b_bomtype,
            msd_template_bom.b_bomstatus,
            msd_template_bom.b_ecode
            FROM
            msd_template_bom
            WHERE b_templatename = '$templatename' AND b_itemid = '$itemid' AND b_bomid = '$bomid' AND b_dataareaid = '$dataareaid' ORDER BY b_autoid ASC
            ");

            foreach($sqlgetBom->result() as $rs){
                $arInsertTemp = array(
                    "b_autoid" => $rs->b_autoid,
                    "b_templatename" => $rs->b_templatename,
                    "b_dataareaid" => $rs->b_dataareaid,
                    "b_itemid" => $rs->b_itemid,
                    "b_bomid" => $rs->b_bomid,
                    "b_linenum" => $rs->b_linenum,
                    "b_rawmaterial" => $rs->b_rawmaterial,
                    "b_bomqty" => $rs->b_bomqty,
                    "b_bomqtyuse" => $rs->b_bomqtyuse,
                    "b_bomqtyusemix" => $rs->b_bomqtyusemix,
                    "b_bombalance" => $rs->b_bombalance,
                    "b_bomtype" => $rs->b_bomtype,
                    "b_bomstatus" => $rs->b_bomstatus,
                    "b_ecode" => getUser()->ecode
                );
                $this->db->insert("msd_template_bom_temp" , $arInsertTemp);
            }

            $resultBomTemp_edit = $this->getBomTemplate_tmp($templatename , $dataareaid , $itemid , $bomid);
            return $resultBomTemp_edit;
        }
    }


    public function checkUseTemplate()
    {
        if($this->input->post("templatename") != "" && $this->input->post("itemid") != ""){
            $templatename = $this->input->post("templatename");
            $itemid = $this->input->post("itemid");
            $dataareaid = $this->input->post("dataareaid");

            $sqlBom = $this->db->query("SELECT * FROM msd_template_bom_temp
            WHERE b_templatename = '$templatename' AND b_itemid = '$itemid'
            ");

            $sqlFeeder = $this->db->query("SELECT * FROM msd_template_feeder_temp
            WHERE faf_templatename = '$templatename' AND faf_itemid = '$itemid'
            ");

            if($sqlBom->num_rows() != 0 && $sqlFeeder->num_rows() != 0){
                if($sqlBom->row()->b_ecode != getUser()->ecode){
                    $output = array(
                        "msg" => "Template นี้ถูกใช้งานค้างอยู่โดยคุณ ".$sqlFeeder->row()->faf_userpost,
                        "status" => "Found User Use This Template",
                        "userUse" => $sqlFeeder->row()->faf_userpost
                    );
                }else{
                    $output = array(
                        "msg" => "คุณสามารถเข้าใช้งาน Template นี้ได้",
                        "status" => "You Can Use This Template",
                    );
                }
            }else{
                $output = array(
                    "msg" => "คุณสามารถเข้าใช้งาน Template นี้ได้",
                    "status" => "You Can Use This Template",
                );
            }
        }else{
            $output = array(
                "msg" => "ไม่พบข้อมูลที่คุณต้องการ",
                "status" => "Error"
            );
        }

        echo json_encode($output);
    }


    public function getInlet_template()
    {
        if($this->input->post("templatename") && $this->input->post("itemid") != "" && $this->input->post("dataareaid") != ""){

            $templatename = $this->input->post("templatename");
            $itemid = $this->input->post("itemid");
            $dataareaid = $this->input->post("dataareaid");

            $sql = $this->db->query("SELECT
            faf_feedername,
            faf_autoid,
            faf_inlet
            FROM
            msd_template_feeder_temp
            WHERE faf_templatename = '$templatename' AND faf_itemid = '$itemid' AND faf_dataareaid = '$dataareaid' ORDER BY faf_autoid ASC
            ");
            if($sql->num_rows() != 0){
                $output = array(
                    "msg" => "ดึงข้อมูล Inlet เรียบร้อยแล้ว",
                    "status" => "Select Data Success",
                    "inletData" => $sql->result(),
                    "inletType" => "Update"
                );
            }else{

                $output = array(
                    "msg" => "ดึงข้อมูล Inlet ไม่สำเร็จ",
                    "status" => "Select Data Not Success",
                );
            }

            echo json_encode($output);
        }
    }

    public function saveInlet_template()
    {
        if($this->input->post("ip-inletValue") != ""){
            $feederid = $this->input->post("ip-inletFeederID");
            $templatename = $this->input->post("templatename_inlet");
            $itemid = $this->input->post("itemid_inlet");
            $dataareaid = $this->input->post("dataareaid_inlet");

            foreach($feederid as $key => $value){
                $arupdateData = array(
                    "faf_inlet" => $this->input->post("ip-inletValue")[$key]
                );
                $this->db->where("faf_autoid" , $value);
                $this->db->update("msd_template_feeder_temp" , $arupdateData);
            }

            // Getdata Feeder tmp
            $dataFeederTmp = $this->getFeederTemplate_tmp($templatename , $dataareaid , $itemid);

            $output = array(
                "msg" => "อัพเดตข้อมูล Inlet สำเร็จ",
                "status" => "Update Data Success",
                "dataFeederTmp" => $dataFeederTmp
            );
        }else{
            $output = array(
                "msg" => "อัพเดตข้อมูล Inlet ไม่สำเร็จ",
                "status" => "Update Data Not Success"
            );
        }

        echo json_encode($output);
    }











    /* End of file ModelName.php */
}

/* End of file ModelName.php */
