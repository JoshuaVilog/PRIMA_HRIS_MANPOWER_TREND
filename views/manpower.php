
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
                    <h1>MANPOWER TREND</h1>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="">
                                    <strong>START DATE:</strong>
                                </label>
                                <input type="date" class="form-control" id="txtStartDate">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="">
                                    <strong>END DATE:</strong>
                                </label>
                                <input type="date" class="form-control" id="txtEndDate">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <i class="ace-icon fa fa-spinner fa-spin blue bigger-125" id="spinner" style="display: none;"></i>
                        <button class="btn btn-success btn-sm" id="btnDownload">Download</button>
                        <div id="table-records"></div>
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
<script src="/<?php echo $rootFolder; ?>/script/Manpower.js?v=<?php echo $generateRandomNumber; ?>"></script>
<script>
    $("#menuDashboard").addClass("active");

    let manpower = new Manpower();
 
    $("#txtStartDate").val(main.GetCurrentDate());
    $("#txtEndDate").val(main.GetCurrentDate());
    $("#txtEndDate").prop("min", main.GetCurrentDate());
    $("#txtStartDate").prop("max", main.GetCurrentDate());

    setTimeout(() => {
        let startDate = $("#txtStartDate").val();
        let endDate = $("#txtEndDate").val();

        manpower.GetManpowerReport(startDate, endDate);
    }, 1000);

    $("#txtStartDate").change(function () {
        let startDate = $(this).val();
        let endDate = $("#txtEndDate").val();
        $("#txtEndDate").prop("min", startDate);

        manpower.GetManpowerReport(startDate, endDate);
    });
    $("#txtEndDate").change(function () {
        let endDate = $(this).val();
        let startDate = $("#txtStartDate").val();
        $("#txtStartDate").prop("max", endDate);

        manpower.GetManpowerReport(startDate, endDate);
    });
    $("#btnDownload").click(function () {
        manpower.ExportTable();
    });


</script>
