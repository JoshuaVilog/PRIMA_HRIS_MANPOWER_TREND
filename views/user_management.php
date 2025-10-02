
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
                        <h1>User Management</h1>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-4 pricing-box">
                            <div class="widget-box widget-color-orange">
                                <div class="widget-header">
                                    <h5 class="widget-title bigger lighter">Form</h5>
                                </div>
                                <div class="widget-body">
                                    <div class="widget-main">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>
                                                        <strong>EMPLOYEE NAME / USER:</strong>
                                                    </label>
                                                    <select id="selectUser" class="form-control"></select>
                                                </div>
                                                <div class="form-group">
                                                    <label>
                                                        <strong>USER ROLE:</strong>
                                                    </label>
                                                    <select id="selectRole" class="form-control"></select>
                                                </div>
                                                <div class="form-group">
                                                    <label>
                                                        <strong>USER ACCESS:</strong>
                                                    </label>
                                                    <div id="containerChecklist"></div>
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
    <script src="/<?php echo $rootFolder; ?>/script/User.js?v=<?php echo $generateRandomNumber; ?>"></script>
    <script>
        $("#menuUserManagement").addClass("active");
        let user = new User();
        main.CheckUserAccess();

        //DISPLAY RECORDS
        // record.DisplayRecords("#table-records");

        $("#btnAdd").click(function(){

            record.desc = $("#txtDesc");
            record.modal = $("#modalAdd");
            record.table = "#table-records";
            record.module = "FORM";

            record.InsertRecord(record);

        });
        $("#table-records").on("click", ".btnEditRecord", function(){
            let id = $(this).val();

            record.id = id;
            record.desc = $("#txtDesc");
            record.modal = $("#modalEdit");
            record.table = "#table-records";
            record.hiddenID = $("#hiddenID");
            record.btnAdd = $("#btnAdd");
            record.btnCancel = $("#btnCancel");
            record.btnUpdate = $("#btnUpdate");

            record.SetRecord(record);
        });
        
        $("#btnCancel").click(function(){

            $("#btnAdd").show();
            $("#btnUpdate").hide();
            $("#btnCancel").hide();
            $("#txtDesc").val("");
            $("#hiddenID").val("");

        });
    </script>

