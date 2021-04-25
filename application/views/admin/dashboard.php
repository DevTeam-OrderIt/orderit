<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title><?= $app_title;?></title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?= base_url()?>public/assets/plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?= base_url()?>public/assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url()?>public/assets/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  
  
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
  <!-- Navbar -->
  <?php $this->load->view('admin/inc/header');?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
   <?php $this->load->view('admin/inc/sidebar');?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#"></a></li>
              
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
          <div class="row">
          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-users"></i></span>
              <a href="<?= base_url()?>admin/user">  
              <div class="info-box-content">
                <span class="info-box-text">Today Users</span>
                <span class="info-box-number"><?= $users_count; ?></span>
              </div>
              </a>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-cart-plus"></i></span>
              <a href="<?= base_url()?>admin/product">  
              <div class="info-box-content">
                <span class="info-box-text">Total Product</span>
                <span class="info-box-number"><?= $product_count; ?></span>
              </div>
              </a>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-cart-plus"></i></span>
              <a href="<?= base_url()?>admin/order">
              <div class="info-box-content">
                <span class="info-box-text">Total Order</span>
                <span class="info-box-number"><?= $order_count; ?></span>
              </div>
              </a>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          
          

          <!-- /.col -->
        </div>
        <!-- /.row -->
        <script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
        <div id="chartContainer1" style="width: 100%; height: 300px;display: inline-block;"></div> 
        <div id="chartContainer2" style="width: 100%; height: 300px;display: inline-block;"></div><br/>
        <div id="chartContainer3" style="width: 100%; height: 300px;display: inline-block;"></div>
        <!--<div id="chartContainer4" style="width: 100%; height: 300px;display: inline-block;"></div>-->
        <!-- /.row -->

        <!-- Main row -->
        
        <!-- /.row -->
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
 <?php $this->load->view('admin/inc/footer');?>
</div>
<!-- ./wrapper -->
<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<!--<script src="<?= base_url()?>public/assets/plugins/jquery/jquery.min.js"></script>-->
<!-- Bootstrap -->
<script src="<?= base_url()?>public/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?= base_url()?>public/assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url()?>public/assets/dist/js/adminlte.js"></script>
<!-- OPTIONAL SCRIPTS -->
<script src="<?= base_url()?>public/assets/dist/js/demo.js"></script>
<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="<?= base_url()?>public/assets/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="<?= base_url()?>public/assets/plugins/raphael/raphael.min.js"></script>
<script src="<?= base_url()?>public/assets/plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="<?= base_url()?>public/assets/plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS -->

<!-- PAGE SCRIPTS -->
<!--<script src="<?= base_url()?>public/assets/dist/js/pages/dashboard2.js"></script>-->
</body>
</html>

<script>
var chart = new CanvasJS.Chart("chartContainer1",
    {
        animationEnabled: true,
        title: {
            text: "Total Products"
        },
        axisX: {
            valueFormatString: "MMM",
            interval: 1,
            intervalType: "month"
        },
        axisY: {
            includeZero: false
        },
        data: [
        {
            type: "splineArea",
            color: "rgba(255,12,32,.3)",
            dataPoints: [
                { x: new Date(2020, 11, 1), y: <?= $order_count ?> },
                { x: new Date(2020, 12, 1), y: <?= $order_count ?> },
                
                
                
                
            ]
        },
        ]
    });
chart.render();

var chart = new CanvasJS.Chart("chartContainer2",
    {
        animationEnabled: true,
        title: {
            text: "Total Orders",
        },
        data: [
        {
            type: "pie",
            showInLegend: true,
            dataPoints: [
                { y: <?= $complete?>, legendText: "Complete", indexLabel: "complete" },
                { y: <?= $in_process ?>, legendText: "In-process", indexLabel: "in-process" },
                { y: <?= $new_orders ?>, legendText: "New", indexLabel: "new" }
               
            ]
        },
        ]
    });
chart.render();

var chart = new CanvasJS.Chart("chartContainer3",
    {
        animationEnabled: true,
        title: {
            text: "Total Users"
        },
        axisX: {
            valueFormatString: "MMM",
            interval: 1,
            intervalType: "month"
        },
        axisY: {
            includeZero: false
        },
        data: [
        {
          type: "line",
          dataPoints: [
              { x: new Date(2012, 00, 1), y: 450 },
              { x: new Date(2012, 01, 1), y: 414 },
              { x: new Date(2012, 02, 1), y: 520, indexLabel: "highest", markerColor: "red", markerType: "triangle" },
              { x: new Date(2012, 03, 1), y: 460 },
              { x: new Date(2012, 07, 1), y: 480 },
              { x: new Date(2012, 08, 1), y: 410, indexLabel: "lowest", markerColor: "DarkSlateGrey", markerType: "cross" },
              { x: new Date(2012, 11, 1), y: 510 }
            ]
        }
        ]
    });
chart.render();

var chart = new CanvasJS.Chart("chartContainer4",
    {
        animationEnabled: true,
        title: {
            text: "Column Chart"
        },
        axisX: {
            interval: 10,
        },
        data: [
        {
            type: "column",
            legendMarkerType: "triangle",
            legendMarkerColor: "green",
            color: "rgba(255,12,32,.3)",
            showInLegend: true,
            legendText: "Country wise population",
            dataPoints: [
                { x: 10, y: 297571, label: "India" },
                { x: 20, y: 267017, label: "Saudi" },
                { x: 30, y: 175200, label: "Canada" },
                { x: 40, y: 154580, label: "Iran" },
                { x: 50, y: 116000, label: "Russia" },
                { x: 60, y: 97800, label: "UAE" },
                { x: 70, y: 20682, label: "US" },
                { x: 80, y: 20350, label: "China" }
            ]
        },
        ]
    });
chart.render();
</script>
