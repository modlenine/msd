<!-- Modal Create Template -->
<div class="modal fade " id="select_template_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <form id="frm_saveEditTemplate" autocomplete="off">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Template : <span id="selectTempTitle"></span></h5>
                <button type="button" class="close select_template_modal_close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-header subhead">
                <button type="button" id="btnSelectTemplate_edit" name="btnSelectTemplate_edit" class="button button-amber">แก้ไข</button>
                <button style="display:none;" type="button" id="btnSelectTemplate_canceledit" class="button button-amber select_template_modal_close">ยกเลิกแก้ไข</button>
                <button style="display:none;" type="button" id="btnSaveSelectTemplate_edit" class="button button-green">บันทึก</button>
                <button type="button" id="btnSelectTemplate_delete" name="btnSelectTemplate_delete" class="button button-red">ลบ</button>
                <button type="button" id="btnSelectTemplate_overall" class="button button-gray">ดูภาพรวม</button>
                <button type="button" id="btnBomTemplte" class="button button-gray btnBomTemplteClick">ผูกสูตร BOM</button>
                <button type="button" id="btnBomTemplteEdit" class="button button-gray btnBomTemplteEdit" style="display:none;">แก้ไขสูตร BOM</button>
                <button type="button" id="btnSelectTemplate_close" class="button button-gray select_template_modal_close" data-dismiss="modal">ปิด</button>
            </div>

            <input hidden type="text" name="select_check_templatename" id="select_check_templatename">
            <input hidden type="text" name="select_check_templateitemuse" id="select_check_templateitemuse">
            <input hidden type="text" name="select_check_templateimage" id="select_check_templateimage">
            <input hidden type="text" name="select_checkOtherImagePath" id="select_checkOtherImagePath">
            <input hidden type="text" name="checkEditStatus" id="checkEditStatus">
            <input hidden type="text" name="checkDataareaid" id="checkDataareaid">


            <div class="modal-body select_showdata">
                
                <div class="row form-group">
                    <div class="col-md-4">
                        <img id="select_template_imageshow" width="200" height="200">
                    </div>
                    <div class="col-md-8">

                        <!-- <div class="row form-group">
                            <div class="col">
                                <label for="">อัพโหลดรูปภาพ Template</label>
                                <input type="file" name="ted_template_image[]" id="ted_template_image" accept="image/*" onchange="loadFileCreate(event)" class="form-control" readonly>
                            </div>
                        </div> -->

                        <div class="row form-group">
                            <div class="col">
                                <label>ชื่อ Template : </label>
                                <input type="text" name="select_template_name" id="select_template_name" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col">
                                <label>Product ที่ใช้งาน : </label>
                                <input type="text" name="select_template_itemid" id="select_template_itemid" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col">
                                <label>บริษัท : </label>
                                <input type="text" name="select_template_dataareaid" id="select_template_dataareaid" class="form-control" readonly>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-12">
                        <label for=""><b>รูปภาพอื่นๆ</b></label>
                        <div id="show_templateotherimage"></div>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-12">
                        <label for=""><b>หมายเหตุ</b></label>
                        <textarea name="select_template_memo" id="select_template_memo" cols="30" rows="10" class="form-control" style="height:100px;" readonly></textarea>
                    </div>
                </div>

                <div id="alert_create_new_template"></div>
                <div class="divider divider-center"><i class="icon-line-chevron-down"></i></div>

                <div class="row form-group">
                    <div class="col-md-12">
                        <input type="text" name="searchRunscreenMaster_edit" id="searchRunscreenMaster_edit" class="form-control mb-2" placeholder="Search RunScreen Master">
                        <label for="">Total Item : <span id="searchRunTitle_edit1"></span> รายการ</label>
                        <div id="show_select_runscreen"></div>
                    </div>
                </div>


                <div class="row form-group">
                    <div class="col-md-12">
                        <div class="card mb-3">
                            <div class="card-header text-white bg-primary">Feeder Template</div>
                            <div class="card-body">
                                <div class="row form-group">
                                    <div id="showFeederTemplate" class="col-md-12"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-12">
                        <div class="card mb-3">
                            <div class="card-header text-white bg-primary">Bom Template</div>
                            <div class="card-body">
                                <div class="row form-group">
                                    <div id="showBomTemplate" class="col-md-12 form-group"></div>
                                    <div id="showBomMixTemplate" class="col-md-12 form-group"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="modal-body select_editdata" style="display:none;">
                
                <div class="row form-group">
                    <div class="col-md-4">
                        <img id="select_edit_template_imageshow" width="200" height="200">
                    </div>
                    <div class="col-md-8">

                        <div class="row form-group">
                            <div class="col">
                                <label for="">อัพโหลดรูปภาพ Template</label>
                                <input type="file" name="select_edit_template_image[]" id="select_edit_template_image" accept="image/*" onchange="loadFileCreateEdit(event)" class="form-control">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col">
                                <label>ชื่อ Template : </label>
                                <input type="text" name="select_edit_template_name" id="select_edit_template_name" class="form-control" >
                                <input hidden type="text" name="select_edit_template_name_new" id="select_edit_template_name_new">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col">
                                <label>Product ที่ใช้งาน : </label>
                                <input type="text" name="select_edit_template_itemid" id="select_edit_template_itemid" class="form-control text-uppercase">
                                <input hidden type="text" name="select_edit_template_itemid_new" id="select_edit_template_itemid_new">
                                <div id="create_new_template_itemid_search_edit"></div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col">
                                <label for="">บริษัท : </label>
                                <select name="select_edit_template_dataareaid" id="select_edit_template_dataareaid" class="form-control">
                                    <option value="">กรุณาเลือกบริษัท</option>
                                    <option value="ca">Composite Asia Co.,Ltd</option>
                                    <option value="poly">Poly Meritasia Co.,Ltd.</option>
                                    <option value="sln">Salee Colour Public Company Limited.</option>
                                </select>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-12">
                        <label for=""><b>รูปภาพอื่นๆ</b></label>
                        <div id="show_edit_templateotherimage"></div>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-12">
                        <label for="">อัพโหลดรูปภาพอื่นๆ</label>
                        <input id="select_edit_template_otherImage" name="select_edit_template_otherImage[]" type="file" class="file" multiple data-show-upload="false" data-show-caption="true" data-show-preview="true" accept="image/*">
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-12">
                        <label for=""><b>หมายเหตุ</b></label>
                        <textarea name="select_edit_template_memo" id="select_edit_template_memo" cols="30" rows="10" class="form-control" style="height:100px;"></textarea>
                    </div>
                </div>

                <div id="alert_select_edit_template"></div>
                <div class="divider divider-center"><i class="icon-line-chevron-down"></i></div>

                <div class="row">
                    <div class="col-md-6">
                        <input type="text" name="select_edit_searchRunscreenMaster" id="select_edit_searchRunscreenMaster" class="form-control mb-2" placeholder="Search RunScreen Master">
                        <label for="">Total Item : <span id="searchRunTitle_edit"></span> รายการ</label>
                        <div id="show_runscreen_master2_edit"></div>
                        <div id="show_runscreen_master3_edit"></div>
                        <!-- Input Zone -->
                        <input hidden type="text" name="run_name_use_edit" id="run_name_use_edit">
                        <input hidden type="text" name="run_type_use_edit" id="run_type_use_edit">
                        <input hidden type="text" name="run_minvalue_use_edit" id="run_minvalue_use_edit">
                        <input hidden type="text" name="run_maxvalue_use_edit" id="run_maxvalue_use_edit">
                        <input hidden type="text" name="run_spoint_use_edit" id="run_spoint_use_edit">
                        <input hidden type="text" name="run_linenum_use_edit" id="run_linenum_use_edit">

                        <input hidden type="text" name="linenumUsedArray_edit" id="linenumUsedArray_edit" style="width:100%">
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="select_edit_searchRunscreenTemp" id="select_edit_searchRunscreenTemp" class="form-control mb-2" placeholder="Search RunScreen Selected">
                        <label for="">Select Item : <span id="searchRunTempTitle_edit"></span> รายการ</label>
                        <div id="show_pick_runscreen2_edit"></div>
                    </div>
                </div>

            </div>

        </div>
    </form>
    </div>
</div>
<!-- Modal Create Template -->




<!-- Modal Edit Run Template -->
<div class="modal fade " id="edit_runscreen_selectTemplate_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <form id="frm_edit_runscreen_edit" autocomplete="off">
        <div class="modal-content editRSC">
            <div class="modal-header">
                <span id="editRSCTitle_edit"></span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
                <div class="row form-group">
                    <div class="col-lg-6 form-group">
                        <label for="">Min Value</label>
                        <input type="text" name="editRSC_min_edit" id="editRSC_min_edit" class="form-control">
                    </div>
                    <div class="col-lg-6 form-group">
                        <label for="">Max Value</label>
                        <input type="text" name="editRSC_max_edit" id="editRSC_max_edit" class="form-control">
                    </div>
                    <div class="col-lg-6 form-group">
                        <label for="">SPoint Value</label>
                        <input type="text" name="editRSC_spoint_edit" id="editRSC_spoint_edit" class="form-control">
                    </div>
                </div>

                <input hidden type="text" name="editRSC_autoid_edit" id="editRSC_autoid_edit">
                <input hidden type="text" name="editRSC_templatename_edit" id="editRSC_templatename_edit">

                <div class="row form-group">
                    <div class="col-lg-12">
                        <button type="button" class="button button-green" id="save_frm_edit_runscreen_edit">บันทึก</button>
                        <button type="button" class="button button-red" id="cancel_frm_edit_runscreen_edit" data-dismiss="modal">ยกเลิก</button>
                    </div>
                </div>

            </div>
        </div>
        </form>
    </div>
</div>
<!-- Modal Create Template -->



<!-- Modal Edit Run Template -->
<div class="modal fade " id="spinner_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content editRSC">
            
            <div class="modal-body">
                
            <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>

            </div>
        </div>
    </div>
</div>
<!-- Modal Create Template -->





<!-- Modal Edit Run Template -->
<div class="modal fade " id="overall_selectTemplate_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">

        <div class="modal-content">
            <div class="modal-header">
                <span id="overall_title"></span>
                <button type="button" class="close close_overall" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <div id="show_overall_table"></div>
                    </div>
                    <div class="col-md-2"></div>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- Modal Create Template -->



<!-- Modal add bom template -->
<div class="modal fade " id="addBomTemplate_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg upsizeLg modal-dialog-centered modal-dialog-scrollable">
        
        <div class="modal-content">
            <div class="modal-header">
                <span>ผูก Bom เข้ากับ Template</span>
                <button type="button" class="close closeBomTemplate_md" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div id="chooseBomversion_section" class="row form-group">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <label for="">เลือก Bom Version</label>
                        <select name="bom_version_select" id="bom_version_select" class="form-control"></select>
                    </div>
                    <div class="col-md-4"></div>
                </div>
                
                <div id="feeder_bom_section" class="row form-group" style="display:none;">
                    <div class="col-md-12 col-xl-6">
                        <h5><u>Feeder</u></h5>
                        <!-- Load Feeder temp -->
                        <button class="btn btn-warning editInlet_template">
                            <i class="icon-line-edit intletI"></i> Inlet
                        </button>
                        <div id="loadFeederTemp_bom"></div>
                    </div>
                    <div class="col-md-12 col-xl-6">
                        <!-- โหลด Bom มาจาก Database -->
                        <h5><u>Bom Original</u></h5>
                        <div id="loadGetBom_template"></div>
                        <span id="textStartBtn" style="color:#CC0000">*หากรายการใดต้องทำการแบ่ง Mix แนะนำให้แบ่งรายการนั้นใส่ Feeder ก่อน Mix*</span>
                        <br>
                        <h5><u>Bom Mix</u></h5>
                        <div id="loadGetBomMix_template"></div>
                    </div>
                </div>
                <hr>
                <div class="row form-group confirm-btn-section" style="display:none;">
                    <div class="col-md-12 text-center">
                        <button type="button" id="btn-confirmBomTemplate" name="btn-confirmBomTemplate" class="button button-xlarge button-circle button-green btn-confirmBomTemplate">บันทึก Bom Template</button>
                    </div>
                </div>
                <div class="row form-group edit-btn-section" style="display:none;">
                    <div class="col-md-12 text-center">
                        <button type="button" id="btn-editBomTemplate" name="btn-editBomTemplate" class="button button-xlarge button-circle button-green btn-editBomTemplate">บันทึกการแก้ไข Bom Template</button>
                    </div>
                </div>



            </div>
        </div>
        
    </div>
