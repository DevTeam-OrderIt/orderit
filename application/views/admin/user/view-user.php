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
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url()?>public/assets/dist/css/adminlte.min.css">
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
            <h1>Profile View</h1>
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
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
              <div class="text-center">
               <?php
                if ($user['image']!='') { ?>
                 <img class="profile-user-img img-fluid img-circle" src="<?= base_url()?>public/image_gallary/upload/<?= $user['image']?>" alt="User profile picture">
                <?php  } else { ?>
                    <img class="profile-user-img img-fluid img-circle" src="<?= base_url()?>public/assets/dist/img/avatar5.png" alt="User profile picture">
                <?php }  ?>
                       
                </div>

                <h3 class="profile-username text-center"><?= ucfirst($user['first_name']).' '.$user['last_name'];?></h3>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Mobile Number</b> <a class="float-right"><?= !empty($user['phone'])?$user['phone']:'XXXXXXXXXX'?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Email</b> <a class="float-right"><?= !empty($user['email'])?$user['email']:'XXXXXXXXXX'?></a>
                  </li>
                  
                  <li class="list-group-item">
                    <b>Status</b> <a class="float-right"><?php
                      if ($user['status']==0) {
                       echo '<span class="badge badge-danger">Block</span>';
                      }else{
                        echo '<span class="badge badge-success">active</span>';
                      }
                    ?></a>
                  </li>
                </ul>

              </div>
              
            </div>
            
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane active" id="settings">
                    <form class="form-horizontal">
                      <h2>Address</h2>
                      <?php
                        $address_list = $this->db->get_where('tbl_delivery_address',['user_id'=>$user['user_id']])->result_array();
                        /*print_r($address_list);*/
                        if (count($address_list) > 0) {
                          # code...
                       
                        foreach ($address_list as $address) { ?>
                          
                          <div class="form-group row">
                            
                            <p>
                              <input type="radio" name="address" <?= ($address['default']=='1') ? 'checked':''; ?> >  
                               <div>
                                   <p>
                                   <?php
                                    if($address['door_no']!=''){
                                      echo ' Door no: '.$address['door_no'];
                                    }
                                    if($address['floo_no']!=''){
                                      echo ', Floor no: '.$address['floo_no'];
                                    }
                                    if($address['building_no']!=''){
                                      echo ', Building no: '.$address['building_no'];
                                    }
                                    if($address['appartment_name']!=''){
                                      echo ', Appartment name: '.$address['appartment_name'];
                                    }
                                    
                                   ?>
                                 </p>


                                   <p>
                                   <?php
                                    
                                    if($address['street']!=''){
                                      echo 'Street: '.$address['street'];
                                    }
                                    if($address['near_by']!=''){
                                      echo ', Near by: '.$address['near_by'];
                                    }
                                    if($address['locality']!=''){
                                      echo ', Locality: '.$address['locality'];
                                    }
                                    if($address['city']!=''){
                                      echo ', City: '.$address['city'];
                                    }
                                   ?>
                                 </p>


                                 <p>
                                   <?php
                                    if($address['district']!=''){
                                      echo 'District: '.$address['district'];
                                    }
                                    if($address['state']!=''){
                                      echo ', State: '.$address['state'];
                                    }
                                    if($address['pincode']!=''){
                                      echo ', pincode: '.$address['pincode'];
                                    }
                                   ?>
                                 </p>
                               </div>


                            </p>

                          </div>
                           <hr class="text-danger"> 
                       <?php }  } else{ ?>

                            <h4> No Address found</h4>

                      <?php } ?>
                      
                       <div class="form-group row">
                            <label for="inputName" class="col-sm-2 col-form-label">Last Update</label>
                            <div class="col-sm-10">
                              <?= !empty($user['last_update']!='0000-00-00 00:00:00')?formate_date($user['last_update']):'------'; ?>
                            </div>
                      </div>

                      
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">Last Login</label>
                        <div class="col-sm-10">
                           <?= !empty($user['add_on']!='0000-00-00 00:00:00')?formate_date($user['add_on']):'------'; ?>
                        </div>
                      </div>
                      
                        
                      
                    </form>
                  </div>

                  <!-- /.tab-pane -->
                </div>


                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
            <!-- /.nav-tabs-custom -->
            <div class="card">
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane active" id="settings">
                    <h4>Last Order</h4>
                      <div class="form-group row">
                        <table class="table">
                          <thead>
                            <tr>
                              <th>Order Id</th>
                              <th>Product</th>
                              <th>Amount(Rs.)</th>
                              <th>Status</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <?php
                                #print_r($order);
                                $product_name='';
                                $quantity=0;
                                $discount= [];
                                $total_price=[];
                                $card_data = $this->db->where(['token'=>$order['token'],'status'=>'1','user_id'=>$user['user_id'],'order_id'=>$order['order_id']])->get('cart')->result_array();

                                foreach ($card_data as $cart) {
                                   $product = $this->db->select('product_name')->get_where('product',['id'=>$cart['product_id']])->row_array();
                                   $product_name  .= $product['product_name'].', ';
                                   $quantity +=$cart['quantity']; 
                                   array_push($discount, $cart['discount']*$cart['quantity']);
                                   array_push($total_price, $cart['total_price']);
                                }
                              ?>
                              <td><?= $order['order_id']?></td>
                              <td><?= trim($product_name,", ");?></td>
                              <td><?php
                              $total = array_sum($total_price);
                              if ($total!=0) {
                                  echo $total;
                                }  
                              ?></td>
                              <td><?php
                                if ($order['order_status']=='0') {
                                     echo '<span class="badge badge-primary">New</span>';
                                    }
                                    if ($order['order_status']=='1') {
                                      echo '<span class="badge badge-warning">Proccesing</span>';
                                    }if($order['order_status']=='2') {
                                      echo '<span class="badge badge-success">Delivered</span>';
                                    }

                               //$order['order_id']
                                    ?></td>
                            </tr>
                          </tbody>
                        </table>
                        
                      </div>
                    
                  </div>
                </div>
              </div><!-- /.card-body -->
            </div>


           </div>







		  <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 
<?php $this->load->view('admin/inc/footer');?>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?= base_url()?>public/assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url()?>public/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url()?>public/assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= base_url()?>public/assets/dist/js/demo.js"></script>
</body>
</html>
