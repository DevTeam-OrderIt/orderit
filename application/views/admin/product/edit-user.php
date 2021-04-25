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
            <h1>Product Edit</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class=""><a  class="breadcrumb-item btn btn-primary"href="<?= base_url()?>admin/product"><i class="fas fa-fast-backward"></i> Back</a></li>
              
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
			
              <form role="form" action="<?= base_url()?>admin/product/update/<?= $id?>" method="post" enctype="multipart/form-data">
                <div class="card-body">
                  <div class="form-group">
                    <div class="row">

                      <div class="col-sm-4">
                         <label for="exampleInputPassword1">Product Name</label>
                         <input type="text" name="product_name" class="form-control" id="" value="<?= $product['product_name']?>" placeholder="Product Name">
                         <span class="text-danger"><?= form_error('product_name');?></span>
                      </div>

                       <div class="col-sm-4">
                         <label for="exampleInputPassword1">Other Name</label>
                         <input type="text" name="other_name" class="form-control" id="" value="<?= $product['other_name']?>" placeholder="Other Name">
                         <span class="text-danger"><?= form_error('other_name');?></span>
                      </div>

                      <div class="col-sm-4">
                         <label for="exampleInputPassword1">MRP price</label>
                         <input type="text" name="mrp_price" class="form-control" id="" value="<?= $product['mrp_price']?>" placeholder="mrp price">
                         <span class="text-danger"><?= form_error('mrp_price');?></span>
                      </div>

                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                       <!-- <div class="col-sm-4">
                         <label for="exampleInputPassword1">Price</label>
                         <input type="hidden" name="price" class="form-control" id="" value="<?= $product['price']?>" placeholder="price">
                         <span class="text-danger"><?= form_error('price');?></span>
                      </div> -->
                      <div class="col-sm-4">
                         <label for="exampleInputPassword1">Category</label>
                         <?php
                            $category = $this->db->get_where('category',['delete_status'=>'0'])->result_array();
                         ?>
                         <select class="form-control" name="category_id" >
                           <option value="" >Select Category</option>
                           <?php
                            foreach ($category as $cat) { ?>
                              <option value="<?= $cat['id']?>" <?= ($cat['id']==$product['category_id'])?'selected':''  ?> ><?= $cat['name'];?></option>
                           <?php } ?>
                         </select>
                         <span class="text-danger"><?= form_error('category_id');?></span>
                         
                      </div>

                      <div class="col-sm-4">
                         <label for="exampleInputPassword1">Unit Set</label>
                         <?php
                            $unit = $this->db->get_where('unit',['delete_status'=>'0'])->result_array();
                         ?>
                         <select class="form-control" name="unit_id" >
                           <option value="" >Select Unit</option>
                           <?php
                            foreach ($unit as $uni) { ?>
                              <option value="<?= $uni['id']?>" <?= ($uni['id']==$product['unit_id'])?'selected':''  ?> ><?= $uni['unite_name'];?></option>
                           <?php } ?>
                         </select>
                         <span class="text-danger"><?= form_error('unit_id');?></span>
                         
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="row">

                      <div class="col-sm-2">
                        <label for="exampleInputPassword1">Select</label>
                        <select name="discount_type" class="form-control">
                          <option value="rs" <?= ('rs'==$product['discount_type'])?'selected':''; ?> >Rs.</option>
                          <option value="%" <?= ('%'==$product['discount_type'])?'selected':''; ?>>Percent.</option>
                        </select>
                      </div>

                      <div class="col-sm-2">
                         <label for="exampleInputPassword1">Discount</label>
                         <input type="number" name="discount" class="form-control" id="" value="<?= $product['discount']?>" placeholder="Discount">
                         <span class="text-danger"><?= form_error('discount');?></span>
                      </div>

                       <div class="col-sm-4">
                         <label for="exampleInputPassword1">Offer msg</label>
                         <input type="text" name="offer_msg" class="form-control" id="" value="<?= $product['offer_msg']?>" placeholder="offer msg">
                         <span class="text-danger"><?= form_error('offer_msg');?></span>
                      </div>

                      <div class="col-sm-4">
                         <label for="exampleInputPassword1">No of product</label>
                         <input type="number" name="no_of_product" class="form-control" id="" value="<?= $product['no_of_product']?>" placeholder="no of product">
                         <span class="text-danger"><?= form_error('no_of_product');?></span>
                      </div>

                    </div>
                  </div>

                  <div class="form-group">
                    <div class="row">
                      <div class="col-sm-4 checkbox">
                         <label for="exampleInputPassword1">Add Units</label>&nbsp;&nbsp;
                         <?php
                          $unites_arr = explode(',', $product['units']);
                          foreach ($unit as $unt) { ?>
                            <input type="checkbox" name="addunits[]" value="<?= $unt['id']?>" <?= in_array($unt['id'], $unites_arr)?'checked':'';  ?>   ><?= '&nbsp;'.$unt['unite_name']?>
                          <?php } ?>
                      </div>
                      
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="row">
                      <div class="col-sm-6">
                         <label for="exampleInputPassword1">Searching Tags</label>
                         <textarea class="form-control" cols="10" name="search_tags"><?= $product['search_tags'];?></textarea>
                        <span class="text-danger"><?= form_error('search_tags');?></span>
                        <span class="text-danger">Please add tags with comma(,)</span>
                      </div>
                      <div class="col-sm-6">
                         <label for="exampleInputPassword1">Description</label>
                         <textarea class="form-control" cols="10" name="description"><?= $product['description'];?></textarea>
                        <span class="text-danger"><?= form_error('description');?></span>
                      </div>
                    </div>
                  </div>
                  
                 
                  <div class="form-group">
                    <label for="exampleInputFile">Image</label>
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="input-group">
                          <div class="custom-file">
                            <input type="file" name="files[]"  id="thumb_image" multiple>
                            <label  for="thumb_image">Choose file</label>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6">
                          <?php
                           $img_arr = explode(',',$product['images']);
                           foreach($img_arr as $img){ ?>
                           <img src="<?= base_url()?>public/image_gallary/upload/<?= $img ?>" height="100" width="100" >
                               
                           <?php }
                          
                          ?>
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
