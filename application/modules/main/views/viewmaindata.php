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
    <!-- Check zone -->
    <input hidden type="text" name="view_loadMainData" id="view_loadMainData" value="<?= $mainformno ?>">
    <input hidden type="text" name="checkChoosePage" id="checkChoosePage">

    <input hidden type="text" name="checkDataBatchNumber" id="checkDataBatchNumber" value="<?=$fam_batchnumber?>">
    <input hidden type="text" name="checkDataProductNumber" id="checkDataProductNumber" value="<?=$fam_prodid?>">
    <input hidden type="text" name="checkDataProductCode" id="checkDataProductCode" value="<?=$fam_productcode?>">
    <input hidden type="text" name="checkDataAreaid" id="checkDataAreaid" value="<?=$fam_dataareaid?>">
    <input hidden type="text" name="checkTemplatename" id="checkTemplatename" value="<?= $fam_machinename ?>">
    <!-- Check zone -->

    <div class="container conViewpage px-5" id="app">
        <div class="row">
            <div class="col-md-12">
                <h3 class="text-center h1vtitle">หน้าแสดงรายละเอียดเครื่องจักร<span id="textTitle"></span><br>เลขที่ : <?= $mainformno ?></h3>
            </div>

        </div>

        <div class="form-row headzone">

            <div class="form-group col-md-4">
                <label for="">Company</label>
                <input readonly type="text" name="fam_machinenameV" id="fam_machinenameV" class="form-control" value="<?= conCompany($fam_dataareaid)?>">
            </div>

            <div class="form-group col-md-4">
                <label for="">STD. name</label>
                <input readonly type="text" name="fam_machinenameV" id="fam_machinenameV" class="form-control" value="<?= $fam_machinename ?>">
            </div>

            <div class="form-group col-md-4">
                <label for="">Machine name</label>
                <input readonly type="text" name="fam_machineV" id="fam_machineV" class="form-control" value="<?= $fam_machine ?>">
            </div>

            <div class="form-group col-md-4">
                <label for="">Product No.</label>
                <input readonly type="text" name="fam_prodid" id="fam_prodid" class="form-control" value="<?=$fam_prodid?>">
            </div>

            <div class="form-group col-md-4">
                <label for="">Product Code</label>
                <input readonly type="text" name="fam_productcode" id="fam_productcode" class="form-control" value="<?=$fam_productcode?>">
            </div>

            <div class="form-group col-md-4">
                <label for="">Batch Number</label>
                <input readonly type="text" name="fam_batchnumber" id="fam_batchnumber" class="form-control" value="<?=$fam_batchnumber?>">
            </div>


            <div class="form-group col-md-4">
                <label for="">Date</label>
                <input readonly type="text" name="fam_datetime" id="fam_datetime" class="form-control" value="{fam_datetime}">
            </div>

            <div class="form-group col-md-4">
                <label for="">MIS</label>
                <input readonly type="text" name="fam_mis" id="fam_mis" class="form-control" value="<?=valueFormat($fam_mis)?>">
            </div>

            <div class="form-group col-md-4">
                <label for="">Output</label>
                <input readonly type="text" name="fam_output" id="fam_output" class="form-control" value="<?=valueFormat($fam_output)?>">
            </div>

            <i class="icon-line-edit editHead"
                data_fam_mis="<?=$fam_mis?>"
                data_fam_output="<?=$fam_output?>"
                data_mainformno="<?=$mainformno?>"
                data_fam_machine="<?=$fam_machine?>"
            ></i>
        </div>

        <div class="divider divider-center"><i class="icon-cloud"></i></div>


        <!-- Zone Tab -->

        <!-- Debug นับข้อมูลบน Feeder  -->
        <input hidden type="text" name="checkFeederDataForEdit" id="checkFeederDataForEdit">

        <div class="tabs tabs-alt tabs-justify clearfix" id="tab-10">

            <ul class="tab-nav clearfix">
                <li><a id="tabpage1" href="#page1">รายละเอียดเครื่องจักร</a></li>
                <li><a id="tabpage2" href="#page2">ตรวจสอบเครื่องจักร</a></li>
                <li><a id="tabpage3" href="#page3">QC Sampling</a></li>
                <li><a id="tabpage4" href="#page4">Job Card</a></li>
                <li><a id="tabpage5" href="#page5">Packing List</a></li>
            </ul>

            <div class="tab-container mt-3">

                <div class="tab-content clearfix" id="page1">

                    <div class="row form-group">
                        <div class="col-md-12">
                            <div class="card mb-3">
                                <div class="card-header text-white bg-primary">Template
                                </div>
                                <div class="card-body">

                                    <div id="template_feeder" class="row form-group">
                                        <div class="col-md-12 col-xl-6">
                                            <h5><u>Feeder</u></h5>
                                            <!-- Load Feeder temp -->
                                            <div id="loadFeeder_template"></div>
                                        </div>
                                        <div class="col-md-12 col-xl-6">
                                            <!-- โหลด Bom มาจาก Database -->
                                            <div id="loadBom_template"></div>
                                            <br>
                                            <div id="loadBomMixed_template"></div>
                                        </div>
                                    </div>

                                    <div id="notify_oldData" style="diaplay:none;">
                                        <h3 class="text-center">ไม่พบข้อมูลเนื่องจากรายการนี้เป็นชุดข้อมูลก่อนปรับโปรแกรม</h3>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row form-group">
                        <div class="col-md-12">
                            <div class="card mb-3">
                                <div class="card-header text-white bg-success">Actual
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 col-xl-6">
                                            <h5><u>Feeder</u></h5>
                                            <button class="btn btn-warning editInlet" data_mainformno = "<?=$mainformno?>">
                                                <i class="icon-line-edit intletI"></i> Inlet
                                            </button>
                                            <!-- Load Feeder temp -->
                                            <div id="loadFeederTemp"></div>
                                        </div>
                                        <div class="col-md-12 col-xl-6">
                                            <!-- โหลด Bom มาจาก Database -->
                                            <h5><u>Bom Original</u></h5>
                                            <div id="loadGetBom"></div>
                                            <span id="textStartBtn" style="color:#CC0000">*หากรายการใดต้องทำการแบ่ง Mix แนะนำให้แบ่งรายการนั้นใส่ Feeder ก่อน Mix*</span>
                                            <br>
                                            <h5><u>Bom Mix</u></h5>
                                            <div id="loadGetBomMix"></div>
                                        </div>
                                    </div>
                                    <!-- <div id="showFeedAlt"></div> -->
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="divider divider-center check_btn_addSpoint"><i class="icon-cloud"></i></div>

                    <input hidden type="text" name="checkSumFeederValue" id="checkSumFeederValue" value="<?= checkFeederSumValue($mainformno) ?>">

                    <div class="row mt-3 btnViewPage1">
                    <div class="col-md-12 text-center form-group ctrStartBtn">
                            <button class="btn btn-success startBtn mb-3" name="btn_reportStart" id="btn_reportStart"><i class="icon-play1" style="font-size:22px;"></i>&nbsp;Start</button>
                            <button class="btn btn-danger startBtn mb-3" name="btn_reportCancel" id="btn_reportCancel"><i class="icon-remove-sign" style="font-size:22px;"></i>&nbsp;Cancel</button><br>
                            <span id="textStartBtn" style="color:#CC0000">*ท่านต้องกรอกข้อมูลวัตถุดิบใน Feeder ให้ครบ 100% ก่อนจึงจะกด Start ได้*</span>
                        </div>
                        <div class="col-md-12 text-center form-group ctrStopBtn">
                            <button class="btn btn-danger startBtn" name="btn_reportStop" id="btn_reportStop" style="display:none;"><i class="icon-stop1" style="font-size:22px;"></i>&nbsp;Stop</button>
                        </div>

                        <div id="section_btnSpoint" class="col-md-12 text-center" style="display:none;">
                            <button type="button" id="btn_addSpoint" name="btn_addSpoint" class="btn btn-success" data-toggle="modal" data-target="#spoint_modal" data_template="<?= $fam_machinename ?>" data_mainform="<?= $mainformno ?>" data_prodid="<?= $fam_prodid ?>" data_productcode="<?= $fam_productcode ?>" data_batchnumber="<?= $fam_batchnumber ?>">บันทึก S/Point</button>
                        </div>
                        <input hidden type="text" name="checkSpointDataOnDatabase" id="checkSpointDataOnDatabase" value="<?= checkSpoint($mainformno) ?>">
                    </div>



                    <!-- <div class="divider divider-center csubmain_frm"><i class="icon-cloud"></i></div> -->
                    <!-- <form id="submain_frm">
                        <input hidden type="text" name="check_fasub_main_formno" id="check_fasub_main_formno" value="<?= $mainformno ?>">
                        <input hidden type="text" name="check_machinename" id="check_machinename" value="<?= $fam_machinename ?>">
                        <h5 class="sectionShift">สร้างกะงาน</h5>
                        <div class="row sectionShift">
                            <div class="col-md-8">
                                <select name="choose_worksection" id="choose_worksection" class="form-control">
                                    <option value="">กรุณาเลือกกะงาน</option>
                                    <option value="shift-a">กะเช้า (Shift A)</option>
                                    <option value="shift-b">กะบ่าย (Shift B)</option>
                                    <option value="shift-c">กะดึก (Shift C)</option>
                                </select>
                            </div>
                            <div class="col-md-4 div_btn">
                                <button type="button" id="btn_add_submain_frm" name="btn_add_submain_frm" class="button button-small button-circle button-green">บันทึก</button>
                            </div>
                        </div>
                    </form> -->
                    <!-- <div class="divider divider-center sectionShift"><i class="icon-cloud"></i></div> -->


                    <div id="speacial_section" class="row align-items-center mt-3" style="display:none;">
                        <div class="col-md-12 text-center">
                            <h4>ข้อแนะนำพิเศษ</h4>
                        </div>
                    </div>

                    <div id="otherImage_view_section" class="row form-group" style="display:none;">
                        <div class="col-md-12">
                            <label for=""><b>รูปภาพอื่นๆ</b></label>
                            <div id="show_otherImage_viewpage"></div>
                        </div>
                    </div>

                    <div id="templateRemark_view_section" class="row form-group" style="display:none;">
                        <div class="col-md-12">
                            <label for=""><b>หมายเหตุ</b></label>
                            <textarea name="show_templateRemark" id="show_templateRemark" cols="30" rows="10" class="form-control" style="height:100px;" readonly></textarea>
                        </div>
                    </div>



                    <div class="row">
                        <div class="form-group col-md-12">
                            <!-- <?=getsubmaindata2($mainformno , $detailFormno)?> -->
                            <div id="showSubmainData2"></div>
                        </div>
                    </div>
                </div>

                
                <div class="tab-content clearfix" id="page2">
                    <div class="row form-group">
                        <!-- Input check Start page 2 -->
                        <input hidden type="text" name="checkStartPage2" id="checkStartPage2" value="<?= checkStatusPage2($mainformno)->ptwo_pagestatus ?>">
                        <input hidden type="text" name="checkPosiPage2" id="checkPosiPage2" value="<?= getUser()->posi ?>">
                        <input hidden type="text" name="countFeeder" id="countFeeder">
                        <input hidden type="text" name="getUrl" id="getUrl" value="<?= base_url() ?>">

                        <div class="col-md-12 text-center forViewPage21">
                            <button class="btn btn-primary addoutPuts" name="btns_addOutput" id="btns_addOutput" data-toggle="modal" data-target="#checkFeeder_modal" style="display:none;" data_prodid="<?= $fam_prodid ?>" data_productcode="<?= $fam_productcode ?>" data_batchnumber="<?= $fam_batchnumber ?>" data_outputhr="<?= $fam_outputhr ?>">กำหนด Output และ ค่าเบี่ยงเบน</button>
                        </div>
                    </div>

                    <div class="divider divider-center btnzone"><i class="icon-cloud"></i></div>

                    <div class="row control_report">
                        <div id="showReportByTemplate" class="" style="width:100%"></div>
                    </div>
                    <div class="divider divider-center control_report"><i class="icon-cloud"></i></div>
                    <div class="row control_report">
                        <div id="showReportMachineCheck" class="" style="width:100%"></div>
                    </div>
                    <div class="divider divider-center control_report"><i class="icon-cloud"></i></div>
                    <div class="row control_report">
                        <div id="showBomReport" class="col-sm-6" style="width:100%"></div>
                        <div id="showBomMixReport" class="col-sm-6" style="width:100%"></div>
                    </div>


                    <div class="divider divider-center"><i class="icon-cloud"></i></div>
                    <!-- <div class="row text-center mb-5">
                        <div class="col-md-6">
                            <span><b>Operator : </b><?= checkStatusPage2($mainformno)->ptwo_userstart ?></span><br>
                            <span><b>Date : </b><?= conDateTimeFromDb(checkStatusPage2($mainformno)->ptwo_datetimestart) ?></span>
                        </div>
                        <div class="col-md-6">
                            <span><b>Approve : </b><?= checkStatusPage2($mainformno)->ptwo_userend ?></span><br>
                            <span><b>Date : </b><?= conDateTimeFromDb(checkStatusPage2($mainformno)->ptwo_datetimeend) ?></span>
                        </div>
                    </div> -->

                </div>


                <div class="tab-content clearfix" id="page3">
                    <div class="row">
                        <div class="col-lg-1"></div>
                        <div id="showQcSampling" class="col-lg-10" style="width:100%"></div>
                        <div class="col-lg-1"></div>
                    </div>

                    <div id="qcsticker" class="row mt-5"></div>

                    <div id="showCheckGraph" class="row mt-5"></div>

                    <!-- <div class="row mt-4">
                        <div class="col-lg-12">
                            <div id="showGraph"></div>
                        </div>
                    </div> -->

                    <div class="row mt-4">
                        <div class="col-lg-12">
                            <div id="showGraphMain"></div>
                        </div>
                    </div>

                </div>


                <div class="tab-content clearfix" id="page4">
                    
                    <div id="showJobcard" class="row"></div>

                </div>


                <div class="tab-content clearfix" id="page5">
                    
                    <div id="showPackingList" class="row"></div>

                </div>


            </div>

        </div>



    </div>

