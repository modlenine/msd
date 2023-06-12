<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Graph extends MX_Controller {

    
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        date_default_timezone_set("Asia/Bangkok");
        $this->load->model("graph_model" , "graph");
    }
    

    public function index()
    {
        $this->graph->loadGraphByItemLot();
    }


    public function loadCheckGraph()
    {
        $this->graph->loadCheckGraph();
    }


    public function updateTestIDUse()
    {
        $this->graph->updateTestIDUse();
    }

    public function graphPage()
    {
        $data = array(
            "title" => "Graph Page"
        );
        getHead();
        getContent("graph/graphmain" , $data);
        getFooter();
    }


    public function loadItemid()
    {
        $this->graph->loadItemid();
    }


    public function loadItemLot()
    {
        $this->graph->loadItemLot();
    }

    public function loadItemLot_runscreen()
    {
        $this->graph->loadItemLot_runscreen();
    }


    public function loadGraphDataByCheckLot()
    {
        $this->graph->loadGraphDataByCheckLot();
    }


    public function loadTestid_checkLot()
    {
        $this->graph->loadTestid_checkLot();
    }


    public function loadCheckGraphByCheckLotNum()
    {
        $this->graph->loadCheckGraphByCheckLotNum();
    }

    public function checkDataGraph()
    {
        $this->graph->checkDataGraph();
    }

    public function loadAlldataForUseGraph()
    {
        $this->graph->loadAlldataForUseGraph();
    }


    public function updateTestIDUseCheckLot()
    {
        $this->graph->updateTestIDUseCheckLot();
    }


    public function loadItemidAndLotNumber()
    {
        $this->graph->loadItemidAndLotNumber();
    }

    public function graphRunscreenPage()
    {
        $data = array(
            "title" => "Graph Runscreen Page"
        );
        getHead();
        getContent("graph/graphRunscreen" , $data);
        getFooter();
    }

    public function loadItemid_run()
    {
        $this->graph->loadItemid_run();
    }

    public function getDataRunscreenForCheckGraph()
    {
        $this->graph->getDataRunscreenForCheckGraph();
    }

    public function saveFristDataGraphRunscreen()
    {
        $this->graph->saveFristDataGraphRunscreen();
    }


    public function updateRunscreenChecked()
    {
        $this->graph->updateRunscreenChecked();
    }

    public function getDataRunscreenGraphFromdatabase()
    {
        $this->graph->getDataRunscreenGraphFromdatabase();
    }

    public function loadAlldataForUseGraphRunscreen()
    {
        $this->graph->loadAlldataForUseGraphRunscreen();
    }


}
/* End of file Controllername.php */
?>