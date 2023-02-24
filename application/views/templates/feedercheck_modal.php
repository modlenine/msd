<!-- Modal รายการหลัก -->

<div class="modal fade " id="checkFeeder_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <h5 class="modal-title" id="exampleModalLabel">การตรวจสอบ Feeder</h5> -->
                <div id="show_checkFeeder_modal"></div>
                <button type="button" class="close outputClose" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frm_outputfix" autocomplete="off">
                    <input hidden type="text" name="check_output_mainform" id="check_output_mainform" value="<?= $this->uri->segment(2) ?>">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="">กำหนด Output</label>
                            <input type="number" name="cf_output" id="cf_output" class="form-control">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="">กำหนด ค่าเบี่ยงเบน</label>
                            <div id="show_cf_deviation"></div>
                            
                        </div>
                        <div class="col-md-12 text-center">
                            <button type="button" name="btn_addoutput" id="btn_addoutput" class="btn btn-success">บันทึก</button>
                            <button type="button" name="btn_editoutput" id="btn_editoutput" class="btn btn-warning">แก้ไขรายการ</button>
                        </div>
                    </div>
                </form>
                <div class="divider divider-center"><i class="icon-cloud"></i></div>

            </div>

        </div>
    </div>
</div>
<!-- Modal รายการหลัก -->







