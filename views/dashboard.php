
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
                    <h1>Dashboard</h1>
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
    $("#menuDashboard").addClass("active");
</script>