</div>
<!-- Modal add bom template -->


<!-- Modal เมนู BOM-->
<div class="modal fade bgBomTemplate1" id="md_bom_template" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">คุณต้องการทำอะไร ?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div id="md_bom_canuse_template" class="row">
                    <div class="col-md-12" id="cbtn_addmat_template">
                        <button type="button" name="btn_addmat_template" id="btn_addmat_template" class="button button-xlarge button-circle button-green btn_addmatMix_tmp" style="width:100%">ใส่วัตถุดิบ</button>
                    </div>
                    <div class="col-md-12">
                        <button type="button" name="btn_mixmat_template" id="btn_mixmat_template" class="button button-xlarge button-circle button-green" style="width:100%">Mix</button>
                    </div>
                    <div id="md_bom_cancelMix_template" class="col-md-12" style="display:none;">
                        <input hidden type="text" name="can_mainformno" id="can_mainformno">
                        <button type="button" name="btn_canMixmat_template" id="btn_canMixmat_template" class="button button-xlarge button-circle button-red btn_canMixmat_template" style="width:100%">ยกเลิกการ Mix ทั้งหมด</button>
                    </div>
                </div>

                <div id="md_bom_notuse_template" class="row" style="display:none;">
                    <div class="col-md-12">
                        <h3 class="text-center">วัตถุดิบนี้ถูกใช้ไปหมดแล้ว</h3>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- Modal เมนู BOM -->


<!-- Modal Mix วัตถุดิบ  -->
<div class="modal fade bgBomTemplate1" id="md_mixmatFeeder_template" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="false" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">กรุณาเลือกวัตถุดิบสำหรับ Mix</h5>
                <button id="close_md_saveMix" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="confirmMix_frm" autocomplete="off">

                    <input hidden type="text" name="mix_mainformno" id="mix_mainformno">
                    <input hidden type="text" name="mix_prodid" id="mix_prodid">

                    <div class="row">
                        <div class="col-md-12 form-group">
                            <!-- แสดงข้อมูล Bom สำหรับ Mix -->
                            <h5><u>Bom</u></h5>
                            <div id="showBomMix_tmp"></div>
                            <!-- แสดงข้อมูล Bom สำหรับ Mix -->
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="">รายการ Mix</label>
                            <input type="text" name="mixDataInput_tmp" id="mixDataInput_tmp" class="form-control" readonly>
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="">จำนวน Mix (%)</label>
                            <input type="text" name="mixValueDataInput_tmp" id="mixValueDataInput_tmp" class="form-control" readonly>
                        </div>
                        <div class="col-md-12 form-group">
                            <button type="button" name="btn_adddataMix_tmp" id="btn_adddataMix_tmp" class="button button-small button-circle button-green">ยืนยันการ Mix</button>
                            <!-- <button type="button" name="btn_clearDatafeeder" id="btn_clearDatafeeder" class="button button-small button-circle button-amber">ล้างข้อมูล Mix</button> -->
                        </div>
                    </div>
                </form>

                <div class="divider divider-center"><i class="icon-line-chevron-down"></i></div>

                <div class="row">
                    <div class="col-md-12">
                        <h5><u>Bom Mix</u></h5>
                        <div id="showBomMix2_tmp"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Mix วัตถุดิบ  -->


<!-- Modal Mix วัตถุดิบ  -->
<div class="modal fade " id="md_getValueForMix_template" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="false" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">กรุณากำหนดปริมาณสำหรับ Mix</h5>
                <button id="close_md_getValMix" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="getValueConfirmMix" autocomplete="off">

                    <div class="row">
                        <div class="col-md-12 form-group">
                            <!-- แสดงข้อมูล Bom สำหรับ Mix -->
                            <h5>Item : <span id="gv_item"></span></h5>
                            <input type="text" name="gv_bom" id="gv_bom" class="form-control">

                            <input type="text" name="gv_b_autoid" id="gv_b_autoid">
                            <input type="text" name="gv_b_prodid" id="gv_b_prodid">
                            <input type="text" name="gv_mainformNo" id="gv_mainformNo">
                            <input type="text" name="gv_rawmat" id="gv_rawmat">
                            <!-- แสดงข้อมูล Bom สำหรับ Mix -->
                        </div>
                        <div class="col-md-12 form-group">
                            <button type="button" id="gv_btn_confirm" name="gv_btn_confirm" class="btn btn-primary btn-block">ยืนยัน</button>
                        </div>


                    </div>
                </form>

                <div class="divider divider-center"><i class="icon-line-chevron-down"></i></div>


            </div>
        </div>
    </div>
</div>
<!-- Modal Mix วัตถุดิบ  -->


<!-- Modal ใส่วัตถุดิบลง Feeder  -->
<div class="modal fade bg_addmatFeeder" id="md_addmatFeeder_template" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="false" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <h5 class="modal-title" id="exampleModalLabel">กรุณาเลือก Feeder สำหรับ <span id="textMatname"></span></h5> -->
                <div id="showDetail_md_addmatFeeder_tm"></div>
                <button id="close_md_addmatFeeder" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="feeder_frm_template" autocomplete="off">
                    <div class="row">
                        <div class="col-md-12">
                            <b><span>ชื่อวัตถุดิบ : </span><span id="textMatname2_tm"></span></b>&nbsp;&nbsp;&nbsp;<b><span>จำนวน : </span><span id="textValue_tm"></span> %</b>&nbsp;&nbsp;&nbsp;<b><span>จำนวนคงเหลือ : </span><span id="textValue2_tm"></span> %</b>
                        </div>
                    </div>
                    <div class="divider divider-center"><i class="icon-line-chevron-down"></i></div>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="">เลือก Feeder</label>
                            <!-- Feeder list from databas -->
                            <select name="chooseFeeder_template" id="chooseFeeder_template" class="form-control"></select>
                            <!-- Feeder list from databas -->
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="">จำนวนวัตถุดิบ (%)</label>
                            <input type="number" name="md_value_template" id="md_value_template" class="form-control">
                            <div id="alertMdvalue"></div>
                        </div>

                        <!-- Check Zone -->
                        <input hidden type="text" name="md_templatename_tm" id="md_templatename_tm">
                        <input hidden type="text" name="md_itemid_tm" id="md_itemid_tm">
                        <input hidden type="text" name="md_rawmaterial_tm" id="md_rawmaterial_tm">
                        <input hidden type="text" name="md_dataareaid_tm" id="md_dataareaid_tm">
                        <input hidden type="text" name="md_bomid_tm" id="md_bomid_tm">
                        <input hidden type="text" name="md_autoid_tm" id="md_autoid_tm">
                        <input hidden type="text" name="md_qtyuse_tm" id="md_qtyuse_tm">

                        <input hidden type="text" id="md_qtyBalance_tm" name="md_qtyBalance_tm">
                        <input hidden type="text" name="md_qtyuseCal_tm" id="md_qtyuseCal_tm">

                        <div class="col-md-12 form-group">
                            <button type="button" name="btn_adddatafeeder_template" id="btn_adddatafeeder_template" class="btn btn-success btn_adddatafeeder_template">ยืนยัน</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal ใส่วัตถุดิบลง Feeder -->



<!-- Modal Inlet -->
<div class="modal fade bg_addmatFeeder" id="inlet_template_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-md modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><span id="inlet_template_title"></span></h5><br>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form id="saveInlet_template_frm" autocomplete="off">
                    <!-- Check zone -->
                    <input hidden type="text" name="templatename_inlet" id="templatename_inlet">
                    <input hidden type="text" name="itemid_inlet" id="itemid_inlet">
                    <input hidden type="text" name="dataareaid_inlet" id="dataareaid_inlet">

                    <div id="inlet_template_show" class="row form-group"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" id="btn-saveInlet_template" name="btn-saveInlet_template" class="btn btn-info">บันทึก</button>
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>
<!-- Modal Inlet -->




