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
            <h1>Orders List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url()?>admin/order/add" class="btn btn-primary">Create Order</a></li>
              
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
         
       </div>

            <!-- /.card-header -->
            <div class="card-body" style="overflow-x:auto;">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>order id</th>
                  <th>User Name</th>
                  <th>Customer Name</th>
                  <th>Amount</th>
                  <th>Order Status</th>
                  <th>Payment status</th>
                  <th>Order Date</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                 <?php
                 $i=1;
                  foreach ($orders as $row) {?>
                <tr>
                  <td><?= $row['order_id'];?></td>
                  <td><?php
                      $users = $this->db->get_where('users',['user_id'=>$row['user_id']])->row_array();
                      echo $users['first_name'].' '.$users['last_name'];
                   ?></td>
                  <td><?= $row['customer_name']?></td>
                  <td><?= $row['amount'];?></td>
                  <td><?php
                      if ($row['order_status']=='0') {
                       echo '<span class="badge badge-primary">New</span>';
                      }
                      if ($row['order_status']=='1') {
                        echo '<span class="badge badge-warning">Proccesing</span>';
                      }if($row['order_status']=='2') {
                        echo '<span class="badge badge-success">Delivered</span>';
                      }

                        //$cart = $this->db->select('product_id')->get_where('cart',['token',$row['token']])->row_array();
                        //$product = $this->db->select('product_name')->get_where('product',['id'=>$cart['product_id']])->row_array();
                        //echo $product['product_name'];?></td>
                  <td><?php
                    if ($row['payment_status']=='1') {
                      echo '<span class="badge badge-success">paid</span>';
                    } else {
                      echo '<span class="badge badge-danger">unpaid</span>';
                    }

                    echo '<br>'.$row['payment_method'];
                    

                   ;?></td>
                  <td><?= $row['create_date']; ?></td>
                  <td style="white-space: nowrap;">
                      <!-- <a href="<?= base_url()?>admin/order/edit/<?= $row['id']?>" class="btn bg-gradient-primary btn-xs"><i class="fas fa-pencil-alt"></i></a>
                       -->
                      <button type="button" class="btn bg-gradient-primary btn-xs" onclick="deletes('<?= $row['id']?>')"><i class="far fa-trash-alt"></i></button>
                      <button type="button" class="btn bg-gradient-primary btn-xs view_order" data-id="<?= $row['id']?>" data-toggle="modal" data-target=".bd-example-modal-xl">view</button>
                      <a href="<?= base_url()?>admin/order/edit/<?= $row['id']?>" class="btn bg-gradient-primary btn-xs"><i class="fas fa-pencil-alt"></i></a>
                        
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

<div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Product Details</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <table id="example1" class="table table-bordered table-striped product_list">
                <tr>
                  <th>Order Id</th>
                  <td class="order_id"></td>
                </tr>
                <tr> 
                  <th>Total Discount</th>
                  <td class="discount"></td>
                 </tr>
                 <tr> 
                  <th>Total Price</th>
                  <td class="total_price"></td>
                 </tr>
                <tr>
                  <th>Product Name</th>
                  <th>Quantity</th>
                </tr>
                
                 
                 
                 
               </table>
               <table class="table table-bordered table-striped">
                 <h2>Shipping Address</h2>  
                 <tr> 
                  <th>Customer Name</th>
                  <td class="customer_name"></td>
                 </tr>
                 <tr> 
                  <th>Customer Phone</th>
                  <td class="customer_phone"></td>
                 </tr>
                 <tr> 
                  <th>Customer Email</th>
                  <td class="customer_email"></td>
                 </tr>
                 <tr> 
                  <th>Address</th>
                  <td class="shipping_address"></td>
                 </tr>
                 <tr> 
                  <th>Delivery boy</th>
                  <td class="delivery_boy"></td>
                 </tr>
                  
                
                
              </table>
      </div>
      <div class="modal-footer">
        <form method="post" action="<?= base_url()?>admin/order/invoice">
          <input type="hidden" name="product_id" value="" class="product-id">
          <button type="submit" class="btn btn-primary">Invoice Download</button>
        </form>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
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
<script src="<?= base_url()?>public/assets/js/custom.js"></script>
<!-- page script -->
<script>
  

  $(function () {
     $("#example1").DataTable({
      "aaSorting": [[ 6, "desc" ]]
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
     window.location.href='<?= base_url()?>admin/order/delete/'+id;
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
