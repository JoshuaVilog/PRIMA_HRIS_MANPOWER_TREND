
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
                    <h1>Profile</h1>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-sm-12 pricing-box">
                        <div class="widget-box widget-color-orange">
                            <div class="widget-header">
                                <h5 class="widget-title bigger lighter">Account Profile</h5>
                            </div>
                            <div class="widget-body">
                                <div class="widget-main">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-4">
                                            <div class="form-group">
                                                <label>Last Name:</label>
                                                <input type="text" id="txtLastName" class="form-control disabled">
                                            </div>
                                        </div>
                                        <div class=" col-xs-6 col-sm-4">
                                            <div class="form-group">
                                                <label>First Name:</label>
                                                <input type="text" id="txtFirstName" class="form-control disabled">
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-4">
                                            <div class="form-group">
                                                <label>Middle Name:</label>
                                                <input type="text" id="txtMiddleName" class="form-control disabled">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Username:</label>
                                        <input type="text" id="txtUsername" class="form-control disabled">
                                    </div>
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

    <!-- MODAL  -->
    <?php
    //include "modal/modalAdd.php";
    //include "modal/modalEdit.php";
    ?>
</div>
<script>
    // $("#menuDashboard").addClass("active");

    $.ajax({
        url: "php/controllers/User/GetRecord.php",
        method: "POST",
        data: {},
        datatype: "json",
        success: function(data){
            console.log(data);
            $("#txtLastName").val(data.L_NAME);
            $("#txtFirstName").val(data.F_NAME);
            $("#txtMiddleName").val(data.M_NAME);
            $("#txtUsername").val(data.RFID);

        },
        error: function(err){
            console.log("Error:"+JSON.stringify(err));
        },
    });
</script>
