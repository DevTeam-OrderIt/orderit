<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
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
            <h1>Support doner Management</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class=""><a  class="breadcrumb-item btn btn-primary"href="<?= base_url()?>admin/support">Back</a></li>
              
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
            <div class="card-body">
                
                 <div class="card-body">
               <!--  <form action="<?= base_url()?>admin/support/deletes/" method="post" name="approvesform" style="margin-bottom: 3%;" >
                    <button type="button" download class="btn btn-primary pull-right multiInvoice1" >Delete</button>
                <input type="hidden" name="checkboxval" id="checkboxval" value="" required>  
                </form> -->
                
                
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Payment Id</th>
                  <th>Name</th>
                  <th>Public date</th>
                  <th>Amount</th>
                  <th>phone</th>
                  <th>email</th>
                  <th>purpose</th>
                </tr>
                </thead>
                <tbody>
                 <?php
                 $i=1;
                  foreach ($doner as $row) {?>
                <tr>
                  <td><?= ucfirst($row['payment_id'])?></td>
                  <td><?= ucfirst($row['name'])?></td>
                  <td><?= date("d, M Y g:s a", strtotime($row['create_time']));?></td>
                  <td><?= $row['amount']?></td>
                  <td><?= $row['phone']?></td>
                  <td><?= $row['email']?></td>
                  <td><?= $row['purpose']?></td>
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
        <h4 class="modal-title">Delete Confirmation</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">??</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="" class="delete_class" value="">
        <p class="text-center">Are You Want To Sure Delete ?</p>
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

function deletes(){
   var deleteId= $('.delete_class').val();
   window.location.href='<?= base_url()?>admin/support/delete/'+deleteId;
}

function status(status,id){
   window.location.href='<?= base_url()?>admin/support/status/'+status+'/'+id;
}

$(document).on('click','.delete_data',function(){
  var id= $(this).attr('data-delete');
  $('.delete_class').val(id);
});



  $('.multiInvoice1').click(function(){
       var Array=[];
      $("input:checkbox[name=checkbox]:checked").each(function(){
           Array.push($(this).val());
       });

      if (Array.length === 0) {
         alert('Please checked at least One post');
         
      }else{
     document.approvesform.submit();
      }

     
  });
  

</script>
</body>
</html>
