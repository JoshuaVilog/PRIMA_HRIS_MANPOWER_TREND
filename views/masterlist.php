
<body class="no-skin">
    <?php include "partials/navbar.php";?>

    <div class="main-container ace-save-state" id="main-container">
        <script type="text/javascript">
            try{ace.settings.loadState('main-container')}catch(e){}
        </script>

        <?php include "partials/sidebar.php";?>
        <div class="main-content">
            <div class="main-content-inner">
                <div class="page-content">
                    <div class="page-header">
                        <h1>Masterlist</h1>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-4 pricing-box">
                            <div class="widget-box widget-color-orange">
                                <div class="widget-header">
                                    <h5 class="widget-title bigger lighter">List</h5>
                                </div>
                                <div class="widget-body">
                                    <div class="widget-main">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>
                                                        <strong>Description:</strong>
                                                    </label>
                                                    <input type="text" class="form-control" id="txtDesc" oninput="this.value = this.value.toUpperCase()">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">
                                                        <strong>Category:</strong>
                                                    </label>
                                                    <div class="input-group input-group-lg" id="inputGroupCategory">
                                                        <select id="selectCategory" class="form-control" ></select>
                                                        <input type="text" id="txtAddNewCategory" class="form-control" style="display:none" oninput="this.value = this.value.toUpperCase()">

                                                        <span class="input-group-btn">
                                                            <button type="button" class="btn btn-primary" id="btnAddNewCategory" ><i class="ace-icon glyphicon glyphicon-plus"></i></button>
                                                            <button type="button" class="btn btn-success" style="display:none" id="btnSaveNewCategory">
                                                                <i class="ace-icon glyphicon glyphicon-ok"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-danger" style="display:none" id="btnCancelAddCategory">
                                                                <i class="ace-icon glyphicon glyphicon-remove"></i> 
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>
                                                <hr>
                                                <input type="hidden" id="hiddenID">
                                                <button class="btn btn-primary" id="btnAdd">Submit</button>
                                                <button class="btn btn-primary" id="btnUpdate" style="display: none;">Save</button>
                                                <button class="btn btn-default" id="btnCancel" style="display: none;">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-8 pricing-box">
                            <div class="widget-box widget-color-orange">
                                <div class="widget-header">
                                    <h5 class="widget-title bigger lighter">List</h5>
                                </div>
                                <div class="widget-body">
                                    <div class="widget-main">
                                        <div id="table-records"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include "partials/footer.php";?>
        <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
            <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
        </a>
    </div>
    <!-- JavaScript -->
    <script src="/<?php echo $rootFolder; ?>/script/Masterlist.js?v=<?php echo $generateRandomNumber; ?>"></script>
    <script src="/<?php echo $rootFolder; ?>/script/Record.js?v=<?php echo $generateRandomNumber; ?>"></script>
    <script>
        $("#menuMasterlist").addClass("active");
        let masterlist = new Masterlist();
        let record = new Record();

        //DISPLAY RECORDS
        masterlist.DisplayMasterlists("#table-records");
        main.PopulateSelectAddRecord(
            {
                selectElem: $("#selectCategory"),
                txtAdd: $("#txtAddNewCategory"),
                btnAdd: $("#btnAddNewCategory"),
                btnSave: $("#btnSaveNewCategory"),
                btnCancel: $("#btnCancelAddCategory"),

            }, 
            {
                getRecords: (callback) => main.GetRecordRecords(callback),
                populateSelect: (callback, data) => masterlist.PopulateCategory(callback, data),
                insertRecord: (data, callback) => record.InsertRecord(data, callback),
            },
        );

        $("#btnOpenModalAdd").click(function(){
            
            $("#modalAdd").modal("show");

        });
        $("#btnAdd").click(function(){

            masterlist.desc = $("#txtDesc");
            masterlist.category = $("#selectCategory");
            masterlist.modal = $("#modalAdd");
            masterlist.table = "#table-records";

            masterlist.InsertMasterlist(masterlist);

        });
        $("#table-records").on("click", ".btnEditRecord", function(){
            let id = $(this).val();

            masterlist.id = id;
            masterlist.desc = $("#txtDesc");
            masterlist.modal = $("#modalEdit");
            masterlist.table = "#table-records";
            masterlist.hiddenID = $("#hiddenID");
            masterlist.btnAdd = $("#btnAdd");
            masterlist.btnCancel = $("#btnCancel");
            masterlist.btnUpdate = $("#btnUpdate");
            masterlist.selectCategory = $("#selectCategory");

            masterlist.SetMasterlist(masterlist);
        });
        $("#btnUpdate").click(function(){

            masterlist.desc = $("#txtDesc");
            masterlist.category = $("#selectCategory");
            masterlist.id = $("#hiddenID");
            masterlist.modal = $("#modalEdit");
            masterlist.table = "#table-records";
            masterlist.btnAdd = $("#btnAdd");
            masterlist.btnCancel = $("#btnCancel");
            masterlist.btnUpdate = $("#btnUpdate");

            $("#btnAdd").show();
            $("#btnUpdate").hide();
            $("#btnCancel").hide();

            masterlist.UpdateMasterlist(masterlist);
        });
        $("#table-records").on("click", ".btnRemoveRecord", function(){
            let id = $(this).val();

            masterlist.table = "#table-records";
            masterlist.id = id;
            
            masterlist.RemoveMasterlist(masterlist);

        });
        $("#btnCancel").click(function(){

            $("#btnAdd").show();
            $("#btnUpdate").hide();
            $("#btnCancel").hide();
            $("#txtDesc").val("");
            $("#hiddenID").val("");
            masterlist.PopulateCategory($("#selectCategory"))

        });

        


    </script>

