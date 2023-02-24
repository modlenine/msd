<!-- Modal รายการหลัก -->
<div class="modal fade " id="inlet_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-md modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><span id="inlet_title"></span></h5><br>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form id="saveInlet_frm" enctype="multipart/form-data" method="post" autocomplete="off">
                    
                    <div id="inlet_show" class="row form-group"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" id="btn-saveInlet" name="btn-saveInlet" class="btn btn-info">บันทึก</button>
                        </div>
                    </div>

                    <input hidden type="text" name="inlet-mainformno" id="inlet-mainformno">
                </form>
            </div>

        </div>
    </div>
</div>
<!-- Modal รายการหลัก -->

<script>
    $(document).ready(function(){
        $('#btn-saveInlet').on('click' , function(){
            let mainformno = $('#inlet-mainformno').val();
            if(mainformno != ""){
                saveInlet();
            }
        });

        function saveInlet(){
            // const form = $('#saveInlet_frm')[0];
            // const data = new FormData(form);

            $.ajax({
                url:"/intsys/msd/main/saveInlet",
                method:"POST",
                data:$('#saveInlet_frm').serialize(),
                beforeSend:function(){},
                success:function(res){
                    console.log(JSON.parse(res));
                    if(JSON.parse(res).status == "Update Data Success"){
                        swal({
                            title: 'บันทึกข้อมูลสำเร็จ',
                            type: 'success',
                            showConfirmButton: false,
                            timer:800
                        }).then(function(){
                            // location.href = url+'viewfulldata.html/'+res.data.templateformno;
                            // $('.loader').fadeOut(800);
                            // viewfulldata_vue.checkFormStatus();
                            location.reload();
                        });
                    }
                }
            });
        }
    });

</script>