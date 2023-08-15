<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{title}</title>

    <!-- <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/series-label.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script> -->

    <script src="<?=base_url('assets/js/custom/highcharts.js?v='.filemtime('./assets/js/custom/highcharts.js'))?>"></script>
    <script src="<?=base_url('assets/js/custom/series-label.js?v='.filemtime('./assets/js/custom/series-label.js'))?>"></script>
    <script src="<?=base_url('assets/js/custom/exporting.js?v='.filemtime('./assets/js/custom/exporting.js'))?>"></script>
    <script src="<?=base_url('assets/js/custom/export-data.js?v='.filemtime('./assets/js/custom/export-data.js'))?>"></script>
    <script src="<?=base_url('assets/js/custom/accessibility.js?v='.filemtime('./assets/js/custom/accessibility.js'))?>"></script>
    
</head>


<body>

    <!-- Modal Edit Run Template -->
    <div class="modal fade " id="selectLotnumber_runscreen_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg qcsampling_md modal-dialog-scrollable">

            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="add_title_h">เลือก Lot Number ที่ต้องการ</h4>
                    <button type="button" class="close clearDivIconModal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-header subhead">
                    <button type="button" id="confirm_checkboxLotnum_runscreen" name="confirm_checkboxLotnum_runscreen" class="btn btn-success">Confirm</button>
                    <button type="button" id="close_qcline" name="close_qcline" class="btn btn-danger ml-2 clearDivIconModal" data-dismiss="modal">Close</button>
                </div>
                
                <div class="modal-body">
                    <div id="showLotNumberBy_runscreen"></div>
                </div>

            </div>

        </div>
    </div>
    <!-- Modal Create Template -->

    <div class="container px-5" id="app">
        <div class="row mt-3">
            <div class="col-md-12">
                <h3 class="text-center h1vtitle">หน้าแสดงข้อมูล กราฟ Runscreen<span id="textTitle"></span></h3>
            </div>
        </div>

        <div class="row form-group">
            <div class="col-lg-3"></div>
            <div class="col-lg-6 clearDiv_runscreen">
                <input type="text" name="searchItemID_runscreen" id="searchItemID_runscreen" class="form-control" placeholder="ค้นหา Item ID">
                <div id="showSearchItemID_runscreen" class="mt-2"></div>
                <i class="icon-undo-alt clearDivIcon_runscreen"></i>
            </div>
            <div class="col-lg-3"></div>
        </div>

        <div class="row mt-5">
            <div class="col-lg-4">
                <span><b>Item ID : </b></span><span id="itemid_text_runscreen"></span>
            </div>
            <div class="col-lg-8">
                <span><b>Lot Number : </b></span><span id="lotnumber_text_runscreen"></span>
            </div>
        </div>

        <div id="showCheckboxList_runscreen" class="row mt-5"></div>

        <div class="row mt-4">
            <div class="col-lg-12">
                <div id="showGraphByCheckRunscreenMain"></div>
            </div>
        </div>

     


    </div>


</body>

