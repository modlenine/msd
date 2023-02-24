<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{title}</title>



    <!-- <script>
        $(document).ready(function() {

            


        });
    </script> -->
</head>

<body>


    <div class="container-fluid" id="app">

        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center">Machine setup data</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div id="searchBydate">
                    <input type="text" name="datestart" id="datestart" class="" placeholder="วันที่เริ่มต้น">
                    <input type="text" name="dateend" id="dateend" class="" placeholder="วันที่สิ้นสุด">
                </div>
                <div id="btn_searchBydateDiv">
                    <button type="button" id="btn_clearSearchByDate" class="button button-amber button-small button-circle">ล้างการค้นหา</button>

                    <button type="button" id="btn_searchBydate" class="button button-green button-small button-circle"><i class="icon-line-search"></i>ค้นหา</button>
                    
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table id="dataMainList" class="table table-striped table-bordered" cellspacing="0">
                <thead>
                    <tr>
                        <th>Form No.</th>
                        <th>STD. Name</th>
                        <th>Product Code</th>
                        <th>Product No.</th>
                        <th>Batch Number</th>
                        <th>MIS</th>
                        <th>Output</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Memo</th>
                    </tr>
                </thead>
            </table>
        </div>

    </div>
    <div class="mt-6"></div>

</body>
<script>
    $(document).ready(function(){

        checkDateSearch();

        $('#btn_searchBydate').click(function(){
            let datestart = $('#datestart').val();
            let dateend = $('#dateend').val();

            if(datestart != "" && dateend != ""){
                let dateSearch_value = {
                'dateStart':datestart,
                'dateEnd':dateend
                }
                localStorage.setItem('dateSearch',JSON.stringify(dateSearch_value));
                checkDateSearch();
                // console.log(datestart+dateend);
            }else{
                swal(
                        {
                            type: 'error',
                            title: 'กรุณาเลือกวันที่ต้องการค้นหา',
                            showConfirmButton: false,
                            timer: 1500
                        }
                    );
                    $('#datestart').val('');
                    $('#dateend').val('');
            }

            
        });

        $('#btn_clearSearchByDate').click(function(){
            localStorage.removeItem('dateSearch');
            $('#dataMainList').DataTable().state.clear();
            checkDateSearch();
        });

        $(document).on('click' , '.stopMemoView' , function(){
            // Open modal
            const data_stopMemo = $(this).attr("data_stopMemo");
            $('#stopmemo_view').html(data_stopMemo);
            $('#stopMemoView_modal').modal('show');
        })

        $('#datestart').Zebra_DatePicker({
            pair: $('#dateend')
        });
        $('#dateend').Zebra_DatePicker({
            direction: 1
        });
    });


    function loadDataList()
    {
        let thid = 1;
        $('#dataMainList thead th').each(function() {
            var title = $(this).text();
            $(this).html(title + ' <input type="text" id="mainlist_'+thid+'" class="col-search-input" placeholder="Search ' + title + '" />');
            thid++;
        });

            var widthss;
            const browserWidth = $(window).width();
            if(browserWidth > 768){
                    $('#dataMainList').css('width' , '100%');
                }

            $(window).resize(function(){
                if(browserWidth > 768){
                    $('#dataMainList').css('width' , '100%');
                }
            });

            if(datestart != "" && dateend != ""){
                $('#dataMainList').DataTable().destroy();
                
            }
            
                var table = $('#dataMainList').removeAttr('width').DataTable({
                            "scrollX": true,
                            "processing": true,
                            "serverSide": true,
                            "stateSave": true,
                            stateLoadParams: function(settings, data) {
                                for (i = 0; i < data.columns["length"]; i++) {
                                    let col_search_val = data.columns[i].search.search;
                                    if (col_search_val !== "") {
                                        $("input", $("#dataMainList thead th")[i]).val(col_search_val);
                                    }
                                }
                            },
                            "ajax": {
                                "url":"<?php echo base_url('main/loadMainData') ?>",
                            },
                            order: [
                                [0, 'desc']
                            ],
                            columnDefs: [{
                                    targets: "_all",
                                    orderable: false
                                },
                                {"width": "80","targets": 0},
                                {"width": "200","targets": 1},
                                {"width": "100","targets": 2},
                                {"width": "100","targets": 3},
                                {"width": "100","targets": 4},
                                {"width": "100","targets": 5},
                                {"width": "100","targets": 6},
                                {"width": "150","targets": 7},
                                {"width": "50","targets":8},
                                {"width": "30","targets":9}
                            ],
                            });


            table.columns().every(function() {
                var table = this;
                $('input', this.header()).on('keyup change', function() {
                    if (table.search() !== this.value) {
                        table.search(this.value).draw();
                    }
                });
            });

            $('#mainlist_8 , #mainlist_10').prop('readonly' , true).css({
                'background-color':'#F5F5F5',
                'cursor':'no-drop'
            });
    }

    function loadDataListByDate(datestart , dateend)
    {
        $('#dataMainList').DataTable().destroy();

        let thid = 1;
        $('#dataMainList thead th').each(function() {
            var title = $(this).text();
            $(this).html(title + ' <input type="text" id="mainlist_'+thid+'" class="col-search-input" placeholder="Search ' + title + '" />');
            thid++;
        });

            var widthss;
            const browserWidth = $(window).width();
            if(browserWidth > 768){
                    $('#dataMainList').css('width' , '100%');
                }

            $(window).resize(function(){
                if(browserWidth > 768){
                    $('#dataMainList').css('width' , '100%');
                }
            });

            
            
                var table = $('#dataMainList').removeAttr('width').DataTable({
                            "scrollX": true,
                            "processing": true,
                            "serverSide": true,
                            "stateSave": true,
                            stateLoadParams: function(settings, data) {
                                for (i = 0; i < data.columns["length"]; i++) {
                                    let col_search_val = data.columns[i].search.search;
                                    if (col_search_val !== "") {
                                        $("input", $("#dataMainList thead th")[i]).val(col_search_val);
                                    }
                                }
                            },
                            "ajax": {
                                "url":"<?php echo base_url('main/loadMainDataByDate/') ?>"+datestart+"/"+dateend,
                            },
                            order: [
                                [0, 'desc']
                            ],
                            columnDefs: [{
                                    targets: "_all",
                                    orderable: false
                                },
                                {"width": "80","targets": 0},
                                {"width": "200","targets": 1},
                                {"width": "100","targets": 2},
                                {"width": "100","targets": 3},
                                {"width": "100","targets": 4},
                                {"width": "100","targets": 5},
                                {"width": "100","targets": 6},
                                {"width": "150","targets": 7},
                                {"width": "50","targets":8},
                                {"width": "30","targets":9}
                            ],
                            });


            table.columns().every(function() {
                var table = this;
                $('input', this.header()).on('keyup change', function() {
                    if (table.search() !== this.value) {
                        table.search(this.value).draw();
                    }
                });
            });

            $('#mainlist_8 , #mainlist_10').prop('readonly' , true).css({
                'background-color':'#F5F5F5',
                'cursor':'no-drop'
            });
    }

    function checkDateSearch()
    {
        let dataDateSearch = localStorage.getItem('dateSearch');
        // console.log(JSON.parse(dataDateSearch).dateStart);
        if(dataDateSearch){
            console.log('มีค่า');
            let dateStart_value = JSON.parse(dataDateSearch).dateStart;
            let dataEnd_value = JSON.parse(dataDateSearch).dateEnd;
            loadDataListByDate(dateStart_value,dataEnd_value);
            $('#datestart').val(dateStart_value);
            $('#dateend').val(dataEnd_value);
        }else{
            loadDataList();
            $('#datestart').val('');
            $('#dateend').val('');
        }
    }
</script>

</html>