<!-- Modal รายการหลัก -->
<div class="modal fade " id="addFeeder_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <h5 class="modal-title" id="exampleModalLabel">การตรวจสอบ <span id="showTxtCheckFeeder"></span> </h5> -->
                <div id="show_addFeeder_modal"></div>
                <button type="button" class="close clsaddFeeder" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-header">
                <div class="row form-group">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-primary btn-newFeederc" id="btn-newFeederc" name="btn-newFeederc">เพิ่มรายการ</button>
                        <button type="button" class="btn btn-primary btn-editFeederc" id="btn-newFeederc" name="btn-newFeederc">แก้ไขรายการเดิม</button>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-12">
                        <div id="showFeederCheckList"></div>
                    </div>
                </div>
            </div>

            <div class="modal-body form-checkFeeder" style="display:none;">
                <form id="frm_saveCheckFeeder">

                <!-- input for check -->
                <input hidden type="text" name="checkAddfAutoid" id="checkAddfAutoid">
                <input hidden type="text" name="checkAddf-mainformno" id="checkAddf-mainformno">
                <input hidden type="text" name="checkAddf-feedername" id="checkAddf-feedername">
                <input hidden type="text" name="checkEdit-fc_autoid" id="checkEdit-fc_autoid">

                <div class="row form-group">
                    <div class="col-md-6">
                        <label for="">รหัสวัตถุดิบ</label>
                        <input type="text" name="addf_rawmaterial" id="addf_rawmaterial" class="form-control" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="">ส่วนผสม %</label>
                        <input type="text" name="addf_value" id="addf_value" class="form-control" readonly>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-6">
                        <label for="">กำหนด Output kg. / hr</label>
                        <input type="text" name="addf_output" id="addf_output" class="form-control" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="">ค่าเบี่ยงเบน</label>
                        <!-- <input type="text" name="getFeederDeviation" id="getFeederDeviation" class="form-control" style="display:none;"> -->
                        <div id="showMainDeviation"></div>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-6">
                        <label for="">น้ำหนักต่อ 1 ชั่วโมง (kg.)</label>
                        <input type="text" name="addf_perhr" id="addf_perhr" class="form-control" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="">เวลาใช้หาน้ำหนัก (นาที)</label>
                        <div id="showMinCalf"></div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-6">
                        <label for="">น้ำหนักต่อ <span id="minText">1</span> นาที (kg.)</label>
                        <input type="text" name="addf_permin" id="addf_permin" class="form-control" readonly>
                    </div>
                </div>
                <div class="divider divider-center"><i class="icon-cloud"></i></div>
                <div class="row">
                    <div id="alertEx"></div>
                    <div class="col-md-12 form-group">
                        <label for="">ตัวอย่างที่ 1</label>
                        <input type="number" name="addf_ex1" id="addf_ex1" class="form-control ex adex">
                    </div>
                    <div class="col-md-12 form-group">
                        <label for="">ตัวอย่างที่ 2</label>
                        <input type="number" name="addf_ex2" id="addf_ex2" class="form-control ex adex">
                    </div>
                    <div class="col-md-12 form-group">
                        <label for="">ตัวอย่างที่ 3</label>
                        <input type="number" name="addf_ex3" id="addf_ex3" class="form-control ex adex">
                    </div>
                    <div class="col-md-12 form-group">
                        <label for="">ตัวอย่างที่ 4</label>
                        <input type="number" name="addf_ex4" id="addf_ex4" class="form-control ex adex">
                    </div>
                    <div class="col-md-12 form-group">
                        <label for="">ตัวอย่างที่ 5</label>
                        <input type="number" name="addf_ex5" id="addf_ex5" class="form-control ex adex">
                    </div>
                    <!-- <div class="col-md-12 form-group text-center">
                        <button type="button" name="btnCalEx" id="btnCalEx" class="btn btn-primary">คำนวณ</button>
                    </div> -->
                    <div class="col-md-12 form-group">
                        <label for="">ค่าเฉลี่ย</label>
                        <input type="text" name="addf_exAvg" id="addf_exAvg" class="form-control ex" readonly>
                    </div>
                    <div class="col-md-12 form-group">
                        <label for="">ค่าเบี่ยงเบน</label>
                        <input type="text" name="addf_accept" id="addf_accept" class="form-control ex" readonly>
                    </div>
                </div>
                <div class="row text-center">
                    <div class="col-md-2"></div>
                    <div class="col-md-4">
                        <div id="checkBoxDiv">
                            <input id="pass" class="checkbox-style radio" name="addf_checkpass" type="checkbox" value="ผ่าน" onclick="return false">
                            <label for="pass" class="checkbox-style-3-label">ผ่าน</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div id="checkBoxDiv">
                            <input id="notpass" class="checkbox-style radio" name="addf_checkpass" type="checkbox" value="ไม่ผ่าน" onclick="return false">
                            <label for="notpass" class="checkbox-style-3-label">ไม่ผ่าน</label>
                        </div>
                    </div>
                    <div class="col-md-2"></div>
                </div>

                <div class="row form-group">
                    <div class="col-md-12">
                        <label for="">หมายเหตุ</label>
                        <textarea name="addf_memo" id="addf_memo" cols="30" rows="5" class="form-control ex adex"></textarea>
                    </div>
                </div>

                <div class="row form-group text-center">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <button type="button" name="btn_saveAddf" id="btn_saveAddf" class="btn btn-success btn-block" disabled>บันทึก</button>
                        <button type="button" name="btn_editAddf" id="btn_editAddf" class="btn btn-warning btn-block">บันทึกการแก้ไข</button>
                        <button type="button" name="btn_delAddfCheck" id="btn_delAddfCheck" class="btn btn-danger btn-block" disabled>ลบรายการ</button>
                        <input type="button" name="btn_closeAddf" id="btn_closeAddf" class="btn btn-secondary btn-block" value="ปิด" data-dismiss="modal">
                    </div>
                    <div class="col-md-4"></div>
                </div>
                </form>
            </div>

        </div>
    </div>
</div>
<!-- Modal รายการหลัก -->










<!-- Modal รายการหลัก -->

