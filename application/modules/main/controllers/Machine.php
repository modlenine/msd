<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Machine extends MX_Controller
{


    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Bangkok");
        $this->load->model("main/machine_model" , "machine");
    }


    public function index()
    {
        $data = array(
            "title" => "Setting machine page."
        );

        //Check Permission page
        if(getUser()->ecode == "M1413" || getUser()->ecode == "M2067" || getUser()->ecode == "M0089" || getUser()->ecode == "M1832"){
            getHead();
            getContent("machine/index", $data);
            getFooter();
        }else if(getUser()->DeptCode == "1002"){
            getHead();
            getContent("machine/index", $data);
            getFooter();
        }else{
            getHead();
            getContent("templates/permissionpage", $data);
            getFooter();
        }


    }




////////////////////////////////////////////////////////////
////////////setting.heml
//////////////////////////////////////////////////////////
    public function saveMachineTemplate()
    {
        $this->machine->saveMachineTemplate();
    }

    public function getListMachineTemp()
    {
        $this->machine->getListMachineTemp();
    }

    public function checkDuplicateRunscreen()
    {
        $this->machine->checkDuplicateRunscreen();
    }
    
    public function getRunscreenMaster()
    {
        $this->machine->getRunscreenMaster();
    }

    public function getRunscreenMasterNew()
    {
        $this->machine->getRunscreenMasterNew();
    }

    public function getRunscreenMasterNew2()
    {
        $this->machine->getRunscreenMasterNew2();
    }

    public function getRunscreenMasterNew_arrayNull()
    {
        $action = "";
        $this->machine->getRunscreenMasterNew_arrayNull($action);
    }

    public function getRunscreenMasterNew_search()
    {
        $this->machine->getRunscreenMasterNew_search();
    }

    public function delRunScrFromTempTable()
    {
        $this->machine->delRunScrFromTempTable();
    }

    public function getMachineTemp()
    {
        $this->machine->getMachineTemp();
    }

    public function deleteRunscreenFromTemp()
    {
        $this->machine->deleteRunscreenFromTemp();
    }

    public function runscreenManagement()
    {
        $this->machine->runscreenManagement();
    }

    public function saveRunscreen()
    {
        $this->machine->saveRunscreen();
    }

    public function checkDupRunManage()
    {
        $this->machine->checkDupRunManage();
    }

    public function checkDupEditRunManage()
    {
        $this->machine->checkDupEditRunManage();
    }

    public function editRunscreen()
    {
        $this->machine->editRunscreen();
    }

    public function delRunscreen()
    {
        $this->machine->delRunscreen();
    }

    public function copyTemplate()
    {
        $this->machine->copyTemplate();
    }

    public function saveCopyTemplate()
    {
        $this->machine->saveCopyTemplate();
    }

    public function delTemplate()
    {
        $this->machine->delTemplate();
    }


    public function loadTemplateBox()
    {
        $this->machine->loadTemplateBox();
    }

    /////////////////////////////////////////////////////////
    //////////// template detail page
    public function temDetail()
    {
        $this->machine->temDetail();
    }

    public function saveMinMax()
    {
        $this->machine->saveMinMax();
    }


    public function saveRunScrToTempTable()
    {
        $this->machine->saveRunScrToTempTable();
    }


    public function saveRunScrToTempTable_edit()
    {
        $this->machine->saveRunScrToTempTable_edit();
    }


    public function uploadImageOnly_edit()
    {
        $this->machine->uploadImageOnly_edit();
    }


    public function uploadImageCopyToTemp()
    {
        $this->machine->uploadImageCopyToTemp();
    }


    // public function uploadImageOnly()
    // {
    //     $this->machine->uploadImageOnly();
    // }


    public function loadRunScrFromTempTable()
    {
        $this->machine->loadRunScrFromTempTable();
    }


    public function truncate_machine_template_temp()
    {
        $this->machine->truncate_machine_template_temp();
    }


    public function updateLinenumDown()
    {
        $this->machine->updateLinenumDown();
    }


    public function updateLinenumUp()
    {
        $this->machine->updateLinenumUp();
    }


    public function countTotalRunmaster()
    {
        $this->machine->countTotalRunmaster();
    }


    public function countTotalRunTemp()
    {
        $this->machine->countTotalRunTemp();
    }


    public function save_frm_edit_runscreen_newtemplate()
    {
        $this->machine->save_frm_edit_runscreen_newtemplate();
    }


////////////////////////////////////////////////////////////
////////////setting.heml
//////////////////////////////////////////////////////////




public function testdb()
{
    $arr1 = Array('a', 'e', 'b', 'c', 'd');
    print_r(moveElementInArray($arr1, 1, 0));
}

public function loadLinenumFromTemp()
{
    $this->machine->loadLinenumFromTemp();
}

public function saveDataToMachineTemplate()
{
    $this->machine->saveDataToMachineTemplate();
}

public function saveDataToMachineTemplate_edit()
{
    $this->machine->saveDataToMachineTemplate_edit();
}

public function loadOldTemplate()
{
    $this->machine->loadOldTemplate();
}

public function loadRunscreen()
{
    $this->machine->loadRunscreen();
}


public function copyOriTemplateToTemp()
{
    $this->machine->copyOriTemplateToTemp();
}

public function copyOriTemplateToTemp_edit()
{
    $this->machine->copyOriTemplateToTemp_edit();
}


public function checkTemplateNameDuplicate()
{
    $this->machine->checkTemplateNameDuplicate();
}

public function loadDataTemplate()
{
    $this->machine->loadDataTemplate();
}


public function loadRunscreenFromTemplate()
{
    $this->machine->loadRunscreenFromTemplate();
}