<script>
    let selectLotNumber_runscreen = [];
    let runscreenCheckedArray = [];

    $(document).ready(function(){

        getDataRunscreenGraphFromdatabase();

        $('#searchItemID_runscreen').keyup(function(){
            if($(this).val() != ""){
                const itemid = $('#searchItemID_runscreen').val();
                loadItemid_run(itemid);
            }else{
                $('#showSearchItemID_runscreen').html('');
            }
        });

        function loadItemid_run(itemid)
        {
            $.ajax({
                url:"/intsys/msd/main/graph/loadItemid_run",
                method:"POST",
                data:{
                    itemid:itemid
                },
                beforeSend:function(){},
                success:function(res){
                    console.log(JSON.parse(res));
                    if(JSON.parse(res).status == "Select Data Success"){
                        let result = JSON.parse(res).result;
                        let html = '';
                        html += '<ul class="list-group searchItemid_runscreen_ul">';
                        for(let i = 0; i < result.length; i++){
                            html +=`
                            <a href="javascript:void(0)" id="searchItemid_a" class="searchItemid_runscreen_a"
                                data_itemid = "`+result[i].fam_productcode+`"
                            >
                                <li class="list-group-item mb-1 searchItemid_runscreen_li">
                                    <span>`+result[i].fam_productcode+`</span><br>
                                </li>
                            </a>
                            `;
                        }
                        html +=`</ul>`;

                        $('#showSearchItemID_runscreen').html(html);
                    }
                }
            });
        }


        $(document).on('click','.searchItemid_runscreen_a',function(){
            selectLotNumber_runscreen = [];
            data_itemid = $(this).attr("data_itemid");
            console.log(data_itemid);
            $('#showSearchItemID_runscreen').html('');
            $('#searchItemID_runscreen').val(data_itemid).prop('readonly' , true);
            $('#selectLotnumber_runscreen_modal').modal('show');
            loadItemLot_runscreen(data_itemid);
        });

        $(document).on('click','.clearDivIcon_runscreen',function(){
            $('#searchItemID_runscreen').val('').prop('readonly' , false);
            selectLotNumber_runscreen = [];
        });


        function loadItemLot_runscreen(itemid)
        {
            $.ajax({
                url:"/intsys/msd/main/graph/loadItemLot_runscreen",
                method:"POST",
                data:{
                    itemid:itemid
                },
                beforeSend:function(){},
                success:function(res){
                    console.log(JSON.parse(res));
                    if(JSON.parse(res).status == "Select Data Success"){
                        let result = JSON.parse(res).result;
                        let html = '';
                        html +=`<ul class="list-group showLotNumber_ul`;
                        for(let i = 0; i < result.length; i++){
                            html +=`
                            <a href="javascript:void(0)" class="showLotNumber_runscreen_a">
                                <li class="list-group-item mb-1 showLotNumber_runscreen_li">
                                    <input type="checkbox" id="checkbox_lotNumber_runscreen" name="checkbox_lotNumber_runscreen[]" class="showLotNumber_runscreen_checkbox"
                                        data_batchnumber="`+result[i].fam_batchnumber+`"
                                        data_formno="`+result[i].fam_formno+`"
                                        data_ItemId="`+itemid+`"
                                        data_index="`+i+`"
                                    >
                                    <span>`+result[i].fam_batchnumber+` <b>Machine: </b>`+result[i].fam_machine+` <b>Template: </b>`+result[i].fam_machinename+`</span><br>
                                </li>
                            </a>
                            `;
                        }
                        html +=`</ul>`;

                        $('#showLotNumberBy_runscreen').html(html);
                    }
                }
            });
        }

        $(document).on('click','.showLotNumber_runscreen_checkbox',function(){
            const data_batchnumber = $(this).attr("data_batchnumber");
            const data_ItemId = $(this).attr("data_ItemId");
            const data_index = $(this).attr("data_index");
            const data_formno = $(this).attr("data_formno");

            if($(this).prop("checked") == true){
                let dataFromLot = {
                    "batchnumber":data_batchnumber,
                    "itemId":data_ItemId,
                    "index":data_index,
                    "formno":data_formno
                }
                selectLotNumber_runscreen.push(dataFromLot);
                console.log(selectLotNumber_runscreen);
            }else{
                // console.log("Not check");
                selectLotNumber_runscreen.splice(data_index,1);
                console.log(selectLotNumber_runscreen);
            } 
        });


        $('#confirm_checkboxLotnum_runscreen').click(function(){
            if(selectLotNumber_runscreen.length > 0){
                let batchnumberarray = [];
                let mainformnoarray = [];
                let itemid = selectLotNumber_runscreen[0].itemId;

                for(let i = 0; i < selectLotNumber_runscreen.length; i++){
                    batchnumberarray.push(selectLotNumber_runscreen[i].batchnumber);
                    mainformnoarray.push(selectLotNumber_runscreen[i].formno);
                }
                saveFristDataGraphRunscreen(itemid , batchnumberarray , mainformnoarray);
                $('#itemid_text_runscreen').text(itemid);
                $('#lotnumber_text_runscreen').text(batchnumberarray);
                batchnumberarray = [];
                mainformnoarray = [];
                runscreenCheckedArray = [];
                $('#selectLotnumber_runscreen_modal').modal('hide');
                $('#showGraphByCheckRunscreenMain').html('');
            }
        });

        function getDataRunscreenForCheckGraph(itemid , batchnumberarray)
        {
            $.ajax({
                url:"/intsys/msd/main/graph/getDataRunscreenForCheckGraph",
                method:"POST",
                data:{
                    itemid:itemid,
                    batchnumberarray:batchnumberarray
                },
                beforeSend:function(){
                    
                },
                success:function(res){
                    console.log(JSON.parse(res));
                    if(JSON.parse(res).status == "Select Data Success"){
                        let result = JSON.parse(res).result;
                        let result_mainformno = JSON.parse(res).result_mainformno;

                        $('#showCheckboxList_runscreen').html(result);

                    }
                }
            });
        }
        function saveFristDataGraphRunscreen(itemid , batchnumberarray , mainformnoarray)
        {
            if(itemid != "" && batchnumberarray != "" && mainformnoarray != ""){
                $.ajax({
                    url:"/intsys/msd/main/graph/saveFristDataGraphRunscreen",
                    method:"POST",
                    data:{
                        itemid:itemid,
                        batchnumberarray:batchnumberarray,
                        mainformnoarray:mainformnoarray
                    },
                    beforeSend:function(){},
                    success:function(res){
                        console.log(JSON.parse(res));
                        getDataRunscreenForCheckGraph(itemid , batchnumberarray);
                    }
                });
            }
        }


        $(document).on('click','.runscreenCheck' , function(){
            let data_runscreen = $(this).attr("data_runscreen");
 
                if(data_runscreen != ""){
                    if($(this).prop("checked") == true){
                        console.log("checked");
                        runscreenCheckedArray.push(data_runscreen);
                        updateRunscreenChecked(runscreenCheckedArray);
                    }else{
                        console.log("Not check");
                        
                        runscreenCheckedArray = arrayRemoveRunscreenCheck(runscreenCheckedArray , data_runscreen);
                        updateRunscreenChecked(runscreenCheckedArray);
                    }
                }else{
                    updateRunscreenChecked('');
                }

                console.log(data_runscreen);
            
        });

        function updateRunscreenChecked(runscreenCheckedArray)
        {
            if(runscreenCheckedArray != ""){
                $.ajax({
                    url:"/intsys/msd/main/graph/updateRunscreenChecked",
                    method:"POST",
                    data:{
                        runscreenCheckedArray:runscreenCheckedArray
                    },
                    beforeSend:function(){
                        $('.loader').fadeIn(1000);
                    },
                    success:function(res){
                        $('.loader').fadeOut(500);
                        console.log(JSON.parse(res));
                        loadAlldataForUseGraphRunscreen(true);
                    }
                });
            }
            console.log(runscreenCheckedArray);
        }


        function arrayRemoveRunscreenCheck(array , value)
        {
            return array.filter(function(ele){
                return ele != value;
            });
        }


        function getDataRunscreenGraphFromdatabase()
        {
            $.ajax({
                url:"/intsys/msd/main/graph/getDataRunscreenGraphFromdatabase",
                method:"POST",
                data:{},
                beforeSend:function(){},
                success:function(res){
                    console.log(JSON.parse(res));
                    if(JSON.parse(res).status == "Select Data Success"){
                        let result_runscreen = JSON.parse(res).result_runscreen;
                        let result_batchnumber = JSON.parse(res).result_batchnumber;
                        let result_mainformno = JSON.parse(res).result_mainformno;
                        let result_itemid = JSON.parse(res).result_itemid;


                        if(result_batchnumber !== null){
                            selectLotNumber_runscreen = result_batchnumber;
                        }else{
                            selectLotNumber_runscreen = [];
                        }

                        if(result_mainformno !== null){
                            mainformnoArray = result_batchnumber;
                        }else{
                            mainformnoArray = [];
                        }

                        if(result_runscreen !== null){
                            runscreenCheckedArray = result_runscreen;
                        }else{
                            runscreenCheckedArray = [];
                        }

                        getDataRunscreenForCheckGraph(result_itemid , selectLotNumber_runscreen);
                        $('#itemid_text_runscreen').text(result_itemid);
                        $('#lotnumber_text_runscreen').text(result_batchnumber);
                        loadAlldataForUseGraphRunscreen(true);
                        
                    }
                }
            });
        }



        function loadAlldataForUseGraphRunscreen(permission)//By ecode on database
        {
            if(permission === true){
                $.ajax({
                    url:"/intsys/msd/main/graph/loadAlldataForUseGraphRunscreen",
                    method:"POST",
                    data:{},
                    beforeSend:function(){},
                    success:function(res){
                        console.log(JSON.parse(res));
                        if(JSON.parse(res).status == "Select Data Success"){
                            let result_itemid = JSON.parse(res).result_itemid;
                            let result_runscreen = JSON.parse(res).result_runscreen;
                            let result_graph = JSON.parse(res).result_graph;

                            let runscreen_value_t = [];
                            let runscreen_max_t = 0;
                            let runscreen_min_t = 0;
                            let runscreen_batchno_t = [];
                            let runscreen_prodid_t = [];
                            let runscreen_datetime_t = [];
                            let runscreen_worktime_t = [];
                            let runscreen_name_t = [];
                            let runscreen_name_fix = '';
                            let graph_category = [];

                            let resultData = [];

                            if(result_runscreen !== null){
                                for(let i = 0; i < result_runscreen.length; i++){

                                    for(let ii = 0; ii < result_graph.length; ii++){
                                        if(result_runscreen[i] == result_graph[ii].far_runscreen_name){

                                            runscreen_value_t.push(parseFloat(result_graph[ii].far_runscreen_value));
                                            runscreen_max_t = result_graph[ii].far_runscreen_max;
                                            runscreen_min_t = result_graph[ii].far_runscreen_min;
                                            runscreen_batchno_t.push(result_graph[ii].fam_batchnumber);
                                            runscreen_prodid_t.push(result_graph[ii].fam_prodid);
                                            runscreen_datetime_t.push(result_graph[ii].far_datetime);
                                            runscreen_worktime_t.push(result_graph[ii].far_worktime);
                                            runscreen_name_t.push(result_graph[ii].far_runscreen_name);
                                            runscreen_name_fix = result_graph[ii].far_runscreen_name;
                                            graph_category.push(result_graph[ii].far_worktime+' '+result_graph[ii].fam_batchnumber);

                                        }
                                    }

                                    let graphByRunscreen = {
                                        'runscreen_value':runscreen_value_t,
                                        'runscreen_max':runscreen_max_t,
                                        'runscreen_min':runscreen_min_t,
                                        'runscreen_batchno':runscreen_batchno_t,
                                        'runscreen_prodid':runscreen_prodid_t,
                                        'runscreen_datetime':runscreen_datetime_t,
                                        'runscreen_worktime':runscreen_worktime_t,
                                        'runscreen_name':runscreen_name_t,
                                        'runscreen_name_fix':runscreen_name_fix,
                                        'graph_category':graph_category
                                    }

                                    resultData.push(graphByRunscreen);

                                    runscreen_value_t = [];
                                    runscreen_max_t = [];
                                    runscreen_min_t = [];
                                    runscreen_batchno_t = [];
                                    runscreen_prodid_t = [];
                                    runscreen_datetime_t = [];
                                    runscreen_worktime_t = [];
                                    runscreen_name_t = [];
                                    runscreen_name_fix = '';
                                    graph_category = [];
                                    }

                                    console.log(resultData);

                                    // Loop for create graph section
                                    let areaGraphRunscreen = '';
                                    for(let i =0;i<resultData.length;i++){
                                    areaGraphRunscreen += `<div id="areaGraphRunscreenShow_`+i+`" class="mt-5">`+resultData[i].runscreen_name_fix+`</div>`;
                                    $('#showGraphByCheckRunscreenMain').html(areaGraphRunscreen);

                                    graphBy_checkLotNumber(resultData[i].graph_category , resultData[i].runscreen_name_fix , resultData[i].runscreen_value , i , resultData[i].runscreen_min , resultData[i].runscreen_max)
                                    }
                                    // Loop for create graph section

                                    for(let i =0;i<resultData.length;i++){
                                    graphBy_checkLotNumber(resultData[i].graph_category , resultData[i].runscreen_name_fix , resultData[i].runscreen_value , i , resultData[i].runscreen_min , resultData[i].runscreen_max)
                                    }
                            }


                        }
                    }
                });
            }
        }


        
        function graphBy_checkLotNumber(totalWorktime , graphDataArrayName , graphDataArrayData , graphNumber , lowerLimit , upperLimit)
        {

            let minwidth = 5000;

            return Highcharts.chart('areaGraphRunscreenShow_'+graphNumber, {

                    chart: {
                        type: 'spline',
                        scrollablePlotArea: {
                        minWidth: minwidth,
                        scrollPositionX: 1
                        }
                    },
                    title: {
                        text: graphDataArrayName
                    },

                    subtitle: {
                        text: 'Min: '+lowerLimit+' , Max: '+upperLimit
                    },

                    yAxis: {
                        // floor: lowerLimit,
                        // max: upperLimit,
                        title: {
                            text: 'รายการ'
                        },
                        allowDecimals:true,
                    },

                    xAxis: {
                        categories: totalWorktime
                    },

                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom',
                        itemMarginTop: 5,
                        itemMarginBottom: 5,
                    },

                    plotOptions: {
                        series: {
                            label: {
                                connectorAllowed: false
                            },
                            dataLabels: {
                                enabled: 'test',
                                format: '<span style="font-size:10px;">{point.y:.3f}</span>',
                                // formatter: function() {
                                //     if(sumOutcome == 0){
                                //         return '<span style="font-size:10px;">'+this.point.y.toFixed(4)+' '+unitid+'</span>';
                                //     }else{
                                //         if (this.y == 0) {
                                //             return '<span style="font-size:10px;"> ' + this.point.y + ' = Fail</span>';
                                //         }else{
                                //             return '<span style="font-size:10px;"> ' + this.point.y + ' = Pass</span>';
                                //         }
                                //     }
                                // },
                                rotation: 310,
                                y: -30
                            },
                            pointStart: 0
                        }
                    },

                    tooltip: {
                        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                        pointFormat: `<span style="color:{point.color}">{point.category}</span>: <b>{point.y:,.4f}</b><br/>
                        <span></span>`,
                        animation:true,
                    },

                    series: [
                        {
                            name:graphDataArrayName,
                            data:graphDataArrayData,
                            label:false
                        }
                    ],

                    responsive: {
                        rules: [{
                            condition: {
                                maxWidth: 500
                            },
                            chartOptions: {
                                legend: {
                                    layout: 'horizontal',
                                    align: 'center',
                                    verticalAlign: 'bottom'
                                }
                            }
                        }]
                    }
            });
        }

    });//END Ready Zone
</script>
</html>