<div class="modal fade " id="addCheckMachine_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <h5 class="modal-title" id="exampleModalLabel">การตรวจสอบเครื่องจักร</h5> -->
                <div id="show_addCheckMachine_modal"></div>
                <button type="button" class="close clsCheckMachine" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frm_saveCheckMachine">

                <!-- Check input Zone -->
                <input hidden type="text" name="addMc_checkFormno" id="addMc_checkFormno">
                <input hidden type="text" name="addMc_checkAutoid" id="addMc_checkAutoid">

                    <div class="row form-group">
                        <div class="col-md-4">
                            <div id="checkBoxDiv">
                                <input id="addMc_status1" class="checkbox-style radio" name="addMc_status" type="radio" value="ปกติ">
                                <label for="addMc_status1" class="checkbox-style-3-label">ปกติ</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div id="checkBoxDiv">
                                <input id="addMc_status2" class="checkbox-style radio" name="addMc_status" type="radio" value="ไม่ปกติ">
                                <label for="addMc_status2" class="checkbox-style-3-label">ไม่ปกติ</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div id="checkBoxDiv">
                                <input id="addMc_status3" class="checkbox-style radio" name="addMc_status" type="radio" value="ไม่ได้ใช้งาน">
                                <label for="addMc_status3" class="checkbox-style-3-label">ไม่ได้ใช้งาน</label>
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-12">
                            <label for="">หมายเหตุ</label>
                            <textarea name="addMc_memo" id="addMc_memo" cols="30" rows="3" class="form-control"></textarea>
                        </div>
                    </div>

                    <!-- <div class="row form-group">
                        <div class="col-md-6">
                            <label for="">RM ที่ส่งเช็ค QC</label>
                            <input type="text" name="addMc_emQc" id="addMc_emQc" class="form-control" value="0">
                        </div>
                        <div class="col-md-6">
                            <label for="">ค่า Moisture</label>
                            <input type="number" name="addMc_moisture" id="addMc_moisture" class="form-control" value="0">
                        </div>
                    </div> -->


                    <div class="row form-group text-center">
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            <button type="button" name="btn_saveAddCheckMachine" id="btn_saveAddCheckMachine" class="btn btn-success btn-block" disabled>บันทึก</button>
                            <input type="button" name="btn_closeAddCheckMachine" id="btn_closeAddCheckMachine" class="btn btn-secondary btn-block" data-dismiss="modal" value="ปิด">
                        </div>
                        <div class="col-md-4"></div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<!-- Modal รายการหลัก -->