</body>



</html>
<script>
    let testIDShowArray = [];
    $(document).ready(function() {
        if($(window).width() < 480){
            $('.conViewpage').removeClass('px-5');
        }

        let mainformno = $('#view_loadMainData').val();
        loadSubmainData2(mainformno);
        

        $('.datetimepicker1').datetimepicker({
            format: "HH:mm",
            showClose: true
        });


        $('#tabpage1').click(function(){
            const id = $(this).attr("href").substr(1);
            window.location.hash = id;
        });
        $('#tabpage2').click(function(){
            const id = $(this).attr("href").substr(1);
            window.location.hash = id;
        });
        $('#tabpage3').click(function(){
            const id = $(this).attr("href").substr(1);
            window.location.hash = id;

            if(window.location.hash == "#page3"){
                let prodid = $('#checkDataProductNumber').val();
                let dataareaid = $('#checkDataAreaid').val();
                let status = $("#checkStartPage2").val();
                let formno = "<?php echo $mainformno; ?>";
                let batchnumber = $('#checkDataBatchNumber').val();
                loaddataSticker(formno , prodid , batchnumber , dataareaid , status);
            }
        });
        $('#tabpage4').click(function(){
            const id = $(this).attr("href").substr(1);
            window.location.hash = id;

            if(window.location.hash == "#page4"){
                let prodid = $('#checkDataProductNumber').val();
                let dataareaid = $('#checkDataAreaid').val();
                let status = $("#checkStartPage2").val();
                let formno = "<?php echo $mainformno; ?>";
                loaddatajobcard(prodid , dataareaid , status , formno);
            }
        });
        $('#tabpage5').click(function(){
            const id = $(this).attr("href").substr(1);
            window.location.hash = id;

            if(window.location.hash == "#page5"){
                let prodid = $('#checkDataProductNumber').val();
                let dataareaid = $('#checkDataAreaid').val();

                loaddatapackinglist(prodid , dataareaid);
            }
        });



        $(document).on('click' , '.qclink' , function(){
            const data_qcSampleId = $(this).attr("data_qcSampleId");
            const data_qcSampleNum = $(this).attr("data_qcSampleNum");
            const data_areaId = $(this).attr("data_areaId");
            loadQcsamplingByLinenum(data_qcSampleId, data_qcSampleNum, data_areaId);

            $('#titleQcnumber').html(data_qcSampleNum);
            $('#qcsampling_modal').modal('show');

        });

        $(document).on('click','.testid_check',function(){
            const data_testid = $(this).attr("data_testid");
            const data_mainformno = $(this).attr("data_mainformno");
            // console.log(data_testid);
            // console.log(testIDShowArray.length);

            if($(this).prop('checked') == true){
                // console.log("Not check");
                testIDShowArray.push(data_testid);
                updateTestIDUse(testIDShowArray,data_mainformno);
            }else{
                // console.log("check");
                testIDShowArray = arrayRemove(testIDShowArray , data_testid);
                updateTestIDUse(testIDShowArray,data_mainformno);
            }
        });


        $(document).on('click' , '.sysdt' , function(){
            const data_systemDatetime = $(this).attr("data_systemDatetime");
            const data_systemDatetime_modify = $(this).attr("data_systemDatetime_modify");
            // console.log(data_systemDatetime);
            let showdataSysdatetime = 
            `<span>Create</span><br>
            <span>`+data_systemDatetime+`</span><br>
            <hr>
            <span>Modify</span><br>
            <span>`+data_systemDatetime_modify+`</span>
            `;
            $('#showSystemDatetime_modal').modal('show');
            $('#sysTextShow').html(showdataSysdatetime);
        });



        //Zone Change Position Timework
        $(document).on('click' , '.groupLinenum' , function(){
            
            $('.arrowSection').css('display' , '');
            const data_far_detail_formno = $(this).attr("data_far_detail_formno");
            const data_far_main_formno = $(this).attr("data_far_main_formno");
            const data_far_runscreen_group_linenum = $(this).attr("data_far_runscreen_group_linenum");

            let dataGroupLinenum =
                {
                "detailformno":data_far_detail_formno,
                "mainformno":data_far_main_formno,
                "grouplinenum":data_far_runscreen_group_linenum
                };

            localStorage.setItem("dataGroupLinenum" , JSON.stringify(dataGroupLinenum));
            // console.log(data_far_detail_formno+" "+data_far_main_formno+" "+data_far_runscreen_group_linenum);
            // load_runscreen_group_linenum(data_far_main_formno);
            checkMinAndMaxArrow(data_far_runscreen_group_linenum , data_far_main_formno);
        });


        $(document).on('click' , '.iconArrowLeft' , function(){
            let getDataFromStroage = localStorage.getItem("dataGroupLinenum");
            console.log(JSON.parse(getDataFromStroage));

            const grouplinenum = JSON.parse(getDataFromStroage).grouplinenum;
            const mainformno = JSON.parse(getDataFromStroage).mainformno;
            const detailformno = JSON.parse(getDataFromStroage).detailformno;
            console.log(grouplinenum+" "+mainformno+" "+detailformno);
            updateGroupLinenumLeft(grouplinenum , detailformno , mainformno);
        });


        $(document).on('click' , '.iconArrowRight' , function(){
            let getDataFromStroage = localStorage.getItem("dataGroupLinenum");
            // console.log(JSON.parse(getDataFromStroage));
            const grouplinenum = JSON.parse(getDataFromStroage).grouplinenum;
            const mainformno = JSON.parse(getDataFromStroage).mainformno;
            const detailformno = JSON.parse(getDataFromStroage).detailformno;
            console.log(grouplinenum+" "+mainformno+" "+detailformno);
            updateGroupLinenumRight(grouplinenum , detailformno , mainformno);
        });

        $(document).on('dblclick' , '.groupLinenum' , function(){
            $(this).prop('checked' , false);
            $('.arrowSection').css('display' , 'none');
            localStorage.removeItem("dataGroupLinenum");
        });


        //////////////////////////////////////
        // Zone แก้ไขข้อมูลส่วนหัวของเอกสาร
        $(document).on('click','.editHead', function(){
            
            const data_fam_mis = $(this).attr('data_fam_mis');
            const data_fam_output = $(this).attr('data_fam_output');
            const data_mainformno = $(this).attr('data_mainformno');
            const data_fam_machine = $(this).attr('data_fam_machine');

            loadMachineList_edit(data_fam_machine);

            $('#editHeadData_modal').modal('show');
            $('#edit_fam_mis').val(data_fam_mis);
            $('#edit_fam_output').val(data_fam_output);
            $('#textEditHead').html(data_mainformno);
            $('#editHead_checkMainformno').val(data_mainformno);


            console.log(data_fam_mis+data_fam_output);
        });

        $('#edit_fam_mis').focus(function(){
            $(this).select();
        });

        $('#edit_fam_output').focus(function(){
            $(this).select();
        });

        $('#saveEditHead').click(function(){
            if($('#edit_fam_mis').val() != "" && $('#edit_fam_output').val() != "" && $('#edit_fam_machine').val() != ""){
                saveEditHead();
            }else{
                if($('#edit_fam_mis').val() == ""){
                    $('#edit_fam_mis').addClass('inputNull');
                }else{
                    $('#edit_fam_mis').removeClass('inputNull');
                }

                if($('#edit_fam_output').val() == ""){
                    $('#edit_fam_output').addClass('inputNull');
                }else{
                    $('#edit_fam_output').removeClass('inputNull');
                }

                if($('#edit_fam_machine').val() == ""){
                    $('#edit_fam_machine').addClass('inputNull');
                }else{
                    $('#edit_fam_machine').removeClass('inputNull');
                }
            }
        });

        $(document).on('click' , '.close_EditHead' , function(){
            $('#edit_fam_mis , #edit_fam_output').removeClass('inputNull');
        });
        // Zone แก้ไขข้อมูลส่วนหัวของเอกสาร
        //////////////////////////////////////


        $(document).on("click", '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox({
                alwaysShowClose: true,
            });
        });

        $(".fd_files5").fileinput({
            showPreview: false,
            allowedFileExtensions: ["mp4" , "avi"],
            elErrorContainer: "#errorBlock"
		});


        $(document).on('click' , '.editInlet' , function(){
            const data_mainformno = $(this).attr('data_mainformno');
            getInletEdit(data_mainformno);
        });


        loadFeederAndBomTemplate();
        //Feeder AND Bom Template
        function loadFeederAndBomTemplate()
        {
            let templatename = $('#checkTemplatename').val();
            let itemid = $('#checkDataProductCode').val();
            let dataareaid = $('#checkDataAreaid').val();
            let mainformno = $('#view_loadMainData').val();

            console.log('templatename : '+templatename+' itemid : '+itemid+' areaid : '+dataareaid+' mainformno : '+mainformno);
            getBomTemplateView(templatename , itemid , dataareaid , mainformno);

        }

    function getBomTemplateView(templatename , itemid , dataareaid , mainformno)
    {

        if(templatename != "" && itemid != "" && dataareaid != "" && mainformno != ""){
            $.ajax({
                url:"/intsys/msd/main/machine/getBomTemplateView",
                method:"POST",
                data:{
                    templatename:templatename,
                    dataareaid:dataareaid,
                    itemid:itemid,
                    mainformno:mainformno
                },
                beforeSend:function(){},
                success:function(data){
                    let res = JSON.parse(data);
                    console.log(res);
                    if(res.status == "Select Data Success"){
                        let feederData = res.resultFeederTemplate;
                        let bomData = res.resultBomTemplate;
                        let bomMixedData = res.resultBomMixedTemplate;

                        let checkFeeder = res.checkFeeder;
                        let checkBom = res.checkBom;
                        let checkBomMixed = res.checkBomMixed;
                        let feederTemplateSumValue = res.feederTemplateSumValue;

                        if(checkFeeder == 0){
                            $('#template_feeder').css('display' , 'none');
                            $('#notify_oldData').css('display' , '');
                        }else{
                            $('#template_feeder').css('display' , '');
                            $('#notify_oldData').css('display' , 'none');
                        }
                        $('#loadFeeder_template').html(feederData);
                        $('#loadBom_template').html(bomData);
                        $('#loadBomMixed_template').html(bomMixedData);

                        console.log('checkFeeder : '+checkFeeder+' checkBom : '+checkBom+' checkBomMixed : '+checkBomMixed);
                    }
                }
            });
        }

    }

        

    });
    // END Ready Zone


    // Zone Function
    function loadQcsamplingByLinenum(data_qcSampleId, data_qcSampleNum, data_areaId)
    {
        $.ajax({
            url:"/intsys/msd/main/loadQcsamplingByLinenum",
            method:"POST",
            data:{
                data_qcSampleId:data_qcSampleId,
                data_qcSampleNum:data_qcSampleNum,
                data_areaId:data_areaId
            },
            beforeSend:function(){},
            success:function(res){
                // console.log(res);
                $('#showQcSamplingByLinenum').html(res);

                const browserWidth = $(window).width();

                // if (browserWidth <= 768) {
                //     $("#qcSamplingTableByLinenum").addClass("table-responsive");
                // }

                // $(window).resize(function () {
                //     if (browserWidth <= 768) {
                //     $("#qcSamplingTableByLinenum").addClass("table-responsive");
                //     }
                // });

                var table = $("#qcSamplingTableByLinenum").DataTable({
                    paging: false,
                    columnDefs: [
                    {
                        searching: false,
                        orderable: false,
                        targets: "_all",
                    },
                    // { width: "80", targets: 0 },
                    // { width: "200", targets: 1 },
                    // { width: "80", targets: 2 },
                    // { width: "80", targets: 3 },
                    // { width: "80", targets: 4 },
                    // { width: "200", targets: 5 },
                    ],
                    ordering: false,
                });

            }
        });
    }


    function loadGraphByItem(checkQcID , mainformno)
    {
        $.ajax({
            url:"/intsys/msd/main/graph",
            method:"POST",
            data:{
                checkQcID:checkQcID,
                mainformno:mainformno
            },
            beforeSend:function(){
                testIDShowArray = [];
                // $('.loader').fadeIn(1000);
            },
            success:function(res){

                // console.log(JSON.parse(res).linenum.length);
                console.log(JSON.parse(res));

                if(JSON.parse(res).status == "Select Data Success"){
                    let totalQcline = JSON.parse(res).totalQcline;
                    let graphDataArray = [];
                    let newResult = [];
                    
                    for(let i =0; i < JSON.parse(res).checkData.length;i++){
                        
                        let graphdata = {
                            "name":JSON.parse(res).checkData[i].testid,
                            "data":JSON.parse(res).checkData[i].value,
                            "unitId":JSON.parse(res).checkData[i].unitid,
                            "lowerLimit":JSON.parse(res).checkData[i].lowerlimit,
                            "upperLimit":JSON.parse(res).checkData[i].upperlimit,
                            "valueOutcome":JSON.parse(res).checkData[i].valueOutcome,
                            "sumValueOutcome":JSON.parse(res).checkData[i].sumOutcome,
                        }
                        testIDShowArray.push(JSON.parse(res).checkData[i].testid);
                        graphDataArray.push(graphdata);
                    }

                    // console.log(graphDataArray);             
                    // console.log(testIDShowArray);
                    // console.log(totalQcline);
                    let areaGraph = '';
                    for(let i = 0; i < graphDataArray.length;i++){
                        // Loop for create graph
                        areaGraph += `<div id="areaGraphShow_`+i+`" class="mt-5">`+graphDataArray[i].name+`</div>`;
                        $('#showGraphMain').html(areaGraph);
                    }

                    // graphByLot(totalQcline , graphDataArray);
                    loadCheckGraph(mainformno);
                    let resultData;
                    let maxLimit;
                    let conUnitid;
                    for(let i = 0; i < graphDataArray.length;i++){

                        if(graphDataArray[i].sumValueOutcome == 0){
                            resultData = graphDataArray[i].data;
                            maxLimit = graphDataArray[i].upperLimit;
                            if(graphDataArray[i].unitId == null){
                                conUnitid = "";
                            }else{
                                conUnitid = graphDataArray[i].unitId;
                            }
                        }else{
                            resultData = graphDataArray[i].valueOutcome;
                            maxLimit = 1;
                        }
                        // Loop for create graph
                        graphByLot(totalQcline , graphDataArray[i].name , resultData , i , conUnitid , graphDataArray[i].lowerLimit , maxLimit , graphDataArray[i].sumValueOutcome);
                    }

                    $('.loader').fadeOut(1000);
                }else{
                    loadCheckGraph(mainformno);
                }
            }
        });
    }


    function graphByLot(totalQcline , graphDataArrayName , graphDataArrayData , graphNumber , unitid , lowerLimit , upperLimit , sumOutcome)
    {
        let dataLabelShow;
        if(sumOutcome == 0){
            dataLabelShow = false;
        }else{
            dataLabelShow = true;
        }

        let minwidth = 0;
        if(graphDataArrayData.length > 300){
            minwidth = 4000;
        }else{
            minwidth = 1200;
        }

        return Highcharts.chart('areaGraphShow_'+graphNumber, {

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
                    text: 'Min: '+lowerLimit+' , Max: '+upperLimit+' &nbsp;'+unitid
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
                    categories: totalQcline
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
                            enabled: dataLabelShow,
                            // format: '<span style="font-size:10px;">{point.y:.3f}'+unitid+'</span>'
                            formatter: function() {
                                if(sumOutcome == 0){
                                    return '<span style="font-size:10px;">'+this.point.y.toFixed(4)+' '+unitid+'</span>';
                                }else{
                                    if (this.y == 0) {
                                        return '<span style="font-size:10px;"> ' + this.point.y + ' = Fail</span>';
                                    }else{
                                        return '<span style="font-size:10px;"> ' + this.point.y + ' = Pass</span>';
                                    }
                                }
                            },
                            rotation: 310,
                            y: -30
                        },
                        pointStart: 0
                    }
                },

                tooltip: {
                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                    pointFormat: '<span style="color:{point.color}">{point.category}</span>: <b>{point.y:,.4f} '+unitid+'</b><br/>',
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


    function loadCheckGraph(mainformno)
    {
        $.ajax({
            url:"/intsys/msd/main/graph/loadCheckGraph",
            method:"POST",
            data:{
                mainformno:mainformno
            },
            beforeSend:function(){},
            success:function(res){
                // console.log(res);
                $('#showCheckGraph').html(res);
            }
        });
    }

    function arrayRemove(array , value)
    {
        return array.filter(function(ele){
            return ele != value;
        });
    }


    function updateTestIDUse(testIDShowArray,data_mainformno)
    {
        $.ajax({
            url:"/intsys/msd/main/graph/updateTestIDUse",
            method:"POST",
            data:{
                testIDShowArray:testIDShowArray,
                data_mainformno:data_mainformno
            },
            beforeSend:function(){
                $('.loader').fadeIn();
            },
            success:function(res){
                
                console.log(JSON.parse(res));
                if(JSON.parse(res).status == "Update Success"){
                    const checkQcID = $('#checkQcID').val();
                    loadGraphByItem(checkQcID , data_mainformno);
                }else{
                    $('#showGraphMain').html('');
                    $('.loader').fadeOut(1000);
                }

            }
        });
    }

    function conValOutcomeToString(valueOutcome , sumOutcome , unitid)
    {
        if(sumOutcome == 0){
            return unitid;
        }else{
            if(valueOutcome == 1){
                return "Pass";
            }else{
                return "Fail";
            }
        }
        
    }



    // function load_runscreen_group_linenum(mainformno)
    // {
    //     $.ajax({
    //         url:"/intsys/msd/main/load_runscreen_group_linenum",
    //         method:"POST",
    //         data:{
    //             mainformno:mainformno
    //         },
    //         beforeSend:function(){},
    //         success:function(res){
    //             console.log(JSON.parse(res));
    //         }
    //     });
    // }


    function updateGroupLinenumLeft(groupLinenum , detailFormno , mainFormno)
    {
        $.ajax({
            url:"/intsys/msd/main/updateGroupLinenumLeft",
            method:"POST",
            data:{
                groupLinenum:groupLinenum,
                detailFormno:detailFormno,
                mainFormno:mainFormno
            },
            beforeSend:function(){},
            success:function(res){
                console.log(JSON.parse(res));
                if(JSON.parse(res).status == "Change Position Success"){
                    loadSubmainData2(mainFormno , detailFormno);

                    let dataGroupLinenum =
                        {
                            "detailformno":JSON.parse(res).detailformno,
                            "mainformno":JSON.parse(res).mainformno,
                            "grouplinenum":JSON.parse(res).grouplinenum,
                        };

                    let resGroupLinenum = parseFloat(JSON.parse(res).grouplinenum);

                    localStorage.setItem("dataGroupLinenum" , JSON.stringify(dataGroupLinenum));
                    checkMinAndMaxArrow(resGroupLinenum , JSON.parse(res).mainformno);
                }
            }
        });
    }


    function updateGroupLinenumRight(groupLinenum , detailFormno , mainFormno)
    {
        $.ajax({
            url:"/intsys/msd/main/updateGroupLinenumRight",
            method:"POST",
            data:{
                groupLinenum:groupLinenum,
                detailFormno:detailFormno,
                mainFormno:mainFormno
            },
            beforeSend:function(){},
            success:function(res){
                console.log(JSON.parse(res));
                if(JSON.parse(res).status == "Change Position Success"){
                    loadSubmainData2(mainFormno , detailFormno);

                    let dataGroupLinenum =
                        {
                            "detailformno":JSON.parse(res).detailformno,
                            "mainformno":JSON.parse(res).mainformno,
                            "grouplinenum":JSON.parse(res).grouplinenum,
                        };

                    let resGroupLinenum = parseFloat(JSON.parse(res).grouplinenum);

                    localStorage.setItem("dataGroupLinenum" , JSON.stringify(dataGroupLinenum));
                    checkMinAndMaxArrow(resGroupLinenum , JSON.parse(res).mainformno);
                }
            }
        });
    }


    function checkMinAndMaxArrow(groupLinenumNow , mainformno)
    {
        $.ajax({
            url:"/intsys/msd/main/checkMinAndMaxArrow",
            method:"POST",
            data:{
                // groupLinenumNow:groupLinenumNow,
                mainformno:mainformno
            },
            beforeSend:function(){
                // $('.loader').fadeIn(500);
            },
            success:function(res){
                console.log(JSON.parse(res));
                console.log(groupLinenumNow);
                if(JSON.parse(res).status == "Select Data Success"){
                    let linenummin = parseFloat(JSON.parse(res).groupLinenumMin);
                    let linenummax = parseFloat(JSON.parse(res).groupLinenumMax);
                    
                    if(groupLinenumNow == linenummin){
                        $('.iconArrowLeft').css('display','none');
                        $('#arrowDiv').removeClass('justify-content-between').addClass('justify-content-end');
                    }else{
                        $('.iconArrowLeft').css('display','');
                        $('#arrowDiv').removeClass('justify-content-end').addClass('justify-content-between');
                    }
                    if(groupLinenumNow == linenummax){
                        $('.iconArrowRight').css('display','none');
                    }else{
                        $('.iconArrowRight').css('display','');
                    }

                    // $('.loader').fadeOut(1000);
                }
            }
        });
    }



    function loadSubmainData2(mainformno , detailFormno)
    {
        $.ajax({
            url:"/intsys/msd/main/getSubmainData2",
            method:"POST",
            data:{
                mainformno:mainformno,
                detailFormno:detailFormno
            },
            beforeSend:function(){
                $('.loader').fadeIn(1000);
            },
            success:function(res){
                loadFeederTemp(mainformno);

                $('#showSubmainData2').html(res);
                let radioCheck = $('input:radio[name="groupLinenum"]:checked');
                console.log("radio Check : " +radioCheck.length);
                if(radioCheck.length != 0){
                    $('.arrowSection').css('display' , '');
                }
                
                hiddenButton();
                $('.loader').fadeOut(1000);

            }
        });
    }



    function saveEditHead()
    {
        $.ajax({
            url:"/intsys/msd/main/saveEditHead",
            method:"POST",
            data:$('#editHeadData').serialize(),
            beforeSend:function(){},
            success:function(res){
                console.log(JSON.parse(res));
                if(JSON.parse(res).status == "Update Data Success"){
                    swal(
                        {
                            type: 'success',
                            title: 'อัพเดตข้อมูลสำเร็จ',
                            showConfirmButton: false,
                            timer: 1500
                        }
                    );
                    location.reload();
                }
            }
        });
    }


    function hiddenButton()
    {
        let templatename = "<?php echo $fam_machinename; ?>";
        if ($("#checkStartPage2").val() == "") {
            $(".control_report").css("display", "none");
            $("#section_btnSpoint").css("display", "none");
        } else {
            $(".control_report").css("display", "");

            if ($("#checkStartPage2").val() == "Start") {
                $("#section_btnSpoint").css("display", "");
                $(".ctrStartBtn , #textStartBtn").css("display", "none");

                $("#btns_addOutput").css("display", "");

                // Check Stop Button Permmission
                if ($("#checkPosi").val() == 15) {
                $(".ctrStopBtn").css("display", "none");
                } else {
                $(".ctrStopBtn , #btn_reportStop").css("display", "");
                }
                getSpeacialData(templatename);
            } else if ($("#checkStartPage2").val() == "Stop" || $("#checkStartPage2").val() == "Cancel") {
                //Speacial User สามารถแก้ไขรายการได้หลังจากที่ Stop เอกสารไปแล้ว M0089=prateep
                if ($("#checkSessionEcode").val() == "M0089") {
                $(".ctrStartBtn , #textStartBtn , .statusStopBtn").css("display", "");
                // $("button").css("display", "");
                // Zone Control Button By Form status
                } else {
                $(".ctrStartBtn , #textStartBtn , .statusStopBtn").css("display", "none");
                // $("button").css("display", "none");
                }

                $("#btn_reportStop").css("display", "none");
                $(".btnzone").css("display", "none");
                $("#btnStartStopDiv").css("display", "none");
                $(".editHead").css("display","none");

                // Close button
                $("#submain_frm , .csubmain_frm").css("display", "none");
                getSpeacialData(templatename);
            }
        }
    }



    function getSpeacialData(templatename)
    {
        if(templatename != ""){
            $.ajax({
                url:"/intsys/msd/main/getSpeacialData",
                method:"POST",
                data:{
                    action:"getSpeacialData",
                    templatename:templatename
                },
                beforeSend:function(){},
                success:function(res){
                    console.log(JSON.parse(res));
                    if(JSON.parse(res).status == "Select Data Success"){
                        let otherImage = JSON.parse(res).otherimage;
                        let templateRemark = JSON.parse(res).templateRemark.ted_template_remark;
                        let url = "<?php echo base_url() ?>";

                        if(otherImage.length != 0){
                            $('#speacial_section').css('display' , '');
                            $('#otherImage_view_section').css('display' , '');

                            let otherImageHtml = `
                            <div class="row form-group">
                            `;

                            for(let i = 0; i < otherImage.length; i++){
                                otherImageHtml +=`
                                <div class="col-md-4 col-lg-3 col-6 mt-2 otherImage">
                                <a href="`+url+otherImage[i].temi_imagepath+otherImage[i].temi_imagename+`" data-toggle="lightbox">
                                    <img class="runImageView" src="`+url+otherImage[i].temi_imagepath+otherImage[i].temi_imagename+`">
                                </a>
                                </div>`;
                            }
                            otherImageHtml += `
                            </div>
                            `;

                            $('#show_otherImage_viewpage').html(otherImageHtml);
                        }

                        if(templateRemark != null){
                            $('#speacial_section').css('display' , '');
                            $('#templateRemark_view_section').css('display' , '');
                            $('#show_templateRemark').val(templateRemark);
                        }
                    }
                }
            });
        }
    }

    if(window.location.hash == "#page3"){
        let prodid = $('#checkDataProductNumber').val();
        let dataareaid = $('#checkDataAreaid').val();
        let status = $("#checkStartPage2").val();
        let formno = "<?php echo $mainformno; ?>";
        let batchnumber = $('#checkDataBatchNumber').val();
        loaddataSticker(formno , prodid , batchnumber , dataareaid , status);
    }


    if(window.location.hash == "#page4"){
        let prodid = $('#checkDataProductNumber').val();
        let dataareaid = $('#checkDataAreaid').val();
        let status = $("#checkStartPage2").val();
        let formno = "<?php echo $mainformno; ?>";
        loaddatajobcard(prodid , dataareaid , status , formno);
    }

    if(window.location.hash == "#page5"){
        let prodid = $('#checkDataProductNumber').val();
        let dataareaid = $('#checkDataAreaid').val();

        loaddatapackinglist(prodid , dataareaid);
    }

    function loaddatajobcard(prodid , dataareaid , status , formno)
    {
        if(prodid != "" && dataareaid != "" && status != "" && formno != ""){
            // convert status 
            if(status == "Start"){
                status = 0;
            }else if(status == "Stop"){
                status = 1;
            }

            let output =`
                <div class="col-md-12">
                    <div class="container-iframe">

                        <iframe class="w-100" height="1000" frameBorder="0" src="https://intranet.saleecolour.com/intsys/production_plan/machine/jobcard/`+prodid+`/`+dataareaid+`/2-3-4/0/`+status+`/`+formno+`/"></iframe>

                            
                    </div>
                </div>
                `;
                $('#showJobcard').html(output);




            console.log(prodid);
            console.log(dataareaid);
            console.log(status);
            console.log(formno);
            // console.log("https://intranet.saleecolour.com/intsys/production_plan/machine/jobcard/"+prodid+"/"+dataareaid+"/2-3-4/0/"+status+"/"+formno+"/");
        }
    }

    
    function loaddatapackinglist(productionid , areaid)
    {
        if(productionid != "" && areaid != ""){
            let output =`
                <div class="col-md-12">
                    <div class="">
                        <iframe class="" width="100%" height="1200" frameBorder="0" src="/intsys/msd_mix/packing_list/data/`+productionid+`/`+areaid+`"></iframe>
                    </div>
                </div>
                `;
            $('#showPackingList').html(output);
        }
    }

    function getInletEdit(mainformno)
    {
        if(mainformno != ""){
            $.ajax({
                url:"/intsys/msd/main/getInletEdit",
                method:"POST",
                data:{
                    mainformno:mainformno,
                },
                beforeSend:function(){},
                success:function(res){
                    console.log(JSON.parse(res));
                    let inletData = JSON.parse(res).inletData;
                    let inletTitle = '';
                    let inletName = '';
                    $('#inlet_modal').modal('show');

                    let output = '';
                    let option = "";
                    let inletFeederid = "";

                    for(let i = 0; i < inletData.length; i++){
                        if(JSON.parse(res).inletType == "Update"){
                            inletName = inletData[i].inlet_name;
                            inletFeederid = inletData[i].inlet_feeder_id;

                            if(inletData[i].inlet_value == "N/A"){
                                option = `
                                    <option selected value="`+inletData[i].inlet_value+`">`+inletData[i].inlet_value+`</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                `;
                            }else if(inletData[i].inlet_value == "1"){
                                option = `
                                    <option value="N/A">N/A</option>
                                    <option selected value="`+inletData[i].inlet_value+`">`+inletData[i].inlet_value+`</option>
                                    <option value="2">2</option>
                                `;
                            }else if(inletData[i].inlet_value == "2"){
                                option = `
                                    <option value="N/A">N/A</option>
                                    <option value="1">1</option>
                                    <option selected value="`+inletData[i].inlet_value+`">`+inletData[i].inlet_value+`</option>
                                `;
                            }

                        }else{
                            inletName = 'Inlet_'+inletData[i].faf_feedername;
                            inletFeederid = inletData[i].faf_autoid;
                            option = `
                                    <option value="N/A">N/A</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                `;
                        }


                        output +=`
                            <div class="col-md-6 form-group">
                                <label>`+inletName+`</label>
                                <input hidden type="text" id="ip-inletFeederID" name="ip-inletFeederID[]" value="`+inletFeederid+`">
                                <input hidden type="text" id="ip-inletName" name="ip-inletName[]" value="`+inletName+`">
                            </div>
                            <div class="col-md-6">
                                <select id="ip-inletValue" name="ip-inletValue[]" class="form-control form-group ip-inletValue">
                                    `+option+`
                                </select>
                            </div>
                        `;

                        inletTitle = "<?php echo $mainformno ?>";

                        
                    }

                    $('#inlet-mainformno').val(mainformno);

                    $('#inlet_show').html(output);
                    $('#inlet_title').html('บันทึก Inlet เอกสารเลขที่ : '+inletTitle);


                },

            })
        }
    }

    function loaddataSticker(formno , prodid , batchnumber , dataareaid , status)
    {
        if(formno != "" && prodid != "" && batchnumber != "" && dataareaid != "" && status != ""){
            // convert status 
            if(status == "Start"){
                status = 0;
            }else if(status == "Stop"){
                status = 1;
            }

            let output =`
                <div class="col-md-12">
                    <div class="container-iframe">

                    <iframe class="" width="100%" height="500px" frameBorder="0" src=" https://intranet.saleecolour.com/intsys/lab_matching/qc/sample/`+formno+`/`+prodid+`/`+batchnumber+`/`+dataareaid+`/2-3-4/`+status+`"></iframe>
                            
                    </div>
                </div>
                `;
                $('#qcsticker').html(output);




  
            // console.log("https://intranet.saleecolour.com/intsys/production_plan/machine/jobcard/"+prodid+"/"+dataareaid+"/2-3-4/0/"+status+"/"+formno+"/");
        }

            console.log(prodid);
            console.log(dataareaid);
            console.log(status);
            console.log(formno);
            console.log(batchnumber);
    }



</script>