<script>
    $(document).ready(function(){


        $('#btnSelectTemplate_edit').click(function(){

            const templatename = $('#select_check_templatename').val();
            const templateitemuse = $('#select_check_templateitemuse').val();
            const templateimage = $('#select_check_templateimage').val();
            const ecode = $('#checkSessionEcode').val();

            // Check ก่อนว่ามีคนอื่นแก้ไขรายการนี้อยู่หรือไม่
            checkDataTempBefore(templatename , templateitemuse , templateimage , ecode);
            // Check ก่อนว่ามีคนอื่นแก้ไขรายการนี้อยู่หรือไม่
            $('#checkEditStatus').val('แก้ไข');
            $('.iOtherImageDel').css('display' , '');

        });

        $('#btnSelectTemplate_canceledit').click(function(){
            $('#checkEditStatus').val();
            $('.select_showdata').css('display' , '');
            $('.select_editdata').css('display' , 'none');

            $('#btnSelectTemplate_edit').css('display' , '');
            $('#btnSelectTemplate_canceledit').css('display' , 'none');

            $('#btnSaveSelectTemplate_edit').css('display' , 'none');

            $('#select_edit_template_name_new , #select_edit_template_itemid_new').val('');
            
        });


        $('#btnSelectTemplate_delete').click(function(){
            const templatename = $('#select_check_templatename').val();
            const templateimage = $('#select_check_templateimage').val();
            swal({
                title: 'คุณต้องการลบ Template นี้ใช่หรือไม่',
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'ยืนยัน',
                cancelButtonText:'ยกเลิก'
            }).then((result)=>{
                if(result.value == true){
                    //Function Delete Rawmaterial
                    deleteTemplate(templatename , templateimage);
                }
            });
        });


        $('#select_edit_template_name').keyup(function(){
            const templatenamenew = $(this).val();
            $('#select_edit_template_name_new').val(templatenamenew);
            if($(this).val() == $('#select_check_templatename').val()){
                $('#select_edit_template_name_new').val('');
            }
        });

        $('#select_edit_template_itemid').keyup(function(){
            const templateitemidnew = $(this).val();
            $('#select_edit_template_itemid_new').val(templateitemidnew);
            if($(this).val() == $('#select_check_templateitemuse').val()){
                $('#select_edit_template_itemid_new').val('');
            }
        });


        $('#select_edit_searchRunscreenMaster').keyup(function(){
                const linenum = $('#linenumUsedArray_edit').val();
                const searchRunMaster = $('#select_edit_searchRunscreenMaster').val();
                loadRunScrMasUsed_edit( linenum , 'edit_template' , searchRunMaster);
            
        });

        $('#select_edit_searchRunscreenTemp').keyup(function(){
            const templatename = $('#select_check_templatename').val();
            const searchRunTemp = $('#select_edit_searchRunscreenTemp').val();
            loadRunScrFromTempTable_edit(templatename , 'edit_template' , searchRunTemp);
        });


        $('#searchRunscreenMaster_edit').keyup(function(){
            const value = $(this).val().toLowerCase();
            $('.runScSelectLi').filter(function(){
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });



        // Function Run Screen Master
        
        $(document).on('click' , '.runScMaster_attr_edit',function(){

            // Check Input null
            if($('#select_edit_template_name').val() != "" && $('#select_edit_template_itemid').val() != ""){

                    $('#select_edit_template_name').removeClass("inputNull").addClass("inputSuccess");
                    $('#select_edit_template_itemid').removeClass("inputNull").addClass("inputSuccess");

                    const data_run_autoid = $(this).attr("data_run_autoid");
                    const data_run_name = $(this).attr("data_run_name");
                    const data_run_minvalue = $(this).attr("data_run_minvalue");
                    const data_run_maxvalue = $(this).attr("data_run_maxvalue");
                    const data_run_spoint = $(this).attr("data_run_spoint");
                    const data_run_linenum = $(this).attr("data_run_linenum");
                    const data_run_type = $(this).attr("data_run_type");

                    $('#run_name_use_edit').val(data_run_name);
                    $('#run_type_use_edit').val(data_run_type);
                    $('#run_minvalue_use_edit').val(data_run_minvalue);
                    $('#run_maxvalue_use_edit').val(data_run_maxvalue);
                    $('#run_spoint_use_edit').val(data_run_spoint);
                    $('#run_linenum_use_edit').val(data_run_linenum);


                    // Check Array value
                    if($('#linenumUsedArray_edit').val() == ""){
                        objGroup = [];
                        objGroup.push(data_run_linenum);
                        $('#linenumUsedArray_edit').val(objGroup);
                    }else{
                        const stringArray = $('#linenumUsedArray_edit').val();
                        let arrayFromCon = stringArray.split(",");
                        arrayFromCon.push(data_run_linenum);
                        $('#linenumUsedArray_edit').val(arrayFromCon);
                        console.log(arrayFromCon);
                    }

                    // checkTemplateNameDuplicate2_edit(template_newname);
                    saveRunScrToTempTable_edit();
                


            }else{
                $('#select_edit_template_name , #select_edit_template_itemid').addClass("inputNull");
                $('#alert_select_edit_template').fadeIn();
                $('#alert_select_edit_template').html('<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>กรุณากรอกข้อมูลที่สำคัญให้ครบถ้วนด้วยค่ะ</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                $('#alert_select_edit_template').delay(2000).fadeOut(500);
            }
        });



        $(document).on('click' , '.runScMasTempI_edit' , function(){
            const data_mat_autoid = $(this).attr("data_mat_autoid");
            const data_mat_master_linenum = $(this).attr("data_mat_master_linenum");
            const data_mat_machine_name = $(this).attr("data_mat_machine_name");

            let linenumUsedRe = $('#linenumUsedArray_edit').val();
            const usingSpread = linenumUsedRe.split(",");

            let masterLinenum = usingSpread.filter(function(value , index , arr){
                return value != data_mat_master_linenum;
            });

            $('#linenumUsedArray_edit').val(masterLinenum);
            loadRunScrMasUsed_edit($('#linenumUsedArray_edit').val() , 'edit_template' , $('#select_edit_searchRunscreenMaster').val());
            countTotalRunmaster_edit($('#linenumUsedArray_edit').val());
            delRunScrFromTempTable_edit(data_mat_autoid , data_mat_machine_name);

            console.log("Old"+usingSpread+" New"+masterLinenum);
            
        });



        $(document).on('click' , '.runScMasTempIedit_edit' , function(){
            const data_mat_autoid = $(this).attr("data_mat_autoid");
            const data_mat_min_value = $(this).attr("data_mat_min_value");
            const data_mat_max_value = $(this).attr("data_mat_max_value");
            const data_mat_spoint_value = $(this).attr("data_mat_spoint_value");
            const data_mat_column_name = $(this).attr("data_mat_column_name");
            const data_mat_machine_type = $(this).attr("data_mat_machine_type");
            const data_mat_machine_name = $(this).attr("data_mat_machine_name");

            $('#edit_runscreen_selectTemplate_modal').modal('show');

            $('#editRSCTitle_edit').html('<b>'+data_mat_column_name+'</b>');
            $('#editRSC_min_edit').val(data_mat_min_value);
            $('#editRSC_max_edit').val(data_mat_max_value);
            $('#editRSC_spoint_edit').val(data_mat_spoint_value);
            $('#editRSC_autoid_edit').val(data_mat_autoid);
            $('#editRSC_templatename_edit').val(data_mat_machine_name);

        });


        $('#save_frm_edit_runscreen_edit').click(function(){
            save_edittemplate_editrun();
        });



        $(document).on('click' , '.runScUpI_edit' , function(){
            
            const data_mat_autoid = $(this).attr("data_mat_autoid");
            const data_mat_linenum = $(this).attr("data_mat_linenum");

            console.log(data_mat_linenum);
            // Show ข้อมูล linenum ปัจจุบัน
            updateLinenumUp_edit(data_mat_linenum , data_mat_autoid);

        });


        $(document).on('click' , '.runScDownI_edit' , function(){
            
            const data_mat_autoid = $(this).attr("data_mat_autoid");
            const data_mat_linenum = $(this).attr("data_mat_linenum");

            console.log(data_mat_linenum);
            // Show ข้อมูล linenum ปัจจุบัน
            let checkAfterLinenumNow = parseFloat(data_mat_linenum) + 1;

            updateLinenumDown_edit(data_mat_linenum , data_mat_autoid);

        });


        $(document).on('click' , '.selectRunActive' , function(){
            const data_mat_autoid = $(this).attr('data_mat_autoid');
            const data_mat_machine_name = $(this).attr('data_mat_machine_name');
            $.ajax({
                url:"/intsys/msd/main/machine/setActiveRun",
                method:"POST",
                data:{
                    data_mat_autoid:data_mat_autoid,
                    data_mat_machine_name:data_mat_machine_name
                },
                beforeSend:function(){},
                success:function(res){
                    console.log(JSON.parse(res));
                    loadRunScrFromTempTable_edit(data_mat_machine_name , 'edit_template' , $('#select_edit_searchRunscreenTemp').val() , data_mat_autoid);
                }
            });
        });



        $('#btnSaveSelectTemplate_edit').click(function(){

            $('#btnSaveSelectTemplate_edit').prop('disabled' , true);

            const oldtemplate = $('#select_check_templatename').val();
            const editfile = $('input:file[id="select_edit_template_image"]').val();
            const templatename = $('#select_edit_template_name').val();
            const itemid = $('#select_edit_template_itemid').val();
            const checkTname = $('#select_edit_template_name_new').val();
            const checkItemId = $('#select_edit_template_itemid_new').val();
            const templatememo = $('#select_edit_template_memo').val();
            const dataareaid = $('#select_edit_template_dataareaid').val();
            checkEditTemplateDuplicate(oldtemplate , editfile , templatename , itemid , checkTname , checkItemId , templatememo , dataareaid);

        });

        $('#select_edit_template_itemid').keyup(function(){
            if($(this).val() != ""){
                loadItemidFormTable_edit($(this).val());
            }else{
                $('#create_new_template_itemid_search_edit').html('');
            }
        });

        $(document).on('click' , '#itemidA_edit' ,function(){
            const data_itemid = $(this).attr("data_itemid");
            $('#select_edit_template_itemid').val(data_itemid);
            $('#select_edit_template_itemid_new').val(data_itemid);
            $('#create_new_template_itemid_search_edit').html('');
        });



        $('#btnSelectTemplate_overall').click(function (){
            $('#select_template_modal').modal('hide');
            $('#overall_selectTemplate_modal').modal('show');

            const templatename = $('#select_check_templatename').val();
            let ovrTitle = '<b>Template Name : </b>'+templatename;
            $('#overall_title').html(ovrTitle);
            // Run function call data
            overall_template(templatename);

            
        });



        $(document).on('click' , '.select_template_modal_close' , function(){
            const templatename = $('#select_check_templatename').val();
            const ecode = $('#checkSessionEcode').val();
            del_dataFromTemptableBy_templatename(templatename,ecode);
        });


        $(document).on('click' , '.close_overall' , function (){
            const templatename = $('#select_check_templatename').val();
            const ecode = $('#checkSessionEcode').val();
            del_dataFromTemptableBy_templatename(templatename,ecode);
        });

        $(document).on('click' , '.btnBomTemplteClick' , function(){
            const templatename = $(this).attr('templatename');
            const itemid = $(this).attr('itemid');
            const dataareaid = $(this).attr('dataareaid');

            if($('#select_template_dataareaid').val() == ""){
                swal({
                    type: 'warning',
                    title: 'กรุณาอัพเดตข้อมูลบริษัทบน Template ก่อน',
                    showConfirmButton: false,
                    timer: 2000
                });
            }else{
                $('#addBomTemplate_modal').modal('show');
                $('#select_template_modal').modal('hide');
                // copyFeederForBomTemplate();
                //get Bom version for select
                get_bomversionData();

                $('.editInlet_template').attr({
                    'templatename':templatename,
                    'itemid':itemid,
                    'dataareaid':dataareaid
                });
            }
        });
        $(document).on('click' , '.btnBomTemplteEdit' , function(){
            const templatename = $(this).attr('templatename');
            const itemid = $(this).attr('itemid');
            const bomid = $(this).attr('bomid');
            const dataareaid = $(this).attr('dataareaid');

            $('#addBomTemplate_modal').modal('show');
            $('#select_template_modal').modal('hide');
            $('.edit-btn-section').css('display','');

            edit_bomtemplate(templatename , itemid , bomid , dataareaid);
            
            console.log(templatename);
            console.log(itemid);
            console.log(bomid);
            console.log(dataareaid);

            $('.btn-editBomTemplate').attr({
                'templatename':templatename,
                'itemid':itemid,
                'bomid':bomid,
                'dataareaid':dataareaid
            });

        });

        $(document).on('click' , '.closeBomTemplate_md' , function(){
            $('#addBomTemplate_modal').modal('hide');
            $('#select_template_modal').modal('show');
        });




        
        //Bom Template Function 

        function get_bomversionData()
        {
            let template_dataareaid = $('#checkDataareaid').val();
            let template_itemid = $('#select_template_itemid').val();
            if(template_dataareaid != "" && template_itemid != ""){
                $.ajax({
                    url:"/intsys/msd/main/machine/get_bomversionData",
                    method:"POST",
                    data:{
                        template_dataareaid:template_dataareaid,
                        template_itemid:template_itemid
                    },
                    beforeSend:function(){},
                    success:function(data){
                        console.log(JSON.parse(data));
                        if(JSON.parse(data).status == "Select Data Success"){
                            let result = JSON.parse(data).bomversion_result;
                            $('#bom_version_select').html(result);
                            $('#feeder_bom_section').css('display' , 'none');
                            $('.edit-btn-section').css('display' , 'none');
                            $('.confirm-btn-section').css('display' , 'none');
                            $('#bom_version_select').change(function(){
                                // Clear data บน Bom mixed ทั้ง 2 ที่
                                $('.confirm-btn-section').css('display' , '');
                                $('#loadGetBomMix_template').html('');
                                $('#showBomMix2_tmp').html('');
                                
                                let bomid = $('#bom_version_select').val();
                                console.log(bomid);
                                $('#feeder_bom_section').css('display' , '');
                                copyFeederForBomTemplate(bomid);

                            });
                        }
                    }
                });
            }
        }
        function edit_bomtemplate(templatename , itemid , bomid , dataareaid)
        {
            if(templatename != "" && itemid != "" && bomid != "" && dataareaid != ""){
                $.ajax({
                    url:"/intsys/msd/main/machine/getBomTemplateForEdit",
                    method:"POST",
                    data:{
                        templatename:templatename,
                        itemid:itemid,
                        bomid:bomid,
                        dataareaid:dataareaid
                    },
                    beforeSend:function(){},
                    success:function(data){
                        let res = JSON.parse(data);
                        if(res.status == "Select Data Success"){
                            let rsBomVersion = res.rsBomVersion;
                            let rsFeeder = res.rsFeeder;
                            let rsBom = res.rsBom;

                            $('#feeder_bom_section').css('display' , '');
                            $('.confirm-btn-section').css('display' , 'none');

                            $('.editInlet_template').attr({
                                'templatename':templatename,
                                'itemid':itemid,
                                'dataareaid':dataareaid
                            });

                            $('#templatename_inlet').val(templatename);
                            $('#itemid_inlet').val(itemid);
                            $('#dataareaid_inlet').val(dataareaid);

                            $('#bom_version_select').html(rsBomVersion);
                            $('#loadFeederTemp_bom').html(rsFeeder);
                            $('#loadGetBom_template').html(rsBom);
                            getBomMixed2(templatename , itemid , bomid , dataareaid);

                            $('#bom_version_select option[value="'+bomid+'"]').prop("selected" , true);

                            $('#bom_version_select').change(function(){
                                // Clear data บน Bom mixed ทั้ง 2 ที่
                                //Function Delete Rawmaterial
                                $('.confirm-btn-section').css('display' , 'none');
                                $('#loadGetBomMix_template').html('');
                                $('#showBomMix2_tmp').html('');
                                
                                let bomid = $('#bom_version_select').val();
                                console.log(bomid);
                                $('#feeder_bom_section').css('display' , '');
                                copyFeederForBomTemplate(bomid);

                            });
                        }
                    }
                });
            }
        }

        function copyFeederForBomTemplate(template_bomid)
        {
            let templatename = $('#select_check_templatename').val();
            let template_dataareaid = $('#checkDataareaid').val();
            let template_itemid = $('#select_template_itemid').val();
            if(templatename != ""){
                $.ajax({
                    url:"/intsys/msd/main/machine/copyFeederForBomTemplate",
                    method:"POST",
                    data:{
                        templatename:templatename,
                        template_dataareaid:template_dataareaid,
                        template_itemid:template_itemid,
                        template_bomid:template_bomid
                    },
                    beforeSend:function(){},
                    success:function(data){

                        if(JSON.parse(data).status == "Select Data Success"){
                            let resultFeeder = JSON.parse(data).feederResult;
                            let resultBom = JSON.parse(data).bomResult;
                            $('#loadFeederTemp_bom').html(resultFeeder);
                            $('#loadGetBom_template').html(resultBom);

                            $('#templatename_inlet').val(templatename);
                            $('#itemid_inlet').val(template_itemid);
                            $('#dataareaid_inlet').val(template_dataareaid);
                        }

                    }
                });
            }
        }


        $(document).on("click", ".md_bom_template", function () {
            $("#md_bom_template").modal("show");
            $('#btn_mixmat_template').css('display' , '');
            $('#md_bom_cancelMix_template').css('display' , 'none');

            const data_templatename = $(this).attr("data_templatename");
            const data_rawmaterial = $(this).attr("data_rawmaterial");
            const data_bomqty = $(this).attr("data_bomqty");
            const data_bomsum = $(this).attr("data_bomsum");
            const data_bomautoid = $(this).attr("data_bomautoid");
            const data_bomqtyuse = $(this).attr("data_bomqtyuse");
            // const data_productcode = $(this).attr("data_productcode");
            // const data_batchnumber = $(this).attr("data_batchnumber");
            const data_bomstatus = $(this).attr("data_bomstatus");
            const data_bombalance = $(this).attr("data_bombalance");
            const data_dataareaid = $(this).attr("data_dataareaid");
            const data_itemid = $(this).attr("data_itemid");
            const data_bomid = $(this).attr("data_bomid");
            const data_bomtype = $(this).attr("data_bomtype");


            $('.btn_addmatMix_tmp').attr({
                'data_templatename':data_templatename,
                'data_rawmaterial':data_rawmaterial,
                'data_bomqty':data_bomqty,
                'data_bomsum':data_bomsum,
                'data_bomautoid':data_bomautoid,
                'data_bomqtyuse':data_bomqtyuse,
                'data_bomstatus':data_bomstatus,
                'data_bombalance':data_bombalance,
                'data_areaid':data_dataareaid,
                'data_itemid':data_itemid,
                'data_bomid':data_bomid,
                'data_bomtype':data_bomtype,
            });



            $('#btn_mixmat_template').attr({
                'data_templatename':data_templatename,
                'data_itemid':data_itemid,
                'data_bomid':data_bomid,
                'data_dataareaid':data_dataareaid
            });
            // console.log(data_rawmaterial+" = "+data_bomqty);

            // Check Bom Balance
            if(data_bomsum == 0){
                $('#md_bom_canuse_template').css('display' , 'none');
                $('#md_bom_notuse_template').css('display' , '');
            }else{
                $('#md_bom_canuse_template').css('display' , '');
                $('#md_bom_notuse_template').css('display' , 'none');
            }

            
        });

        $("#btn_adddatafeeder_template").click(function () {
            saveDataToFeederBom_template_tmp();
        });
        function saveDataToFeederBom_template_tmp() {
            // Check Feeder Value null
            if ($("#chooseFeeder_template").val() != "" && $("#md_value_template").val() != "") {
                $.ajax({
                    url: "/intsys/msd/main/machine/saveDataToFeederBom_template_tmp",
                    method: "POST",
                    data: $("#feeder_frm_template").serialize(),
                    beforeSend: function () {
                        $('.loader').fadeIn(1000);
                    },
                    success: function (res) {
                        console.log(JSON.parse(res));
                        if(JSON.parse(res).status = "Update Data Success"){
                            let dataFeederTmp = JSON.parse(res).dataFeederTmp;
                            let dataBomTmp = JSON.parse(res).dataBomTmp;
                            let templatename = JSON.parse(res).templatename;
                            let itemid = JSON.parse(res).itemid;
                            let bomid = JSON.parse(res).bomid;
                            let dataareaid = JSON.parse(res).dataareaid;

                            swal({
                                title: 'บันทึกข้อมูลสำเร็จ',
                                showConfirmButton: false,
                                type: 'success',
                                timer: 1000
                            }).then(function(){
                                $('#md_addmatFeeder_template').modal('hide');
                                $('#loadFeederTemp_bom').html(dataFeederTmp);
                                $('#loadGetBom_template').html(dataBomTmp);
                                getBomMixed2(templatename , itemid , bomid , dataareaid);

                                $('.btn-confirmBomTemplate').attr({
                                    'templatename':templatename,
                                    'itemid':itemid,
                                    'bomid':bomid,
                                    'dataareaid':dataareaid
                                });

                                $('.btn-editBomTemplate').attr({
                                    'templatename':templatename,
                                    'itemid':itemid,
                                    'bomid':bomid,
                                    'dataareaid':dataareaid
                                });
                            });
                        }
                            
                    },
                });
            } else {
                if ($("#chooseFeeder_template").val() == "") {
                    $("#chooseFeeder_template").addClass("inputNull");
                }
                if ($("#md_value_template").val() == "") {
                    $("#md_value_template").addClass("inputNull");
                }
                    swal(
                        {
                            title: 'กรุณากรอกข้อมูลให้ครบทุกช่อง',
                            showConfirmButton: false,
                            type: 'error',
                            timer: 2000
                        }
                    );

                // Function change ของตัวเลือก Feeder
                $("#chooseFeeder_template").change(function () {
                if ($(this).val() != "") {
                    $("#chooseFeeder_template").removeClass("inputNull");
                }
                });
            }
        }


        $(document).on('click' , '.iconFeedDel_template' , function(){
            const data_faf_autoid = $(this).attr("data_autoid");
            const data_b_autoid = $(this).attr("data_b_autoid");
            const data_value = $(this).attr("data_value");
            const data_templatename = $(this).attr("data_templatename");
            const data_itemid = $(this).attr("data_itemid");
            const data_areaid = $(this).attr("data_areaid");
            const data_bomid = $(this).attr("data_bomid");

            swal({
                title: 'ต้องการลบรายการนี้ใช่หรือไม่',
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'ยืนยัน',
                cancelButtonText:'ยกเลิก'
            }).then((result)=>{
                if(result.value == true){
                    //Function Delete Rawmaterial
                    deleteRawmaterialOnFeederAndBom(
                        data_faf_autoid , 
                        data_b_autoid , 
                        data_value , 
                        data_templatename , 
                        data_itemid , 
                        data_areaid , 
                        data_bomid
                    );
                }
            });


        });
        function deleteRawmaterialOnFeederAndBom(feederAutoid , bomAutoid , bomValue , templateName , itemId , areaId , bomId)
        {
            if(feederAutoid != "" && bomAutoid != "" && bomValue != ""){
                $.ajax({
                    url:"/intsys/msd/main/machine/deleteRawmaterialOnFeederAndBom",
                    method:"post",
                    data:{
                        feederAutoid:feederAutoid,
                        bomAutoid:bomAutoid,
                        bomValue:bomValue,
                        templateName:templateName,
                        itemId:itemId,
                        areaId:areaId,
                        bomId:bomId
                    },
                    beforeSend:function(){},
                    success:function(res){
                        console.log(JSON.parse(res));
                        if(JSON.parse(res).status == "Update Data Success"){
                            let dataFeederTmp = JSON.parse(res).dataFeederTmp;
                            let dataBomTmp = JSON.parse(res).dataBomTmp;
                            swal({
                                title: 'บันทึกข้อมูลสำเร็จ',
                                showConfirmButton: false,
                                type: 'success',
                                timer: 1000
                            }).then(function(){
                                $('#loadFeederTemp_bom').html(dataFeederTmp);
                                $('#loadGetBom_template').html(dataBomTmp);
                                getBomMixed2(templateName , itemId , bomId , areaId);
                            });
                            
                        }
                    }
                });
            }
        }



        // ถ้าเลือกกดที่ปุ่ม "ใส่วัตถุดิบ"
        $("#btn_addmat_template").click(function () {
            let templatename = $('#select_check_templatename').val();
            let dataareaid = $('#checkDataareaid').val();

            $("#md_addmatFeeder_template").modal("show");
            $("#md_bom_template").modal("hide");

            console.log(templatename+' '+dataareaid);

            chooseFeeder_template(templatename , dataareaid);
        });

        function chooseFeeder_template(templatename , dataareaid)
        {
            if(templatename != "" && dataareaid != ""){
                $.ajax({
                    url:"/intsys/msd/main/machine/chooseFeeder_template",
                    method:"POST",
                    data:{
                        templatename:templatename,
                        dataareaid:dataareaid
                    },
                    beforeSend:function(){},
                    success:function(data){
                        console.log(JSON.parse(data));
                        if(JSON.parse(data).status == "Select Data Success"){
                            let result = JSON.parse(data).result;
                            $('#chooseFeeder_template').html(result);
                        }
                    }
                });
            }
        }

        $(document).on('click' , '#btn_mixmat_template' , function(){
            //Open modal
            $('#md_mixmatFeeder_template').modal('show');
            const data_templatename = $(this).attr("data_templatename");
            const data_itemid = $(this).attr("data_itemid");
            const data_bomid = $(this).attr("data_bomid");
            const data_dataareaid = $(this).attr("data_dataareaid");

            $('#btn_adddataMix_tmp').attr({
                'data_templatename':data_templatename,
                'data_itemid':data_itemid,
                'data_bomid':data_bomid,
                'data_dataareaid':data_dataareaid
            });

            console.log(data_templatename+ ' : '+data_itemid+' : '+data_bomid+' : '+data_dataareaid);
            getBomForMix_template(data_templatename , data_itemid , data_bomid , data_dataareaid);
            getBomMixed(data_templatename , data_itemid , data_bomid , data_dataareaid)
        });
        function getBomForMix_template(templatename , itemid , bomid , dataareaid)
        {
            if(templatename != "" && itemid != "" && bomid != "" && dataareaid != ""){
                $.ajax({
                    url:"/intsys/msd/main/machine/getBomForMix_template",
                    method:"POST",
                    data:{
                        templatename:templatename,
                        itemid:itemid,
                        bomid:bomid,
                        dataareaid:dataareaid
                    },
                    beforeSend:function(){},
                    success:function(res){
                        console.log(JSON.parse(res));
                        if(JSON.parse(res).status == "Select Data Success"){
                            let bomMixResult = JSON.parse(res).bomMixResult;
                            $('#showBomMix_tmp').html(bomMixResult);
                        }
                    }
                });
            }
        }

        $(document).on("click", ".mix_bom_tmp", function () {
            const data_rawmaterial = $(this).attr("data_rawmaterial");
            const data_bomqty = $(this).attr("data_bomqty");
            const data_bomqtyuse = $(this).attr("data_bomqtyuse");
            const data_bombalance = $(this).attr("data_bombalance");
            const data_b_autoid = $(this).attr("data_b_autoid");
            const data_bomstatus = $(this).attr("data_bomstatus");

            const data_templatename = $(this).attr("data_templatename");
            const data_itemid = $(this).attr("data_itemid");
            const data_bomid = $(this).attr("data_bomid");
            const data_areaid = $(this).attr("data_areaid");

            // $('#md_getValueForMix').modal('show');
            // $('#md_mixmatFeeder .modal-content').css('display' , 'none');
            // $('#md_mixmatFeeder').modal('hide');

            //Cal สำหรับใช้งานตอน Mix
            let calBombalance = 0;
            let calBomqtyUse = 0;
            let calBomqtyUseMix = 0;
            if (data_bomstatus == "active") {
                calBomqtyUseMix = parseFloat(data_bombalance);
            } else if (data_bomstatus == "wait confirm") {
                calBomqtyUseMix = 0;
            }

            activeMix_tmp(data_b_autoid , calBomqtyUseMix , data_templatename , data_itemid , data_bomid , data_areaid);

            console.log("AutoID:" + data_b_autoid + " BomBalance:" + data_bombalance);

            //get value to md_getValueForMix Modal
            $("#gv_bom").val(data_bomqty);
            $("#gv_item").text(data_rawmaterial);
            $("#gv_b_autoid").val(data_b_autoid);
            $("#gv_rawmat").val(data_rawmaterial);
            //get value to md_getValueForMix Modal



            // if($("#mixDataInput").val() == ""){
            //   $('#btn_adddataMix').css('display' , 'none');
            // }else{
            //   $('#btn_adddataMix').css('display' , '');
            // }

        
        });

        function activeMix_tmp(b_autoid , calBomqtyUseMix , templatename , itemid , bomid , dataareaid) {
        $.ajax({
            url: "/intsys/msd/main/machine/activeMix_tmp",
            method: "POST",
            data: {
            b_autoid: b_autoid,
            calBomqtyUseMix: calBomqtyUseMix,
            },
            beforeSend: function () {},
            success: function (res) {
            console.log(JSON.parse(res));
                if(JSON.parse(res).status == "Update Data Success"){
                    // console.log(templatename+' : '+itemid+' : '+bomid+' : '+dataareaid);
                    getBomForMix_template(templatename , itemid , bomid , dataareaid);
                    waitConfirmMix_template(templatename , itemid , bomid , dataareaid);
                    countConfirmMix_template(templatename , itemid , bomid , dataareaid);
                }
            },
        });
        }

        function waitConfirmMix_template(templatename , itemid , bomid , dataareaid) {
            $.ajax({
                url: "/intsys/msd/main/machine/waitConfirmMix_template",
                method: "POST",
                data: {
                    templatename:templatename,
                    itemid:itemid,
                    bomid:bomid,
                    dataareaid:dataareaid
                },
                beforeSend: function () {},
                success: function (res) {
                // console.log(res);
                $("#mixDataInput_tmp").val(res);
                },
            });
        }

        function countConfirmMix_template(templatename , itemid , bomid , dataareaid) {
            $.ajax({
                url: "/intsys/msd/main/machine/countConfirmMix_template",
                method: "POST",
                data: {
                    templatename:templatename,
                    itemid:itemid,
                    bomid:bomid,
                    dataareaid:dataareaid
                },
                beforeSend: function () {},
                success: function (res) {
                    console.log(res);
                    if(res == ""){
                        $('#btn_adddataMix').css('display' , 'none');
                    }else{
                        $('#btn_adddataMix').css('display' , '');
                    }
                    $("#mixValueDataInput_tmp").val(res);
                },
            });
        }

        $(document).on('click' , '#btn_adddataMix_tmp' , function(){
            const data_templatename = $(this).attr("data_templatename");
            const data_itemid = $(this).attr("data_itemid");
            const data_bomid = $(this).attr("data_bomid");
            const data_dataareaid = $(this).attr("data_dataareaid");
            saveDataMix_template(data_templatename , data_itemid , data_bomid , data_dataareaid);
        });

        function saveDataMix_template(templatename , itemid , bomid , dataareaid) {
            $.ajax({
                url: "/intsys/msd/main/machine/saveDataMix_template",
                method: "POST",
                data: {
                    templatename:templatename,
                    itemid:itemid,
                    bomid:bomid,
                    dataareaid:dataareaid,
                    rawmaterialmix:$('#mixDataInput_tmp').val(),
                    rawmaterialmixValue:$('#mixValueDataInput_tmp').val()
                },
                beforeSend: function () {},
                success: function (res) {

                    // getBomForMix(mainformno);
                    // getBomForMix2(mainformno);

                    // loadGetBom(mainformno);
                    // loadGetBomMix(mainformno);
                    if(JSON.parse(res).status == "Insert Data Success"){
                        swal({
                            title: 'บันทึกข้อมูลสำเร็จ',
                            showConfirmButton: false,
                            type: 'success',
                            timer: 1000
                        }).then(function(){
                            $("#mixDataInput_tmp").val("");
                            $("#mixValueDataInput_tmp").val("");
                            $('#md_bom_template').modal('hide');
                            getBomForMix_template(templatename , itemid , bomid , dataareaid);
                            getBomMixed(templatename , itemid , bomid , dataareaid);
                            getBomMixed2(templatename , itemid , bomid , dataareaid);
                        });
                    }

                },
            });
        }

        function getBomMixed(templatename , itemid , bomid , dataareaid)
        {
            if(templatename != "" && itemid != "" && bomid != "" && dataareaid != ""){
                $.ajax({
                    url:"/intsys/msd/main/machine/getBomMixed",
                    method:"POST",
                    data:{
                        templatename:templatename,
                        itemid:itemid,
                        bomid:bomid,
                        dataareaid:dataareaid
                    },
                    beforeSend:function(){},
                    success:function(res){
                        $('#showBomMix2_tmp').html(res);
                    }
                });
            }
        }
        function getBomMixed2(templatename , itemid , bomid , dataareaid)
        {
            if(templatename != "" && itemid != "" && bomid != "" && dataareaid != ""){
                $.ajax({
                    url:"/intsys/msd/main/machine/getBomMixed2",
                    method:"POST",
                    data:{
                        templatename:templatename,
                        itemid:itemid,
                        bomid:bomid,
                        dataareaid:dataareaid
                    },
                    beforeSend:function(){},
                    success:function(res){
                        if(JSON.parse(res).status == "Select Data Success"){
                            let bomOriginal = JSON.parse(res).bomOriginal;
                            let bomMixed2 = JSON.parse(res).bomMixed2;
                            let bomMix2Status = JSON.parse(res).bomMix2Status;

                            $('#loadGetBom_template').html(bomOriginal);
                            $('#loadGetBomMix_template').html(bomMixed2);

                            if(bomMix2Status == "ยังไม่มีข้อมูลการ Mix"){
                                $('#btn_canMixmat_template').css('display' , 'none');
                            }else{
                                $('#btn_canMixmat_template').css('display' , '');
                            }
                        }

                    }
                });
            }
        }

        function canCelMix_template(templatename , itemid , bomid , dataareaid){
            $.ajax({
                url: "/intsys/msd/main/machine/canCelMix_template",
                method: "POST",
                data: {
                    templatename:templatename,
                    itemid:itemid,
                    bomid:bomid,
                    dataareaid:dataareaid
                },
                beforeSend: function () {},
                success: function (res) {
                    console.log(JSON.parse(res));
                    let response = JSON.parse(res);
                    let dataBomTemp = response.dataBomTemp;
                    if(response.status == "Update Data Success"){
                        swal({
                            title: 'ยกเลิกการ Mix ทั้งหมด สำเร็จ',
                            showConfirmButton: false,
                            type: 'success',
                            timer: 1000
                        }).then(function(){
                            $('#md_bom_template').modal('hide');
                            $('#loadGetBom_template').html(dataBomTemp);
                            getBomMixed2(templatename , itemid , bomid , dataareaid);
                        });
                    }else if(response.status == "Found Mix Data In Feeder"){
                        swal({
                            title: 'ไม่สามารถยกเลิกการ Mix ได้ ต้องลบรายการ Mix ออกจาก Feeder ก่อน',
                            showConfirmButton: false,
                            type: 'error',
                            timer: 2000
                        })
                    }
 
                },
            });
        }

        $(document).on('click' , '.bommixed_tmp' , function(){
            $("#md_bom_template").modal("show");
            $('#md_bom_cancelMix_template').css('display' , '');

            const data_templatename = $(this).attr('data_templatename');
            const data_areaid = $(this).attr('data_areaid');
            const data_itemid = $(this).attr('data_itemid');
            const data_bomid = $(this).attr('data_bomid');
            const data_rawmaterial = $(this).attr('data_rawmaterial');
            const data_bomqty = $(this).attr('data_bomqty');
            const data_bomqtyusemix = $(this).attr('data_bomqtyusemix');
            const data_bomtype = $(this).attr('data_bomtype');
            const data_bombalance = $(this).attr('data_bombalance');
            const data_b_autoid = $(this).attr('data_b_autoid');
            const data_bomqtyuse = $(this).attr('data_bomqtyuse');
            const data_bomstatus = $(this).attr('data_bomstatus');

            // Check Bom Balance
            if(data_bombalance == 0){
                $('#md_bom_canuse_template').css('display' , 'none');
                $('#md_bom_notuse_template').css('display' , '');
            }else{
                $('#md_bom_canuse_template').css('display' , '');
                $('#md_bom_notuse_template').css('display' , 'none');
            }

            if(data_bomtype === "Mix"){
                $('#btn_mixmat_template').css('display' , 'none');
                $('#md_bom_cancelMix_template').css('display' , '');

                $('#btn_canMixmat_template').attr({
                    'data_templatename':data_templatename,
                    'data_itemid':data_itemid,
                    'data_bomid':data_bomid,
                    'data_areaid':data_areaid
                });

                $('.btn_addmatMix_tmp').attr({
                    'data_bomid':data_bomid,
                    'data_bomautoid':data_b_autoid,
                    'data_templatename':data_templatename,
                    'data_areaid':data_areaid,
                    'data_itemid':data_itemid,
                    'data_bombalance':data_bombalance,
                    'data_bomtype':data_bomtype,
                    'data_rawmaterial':data_rawmaterial,
                    'data_bomqtyusemix':data_bomqtyusemix,
                    'data_bomqty':data_bomqty,
                    'data_bomqtyuse':data_bomqtyuse,
                    'data_bomstatus':data_bomstatus,
                });

            }
        });

        $(document).on('click' , '.btn_addmatMix_tmp' , function(){
            const data_templatename = $(this).attr('data_templatename');
            const data_rawmaterial = $(this).attr('data_rawmaterial');
            const data_bomqty = $(this).attr('data_bomqty');
            const data_bomsum = $(this).attr('data_bomsum');
            const data_bomid = $(this).attr('data_bomid');
            const data_bomqtyuse = $(this).attr('data_bomqtyuse');
            const data_bomstatus = $(this).attr('data_bomstatus');
            const data_bombalance = $(this).attr('data_bombalance');
            const data_areaid = $(this).attr('data_areaid');
            const data_itemid = $(this).attr('data_itemid');
            const data_bomtype = $(this).attr('data_bomtype');
            const data_bomautoid = $(this).attr('data_bomautoid');

            $("#btn_mixmat_template").css("display", "");
            $("#md_bom_cancelMix_template").css("display", "none");
            $("#chooseFeeder_template").removeClass("inputNull");

            ////////////////////////////////////////////////
            // Condition สำหรับการ Control Modal จัดการวัตถุดิบ
            if (data_bomsum == 0) {
                $("#md_bom_canuse_template").css("display", "none");
                $("#md_bom_notuse_template").css("display", "");
            } else {
                $("#md_bom_canuse_template").css("display", "");
                $("#md_bom_notuse_template").css("display", "none");
            }

            if (data_bomstatus == "wait confirm") {
                $("#cbtn_addmat").css("display", "none");
            } else {
                $("#cbtn_addmat").css("display", "");
            }
            // Condition สำหรับการ Control Modal จัดการวัตถุดิบ
            ///////////////////////////////////////////////



            ////////////////////////////////////////////////////////////
            // Check ช่องรายการ Mix และ จำนวน Value รวมของการ Mix
            // ที่อยู่ใน bom_modal
            // Check mix input

            // if (
            //     $("#mixDataInput").val() == "" &&
            //     $("#mixValueDataInput").val() == ""
            // ) {
            //     waitConfirmMix(data_templatename);
            //     countConfirmMix(data_templatename);
            // }
        
            // Check ช่องรายการ Mix และ จำนวน Value รวมของการ Mix
            // ที่อยู่ใน bom_modal
            ////////////////////////////////////////////////////////////




            ///////////////////////////////////////////////////////////////////////////////////
            //ถ้ากดปุ่ม Mix เข้ามาและพบว่า Input:mixDataInput ไม่มีข้อมูลอยู่ให้เอาปุ่ม ยืนยันการ Mix ออก
            if($("#mixDataInput").val() == ""){
                $('#btn_adddataMix').css('display' , 'none');
            }
            //ถ้ากดปุ่ม Mix เข้ามาและพบว่า Input:mixDataInput ไม่มีข้อมูลอยู่ให้เอาปุ่ม ยืนยันการ Mix ออก
            ///////////////////////////////////////////////////////////////////////////////////






            ////////////////////////////////////////////////////////////////////////////////////////
            ////////////////การคำนวณ แบ่ง Item ลง Feeder
            ///////////////////////////////////////////////////////////////////////////////////////
            let bombalance = 0;
            let bomQty = 0;
            let bomQtyUse = 0;
            let bombalance2 = 0;
            let result = 0;

            if (parseFloat(data_bomqtyuse) === 0) {
                bombalance = parseFloat(data_bomqty);
                bomQty = parseFloat(data_bomqty);
                bomQtyUse = parseFloat(data_bomqtyuse);
            } else if (parseFloat(data_bomqtyuse) > 0) {
                bombalance = parseFloat(data_bombalance);
                bomQty = parseFloat(data_bomqtyuse) + parseFloat(data_bombalance);
                bomQtyUse = parseFloat(data_bomqtyuse);
            }

            console.log(
                "AutoID: " +
                data_bomautoid +
                " " +
                " Bom Balance: " +
                data_bombalance +
                " Bom QTY: " +
                bomQty +
                " Bom QTY USE:" +
                bomQtyUse
            );

            $("#textMatname_tm , #textMatname2_tm").text(data_rawmaterial);
            $("#textValue_tm , #textValue2_tm").text(bombalance.toFixed(3));
            $("#md_templatename_tm").val(data_templatename);
            $("#md_itemid_tm").val(data_itemid);
            $("#md_rawmaterial_tm").val(data_rawmaterial);
            $("#md_autoid_tm").val(data_bomautoid);
            $("#md_qtyuse_tm").val(data_bomqtyuse);

            $("#md_qtyBalance_tm").val(bomQty - bomQty);
            $("#md_qtyuseCal_tm").val(bomQty);

            // ส่งค่าไป Form ใส่วัตถุดิบลง Feeder
            $("#md_value_template").val(bombalance.toFixed(3));

            $('#md_dataareaid_tm').val(data_areaid);
            $('#md_bomid_tm').val(data_bomid);

            // ส่งค่าไป Form Mix bom
            // $("#mix_prodid").val(data_prodid);

            // ส่งค่าไป Title modal
            $("#showDetail_md_addmatFeeder_tm").html(
                "<b>Template Name : </b>" +
                data_templatename +
                "&nbsp;&nbsp;<b>Company : </b>" +
                data_areaid +
                "<br><b>Item ID : </b>" +
                data_itemid
            );

            $("#md_value_template").keyup(function () {
                let sumValue = 0;
                let sumUse = 0;
                if ($("#md_value_template").val() == "") {
                sumValue = parseFloat(bombalance);
                } else {
                // sumValue = parseFloat(resultQty) - parseFloat($('#md_value').val());
                sumValue = calBalance(parseFloat(bombalance), $("#md_value_template").val());
                }

                if (sumValue < 0) {
                $("#textValue2_tm").text(sumValue.toFixed(3)).css("color", "#e20707");
                } else {
                $("#textValue2_tm").text(sumValue.toFixed(3)).css("color", "#009900");
                }

                sumUse = parseFloat($("#md_value_template").val()) + bomQtyUse;

                if (isNaN(sumUse) == true) {
                sumUse = 0;
                }

                $("#md_qtyBalance_tm").val(sumValue.toFixed(3));
                $("#md_qtyuseCal_tm").val(sumUse.toFixed(3));

                // Check จำนวนของวัตถุดิบที่ระบุว่า เกินจำนวนที่มีอยู่หรือไม่
                const inputvalue = parseFloat($("#md_value_template").val());
                if (inputvalue > parseFloat(bombalance)) {
                // console.log('จำนวน วัตถุดิบไม่พอ');
                $("#btn_adddatafeeder").prop("disabled", true);
                $("#alertMdvalue").html(
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>วัตถุดิบไม่พอค่ะ</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
                );
                $("#md_value_template").addClass("inputNull");
                } else {
                $("#alertMdvalue").html("");
                $("#btn_adddatafeeder").prop("disabled", false);
                $("#md_value_template").removeClass("inputNull");
                }
                // Check จำนวนของวัตถุดิบที่ระบุว่า เกินจำนวนที่มีอยู่หรือไม่
            });

            ////////////////////////////////////////////////////////////////////////////////////////
            ////////////////การตำนวณ แบ่ง Item ลง Feeder
            ///////////////////////////////////////////////////////////////////////////////////////

            // Mix modal
            // $("#mix_mainformno").val(data_mainformno);
            // getBomForMix(data_mainformno);
            // getBomForMix2(data_mainformno);
        });

        $(document).on('click' , '.btn_canMixmat_template' , function(){
            const data_templatename = $(this).attr("data_templatename");
            const data_itemid = $(this).attr("data_itemid");
            const data_bomid = $(this).attr("data_bomid");
            const data_areaid = $(this).attr("data_areaid");

            swal({
                title: 'ต้องการยกเลิกการ Mix ทั้งหมดใช่หรือไม่',
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'ยืนยัน',
                cancelButtonText:'ยกเลิก'
            }).then((result)=>{
                if(result.value == true){
                    canCelMix_template(data_templatename , data_itemid , data_bomid , data_areaid);
                }
            });

            
        });

        $(document).on('click' , '.btn-confirmBomTemplate' , function(){
            const templatename = $(this).attr('templatename');
            const itemid = $(this).attr('itemid');
            const bomid = $(this).attr('bomid');
            const dataareaid = $(this).attr('dataareaid');

            let feedersum = parseFloat($('#checkFeederSumEdit_tmp').val());
            if(feedersum != 100){
                swal({
                    title: 'กรุณาใส่วัตถุดิบลง Feeder ให้ครบ',
                    showConfirmButton: false,
                    type: 'error',
                    timer: 1500
                });
            }else{
                saveDataTempToTable(templatename , itemid , bomid , dataareaid);
            }

        });

        function saveDataTempToTable(templatename , itemid , bomid , dataareaid)
        {
            if(templatename != "" && itemid != "" && bomid != "" && dataareaid != ""){
                $.ajax({
                    url:"/intsys/msd/main/machine/saveDataTempToTable",
                    method:"POST",
                    data:{
                        templatename:templatename,
                        itemid:itemid,
                        bomid:bomid,
                        dataareaid:dataareaid
                    },
                    beforeSend:function(){},
                    success:function(res){
                        let response = JSON.parse(res);
                        if(response.status == "Insert Data Success"){
                            swal({
                                title: 'บันทึกข้อมูล Bom Template สำเร็จ',
                                showConfirmButton: false,
                                type: 'success',
                                timer: 1000
                            }).then(function(){
                                location.reload();
                            });
                        }
                    }
                });
            }
        }



        $(document).on('click' , '.btn-editBomTemplate' , function(){
            const templatename = $(this).attr('templatename');
            const itemid = $(this).attr('itemid');
            const bomid = $(this).attr('bomid');
            const dataareaid = $(this).attr('dataareaid');

            let feedersum = parseFloat($('#checkFeederSumEdit_tmp').val());
            if(feedersum != 100){
                swal({
                    title: 'กรุณาใส่วัตถุดิบลง Feeder ให้ครบ',
                    showConfirmButton: false,
                    type: 'error',
                    timer: 1500
                });
            }else{
                saveDataTempToTable_edit(templatename , itemid , bomid , dataareaid);
            }

        });

        function saveDataTempToTable_edit(templatename , itemid , bomid , dataareaid)
        {
            if(templatename != "" && itemid != "" && bomid != "" && dataareaid != ""){
                $.ajax({
                    url:"/intsys/msd/main/machine/saveDataTempToTable_edit",
                    method:"POST",
                    data:{
                        templatename:templatename,
                        itemid:itemid,
                        bomid:bomid,
                        dataareaid:dataareaid
                    },
                    beforeSend:function(){},
                    success:function(res){
                        let response = JSON.parse(res);
                        if(response.status == "Insert Data Success"){
                            swal({
                                title: 'บันทึกข้อมูล Bom Template สำเร็จ',
                                showConfirmButton: false,
                                type: 'success',
                                timer: 1000
                            }).then(function(){
                                location.reload();
                            });
                        }
                    }
                });
            }
        }



        $(document).on('click' , '.editInlet_template' , function(){
            const templatename = $(this).attr('templatename');
            const itemid = $(this).attr('itemid');
            const dataareaid = $(this).attr('dataareaid');
            if(templatename != "" && itemid != "" && dataareaid != ""){
                getInlet_template(templatename , itemid , dataareaid);
            }
        });
        function getInlet_template(templatename , itemid , dataareaid)
        {
            if(templatename != "" && itemid != "" && dataareaid != ""){
                $.ajax({
                    url:"/intsys/msd/main/machine/getInlet_template",
                    method:"POST",
                    data:{
                        templatename:templatename,
                        itemid:itemid,
                        dataareaid:dataareaid
                    },
                    beforeSend:function(){},
                    success:function(data){
                        let res = JSON.parse(data);
                        console.log(res);

                        if(res.status == "Select Data Success"){
                            let inletData = res.inletData;
                            let inletTitle = '';
                            let inletName = '';
                            $('#inlet_template_modal').modal('show');

                            let output = '';
                            let option = "";
                            let inletFeederid = "";

                            for(let i = 0; i < inletData.length; i++){
                                
                                inletName = inletData[i].faf_feedername;
                                inletFeederid = inletData[i].faf_autoid;

                                if(inletData[i].faf_inlet === null || inletData[i].faf_inlet == "0"){
                                    option = `
                                        <option selected value="N/A">N/A</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                    `;
                                }else if(inletData[i].faf_inlet == "1"){
                                    option = `
                                        <option value="N/A">N/A</option>
                                        <option selected value="`+inletData[i].faf_inlet+`">`+inletData[i].faf_inlet+`</option>
                                        <option value="2">2</option>
                                    `;
                                }else if(inletData[i].faf_inlet == "2"){
                                    option = `
                                        <option value="N/A">N/A</option>
                                        <option value="1">1</option>
                                        <option selected value="`+inletData[i].faf_inlet+`">`+inletData[i].faf_inlet+`</option>
                                    `;
                                }

                                


                                output +=`
                                    <div class="col-md-6 form-group">
                                        <label>`+inletName+`</label>
                                        <input hidden type="text" id="ip-inletFeederID" name="ip-inletFeederID[]" value="`+inletFeederid+`">
                                    </div>
                                    <div class="col-md-6">
                                        <select id="ip-inletValue" name="ip-inletValue[]" class="form-control form-group ip-inletValue">
                                            `+option+`
                                        </select>
                                    </div>
                                `;
                            }

                            $('#inlet_template_show').html(output);
                            $('#inlet_template_title').html('บันทึก Inlet');
                        }

                    },

                })
            }
        }

        $('#btn-saveInlet_template').click(function(){
            saveInlet_template();
        });
        function saveInlet_template()
        {
            $.ajax({
                url:"/intsys/msd/main/machine/saveInlet_template",
                method:"POST",
                data:$('#saveInlet_template_frm').serialize(),
                beforeSend:function(){},
                success:function(data){
                    let res = JSON.parse(data);
                    console.log(res);
                    if(res.status == "Update Data Success"){
                        let dataFeederTmp = res.dataFeederTmp;
                        swal({
                            title: 'อัพเดต Inlet สำเร็จ',
                            showConfirmButton: false,
                            type: 'success',
                            timer: 1500
                        }).then(function(){
                            $('#loadFeederTemp_bom').html(dataFeederTmp);
                            $('#inlet_template_modal').modal('hide');
                        });
                    }
                }
            });
        }






        
    });//End Ready Function
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////End Ready Function
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



    function getBomTemplate(templatename , itemid , dataareaid , bomid)
    {

        if(templatename != "" && itemid != "" && dataareaid != ""){
            $.ajax({
                url:"/intsys/msd/main/machine/getBomTemplate",
                method:"POST",
                data:{
                    templatename:templatename,
                    dataareaid:dataareaid,
                    itemid:itemid
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

                        $('#showFeederTemplate').html(feederData);
                        $('#showBomTemplate').html(bomData);
                        $('#showBomMixTemplate').html(bomMixedData);

                        if(checkFeeder != 0 && checkBom != 0){
                            $('.btnBomTemplteClick').css('display' , 'none');
                            $('.btnBomTemplteEdit').css('display' , '').attr({
                                'templatename':templatename,
                                'itemid':itemid,
                                'bomid':bomid,
                                'dataareaid':dataareaid
                            });
                        }else{
                            $('.btnBomTemplteClick').css('display' , '');
                            $('.btnBomTemplteEdit').css('display' , 'none')
                        }
                        console.log('checkFeeder : '+checkFeeder+' checkBom : '+checkBom+' checkBomMixed : '+checkBomMixed);
                    }
                }
            });
        }else{
            $('.btnBomTemplteClick').css('display' , '');
            $('.btnBomTemplteEdit').css('display' , 'none');
            $('#showFeederTemplate').html('');
            $('#showBomTemplate').html('');
            $('#showBomMixTemplate').html('');
        }

    }



    // FUNCTION ZONE
    const loadFileCreateEdit = function(event) {
        const reader = new FileReader();
        reader.onload = function(){
        const output = document.getElementById('select_edit_template_imageshow');
        output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);

        uploadImageOnly();
    };

    function uploadImageOnly()
    {
        const form = $("#frm_saveEditTemplate")[0];
        const data = new FormData(form);

        $.ajax({
            url: "/intsys/msd/main/machine/uploadImageOnly_edit",
            type: "POST",
            enctype: "multipart/form-data",
            data: data,
            processData: false,
            contentType: false,
            beforeSend: function () {},
            success: function (res) {
            console.log(JSON.parse(res));

            },
        });
    }


    function loadDataTemplate(templatename)
    {
        $.ajax({
            url:"/intsys/msd/main/machine/loadDataTemplate",
            method:"POST",
            data:{
                templatename:templatename
            },
            beforeSend(){},
            success(res){
                console.log(JSON.parse(res));
                const templateimage = JSON.parse(res).ted_template_image;
                const templatename = JSON.parse(res).ted_template_name;
                const template_itemuse = JSON.parse(res).ted_template_itemuse;
                const template_remark = JSON.parse(res).ted_template_remark;
                const dataareaid = JSON.parse(res).ted_template_dataareaid;
                let template_dataareaid = "";


                if(dataareaid == "sln"){
                    template_dataareaid = "Salee Colour Public Company Limited.";
                }else if(dataareaid == "ca"){
                    template_dataareaid = "Composite Asia Co.,Ltd";
                }else if(dataareaid == "poly"){
                    template_dataareaid = "Poly Meritasia Co.,Ltd.";
                }
                

                let imageurl;


                if(templateimage == "" || templateimage == null){
                    // default image
                    imageurl = "/intsys/msd/upload/noimage2.jpg";
                    $('#select_template_imageshow').attr("src" , imageurl);
                }else{
                    imageurl = "/intsys/msd/upload/images_template/"+templateimage;
                    $('#select_template_imageshow').attr("src" , imageurl);
                }

                $('#select_template_name').val(templatename);
                $('#select_template_itemid').val(template_itemuse);
                $('#select_template_memo').val(template_remark);
                $('#select_edit_template_memo').val(template_remark);
                $('#select_template_dataareaid').val(template_dataareaid);
                $('#checkDataareaid').val(dataareaid);

                $('#select_check_templateimage').val(templateimage);
                $('#select_check_templateitemuse').val(template_itemuse);
                $('#selectTempTitle').html('<b>'+templatename+'</b>');

                loadTemplateOtherImage(templatename);

                loadRunscreenFromTemplate(templatename);

                $('.btnBomTemplteClick').attr({
                    'templatename':templatename,
                    'itemid':template_itemuse,
                    'dataareaid':dataareaid
                });
                
            }
        });
    }


    function loadTemplateOtherImage(templatename)
    {
        if(templatename != ""){
            $.ajax({
                url:"/intsys/msd/main/machine/loadTemplateOtherImage",
                method:"POST",
                data:{templatename:templatename},
                beforeSend:function(){},
                success:function(res){
                    console.log(JSON.parse(res));
                    if(JSON.parse(res).status == "Select Data Success"){
                        const templateOtherImage = JSON.parse(res).templateOtherImage;
                        let url = "<?php echo base_url(); ?>";
                        let otherImageHtml = ``;
                        let otherImagePath = '';
                        otherImageHtml +=`<div class="row form-group">`;
                                for(let i = 0; i < templateOtherImage.length; i++){
                                    otherImageHtml +=`
                                    <div class="col-md-4 col-lg-3 col-6 mt-2 otherImage">
                                    <a href="`+url+templateOtherImage[i].temi_imagepath+templateOtherImage[i].temi_imagename+`" data-toggle="lightbox" class="templateOtherImageLightbox">
                                        <img class="runImageView" src="`+url+templateOtherImage[i].temi_imagepath+templateOtherImage[i].temi_imagename+`">
                                    </a>
                                    <i class="icon-trash-alt iOtherImageDel" style="display:none;"
                                        data_autoid="`+templateOtherImage[i].temi_autoid+`"
                                        data_path="`+templateOtherImage[i].temi_imagepath+`"
                                        data_image="`+templateOtherImage[i].temi_imagename+`"
                                        data_templatename="`+templatename+`"
                                    ></i>
                                    </div>`;
                                    otherImagePath = templateOtherImage[i].temi_imagepath;
                                }
                        otherImageHtml += `
                        </div>
                        `;
                        $('#select_checkOtherImagePath').val(otherImagePath);
                        $('#show_templateotherimage').html(otherImageHtml);
                        $('#show_edit_templateotherimage').html(otherImageHtml);

                        if($('#checkEditStatus').val() == "แก้ไข"){
                            $('.iOtherImageDel').css('display','');
                        }

                    }
                }
            });
        }

    }

    $(document).on('click' , '.iOtherImageDel' , function(){
        const data_autoid = $(this).attr("data_autoid");
        const data_path = $(this).attr("data_path");
        const data_image = $(this).attr("data_image");
        const data_templatename = $(this).attr("data_templatename");

        swal({
            title: 'ต้องการลบรูปนี้ใช่หรือไม่',
            type: 'warning',
            showCancelButton: true,
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            confirmButtonText: 'ยืนยัน',
            cancelButtonText:'ยกเลิก'
        }).then((result)=>{
            if(result.value == true){
                deleteOtherImage(data_autoid , data_path , data_image , data_templatename);
            }
        });
    });

    function deleteOtherImage(data_autoid , data_path , data_image , data_templatename)
    {
        if(data_autoid != "" && data_path != "" && data_image != ""){
            $.ajax({
                url:"/intsys/msd/main/machine/deleteOtherImage",
                method:"POST",
                data:{
                    data_autoid:data_autoid,
                    data_path:data_path,
                    data_image:data_image
                },
                beforeSend:function(){},
                success:function(res){
                    console.log(JSON.parse(res));
                    if(JSON.parse(res).status == "Delete Data Success"){
                        loadTemplateOtherImage(data_templatename);
                    }
                }
            });
        }
    }



    function loadDataTemplate_edit(templatename)
    {
        $.ajax({
            url:"/intsys/msd/main/machine/loadDataTemplate",
            method:"POST",
            data:{
                templatename:templatename
            },
            beforeSend(){},
            success(res){
                console.log(JSON.parse(res));
                const templateimage = JSON.parse(res).ted_template_image;
                const templatename = JSON.parse(res).ted_template_name;
                const template_itemuse = JSON.parse(res).ted_template_itemuse;

                let template_dataareaid = JSON.parse(res).ted_template_dataareaid;

                $('#select_edit_template_dataareaid').val(template_dataareaid);

                if(templateimage == "" || templateimage == null){
                    // default image
                    let imageurl = "/intsys/msd/upload/noimage2.jpg";
                    $('#select_edit_template_imageshow').attr("src" , imageurl);
                }else{
                    imageurl = "/intsys/msd/upload/images_template/"+templateimage;
                    $('#select_edit_template_imageshow').attr("src" , imageurl);
                }

                $('#select_edit_template_name').val(templatename);
                $('#select_edit_template_itemid').val(template_itemuse);

                // loadRunscreenFromTemplate_edit(templatename);
                
            }
        });
    }



    function loadRunscreenFromTemplate(templatename)
    {
        $.ajax({
            url:"/intsys/msd/main/machine/loadRunscreenFromTemplate",
            method:"POST",
            data:{
                templatename:templatename
            },
            beforeSend(){},
            success(res){
                // console.log(res);
                $('#show_select_runscreen').html(res);
                countTotalRunMasterShow(templatename);
            }
        });
    }


    function loadRunscreenFromTemplate_edit(templatename , select_edit_searchRunscreenMaster)
    {
        $.ajax({
            url:"/intsys/msd/main/machine/loadRunscreenFromTemplate",
            method:"POST",
            data:{
                templatename:templatename,
                select_edit_searchRunscreenMaster:select_edit_searchRunscreenMaster
            },
            beforeSend(){},
            success(res){
                // console.log(res);
                $('#show_select_runscreen_edit').html(res);
            }
        });
    }



    function copyOriTemplateToTemp_edit(templatename , itemuse , template_image)
    {
        $.ajax({
            url:"/intsys/msd/main/machine/copyOriTemplateToTemp_edit",
            method:"POST",
            data:{
                templatename:templatename,
                itemuse:itemuse,
                template_image:template_image
            },
            beforeSend(){
            },
            success : function(res){
                console.log(JSON.parse(res));

                if(JSON.parse(res).status == "Insert Success"){
                    loadDataTemplate_edit(templatename);
                    loadRunScrFromTempTable_edit(templatename , 'edit_template' , $('#select_edit_searchRunscreenTemp').val());
                    const masterline = JSON.parse(res).masterlinenum;
                    $('#linenumUsedArray_edit').val(masterline);
                    countTotalRunTemp_edit(templatename);
                    // $('#show_runscreen_master2').html('');
                    countTotalRunmaster_edit($('#linenumUsedArray_edit').val());
                    loadRunScrMasUsed_edit($('#linenumUsedArray_edit').val() , 'edit_template' , $('#select_edit_searchRunscreenMaster').val());
                }
                
            }
        });
    }



    function loadRunScrFromTempTable_edit(templatename , action , searchSelectRun = '' , runautoid = '')
    {
        $.ajax({
            url:"/intsys/msd/main/machine/loadRunScrFromTempTable",
            method:"POST",
            data:{
                templatename:templatename,
                action:action,
                searchSelectRun:searchSelectRun
            },
            beforeSend(){

            },
            success(res){
                // console.log(res);
                $('#show_pick_runscreen2_edit').html(res);
                document.getElementById("selectRunActive_"+runautoid).scrollIntoView();
            }
        });
    }




    function countTotalRunTemp_edit(templatename)
    {
        $.ajax({
            url:"/intsys/msd/main/machine/countTotalRunTemp",
            method:"POST",
            data:{templatename:templatename},
            beforeSend(){},
            success(res){
                console.log(JSON.parse(res));
                $('#searchRunTempTitle_edit').html(JSON.parse(res).countdata);
            }
        });
    }


    function countTotalRunmaster_edit(dataUse)
    {
        $.ajax({
            url:"/intsys/msd/main/machine/countTotalRunmaster",
            method:"POST",
            data:{dataUse:dataUse},
            beforeSend(){},
            success(res){
                $('#searchRunTitle_edit').html(JSON.parse(res).countdata);
            }
        });
    }




    function loadRunScrMasUsed_edit(linenumUsed , action , searchMasterRun)
    {
        $.ajax({
            url:"/intsys/msd/main/machine/getRunscreenMasterNew2",
            method:"POST",
            data:{
                linenumUsed:linenumUsed,
                action:action,
                searchMasterRun:searchMasterRun
            },
            beforeSend(){},
            success(res){
            // console.log(res);
                $("#show_runscreen_master3_edit").html(res);
            }
        });
    }



    function updateLinenumUp_edit(data_mat_linenum , data_mat_autoid)
    {
        $.ajax({
            url:"/intsys/msd/main/machine/updateLinenumUp",
            method:"POST",
            data:{
                data_mat_linenum:data_mat_linenum,
                data_mat_autoid:data_mat_autoid
            },
            beforeSend(){
                console.log("กำลังดำเนินการ");
            },
            success(res){
                console.log(JSON.parse(res));
                console.log("ดำเนินการเสร็จสิ้น");
                const autoid = JSON.parse(res).autoid;
                // $('#runScMasTempLi_edit_'+autoid).addClass('runScMasTempLi_edit_ef');

                if(JSON.parse(res).status == "Change Position Success"){
                    loadRunScrFromTempTable_edit(JSON.parse(res).templatename , 'edit_template' ,$('#select_edit_searchRunscreenTemp').val(),data_mat_autoid);
                }

            }
        });
    }


    function updateLinenumDown_edit(data_mat_linenum , data_mat_autoid)
    {
        $.ajax({
            url:"/intsys/msd/main/machine/updateLinenumDown",
            method:"POST",
            data:{
                data_mat_linenum:data_mat_linenum,
                data_mat_autoid:data_mat_autoid
            },
            beforeSend(){},
            success(res){
                console.log(JSON.parse(res));

                if(JSON.parse(res).status == "Change Position Success"){
                    loadRunScrFromTempTable_edit(JSON.parse(res).templatename , 'edit_template' ,$('#select_edit_searchRunscreenTemp').val(), data_mat_autoid);
                }
            }
        });
    }



    function delRunScrFromTempTable_edit(data_mat_autoid ,data_mat_machine_name)
    {
        $.ajax({
            url:"/intsys/msd/main/machine/delRunScrFromTempTable",
            method:"POST",
            data:{
                data_mat_autoid:data_mat_autoid
            },
            beforeSend(){},
            success(res){
                console.log(res);
                if(JSON.parse(res).status == "Delete Success"){
                    loadRunScrFromTempTable_edit(data_mat_machine_name , 'edit_template' , $('#select_edit_searchRunscreenTemp').val());
                    countTotalRunTemp_edit(data_mat_machine_name);
                } 
            }
        });
    }



    function saveRunScrToTempTable_edit()
    {
        const form = $("#frm_saveEditTemplate")[0];
        const data = new FormData(form);

        $.ajax({
            url: "/intsys/msd/main/machine/saveRunScrToTempTable_edit",
            type: "POST",
            enctype: "multipart/form-data",
            data: data,
            processData: false,
            contentType: false,
            beforeSend: function () {},
            success: function (res) {
            console.log(JSON.parse(res));

            let linenumUsed = $('#linenumUsedArray_edit').val();
            // let searchRun2 = $('#searchRunscreenMaster').val();

            if (JSON.parse(res).status == "Insert Success") {
  
                loadRunScrFromTempTable_edit(JSON.parse(res).templatename , 'edit_template' , $('#select_edit_searchRunscreenTemp').val());
                $("#show_runscreen_master2_edit").html('');
                loadRunScrMasUsed_edit(linenumUsed , 'edit_template' , $('#select_edit_searchRunscreenMaster').val());
                // countTotalRunmasterUse(linenumUsed);
                countTotalRunmaster_edit(linenumUsed);
                countTotalRunTemp_edit(JSON.parse(res).templatename);
            }

            },
        });
    }




    function saveDataToMachineTemplate_edit(oldtemplate , editfile , templatename , itemid , checkTname , checkItemId , templatememo , dataareaid)
    {
        $.ajax({
            url:"/intsys/msd/main/machine/saveDataToMachineTemplate_edit",
            method:"POST",
            data:{
                oldtemplate:oldtemplate,
                editfile:editfile,
                templatename:templatename,
                itemid:itemid,
                checkTname:checkTname,
                checkItemId:checkItemId,
                templatememo:templatememo,
                dataareaid:dataareaid
            },
            beforeSend(){},
            success(res){
                console.log(JSON.parse(res));
                if(JSON.parse(res).status == "Insert Success"){
                    saveOtherImageEdit();
                }
            }
        });
    }



    function deleteTemplate(templatename , filename)
    {
        $.ajax({
            url:"/intsys/msd/main/machine/deleteTemplate",
            method:"POST",
            data:{
                templatename:templatename,
                filename:filename
            },
            beforeSend(){

            },
            success(res){
                console.log(JSON.parse(res));
            
                if(JSON.parse(res).status == "Delete Template Success"){
                    $('#select_template_modal').modal('hide');
                    loadTemplateBox();
                }
            }
        });
    }


    function loadItemidFormTable_edit(itemid)
    {
        $.ajax({
            url:"/intsys/msd/main/machine/loadItemidFormTable_edit",
            method:"POST",
            data:{itemid:itemid},
            beforeSend(){},
            success(res){
                $('#create_new_template_itemid_search_edit').html(res);
            }
        });
    }



    function checkEditTemplateDuplicate(oldtemplate , editfile , templatename , itemid , checkTname , checkItemId , templatememo , dataareaid)
    {
        $.ajax({
            url:"/intsys/msd/main/machine/checkEditTemplateDuplicate",
            method:"POST",
            data:{
                checkTname:checkTname
            },
            beforeSend(){},
            success(res){
                console.log(JSON.parse(res));
                if(JSON.parse(res).status == "Found Duplicate Template Name"){
                    $('#alert_select_edit_template').fadeIn();
                    $('#alert_select_edit_template').html('<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>'+JSON.parse(res).msg+'</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    $('#alert_select_edit_template').delay(2000).fadeOut(500);

                    $('#select_edit_template_name').removeClass("inputSuccess").addClass("inputNull");
                }else{
                    $('#alert_select_edit_template').html('');
                    $('#select_edit_template_name').removeClass("inputNull").addClass("inputSuccess");
                    saveDataToMachineTemplate_edit(oldtemplate , editfile , templatename , itemid , checkTname , checkItemId , templatememo , dataareaid);
                }

            }
        });
    }


    function saveOtherImageEdit()
    {
        const form = $('#frm_saveEditTemplate')[0];
        const data = new FormData(form);


        $.ajax({
            url: "/intsys/msd/main/machine/saveOtherImage_edit",
            method: "POST",
            enctype: "multipart/form-data",
            data: data,
            processData: false,
            contentType: false,
            beforeSend: function () {},
            success: function (res) {
                console.log(JSON.parse(res));
                // $('input:file[id="select_edit_template_image"]').val('');
                // $('input:file[id="select_edit_template_otherImage"]').val('');
                // $('#select_template_modal').modal("hide");
                // loadTemplateBox();
                location.reload();
            },
        });
    }


    function save_edittemplate_editrun()
    {
        $.ajax({
            url:"/intsys/msd/main/machine/save_edittemplate_editrun",
            method:"POST",
            data:$('#frm_edit_runscreen_edit').serialize(),
            beforeSend(){},
            success(res){
                console.log(res);
                if(JSON.parse(res).status == "Update Success"){
                    const templatename = JSON.parse(res).templatename;
                    loadRunScrFromTempTable_edit(templatename , 'edit_template' , $('#select_edit_searchRunscreenTemp').val());
                    $('#edit_runscreen_selectTemplate_modal').modal('hide');
                }
                
            }
        });
    }


    function countTotalRunMasterShow(templatename)
    {
        $.ajax({
            url:"/intsys/msd/main/machine/countTotalRunMasterShow",
            method:"POST",
            data:{
                templatename:templatename
            },
            beforeSend(){},
            success(res){
                $('#searchRunTitle_edit1').html(res);
            }
        });
    }

    function overall_template(templatename)
    {
        $.ajax({
            url:"/intsys/msd/main/machine/overall_template",
            method:"POST",
            data:{
                templatename:templatename
            },
            beforeSend(){},
            success(res){
                $('#show_overall_table').html(res);
            }
        });
    }


    function checkDataTempBefore(templatename , templateitemuse , templateimage , ecode)
    {
        $.ajax({
            url:"/intsys/msd/main/machine/checkDataTempBefore",
            method:"POST",
            data:{
                templatename:templatename,
                ecode:ecode
            },
            beforeSend:function(){},
            success:function(res){
                console.log(JSON.parse(res));
                if(JSON.parse(res).status == "Found other user edit template"){
                    alert(JSON.parse(res).msg);
                    $('#select_template_modal').modal('hide');
                }else if(JSON.parse(res).status == "Clear data"){
                    del_dataFromTemptableBy_templatename(templatename,ecode);
                    copyOriTemplateToTemp_edit(templatename , templateitemuse , templateimage);

                    $('.select_showdata').css('display' , 'none');
                    $('.select_editdata').css('display' , '');
                    $('#select_edit_template_image').val('');

                    $('#btnSelectTemplate_edit').css('display' , 'none');
                    $('#btnSelectTemplate_canceledit').css('display' , '');
                    $('#btnSaveSelectTemplate_edit').css('display' , '');

                    $('#select_edit_template_name , #select_edit_template_itemid').removeClass('inputSuccess').removeClass('inputNull');
                    $('#select_edit_searchRunscreenMaster , #select_edit_searchRunscreenTemp').val('');
                }else if(JSON.parse(res).status == "Ok"){
                    copyOriTemplateToTemp_edit(templatename , templateitemuse , templateimage);
                    // console.log(templatename+"---"+templateitemuse+"---"+templateimage);
                    $('.select_showdata').css('display' , 'none');
                    $('.select_editdata').css('display' , '');
                    $('#select_edit_template_image').val('');

                    $('#btnSelectTemplate_edit').css('display' , 'none');
                    $('#btnSelectTemplate_canceledit').css('display' , '');
                    $('#btnSaveSelectTemplate_edit').css('display' , '');

                    $('#select_edit_template_name , #select_edit_template_itemid').removeClass('inputSuccess').removeClass('inputNull');
                    $('#select_edit_searchRunscreenMaster , #select_edit_searchRunscreenTemp').val('');
                }
            }
        });
    }




    $(document).on('click', '[class="templateOtherImageLightbox"]', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox({
            alwaysShowClose: true,
        });
    });







</script>

		<!-- <script>
			$(document).ready(function(){
				
			});
		</script> -->