<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Graph_model extends CI_Model {
    
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        date_default_timezone_set("Asia/Bangkok");
        $this->db3 = $this->load->database("prodplan", true);
    }


    public function loadGraphByItemLot()
    {
        // $this->loadLinenum("QRC6400646");
        if($this->input->post("checkQcID") != ""){
            $checkQcID = $this->input->post("checkQcID");
            $mainformno = $this->input->post("mainformno");

            $this->loaddataBylot($checkQcID , $mainformno);
        }
        
    }

    private function loaddataBylot($qcid , $mainformno)
    {
        $qcnumTotal = $this->loadQCSampleNum($qcid)->num_rows();
        $testIdArray = $this->loadTestID($qcid , $mainformno);

        if($testIdArray != ""){
            for($i = 1; $i <= $qcnumTotal;$i++){
                $numCount[]=$i;
            }
    
            // Loop 1
                foreach($testIdArray as $testIdArrays){
    
                    $sql = $this->db3->query("SELECT
                        a.SLC_QCSampleId,
                        a.QCSampleNum,
                        b.TestResultValueReal,
                        b.TestUnitID,
                        b.LowerLimit,
                        b.UpperLimit,
                        b.TestResultValueOutcome,
                        b.TestOutcomeStatus
                    FROM
                    slc_qcsampleline a
                    LEFT JOIN (SELECT QCSampleNum , 
                                TestResultValueReal,
                                TestUnitID,
                                LowerLimit,
                                UpperLimit,
                                TestResultValueOutcome,
                                TestOutcomeStatus
                                FROM slc_qcsampleline 
                                WHERE SLC_QCSampleId = '$qcid' AND 
                                TestId = '$testIdArrays'
                                ) b ON a.QCSampleNum = b.QCSampleNum
                    WHERE
                    a.SLC_QCSampleId = '$qcid'
                    GROUP BY a.QCSampleNum
                    ORDER BY a.QCSampleNum ASC");
    
                    
                        foreach($sql->result() as $rs){
    
                            if($rs->TestResultValueReal == 0){
                                $valueReal[] = '';
                                
                            }else{
                                $valueReal[] = (float)$rs->TestResultValueReal;
                                
                            }
    
                            if($rs->TestResultValueOutcome != ""){
                                if($rs->TestOutcomeStatus == "Pass"){
                                    $valueOutcome[] = 1;
                                }else if($rs->TestOutcomeStatus == "Fail"){
                                    $valueOutcome[] = 0;
                                }
                            }else{
                                $valueOutcome[] = "";
                            }
    
                           
    
                            $testid = $testIdArrays;
                            
                            $linenumQc[] = (int)$rs->QCSampleNum;
                            $unitId = $rs->TestUnitID;
                            $lowerlimit = $rs->LowerLimit;
                            $upperlimit = $rs->UpperLimit;
        
                        }
                    
    
                    $output = array(
                        "testid" => $testid,
                        "value" => $valueReal,
                        "valueOutcome" => $valueOutcome,
                        "sumOutcome" => array_sum($valueOutcome),
                        "line" => $linenumQc,
                        "unitid" => $unitId,
                        "lowerlimit" => $lowerlimit,
                        "upperlimit" => $upperlimit
                    );
        
                    $resultOutput[] = $output;
                    $valueReal = [];
                    $linenumQc = [];
                    $valueOutcome = [];
                }
                // Loop 1
    
            $output = array(
                "totalQcline" => $numCount,
                // "resultArray" => $pushNum,
                "checkData" => $resultOutput,
                "status" => "Select Data Success"
            );
    
            echo json_encode($output);
        }else{
            $output = array(
                "status" => "Fail"
            );
    
            echo json_encode($output);
        }


       
    }

    private function loadTestID($qcid , $mainformno)
    {
        $sql = $this->db3->query("SELECT
        slc_qcsampleline.SLC_QCSampleId,
        slc_qcsampleline.TestSequence,
        slc_qcsampleline.TestId,
        slc_qcsampleline.QCSampleNum,
        slc_qcsampleline.dataAreaId
        FROM
        slc_qcsampleline
        WHERE SLC_QCSampleId = '$qcid'
        Group by TestId");

        if($sql->num_rows() != 0){
            foreach($sql->result() as $rs){
                $testid[] = $rs->TestId;
            }
    
            // Check data Test ID
            $checkDataTestID = $this->db->query("SELECT fam_graph_testid FROM farrel_main WHERE fam_formno = '$mainformno' ");
            if($checkDataTestID->row()->fam_graph_testid == null){
                $saveTestId = array(
                    "fam_graph_testid" => json_encode($testid),
                    "fam_graph_testiduse" => json_encode($testid),
                );
                $this->db->where("fam_formno" , $mainformno);
                $this->db->update("farrel_main" , $saveTestId);
            }
            // Check data Test ID
    
    
            // Get data Test ID FROM farrel_main
            $sqlGet_testid = $this->db->query("SELECT fam_graph_testiduse FROM farrel_main WHERE fam_formno = '$mainformno' ");
            if($sqlGet_testid->row()->fam_graph_testiduse != ""){
                $testidFromDb = $sqlGet_testid->row()->fam_graph_testiduse;
                return json_decode($testidFromDb);
            }else{
                return false;
            }
            // Get data Test ID FROM farrel_main
        }


    }



    private function loadQCSampleNum($qcid)
    {
        $sql = $this->db3->query("SELECT QCSampleNum FROM slc_qcsampleline WHERE SLC_QCSampleId = '$qcid' group by QCSampleNum order by QCSampleNum asc");
        return $sql;
    }


    public function loadCheckGraph()
    {
        if($this->input->post("mainformno") != ""){
            $mainformno = $this->input->post("mainformno");
            $sql = $this->db->query("SELECT fam_graph_testid , fam_graph_testiduse  FROM farrel_main WHERE fam_formno = '$mainformno'");
            
            if($sql->row()->fam_graph_testid != ""){
                $dataArrayMain = json_decode($sql->row()->fam_graph_testid);
                $dataArrayUse = json_decode($sql->row()->fam_graph_testiduse);
                $output = '';
                foreach($dataArrayMain as $rs){
                    $checked = "";
                    
                    if($dataArrayUse != ""){
                        foreach($dataArrayUse as $rsuse){
                            if ($rs == $rsuse) {
                                $checked = ' checked="" ';
                                continue;
                            }
                        }
                    }
                    
                    $output .='
                    <div class="col-md-4 col-lg-3 col-sm-6">
                            <input class="form-check-input testid_check" type="checkbox" value="'.$rs.'" id="testid_checkbox" name="testid_checkbox[]" '.$checked.'
                                data_testid="'.$rs.'"
                                data_mainformno="'.$mainformno.'"
                            >
                            <label class="form-check-label" for="testid_checkbox">
                                '.$rs.'
                            </label>
                    </div>
                    ';
                }

                echo $output;
            }
            
        }
    }






    public function updateTestIDUse()
    {
        if($this->input->post("testIDShowArray")){
            $data_mainformno = $this->input->post("data_mainformno");
            $testIDShowArray = $this->input->post("testIDShowArray");

            $arupdate = array(
                "fam_graph_testiduse" => json_encode($testIDShowArray)
            );
            $this->db->where("fam_formno" , $data_mainformno);
            $this->db->update("farrel_main" , $arupdate);

            $output = array(
                "msg" => "อัพเดต เสร็ตเรียบร้อยแล้ว",
                "status" => "Update Success"
            );

            echo json_encode($output);
        }else{
            $data_mainformno = $this->input->post("data_mainformno");
            $arupdate = array(
                "fam_graph_testiduse" => ""
            );
            $this->db->where("fam_formno" , $data_mainformno);
            $this->db->update("farrel_main" , $arupdate);

            $output = array(
                "msg" => "Fail",
                "status" => "Fail"
            );

            echo json_encode($output);
        }
    }



    public function loadItemid()
    {
        if($this->input->post("itemid") != ""){
            $itemid = $this->input->post("itemid");

            $sql = $this->db3->query("SELECT
            slc_qcsampletable.ItemId
            FROM
            slc_qcsampletable
            WHERE Itemid LIKE '%$itemid%'
            GROUP BY ItemId
            ORDER BY ItemId ASC;");

            $output = '<ul class="list-group searchItemid_ul">';
            foreach($sql->result() as $rs){
                $output .='
                <a href="javascript:void(0)" id="searchItemid_a" class="searchItemid_a"
                    data_itemid = "'.$rs->ItemId.'"
                ><li class="list-group-item mb-1 searchItemid_li">
                <span>' . $rs->ItemId . '</span><br>
                </li></a>
                ';
            }
            $output .='</ul>';

            echo $output;
        }
    }

    public function loadItemid_run()
    {
        if($this->input->post("itemid") != ""){
            $itemid = $this->input->post("itemid");

            $sql = $this->db->query("SELECT fam_productcode FROM farrel_main 
            WHERE fam_productcode LIKE '%$itemid%' 
            GROUP BY fam_productcode 
            ORDER BY fam_productcode ASC");

            $output = array(
                "msg" => "ดึงข้อมูล Itemid สำเร็จ",
                "status" => "Select Data Success",
                "result" => $sql->result()
            );
        }else{
            $output = array(
                "msg" => "ดึงข้อมูล Itemid ไม่สำเร็จ",
                "status" => "Select Data Not Success",
            );
        }
        echo json_encode($output);
    }




    public function loadItemLot()
    {
        if($this->input->post("itemid") != ""){
            $itemid = $this->input->post("itemid");
            $sql = $this->db3->query("SELECT
            slc_qcsampletable.InventBatchId,
            slc_qcsampletable.ItemId,
            slc_qcsampletable.QCSampleId
            FROM
            slc_qcsampletable
            WHERE
            slc_qcsampletable.ItemId = '$itemid'
            GROUP BY
            slc_qcsampletable.InventBatchId,
            slc_qcsampletable.QCSampleId
            ORDER BY
            RecId DESC");

            $output = '<ul class="list-group showLotNumber_ul">';
            $i =0;
            foreach($sql->result() as $rs){
                $output .='
                <a href="javascript:void(0)" class="showLotNumber_a">
                
                <li class="list-group-item mb-1 showLotNumber_li">
                <input type="checkbox" id="checkbox_lotNumber" name="checkbox_lotNumber[]" class="showLotNumber_checkbox"
                    data_QCSampleId="'.$rs->QCSampleId.'"
                    data_InventBatchId="'.$rs->InventBatchId.'"
                    data_ItemId="'.$rs->ItemId.'"
                    data_index="'.$i.'"
                >
                <span>' . $rs->InventBatchId . '</span><br>
                </li></a>
                ';

                $i++;
            }
            $output .='</ul>';

            echo $output;
        }
    }


    public function loadItemLot_runscreen()
    {
        if($this->input->post("itemid") != ""){
            $itemid = $this->input->post("itemid");
            $sql = $this->db->query("SELECT 
            fam_batchnumber , fam_formno , fam_machine , fam_machinename FROM farrel_main 
            WHERE fam_productcode LIKE '%$itemid%' GROUP BY fam_batchnumber ORDER BY fam_batchnumber DESC");

            $output = array(
                "msg" => "ดึงข้อมูล Batchnumber สำเร็จ",
                "status" => "Select Data Success",
                "result" => $sql->result()
            );
        }else{
            $output = array(
                "msg" => "ดึงข้อมูล Batchnumber ไม่สำเร็จ",
                "status" => "Select Data Not Success",
            );
        }
        echo json_encode($output);
    }


    public function loadGraphDataByCheckLot()
    {

        if($this->input->post("qcid") != ""){
            $qcIdGroup = [];
            $inventBatchIdGroup = [];
            $qcSampleNumGroup = [];
            $testidGroup = [];

            $qcid = $this->input->post("qcid");
            $inventBatchId = $this->input->post("inventBatchId");
            $data_itemid = $this->input->post("data_itemid");

            foreach($qcid as $key => $qcids){

                $qclinenum = $this->loadQCSampleNum($qcids);

                foreach($qclinenum->result() as $rs){
                    $QCSampleNum[] = valueFormat($rs->QCSampleNum)." ".$inventBatchId[$key];
                }

                $inventBatchIdGroup[] = $inventBatchId[$key];
                $qcIdGroup[] =  $qcids;
                $qcSampleNumGroup = $QCSampleNum;

                // $QCSampleNum = [];
            }

            $testidGroup = $this->loadTestIdArray($qcIdGroup);


            $ecodepost = getUser()->ecode;
            // check data on database
            $sql_checkdata = $this->db->query("SELECT
            msd_graphpage.gpm_autoid,
            msd_graphpage.gpm_lotnumber
            FROM
            msd_graphpage
            WHERE gpm_ecodepost = '$ecodepost'
            ");
            if($sql_checkdata->num_rows() == 0){
                // Insert data
                $arInsertdata = array(
                    "gpm_lotnumber" => json_encode($inventBatchIdGroup),
                    "gpm_qcid" => json_encode($qcIdGroup),
                    "gpm_qcSampleNum" => json_encode($qcSampleNumGroup),
                    "gpm_testid" => json_encode($testidGroup),
                    "gpm_testid_use" => json_encode($testidGroup),
                    "gpm_itemid" => $data_itemid,
                    "gpm_userpost" => getUser()->Fname." ".getUser()->Lname,
                    "gpm_ecodepost" => getUser()->ecode,
                    "gpm_datetime" => date("Y-m-d H:i:s")
                );
                $this->db->insert("msd_graphpage" , $arInsertdata);
            }else{
                // Update data
                $gpm_autoid = $sql_checkdata->row()->gpm_autoid;
                $arInsertdata = array(
                    "gpm_lotnumber" => json_encode($inventBatchIdGroup),
                    "gpm_qcid" => json_encode($qcIdGroup),
                    "gpm_qcSampleNum" => json_encode($qcSampleNumGroup),
                    "gpm_testid" => json_encode($testidGroup),
                    "gpm_testid_use" => json_encode($testidGroup),
                    "gpm_itemid" => $data_itemid,
                    "gpm_userpost" => getUser()->Fname." ".getUser()->Lname,
                    "gpm_ecodepost" => getUser()->ecode,
                    "gpm_datetime" => date("Y-m-d H:i:s")
                );
                $this->db->where("gpm_autoid" , $gpm_autoid);
                $this->db->update("msd_graphpage" , $arInsertdata);
            }
            

            

            $outputQcSampleNum = array(
                "qcid" => $qcIdGroup,
                "inventBatchId" => $inventBatchIdGroup,
                "qcSampleNum" => $qcSampleNumGroup,
                "testId" => $testidGroup,
                "status" => "Update data Success"
            );

            echo json_encode($outputQcSampleNum);

        }
    }


    private function loadTestIdArray($qcid)
    {
        $conQcid = '';
        for($i=0;$i<count($qcid);$i++){

            if($i== count($qcid)-1){
                $comma = "";
            }else{
                $comma = ",";
            }
            $conQcid .='"'.$qcid[$i].'"'.$comma.'';
        }

        $sql = $this->db3->query("SELECT
                slc_qcsampleline.TestId 
            FROM
                slc_qcsampleline 
            WHERE
                SLC_QCSampleId IN ($conQcid) 
            GROUP BY
                TestId 
            ORDER BY
                TestId ASC");

        foreach($sql->result() as $rs){
            $testid[] = $rs->TestId;
        }

        return $testid;
    }



    public function loadTestid_checkLot()
    {
        if($this->input->post("qcidArray") != ""){
            $qcidArray = $this->input->post("qcidArray");
            echo json_encode($qcidArray);
        }
    }



    public function loadCheckGraphByCheckLotNum()
    {
            $ecodepost = getUser()->ecode;
            $sql = $this->db->query("SELECT 
            gpm_testid,
            gpm_testid_use  
            FROM msd_graphpage
            WHERE gpm_ecodepost = '$ecodepost'
            ");
            
            if($sql->num_rows() != 0){
                if($sql->row()->gpm_testid != ""){
                    $gpm_testid = json_decode($sql->row()->gpm_testid);
                    $gpm_testid_use = json_decode($sql->row()->gpm_testid_use);
    
                    $output = '';
                    foreach($gpm_testid as $rs){
                        $checked = "";
                        if($gpm_testid_use != ""){
                            foreach($gpm_testid_use as $rsuse){
                                if ($rs == $rsuse) {
                                    $checked = ' checked="" ';
                                    continue;
                                }
                            }
                        }
                        
                        $output .='
                        <div class="col-md-4 col-lg-3 col-sm-6">
                                <input class="form-check-input testidCheckLot_check" type="checkbox" value="'.$rs.'" id="testid_checkbox" name="testid_checkbox[]" '.$checked.'
                                    data_testid="'.$rs.'"
                                >
                                <label class="form-check-label" for="testid_checkbox">
                                    '.$rs.'
                                </label>
                        </div>
                        ';
                    }
    
                    echo $output;
                }
            }else{
                $output = '';
                echo $output;
            }

    }



    public function checkDataGraph()
    {
        $ecodepost = getUser()->ecode;
        $sql = $this->db->query("SELECT gpm_lotnumber , gpm_testid_use FROM msd_graphpage WHERE gpm_ecodepost = '$ecodepost' ");
        if($sql->num_rows() != 0){
            
            if($sql->row()->gpm_testid_use != ""){
                $output = array(
                    "msg" => "ตรวจพบข้อมูล Graph",
                    "status" => "Found data on Database"
                );
            }else{
                $output = array(
                    "msg" => "ตรวจไม่พบข้อมูล Graph",
                    "status" => "Not Found data on Database"
                );
            }
        }else{
            $output = array(
                "msg" => "ตรวจไม่พบข้อมูล Graph",
                "status" => "Not Found data on Database"
            );
        }

        echo json_encode($output);
    }


    public function loadAlldataForUseGraph()
    {
        // Load data from data base for use graph
        $ecodepost = getUser()->ecode;
        $sql = $this->db->query("SELECT
        msd_graphpage.gpm_autoid,
        msd_graphpage.gpm_itemid,
        msd_graphpage.gpm_lotnumber,
        msd_graphpage.gpm_qcid,
        msd_graphpage.gpm_testid,
        msd_graphpage.gpm_testid_use,
        msd_graphpage.gpm_qcSampleNum,
        msd_graphpage.gpm_memo,
        msd_graphpage.gpm_userpost,
        msd_graphpage.gpm_ecodepost,
        msd_graphpage.gpm_datetime
        FROM
        msd_graphpage
        WHERE gpm_ecodepost = '$ecodepost'
        ");

        // Cheak data null
        if($sql->num_rows() != 0){


            
            $testIdArray = $sql->row()->gpm_testid_use;
            $qcSampleNumArray = $sql->row()->gpm_qcSampleNum;
            $itemId = $sql->row()->gpm_itemid;
            $lotNumber = $sql->row()->gpm_lotnumber;

            $conTestidArray = json_decode($testIdArray);
            $conQcidArray = json_decode($sql->row()->gpm_qcid);


            foreach($conQcidArray as $qcid){//Loop 3 รอบ

                foreach($conTestidArray as $testIdArrays){//Loop 10 รอบ

                    $sql2 = $this->db3->query("SELECT
                        a.SLC_QCSampleId,
                        a.QCSampleNum,
                        b.TestResultValueReal,
                        b.TestUnitID,
                        b.LowerLimit,
                        b.UpperLimit,
                        b.TestResultValueOutcome,
                        b.TestOutcomeStatus
                    FROM
                    slc_qcsampleline a
                    LEFT JOIN (SELECT QCSampleNum , 
                                TestResultValueReal,
                                TestUnitID,
                                LowerLimit,
                                UpperLimit,
                                TestResultValueOutcome,
                                TestOutcomeStatus
                                FROM slc_qcsampleline 
                                WHERE SLC_QCSampleId = '$qcid' AND 
                                TestId = '$testIdArrays'
                                ) b ON a.QCSampleNum = b.QCSampleNum
                    WHERE
                    a.SLC_QCSampleId = '$qcid'
                    GROUP BY a.QCSampleNum
                    ORDER BY a.QCSampleNum ASC");

                    foreach($sql2->result() as $rs){//Loop ตาม value

                        if($rs->TestResultValueReal == 0){
                            $valueReal[] = '';
                        }else{
                            $valueReal[] = (float)$rs->TestResultValueReal;
                        }

                        if($rs->TestResultValueOutcome != ""){
                            if($rs->TestOutcomeStatus == "Pass"){
                                $valueOutcome[] = 1;
                            }else if($rs->TestOutcomeStatus == "Fail"){
                                $valueOutcome[] = 0;
                            }
                        }else{
                            $valueOutcome[] = "";
                        }

                        
                        
                        // $linenumQc[] = (int)$rs->QCSampleNum;
                        $unitId = $rs->TestUnitID;
                        $lowerlimit = $rs->LowerLimit;
                        $upperlimit = $rs->UpperLimit;

                    }


            

                    $output = array(
                        "testid" => $testIdArrays,
                        "value" => $valueReal,
                        "valueOutcome" => $valueOutcome,
                        "sumOutcome" => array_sum($valueOutcome),
                        // "line" => $linenumQc,
                        "unitid" => $unitId,
                        "lowerlimit" => $lowerlimit,
                        "upperlimit" => $upperlimit
                    );

                    $resultOutput[] = $output;//เก็บค่า 10 รอบ
                    $valueReal = [];
                    // $linenumQc = [];
                    $valueOutcome = [];
             
           


                }//End TestID Array Loop

                $totalResult[] = $resultOutput;//เก็บค่า 3 รอบ
                $resultOutput = [];
 

            }//End qcID Loop
            




            $output = array(
                "testId" => json_decode($testIdArray),
                "qcSampleNum" => json_decode($qcSampleNumArray),
                "itemId" => $itemId,
                "lotNumber" => json_decode($lotNumber),
                "checkData" => $totalResult
            );

            echo json_encode($output);
        }

    }




    public function updateTestIDUseCheckLot()
    {
        if($this->input->post("testidShowArrayCheckLot")){
            $testidShowArrayCheckLot = $this->input->post("testidShowArrayCheckLot");
            $ecodepost = getUser()->ecode;
            $sql = $this->db->query("SELECT gpm_autoid FROM msd_graphpage WHERE gpm_ecodepost = '$ecodepost' ");
            
            $arupdate = array(
                "gpm_testid_use" => json_encode($testidShowArrayCheckLot)
            );
            $this->db->where("gpm_autoid" , $sql->row()->gpm_autoid);
            $this->db->update("msd_graphpage" , $arupdate);

            $output = array(
                "msg" => "อัพเดต เสร็ตเรียบร้อยแล้ว",
                "status" => "Update Success",
                "data" => $testidShowArrayCheckLot
            );

            echo json_encode($output);
        }else{

            $ecodepost = getUser()->ecode;
            $sql = $this->db->query("SELECT gpm_autoid FROM msd_graphpage WHERE gpm_ecodepost = '$ecodepost' ");
            
            $arupdate = array(
                "gpm_testid_use" => ""
            );
            $this->db->where("gpm_autoid" , $sql->row()->gpm_autoid);
            $this->db->update("msd_graphpage" , $arupdate);

            $output = array(
                "msg" => "Fail",
                "status" => "Fail",
            );

            echo json_encode($output);
        }
    }





    public function loadItemidAndLotNumber()
    {
        $ecodepost = getUser()->ecode;
            $sql = $this->db->query("SELECT 
            gpm_itemid,
            gpm_lotnumber
            FROM msd_graphpage
            WHERE gpm_ecodepost = '$ecodepost'
            ");

        if($sql->num_rows() != 0){
            $output = array(
                "status" => "Select Data Success",
                "itemidHead" => $sql->row()->gpm_itemid,
                "lotnumberHead" => json_decode($sql->row()->gpm_lotnumber),
            );

            
        }else{
            $output = array(
                "status" => "Select Data Not Success"
            );
        }

        echo json_encode($output);
    }


    public function getDataRunscreenForCheckGraph()
    {
        if($this->input->post("itemid") != ""){
            $itemid = $this->input->post("itemid");
            $batchnumberarray = $this->input->post("batchnumberarray");

            $resultMainformno = $this->getMainFormno($itemid , $batchnumberarray);
            $resultRunscreenByMainFormno = $this->getRunscreenByMainformno($resultMainformno);

            $output = array(
                "msg" => "ดึงข้อมูล Runscreen By Mainformno สำเร็จ",
                "status" => "Select Data Success",
                "result" => $resultRunscreenByMainFormno,
                "result_mainformno" => $resultMainformno,
            );

        }else{
            $output = array(
                "msg" => "ดึงข้อมูล Runscreen By Mainformno ไม่สำเร็จ",
                "status" => "Select Data Not Success",
            );
        }
        echo json_encode($output);
    }
    private function getMainFormno($itemid , $batchnumberarray)
    {
        if($itemid != "" && $batchnumberarray != ""){
            // Get data main form no    
            $sql = $this->db->query("SELECT fam_formno FROM farrel_main WHERE fam_productcode LIKE '%$itemid%' AND fam_batchnumber IN ('" . implode("','", $batchnumberarray) . "')");
            $formnoarray = [];
            foreach($sql->result() as $rs){
                array_push($formnoarray , $rs->fam_formno);
            }

            //saveMaimFromno

            return $formnoarray;
        }
    }
    private function getRunscreenByMainformno($mainformno)
    {
        if($mainformno != ""){
            $ecode = getUser()->ecode;
            $sql = $this->db->query("SELECT 
            far_runscreen_name 
            FROM farrel_detail 
            WHERE far_main_formno IN ('" . implode("','", $mainformno) . "') 
            GROUP BY far_runscreen_name");

            $sql2 = $this->db->query("SELECT
            gprun_runscreen_name
            FROM msd_runscreen_graph WHERE gprun_ecode = '$ecode'
            ");

            $runscreenAr = [];
            if($sql2->num_rows() != 0){
                if($sql2->row()->gprun_runscreen_name !== null){
                    $runscreenAr = json_decode($sql2->row()->gprun_runscreen_name);
                }
            }
            
            $html = '';
            $checked = '';
            if($sql->num_rows() != 0){
                foreach($sql->result() as $rs){

                    if($sql2->row()->gprun_runscreen_name !== null){
                        if(in_array($rs->far_runscreen_name , $runscreenAr)){
                            $checked = ' checked';
                        }else{
                            $checked = '';
                        }
                    }

                    $html .='
                    <div class="col-md-4 col-lg-3 col-sm-6">
                        <input '.$checked.' class="form-check-input runscreenCheck" type="checkbox" value="" id="runscreenCheck" name="runscreenCheck[]" data_runscreen="'.$rs->far_runscreen_name.'">
                        <label class="form-check-label" for="runscreenCheck">'.$rs->far_runscreen_name.'</label>
                    </div>
                    ';
                }
            }

            return $html;
        }
    }
    private function getRunscreenFromTableGraph()
    {
        $ecode = getUser()->ecode;
        $sql = $this->db->query("SELECT
        gprun_runscreen_name
        FROM msd_runscreen_graph
        WHERE gprun_ecode = '$ecode'
        ");
        return $sql;
    }


    public function saveFristDataGraphRunscreen()
    {
        if($this->input->post("itemid") != ""){
            $ecode = getUser()->ecode;

            $itemid = $this->input->post("itemid");
            $batchnumberarray = $this->input->post("batchnumberarray");
            $mainformnoarray = $this->input->post("mainformnoarray");

            $sql = $this->db->query("SELECT * FROM msd_runscreen_graph WHERE gprun_ecode = '$ecode'
            ");

            if($sql->num_rows() == 0){
                $arInsert = array(
                    "gprun_itemid" => $itemid,
                    "gprun_batchnumber" => json_encode($batchnumberarray),
                    "gprun_runscreen_name" => null,
                    "gprun_mainformno" => json_encode($mainformnoarray),
                    "gprun_user" => getUser()->Fname." ".getUser()->Lname,
                    "gprun_ecode" => getUser()->ecode,
                    "gprun_datetime_access" => date("Y-m-d H:i:s")
                );
                $this->db->insert("msd_runscreen_graph" , $arInsert);
                $output = array(
                    "msg" => "บันทึกข้อมูลสำเร็จ",
                    "status" => "Select Data Success"
                );
            }else{
                $arupdate = array(
                    "gprun_itemid" => $itemid,
                    "gprun_batchnumber" => json_encode($batchnumberarray),
                    "gprun_mainformno" => json_encode($mainformnoarray),
                    "gprun_runscreen_name" => null,
                    "gprun_datetime_access" => date("Y-m-d H:i:s")
                );
                $this->db->where("gprun_ecode" , $ecode);
                $this->db->update("msd_runscreen_graph" , $arupdate);

                $output = array(
                    "msg" => "อัพเดตข้อมูลสำเร็จ",
                    "status" => "Update Data Success",
                );
            }
        }else{
            $output = array(
                "msg" => "พบข้อผิดพลาด",
                "status" => "Error"
            );
        }

        echo json_encode($output);
    }




    public function updateRunscreenChecked()
    {
        if($this->input->post("runscreenCheckedArray") != ""){
            $runscreenCheckArray = $this->input->post("runscreenCheckedArray");
            $ecode = getUser()->ecode;
            if($runscreenCheckArray == "0"){
                $gprun_runscreen_name = null;
            }else{
                $gprun_runscreen_name = json_encode($runscreenCheckArray);
            }
            $arupdate = array(
                "gprun_runscreen_name" => $gprun_runscreen_name,
                "gprun_datetime_access" => date("Y-m-d H:i:s")
            );
            $this->db->where("gprun_ecode" , $ecode);
            $this->db->update("msd_runscreen_graph" , $arupdate);

            $output = array(
                "msg" => "อัพเดตข้อมูล Runscreen เรียบร้อยแล้ว",
                "status" => "Update Data Success"
            );
        }else{
            $output = array(
                "msg" => "อัพเดตข้อมูล Runscreen ไม่สำเร็จ",
                "status" => "Update Data Not Success",
                "result" => $this->input->post("runscreenCheckedArray")
            );
        }
        echo json_encode($output);
    }


    public function getDataRunscreenGraphFromdatabase()
    {
        $ecode = getUser()->ecode;
        $sql = $this->db->query("SELECT
        gprun_itemid,
        gprun_batchnumber,
        gprun_mainformno,
        gprun_runscreen_name
        FROM msd_runscreen_graph
        WHERE gprun_ecode = '$ecode'
        ");

        if($sql->num_rows() != 0){
            $runscreen = $sql->row()->gprun_runscreen_name;
            $mainformno = $sql->row()->gprun_mainformno;
            $itemid = $sql->row()->gprun_itemid;
            $batchnumber = $sql->row()->gprun_batchnumber;

            $output = array(
                "msg" => "ดึงข้อมูลจาก Database สำเร็จ",
                "status" => "Select Data Success",
                "result_runscreen" => json_decode($runscreen),
                "result_mainformno" => json_decode($mainformno),
                "result_itemid" => $itemid,
                "result_batchnumber" => json_decode($batchnumber),
            );
        }else{
            $output = array(
                "msg" => "ดึงข้อมูลจาก Database ไม่สำเร็จ",
                "status" => "Select Data Not Success",
            );
        }

        echo json_encode($output);

    }


    public function loadAlldataForUseGraphRunscreen()
    {
        $ecode = getUser()->ecode;
        if($ecode != ""){
            $masterData = $this->getMasterDataRunscreenGraph($ecode);

            $runscreenSelect = [];
            $mainformnoSelect = [];
            $itemid = "";
            foreach($masterData->result() as $rs){
                $runscreenSelect = json_decode($rs->gprun_runscreen_name);
                $mainformnoSelect = json_decode($rs->gprun_mainformno);
                $itemid = $rs->gprun_itemid;
            }

            if($runscreenSelect !== null){
                $runscreenResultData = $this->getdataForCreateRunscreenGraph($mainformnoSelect , $runscreenSelect)->result();
            }else{
                $runscreenResultData = 0;
            }
            

            $output = array(
                "msg" => "ดึงข้อมูลสำหรับทำ Graph สำเร็จ",
                "status" => "Select Data Success",
                "result_runscreen" => $runscreenSelect,
                "result_mainformno" => $mainformnoSelect,
                "result_itemid" => $itemid,
                "result_graph" => $runscreenResultData
            );
        }else{
            $output = array(
                "msg" => "ดึงข้อมูลสำหรับทำ Graph สำเร็จ",
                "status" => "Select Data Success",
            );
        }
        echo json_encode($output);
    }
    private function getMasterDataRunscreenGraph($ecode)
    {
        if($ecode != ""){
            $sql = $this->db->query("SELECT
            gprun_itemid,
            gprun_batchnumber,
            gprun_mainformno,
            gprun_runscreen_name
            FROM msd_runscreen_graph
            WHERE gprun_ecode = '$ecode'
            ");

            return $sql;
        }
    }
    private function getdataForCreateRunscreenGraph($mainformno , $runscreenname)
    {
        if($mainformno != "" && $runscreenname != ""){
            $sql = $this->db->query("SELECT
            far_main_formno,
            fam_prodid,
            fam_batchnumber,
            far_worktime,
            far_runscreen_name,
            far_runscreen_value,
            far_runscreen_min,
            far_runscreen_max,
            far_datetime
            FROM farrel_detail 
            INNER JOIN farrel_main ON far_main_formno = fam_formno
            WHERE far_main_formno IN ('" . implode("','", $mainformno) . "') AND far_action != 'spoint' AND far_runscreen_name IN ('" . implode("','", $runscreenname) . "')  ORDER BY far_datetime ASC , far_runscreen_name ASC");
            return $sql;
        }
    }


    

    

}

/* End of file ModelName.php */



?>