<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= $app_title.' | '.$title; ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url()?>public/assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?= base_url()?>public/assets/plugins/summernote/summernote-bs4.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?= base_url()?>public/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url()?>public/assets/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="<?= base_url()?>public/assets/plugins/toastr/toastr.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="<?= base_url()?>public/assets/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?= base_url()?>public/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <?php $this->load->view('admin/inc/header');?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
   <?php $this->load->view('admin/inc/sidebar');?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Order Create</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class=""><a  class="breadcrumb-item btn btn-primary"href="<?= base_url()?>admin/order"><i class="fas fa-fast-backward"></i> Back</a></li>
              
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
     <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <!-- /.card-header -->
              <!-- form start -->
			        <form role="form" action="<?= base_url()?>admin/order/add" method="post" enctype="multipart/form-data">
                <div class="card-body">
                  <div class="form-group">
                    <div class="row">
                      <div class="col-sm-6"><h5>Shiping Details</h5></div>
                      <div class="col-sm-6"><h5 class="float-right">Total Amount : Rs. <span class="total_amount">0.00</span></h5> <br></div>
                      
                    </div>
                    
                    <div class="row">

                      <!-- <div class="col-sm-4">
                         <label for="exampleInputPassword1">Select User</label>
                         <?php
                            $users = $this->db->get_where('users',['delete_status'=>'0','status'=>'1'])->result_array();
                         ?>
                         <select class="form-control users" name="user_id" >
                           <option value="" >Select User</option>
                           <?php
                            foreach ($users as $row) { ?>
                              <option value="<?= $row['user_id']?>" ><?= $row['first_name'].' '.$row['last_name'];?><br><small>(<?= $row['phone'];?>)</small></option>
                           <?php } ?>
                         </select>
                         <span class="text-danger"><?= form_error('user_id');?></span>
                      </div> -->

                       <div class="col-sm-4">
                         <label for="exampleInputPassword1">Select User</label>
                         <?php
                            $users = $this->db->get_where('users',['delete_status'=>'0','status'=>'1'])->result_array();
                         ?>
                         <div class="select2-purple">
                          <select class="select2 users" name="user_id" data-placeholder="Select User" style="width: 100%;">
                            <option value=""></option>
                            <?php
                            foreach ($users as $row) { ?>
                              <option value="<?= $row['user_id']?>" ><?= $row['first_name'].' '.$row['last_name'];?><br><small>(<?= $row['phone'];?>)</small></option>
                           <?php } ?>
                          </select>
                          </div>
                         
                         
                      </div>
                       
                      <div class="col-sm-4">
                         <label for="exampleInputPassword1">Customer name</label>
                         <input type="text" name="customer_name" class="form-control customer_name" value="<?= @$_POST['customer_name']?>" placeholder="customer name">
                         <span class="text-danger"><?= form_error('customer_name');?></span>
                      </div>

                       <div class="col-sm-4">
                         <label for="exampleInputPassword1">Customer phone</label>
                         <input type="text" maxlength="10" name="customer_phone" class="form-control customer_phone" value="<?= @$_POST['customer_phone']?>" placeholder="customer phone">
                         <span class="text-danger"><?= form_error('customer_phone');?></span>
                      </div>

                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-sm-3">
                         <label for="exampleInputPassword1">Customer email</label>
                         <input type="text" name="customer_email" class="form-control customer_email" value="<?= @$_POST['customer_email']?>" placeholder="customer email">
                         <span class="text-danger"><?= form_error('customer_email');?></span>
                      </div>

                       <div class="col-sm-4">
                         <label for="exampleInputPassword1">Shiping Address</label>
                         <textarea cols="10" type="text" name="shiping_address" class="form-control shiping_address" ></textarea>
                         
                      </div>
                      <div class="col-sm-4">
                         <label for="exampleInputPassword1">Select Product</label>
                         <?php
                            $product = $this->db->order_by('product_name','ASC')->get_where('product',['delete_status'=>'0'])->result_array();
                         ?>
                         <div class="select2-purple">
                          <select class="select2 products" data-placeholder="Select Product" style="width: 100%;">
                            <option value=""></option>
                            <?php
                            foreach ($product as $pr) { ?>
                              <option value="<?= $pr['id']?>" ><?= $pr['product_name'];?></option>
                           <?php } ?>
                          </select>
                          </div>
                         <span class="text-danger"><?= form_error('product_id');?></span>
                         
                      </div>
                      

                    </div>
                  </div>
                  <div class="form-group" id="wrap">
                    
                    
                  </div>

                  <div class="form-group">
                    <div class="row">
                      <div class="col-sm-4">
                         <label for="exampleInputPassword1">Order Status</label>
                         <select name="order_status" class="form-control" value="">
                           <option value="0">New</option>
                           <option value="1">inprogess</option>
                           <option value="2">complate</option>
                         </select>
                      </div>

                      <div class="col-sm-4">
                         <label for="exampleInputPassword1">Payment Status</label>
                         <select name="payment_status" class="form-control" value="">
                           <option value="0">Unpaid</option>
                           <option value="1">paid</option>
                         </select>
                      </div>

                       <div class="col-sm-4">
                         <label for="exampleInputPassword1">Payment Method</label>
                         <select name="payment_method" class="form-control" value="">
                           <option value="Cash">Cash</option>
                           <option value="UPI">UPI</option>
                           <option value="Paytm">Paytm</option>
                         </select>
                      </div>

                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-sm-12">
                         <label for="exampleInputPassword1">Delivery boy assign</label>
                         <select class="form-control" name="delivery_boys">
                         <option value="">--------</option>
                         <?php
                         $delivery_boys = $this->db->get_where('staff',['first_name !='=>''])->result_array();
                         foreach($delivery_boys as $row){ ?>
                             <option value="<?=$row['id'] ?>" ><?= $row['first_name'].' '.$row['last_name'];?></option>
                         <?php }
                         
                         ?>
                         
                         </select>
                      </div>
                    </div>
                  </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-success pull-right">Submit</button>
                </div>
              </form>
            </div>
            <!-- /.card -->

           

          </div>
          
        </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
<!-- /.content-wrapper -->
 <?php $this->load->view('admin/inc/footer');?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>

<div class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Delete Confirmation</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="" class="delete_class" value="">
        <p class="text-center">Are You Want To Sure Delete User ?</p>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" onclick="deletes()" class="btn btn-primary">Delete</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<!-- ./wrapper -->

<!-- jQuery -->

<!-- Bootstrap 4 -->
<script src="<?= base_url()?>public/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables -->
<script src="<?= base_url()?>public/assets/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?= base_url()?>public/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script src="<?= base_url()?>public/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url()?>public/assets/plugins/select2/js/select2.full.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url()?>public/assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= base_url()?>public/assets/dist/js/demo.js"></script>
<script src="<?= base_url()?>public/assets/js/custom.js"></script>
<script src="<?= base_url()?>public/assets/plugins/summernote/summernote-bs4.min.js"></script>

<!-- page script -->
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
  });




  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
    });
  });

$(function () {
    // Summernote
    $('.textarea').summernote()
  });

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('.show_image').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$("#thumb_image").change(function(){
    readURL(this);
});



</script>

</body>

</html>
