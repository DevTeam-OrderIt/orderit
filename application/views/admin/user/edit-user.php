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
            <h1>Users Edit</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class=""><a  class="breadcrumb-item btn btn-primary"href="<?= base_url()?>admin/user"><i class="fas fa-fast-backward"></i> Back</a></li>
              
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
			
              <form role="form" action="<?= base_url()?>admin/user/update/<?= $id ?>" method="post" enctype="multipart/form-data">
                <div class="card-body">
                  <div class="form-group">
                    <div class="row">
                      <div class="col-sm-4">
                         <label for="exampleInputPassword1">First Name</label>
                         <input type="text" name="first_name" class="form-control" id="" value="<?= $user['first_name']?>" placeholder="First Name">
                         <span class="text-danger"><?= form_error('first_name');?></span>
                      </div>
                       <div class="col-sm-4">
                         <label for="exampleInputPassword1">Last Name</label>
                         <input type="text" name="last_name" class="form-control" id="" value="<?= $user['last_name']?>" placeholder="Last Name">
                        <span class="text-danger"><?= form_error('last_name');?></span>
                      </div>
                      <div class="col-sm-4">
                         <label for="exampleInputPassword1">Mobile number</label>
                         <input type="text" name="phone" maxlength="10"  class="form-control" id="" value="<?= $user['phone']?>" placeholder="Mobile 10 digits">
                         <span class="text-danger"><?= form_error('phone');?></span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                       <div class="col-sm-4">
                         <label for="exampleInputPassword1">Email Id</label>
                         <input type="text" name="email" class="form-control" id="" value="<?= $user['email']?>" placeholder="Email Id">
                        <span class="text-danger"><?= form_error('email');?></span>
                      </div>
                      <div class="col-sm-4">
                         <label for="exampleInputPassword1">Gender</label>
                         <select class="form-control" name="gender" >
                           <option value="Male" <?= ($user['gender']=='Male')?'selected':'';?> >Male</option>
                           <option value="Female"  <?= ($user['gender']=='Female')?'selected':'';?> >Female</option>
                         </select>
                         
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                       <div class="col-sm-3">
                         <label for="exampleInputPassword1">Door No</label>
                         <input type="text" name="door_no" class="form-control" id="" value="<?= $adderss['door_no']?>" placeholder="door no">
                         <span class="text-danger"><?= form_error('door_no');?></span>
                      </div>
                       <div class="col-sm-3">
                         <label for="exampleInputPassword1">Floo no</label>
                         <input type="text" name="floo_no" class="form-control" id="" value="<?= $adderss['floo_no']?>" placeholder="floo no">
                         <span class="text-danger"><?= form_error('floo_no');?></span>
                      </div>
                    
                       <div class="col-sm-3">
                         <label for="exampleInputPassword1">Building no</label>
                         <input type="text" name="building_no" class="form-control" id="" value="<?= $adderss['building_no']?>" placeholder="building no">
                         <span class="text-danger"><?= form_error('building_no');?></span>
                      </div>
                       <div class="col-sm-3">
                         <label for="exampleInputPassword1">Appartment name</label>
                         <input type="text" name="appartment_name" class="form-control" id="" value="<?= $adderss['appartment_name']?>" placeholder="appartment name">
                         <span class="text-danger"><?= form_error('appartment_name');?></span>
                      </div>
                  </div>

                  <div class="form-group">
                    <div class="row">
                       <div class="col-sm-3">
                         <label for="exampleInputPassword1">Street</label>
                         <input type="text" name="street" class="form-control" id="" value="<?= $adderss['street']?>" placeholder="street">
                         <span class="text-danger"><?= form_error('street');?></span>
                      </div>
                       <div class="col-sm-3">
                         <label for="exampleInputPassword1">Near by</label>
                         <input type="text" name="near_by" class="form-control" id="" value="<?= $adderss['near_by']?>" placeholder="near by">
                         <span class="text-danger"><?= form_error('near_by');?></span>
                      </div>
                    
                     <div class="col-sm-3">
                         <label for="exampleInputPassword1">Locality</label>
                         <input type="text" name="locality" class="form-control" id="" value="<?= $adderss['locality']?>" placeholder="locality">
                         <span class="text-danger"><?= form_error('locality');?></span>
                      </div>
                       <div class="col-sm-3">
                         <label for="exampleInputPassword1">City</label>
                         <input type="text" name="city" class="form-control" id="" value="<?= $adderss['city']?>" placeholder="city">
                         <span class="text-danger"><?= form_error('city');?></span>
                      </div>
                  </div>

                  <div class="form-group">
                    <div class="row">
                       <div class="col-sm-3">
                         <label for="exampleInputPassword1">District</label>
                         <input type="text" name="district" class="form-control" id="" value="<?= $adderss['district']?>" placeholder="district">
                         <span class="text-danger"><?= form_error('district');?></span>
                      </div>
                       <div class="col-sm-3">
                         <label for="exampleInputPassword1">State</label>
                         <input type="text" name="state" class="form-control" id="" value="<?= $adderss['state']?>" placeholder="state">
                         <span class="text-danger"><?= form_error('state');?></span>
                      </div>
                    
                       <div class="col-sm-3">
                         <label for="exampleInputPassword1">Pincode</label>
                         <input type="text" name="pincode" class="form-control" id="" value="<?= $adderss['pincode']?>" placeholder="pincode">
                         <span class="text-danger"><?= form_error('pincode');?></span>
                      </div>
                       
                   
                  </div>

                  
                    

                  <div class="form-group">
                    <label for="exampleInputFile">Image</label>
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="input-group">
                          <div class="custom-file">
                            <input type="file" name="files[]" class="custom-file-input" id="thumb_image">
                            <label class="custom-file-label" for="thumb_image">Choose file</label>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6 pull-right">
                        <?php
                            if ($user['image']!='') { ?>
                              <img class="show_image" src="<?= base_url()?>public/image_gallary/upload/<?= $user['image']?>" width="100" height="100">
                           <?php } else { ?>
                             <img class="show_image" src="<?= base_url()?>public/assets/dist/img/avatar5.png" width="100" height="100">
                           <?php }  ?>
                          
                        </div>
                     </div>
                    
                  </div>
                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-success pull-right">Save</button>
                </div>
              </form>
            </div>
            <!-- /.card -->

           

          </div>
          <!--/.col (left) -->
          <!-- right column -->
         
          <!--/.col (right) -->
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
<!-- AdminLTE App -->
<script src="<?= base_url()?>public/assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= base_url()?>public/assets/dist/js/demo.js"></script>
<script src="<?= base_url()?>public/assets/plugins/summernote/summernote-bs4.min.js"></script>

<!-- page script -->
<script>
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