<script>
    $(document).ready(function(){
        getMin();

        function getMin()
        {
            let m = 60;
            let html ='';
            html +=`
                <select id="addf_min" name="addf_min" class="form-control">
            `;
            for(let i = 1; i <= m ; i++){
                html +=`<option value="`+i+`">`+i+`</option>`;
            }
            html +=`
                </select>
            `;

            $('#showMinCalf').html(html);
        }

        $(document).on('change' , '#addf_min' , function(){
            let summin = 0;
            let min = $(this).val();
            const sumhr = parseFloat($('#addf_perhr').val());

            if($(this).val() != ""){


                summin = (sumhr * min) /60;

                $('#addf_permin').val(summin.toFixed(3));
                $('#minText').html(min);
                $('#addf_ex1 , #addf_ex2 , #addf_ex3 , #addf_ex4 , #addf_ex5').val('');
            }


            // หาค่าเฉลี่ย
            $("#btnCalEx").click(function () {
            calAvg(sumhr, summin);
            });

            $("#addf_ex1").keyup(function () {
            calAvg(sumhr, summin);
            });
            $("#addf_ex2").keyup(function () {
            calAvg(sumhr, summin);
            });
            $("#addf_ex3").keyup(function () {
            calAvg(sumhr, summin);
            });
            $("#addf_ex4").keyup(function () {
            calAvg(sumhr, summin);
            });
            $("#addf_ex5").keyup(function () {
            calAvg(sumhr, summin);
            });

        });



        $(document).on('click' , '.btn-newFeederc' , function(){
            $('.form-checkFeeder').css('display', '');
            $('#btn_editAddf').css('display','none');
            $('#btn_saveAddf').css('display' , '');
            $('#showFeederCheckList').html('');
            $('#btn_delAddfCheck').css('display' , 'none');

            const data_faf_mainformno = $(this).attr("data_faf_mainformno");
            const data_faf_feedername = $(this).attr("data_faf_feedername");
            const data_faf_rawmaterial = $(this).attr("data_faf_rawmaterial");
            const data_faf_value = $(this).attr("data_faf_value");
            const data_faf_autoid = $(this).attr("data_faf_autoid");
            const data_fam_deviation = $("#acf_deviation :selected").val();
            const data_fam_outputhr = $(this).attr("data_fam_outputhr");
            const data_min = $('#addf_min :selected').val();

            const data_prodid = $(this).attr("data_prodid");
            const data_productcode = $(this).attr("data_productcode");
            const data_batchnumber = $(this).attr("data_batchnumber");

            $('#addf_ex1').val('');

            if (data_fam_deviation == "") {
            alert("คุณต้องกำหนด ค่า Output และ ค่าเบี่ยงเบนก่อน");
            } else {
                $("#showTxtCheckFeeder").text(data_faf_feedername);
                $("#addf_rawmaterial").val(data_faf_rawmaterial);
                $("#addf_value").val(data_faf_value);
                $("#addf_output").val(data_fam_outputhr);
                // $('#addf_deviation').val(data_fam_deviation);
                $("#checkAddfAutoid").val(data_faf_autoid);

                $('#checkAddf-mainformno').val(data_faf_mainformno);
                $('#checkAddf-feedername').val(data_faf_feedername);


                // ตรวจสอบว่ามีการบันทึกค่าไปแล้วหรือยัง
                // getDataFeeder(data_faf_autoid, data_faf_mainformno);
                loadDeviation2(data_faf_mainformno, data_faf_autoid);

                // หาค่าน้ำหนักต่อ 1 ชั่วโมง
                const sumperhr =
                (parseFloat(data_faf_value) * parseFloat(data_fam_outputhr)) / 100;
                const sumpermin = (sumperhr * parseFloat(data_min)) / 60;

                // 1 ชม = 60 นาที
                // 1 นาที = 60 วินาที
                // KG ต่อชม = 600
                // KG ต่อ 1 นาที = 10
                //สรุปสูตรคือ จำนวนกิโลต่อนาที = (จำนวนกิโลต่อชม x นาที) / 60 
                //เช่น  A = (600*2)/60  Answer = 20

                let useSumHr = 0;
                let useSumMin = 0;

                if (isNaN(sumperhr) == true) {
                useSumHr = "";
                } else {
                useSumHr = sumperhr.toFixed(3);
                }

                if (isNaN(sumpermin) == true) {
                useSumMin = "";
                } else {
                useSumMin = sumpermin.toFixed(3);
                }

                $("#addf_perhr").val(useSumHr);
                $("#addf_permin").val(useSumMin);

                // หาค่าเฉลี่ย
                $("#btnCalEx").click(function () {
                calAvg(sumperhr, sumpermin);
                });

                $("#addf_ex1").keyup(function () {
                calAvg(sumperhr, sumpermin);
                });
                $("#addf_ex2").keyup(function () {
                calAvg(sumperhr, sumpermin);
                });
                $("#addf_ex3").keyup(function () {
                calAvg(sumperhr, sumpermin);
                });
                $("#addf_ex4").keyup(function () {
                calAvg(sumperhr, sumpermin);
                });
                $("#addf_ex5").keyup(function () {
                calAvg(sumperhr, sumpermin);
                });
            }
        });


        $(document).on('click' , '.btn-editFeederc' , function(){
            const fc_feederid = $(this).attr('data_faf_autoid');
            if(fc_feederid != ""){
                getFeederCheckListByFeederid(fc_feederid);
                $('.form-checkFeeder').css('display','none');
            }
        });

        function getFeederCheckListByFeederid(fc_feederid)
        {
            if(fc_feederid != ""){
                $.ajax({
                    url:"/intsys/msd/main/getFeederCheckListByFeederid",
                    method:"POST",
                    data:{
                        fc_feederid:fc_feederid
                    },
                    beforeSend:function(){},
                    success:function(res){
                        console.log(JSON.parse(res));
                        if(JSON.parse(res).status == "Select Data Success"){
                            let result = JSON.parse(res).result;
                            let html = `
                            <select id="feederList" name="feederList" class="form-control feederList">
                                <option value="">กรุณาเลือกรายการ</option>
                            `;

                            for(let i = 0; i < result.length; i++){
                                html +=`
                                <option value="`+result[i].fc_autoid+`">`+result[i].fc_feedername+` ( `+result[i].fc_linenum+` )</option>
                                `;
                            }

                            html +=`
                            </select>
                            `;

                            $('#showFeederCheckList').html(html);


                        }
                    }
                });
            }
        }


        $(document).on('change' , '.feederList' , function(){
            const feedercheckId = $(this).val();
            if(feedercheckId != ""){
                $('.form-checkFeeder').css('display','');
                $('#btn_saveAddf').css('display' , 'none');
                $('#btn_delAddfCheck').prop('disabled' , false);
                $('#btn_editAddf').css('display' , '');
                $('#btn_delAddfCheck').css('display' , '');
                getFeedercheckDataForEdit(feedercheckId);
            }
        });

        function getFeedercheckDataForEdit(feedercheckId)
        {
            $.ajax({
                url:"/intsys/msd/main/getFeedercheckDataForEdit",
                method:"POST",
                data:{
                    feedercheckId:feedercheckId
                },
                beforeSend:function(){},
                success:function(res){
                    console.log(JSON.parse(res));
                    if(JSON.parse(res).status == "Select Data Success"){
                        let result = JSON.parse(res).result;
                        $("#showTxtCheckFeeder").text();
                        $("#addf_rawmaterial").val(result.fc_rawmaterial);
                        $("#addf_value").val(result.fc_feedervalue);
                        $("#addf_output").val(result.fc_outputhr);
                        // $('#addf_deviation').val(data_fam_deviation);
                        $('#addf_min option[value="'+result.fc_feedermin+'"]').prop("selected" , true);
                        $('#checkEdit-fc_autoid').val(result.fc_autoid);


                        // ตรวจสอบว่ามีการบันทึกค่าไปแล้วหรือยัง
                        // getDataFeeder(data_faf_autoid, data_faf_mainformno);
                        loadDeviation2(result.fc_mainformno, result.fc_feederid);

                        // หาค่าน้ำหนักต่อ 1 ชั่วโมง
                        const sumperhr =
                        (parseFloat(result.fc_feedervalue) * parseFloat(result.fc_outputhr)) / 100;
                        const sumpermin = (sumperhr * parseFloat(result.fc_feedermin)) / 60;

                        // 1 ชม = 60 นาที
                        // 1 นาที = 60 วินาที
                        // KG ต่อชม = 600
                        // KG ต่อ 1 นาที = 10
                        //สรุปสูตรคือ จำนวนกิโลต่อนาที = (จำนวนกิโลต่อชม x นาที) / 60 
                        //เช่น  A = (600*2)/60  Answer = 20

                        let useSumHr = 0;
                        let useSumMin = 0;

                        if (isNaN(sumperhr) == true) {
                        useSumHr = "";
                        } else {
                        useSumHr = sumperhr.toFixed(3);
                        }

                        if (isNaN(sumpermin) == true) {
                        useSumMin = "";
                        } else {
                        useSumMin = sumpermin.toFixed(3);
                        }

                        $("#addf_perhr").val(result.fc_feederkghr);
                        $("#addf_permin").val(result.fc_feederkgmin);

                        $('#addf_ex1').val(result.fc_feederex1);
                        $('#addf_ex2').val(result.fc_feederex2);
                        $('#addf_ex3').val(result.fc_feederex3);
                        $('#addf_ex4').val(result.fc_feederex4);
                        $('#addf_ex5').val(result.fc_feederex5);
                        $('#addf_exAvg').val(result.fc_feederexavg);
                        $('#addf_accept').val(result.fc_feederaccept);
                        
                        if(result.fc_status == "ผ่าน"){
                            $('input:checkbox[id="pass"]').prop("checked", true);
                            $('input:checkbox[id="notpass"]').prop("checked", false);
                        }else if(result.fc_status == "ไม่ผ่าน"){
                            $('input:checkbox[id="pass"]').prop("checked", false);
                            $('input:checkbox[id="notpass"]').prop("checked", true);
                        }
                        // หาค่าเฉลี่ย
                        $("#btnCalEx").click(function () {
                        calAvg(sumperhr, sumpermin);
                        });

                        $("#addf_ex1").keyup(function () {
                        calAvg(sumperhr, sumpermin);
                        });
                        $("#addf_ex2").keyup(function () {
                        calAvg(sumperhr, sumpermin);
                        });
                        $("#addf_ex3").keyup(function () {
                        calAvg(sumperhr, sumpermin);
                        });
                        $("#addf_ex4").keyup(function () {
                        calAvg(sumperhr, sumpermin);
                        });
                        $("#addf_ex5").keyup(function () {
                        calAvg(sumperhr, sumpermin);
                        });
                    }
                }

            });
        }

        $('#btn_editAddf').click(function(){
            if($('#checkEdit-fc_autoid').val() != ""){

                $.ajax({
                    url:"/intsys/msd/main/saveEditFeederCheck",
                    method:"POST",
                    data:$('#frm_saveCheckFeeder').serialize(),
                    beforeSend:function(){},
                    success:function(res){
                        console.log(JSON.parse(res));
                        if(JSON.parse(res).status == "Update Data Success"){
                            swal({
                                type: 'success',
                                title: 'อัพเดตข้อมูลสำเร็จ',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function(){
                                // location.reload();
                                $('#showFeederCheckList').html('');
                                let mainformno = $("#view_loadMainData").val();
                                loadReportFarrel(mainformno);
                                // loadReportCheckMachine(mainformno);
                                // loadBomReport(mainformno);
                                // loadBomMixReport(mainformno);

                                $(".ex").val("");
                                $('input:checkbox[id="notpass"]').prop("checked", false);
                                $('input:checkbox[id="pass"]').prop("checked", false);
                                $("#btn_saveAddf").prop("disabled", false);

                                $("#addFeeder_modal").modal("hide");
                                $('.form-checkFeeder').css('display','none');
                            });
                        }
                    }
                });
            }
        });

        $('#btn_delAddfCheck').click(function(){
            if($('#checkEdit-fc_autoid').val() != ""){
                let fc_autoid = $('#checkEdit-fc_autoid').val();

                swal({
                    title: 'ท่านต้องการลบรายการนี้ ใช่หรือไม่',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    confirmButtonText: 'ยืนยัน',
                    cancelButtonText:'ยกเลิก'
                }).then((result)=> {
                    if(result.value == true){
                        deleteFeederCheckList(fc_autoid);
                    }
                });


            }
        });
        function deleteFeederCheckList(fc_autoid)
        {
            if(fc_autoid != ""){
                $.ajax({
                    url:"/intsys/msd/main/deleteFeederCheckList",
                    method:"POST",
                    data:{
                        fc_autoid:fc_autoid
                    },
                    beforeSend:function(){},
                    success:function(res){
                        console.log(JSON.parse(res));
                        if(JSON.parse(res).status == "Delete Data Success"){
                            swal({
                                type: 'success',
                                title: 'ลบข้อมูลสำเร็จ',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function(){
                                // location.reload();
                                $('#showFeederCheckList').html('');
                                let mainformno = $("#view_loadMainData").val();
                                loadReportFarrel(mainformno);
                                // loadReportCheckMachine(mainformno);
                                // loadBomReport(mainformno);
                                // loadBomMixReport(mainformno);

                                $(".ex").val("");
                                $('input:checkbox[id="notpass"]').prop("checked", false);
                                $('input:checkbox[id="pass"]').prop("checked", false);
                                $("#btn_saveAddf").prop("disabled", false);

                                $("#addFeeder_modal").modal("hide");
                                $('.form-checkFeeder').css('display','none');
                            });
                        }
                    }
                });
            }
        }

    });
</script>