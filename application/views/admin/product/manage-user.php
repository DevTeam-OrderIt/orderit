<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= $app_title.' | '.$title; ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url()?>public/assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
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
            <h1>Products List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#"></a></li>
              
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">
          <!-- /.card -->

          <div class="card">
            <div class="card-header">
              <a href="<?=base_url()?>admin/product/add" style="float: right;" class="btn btn-primary pull-right" > Add Product</a>
            </div>

            <!-- /.card-header -->
            <div class="card-body" style="overflow-x:auto;">
              <div class="row">
                <div class="col-sm-2">
              <form action="<?= base_url()?>admin/product/trending" method="post" name="approvesform" style="margin-bottom: 3%;" >
                    <button type="button" class="btn btn-primary pull-right multiInvoice1" >Trending</button>
                    <input type="hidden" name="checkboxval" id="checkboxval" value="" required>  
              </form>
              </div>
              <div class="col-sm-2">
              <a href="<?= base_url()?>admin/product/un_trending" class="btn btn-primary pull-right">Un Trending</a> 
              </div>
              <div class="col-sm-5">
                <form action="<?= base_url()?>admin/product/import" method="post" enctype="multipart/form-data">
                <input type="file" name="file" required="">
                <button type="submit"  class="btn btn-default"><i class="fa fa-upload" aria-hidden="true"></i> upload CSV</button>
               </form>
              </div>
              <div class="col-sm-2">
              <a href="<?= base_url()?>admin/product/download" download="" class="btn btn-default"><i class="fa fa-download" aria-hidden="true"></i> download CSV</a>
              </div>
              </div>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th><input type="checkbox"  id="select_all"></th>
                  <th>Product Name</th>
                  <th>Other Name</th>
                  <th>Price</th>
                  <th>Total Product</th>
                  <th>Discount</th>
                  <th>Category</th>
                  <th>Units</th>
                  <th>Services</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                 <?php
                 $i=1;
                  foreach ($products as $row) {?>
                <tr>
                  <td><input type="checkbox" name="checkbox" class="checkbox" value="<?= $row['id'];?>"></td>
                  <td><?= $row['product_name']?></td>
                  <td><?= $row['other_name']?></td>
                  <td><?php 
                      if ($row['discount_type']=='%') {
                       $price= $row['mrp_price']-($row['mrp_price']*$row['discount'])/100;

                      } else {
                        $price= $row['mrp_price']-$row['discount'];
                      }

                      $unit = $this->db->get_where('unit',['id'=>$row['unit_id']])->row_array();
                      echo $price.'/'.$unit['unite_name'];
                    ?>
                    <br><p style="font-size: 12px;color: green;">mrp <del><?php echo $row['mrp_price'];

                    

                    ?>
                      

                    </del></p>


                  </td>
                  <td><?= $row['no_of_product'];?></td>
                  <td><?php

                  if ($row['discount_type']=='%') {
                    echo $row['discount'].' %';
                  } else {
                    echo 'Rs. '.$row['discount'];
                  }
                  ;?>

                   <p><?= $row['offer_msg'];?></p></td>
                  <td><?php
                      $cat = $this->db->get_where('category',['id'=>$row['category_id']])->row_array();
                      echo $cat['name'];

                  ?></td>
                  <td>
                    <?php
                      $unit_ar = explode(',', $row['units']);
                      $units = $this->db->where_in('id',$unit_ar)->get('unit')->result_array();;
                      $ut_str = '';
                      foreach ($units as $ut) {
                        $ut_str .= $ut['unite_name'].',';
                      }
                      echo $ut_str;
                  ?>
                  </td>
                  <td>
                    <button type="button" class="btn bg-gradient-primary btn-xs detailsss" data-id="<?= $row['id']?>" data-toggle="modal" data-target="#modal-default">click</button>
                    <?php
                      if (!is_null($row['services'])) {
                        echo $row['services'];
                      } 
                      
                    ?>
                  </td>
                     
                  
                
                  <td style="white-space: nowrap;">
                      <a href="<?= base_url()?>admin/product/edit/<?= $row['id']?>" class="btn bg-gradient-primary btn-xs"><i class="fas fa-pencil-alt"></i></a>
                      <button type="button" class="btn bg-gradient-primary btn-xs" onclick="deletes('<?= $row['id']?>')"><i class="far fa-trash-alt"></i></button>
                   </td>
                </tr>

                 <?php }  ?>

                </tbody>
               
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
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
        <h4 class="modal-title">Product Details</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body img_cls">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
<!-- AdminLTE App -->
<script src="<?= base_url()?>public/assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= base_url()?>public/assets/dist/js/demo.js"></script>
<!-- page script -->
<script>
  var select_all = document.getElementById("select_all"); //select all checkbox
var checkboxes = document.getElementsByClassName("checkbox"); //checkbox items

//select all checkboxes
select_all.addEventListener("change", function(e){
  for (i = 0; i < checkboxes.length; i++) { 
    checkboxes[i].checked = select_all.checked;
  }
  
  var favorite = [];
            $.each($("input[name='checkbox']:checked"), function(){
                favorite.push($(this).val());
            });
              var cval= favorite.join(", ");
      $("#checkboxval").val(cval)
            
});


for (var i = 0; i < checkboxes.length; i++) {
  checkboxes[i].addEventListener('change', function(e){ //".checkbox" change 
    //uncheck "select all", if one of the listed checkbox item is unchecked
    if(this.checked == false){
      select_all.checked = false;
    }
  
      
      var favorite = [];
            $.each($("input[name='checkbox']:checked"), function(){
                favorite.push($(this).val());
            });
          var cval= favorite.join(", ");
      $("#checkboxval").val(cval)
  
  });
}



  $(function () {
     $("#example1").DataTable({
    
  "columnDefs": [
    { "orderable": false, "targets": 0 }
  ]
        });
        
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
    });
  });

function deletes(id){
   if (confirm('Are sure to delete?')) {
     window.location.href='<?= base_url()?>admin/product/delete/'+id;
   }
   return false;
   
}

$(document).on('click','.detailsss',function(){
  var id= $(this).attr('data-id');
  $.ajax({
    url:'<?= base_url()?>admin/product/get_details',
    type:'POST',
    data:{'id':id},
    success:function(html){
        $('.img_cls').html(html);
    }

  });

});

$('.checkAll').click(function(){
  $('input:checkbox').not(this).prop('checked', this.checked);
});

$('.multiInvoice1').click(function(){
       var Array=[];
      $("input:checkbox[name=checkbox]:checked").each(function(){
           Array.push($(this).val());
       });

      if (Array.length === 0) {
         alert('Please checked at least One Product.');
         
      }else{
     document.approvesform.submit();
      }

     
  });
  
  
  

  



</script>
</body>
</html>