public function deleteTemplate()
{
    $this->machine->deleteTemplate();
}


public function loadItemidFormTable()
{
    $this->machine->loadItemidFormTable();
}


public function loadItemidFormTable_edit()
{
    $this->machine->loadItemidFormTable_edit();
}


public function checkEditTemplateDuplicate()
{
    $this->machine->checkEditTemplateDuplicate();
}


public function save_edittemplate_editrun()
{
    $this->machine->save_edittemplate_editrun();
}

public function countTotalRunMasterShow()
{
    $this->machine->countTotalRunMasterShow();
}


public function overall_template()
{
    $this->machine->overall_template();
}


public function del_dataFromTemptableBy_templatename()
{
    $this->machine->del_dataFromTemptableBy_templatename();
}

public function checkDataOnTemptable()
{
    $this->machine->checkDataOnTemptable();
}

public function del_dataFromTemptable_whenReloadPageByEcode()
{
    $this->machine->del_dataFromTemptable_whenReloadPageByEcode();
}

public function checkDataTempBefore()
{
    $this->machine->checkDataTempBefore();
}


public function deleteOtherImage()
{
    $this->machine->deleteOtherImage();
}

public function loadTemplateOtherImage()
{
    $this->machine->loadTemplateOtherImage();
}

public function saveOtherImage_edit()
{
    $this->machine->saveOtherImage_edit();
}



public function setActiveRun()
{
    $this->machine->setActiveRun();
}




public function updateData()
{
    $this->machine->updateData();
}

public function run_updateData()
{
    // $array_masterlinenum = array('88' , '89' , '90' , '91' , '92');

    // $this->db->where_in('mat_master_linenum',$array_masterlinenum);
    // // $this->db->where('mat_userpost','Yaowaman B');
    // $this->db->where('mat_userpost','Janchai Pa');
    // $this->db->like('mat_machine_name' , '24TEK96-1');
    // $this->db->delete('machine_template');


    // $getRunscreen = $this->db->query("SELECT
    // run_name,
    // run_type,
    // run_minvalue,
    // run_maxvalue,
    // run_spoint,
    // run_linenum
    // from runscreen_master where run_linenum = 62");

    // $runData = $getRunscreen->row();

    // $getTemplate = $this->db->query("SELECT
    //         b.mat_machine_name,
    //         b.mat_linenum 
    //     FROM
    //         ( SELECT MAX( mat_linenum ) AS mat_linenum FROM machine_template WHERE mat_machine_name LIKE '%24TEK96-1%' GROUP BY mat_machine_name ) a
    //         LEFT JOIN ( SELECT * FROM machine_template ) b ON a.mat_linenum = b.mat_linenum 
    //     WHERE
    //         mat_machine_name LIKE '%24TEK96-1%' 
    //     GROUP BY
    //         mat_machine_name
    // ");

    // foreach($getTemplate->result() as $rs){

    //     $arinsertdata = array(
    //         "mat_column_name" => $runData->run_name,
    //         "mat_machine_name" => $rs->mat_machine_name,
    //         "mat_machine_type" => $runData->run_type,
    //         "mat_min_value" => $runData->run_minvalue,
    //         "mat_max_value" => $runData->run_maxvalue,
    //         "mat_spoint_value" => $runData->run_spoint,
    //         "mat_linenum" => 84,
    //         "mat_master_linenum" => $runData->run_linenum,
    //     );
    //     $this->db->insert('machine_template' , $arinsertdata);
    // }

    // echo "เพิ่มข้อมูลสำเร็จ";

}


// Template Bom
    public function copyFeederForBomTemplate()
    {
        $this->machine->copyFeederForBomTemplate();
    }

    public function get_bomversionData()
    {
        $this->machine->get_bomversionData();
    }

    public function chooseFeeder_template()
    {
        $this->machine->chooseFeeder_template();
    }

    public function saveDataToFeederBom_template_tmp()
    {
        $this->machine->saveDataToFeederBom_template_tmp();
    }

    public function deleteRawmaterialOnFeederAndBom()
    {
        $this->machine->deleteRawmaterialOnFeederAndBom();
    }

    public function getBomForMix_template()
    {
        $this->machine->getBomForMix_template();
    }

    public function activeMix_tmp()
    {
        $this->machine->activeMix_tmp();
    }

    public function waitConfirmMix_template()
    {
        $this->machine->waitConfirmMix_template();
    }

    public function countConfirmMix_template()
    {
        $this->machine->countConfirmMix_template();
    }

    public function saveDataMix_template()
    {
        $this->machine->saveDataMix_template();
    }

    public function getBomMixed()
    {
        $this->machine->getBomMixed();
    }

    public function getBomMixed2()
    {
        $this->machine->getBomMixed2();
    }

    public function canCelMix_template()
    {
        $this->machine->canCelMix_template();
    }

    public function saveDataTempToTable()
    {
        $this->machine->saveDataTempToTable();
    }

    public function saveDataTempToTable_edit()
    {
        $this->machine->saveDataTempToTable_edit();
    }

    public function getBomTemplate()
    {
        $this->machine->getBomTemplate();
    }

    public function getBomTemplateView()
    {
        $this->machine->getBomTemplateView();
    }

    public function getBomTemplateForEdit()
    {
        $this->machine->getBomTemplateForEdit();
    }

    public function checkUseTemplate()
    {
        $this->machine->checkUseTemplate();
    }

    public function getInlet_template()
    {
        $this->machine->getInlet_template();
    }

    public function saveInlet_template()
    {
        $this->machine->saveInlet_template();
    }





    /* End of file Controllername.php */
}

/* End of file Controllername.php */
