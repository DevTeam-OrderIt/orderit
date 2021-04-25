<html >
<head>
    <title>Invoice  Document</title>
    <style>
    html, body {margin:10;padding:20;overflow-x:hidden;border: 1px solid black;}
    h1, h2, h3, h4, h5, h6, p, blockquote, pre, a, abbr, acronym, address, cite, code, del, dfn, em, img, q, s, samp, small, strike, strong, sub, sup, tt, var, dd, dl, dt, li, ol, ul, fieldset, form, label, legend, button, table, caption, tbody, tfoot, thead, tr, th, td{margin:0;padding:0; border:0;font-weight:normal;font-style:normal;line-height:1;font-family:inherit;}
    table{border-collapse:collapse;border-spacing:0;}
    ol, ul{list-style:none;}
    /*table{border-collapse:collapse;border-spacing:0;}*/
    .clearfix{clear:both;}
    body{font-family:'Lato', sans-serif;}
    /*.container{width:100%;margin:auto;max-width:768px;}*/
    a{text-decoration:none;}
    a:hover{text-decoration:none;}
    .template-head{border-bottom:2px solid #f3f3f3;padding-bottom:15px;margin-top: 30px;}
    .table-border table tr td{font-size:14px;padding:5px 0px;}
    .clearfix {overflow: auto;}
    table tr td{font-size:14px;padding:5px 0px;}
    table tr th{padding:6px 2px;font-size:10px;font-weight:400;background-color:#ebebeb;border:1px solid #b7b7b7;margin:0px;}
   .table-doc table tr td{border:1px solid #b7b7b7;font-size:16px;padding:10px 0px;}

    </style>
</head>
<body>
    <div class="template">
        <div class="container">
            <div class="template-inner">
              <center><h1>ORDER DETAILS</h1></center>
                <div class="template-head clearfix">
                    <table>
                      <tr>
                        <td>
                          <div class="topaddress">
                            <h1 style="font-size:20px;font-weight:600;padding-bottom:5px;">Office Address</h1>
                            <p style="font-size:15px;line-height:15px; width: 300px;">Order it Online
                            Shop No.1, Thaper Gate,
                            Near Rajat Vihar, Sector-62
                            Noida- 201301.
                            Gautam Buddha Nager
                            Utter Pradesh
                            Tel.: 9650571350
                            GSTIN 
                            </p>
                          </div>
                          
                        </td>
                        <td>
                          <div class="barcodeimg" style="float:right;padding-right:10px;">
                              <img src="<?= base_url()?>public/logo.png" alt="orderitonline" width="200px" height="150px">
                          </div>
                        </td>
                      </tr>
                    </table>
                </div>
                
                <table width="100%">
                    <tr>
                        <td style="font-size:16px;font-weight:600;padding-bottom:25px;padding-left: 10px;">
                          Date : <?= date('d, M Y h:i:s A',strtotime($order['create_date']));?><br>
                          <br>
                          <?php
                            if ($order['payment_status']=='1') { ?>
                               Payment : paid <br>
                               Payment Method : <?= $order['payment_method']?><br> 
                               payment date : <?= date('d, M Y h:i:s A',strtotime($order['payment_date']));?> <br>
                               
                            <?php } else {
                              echo 'Payment : unpaid';
                            }
                          
                          ?>
                          
                        </td>
                        <td style="font-size:16px;padding-bottom:25px;margin-right: 10px;">
                        
                        </td>
                      
                    </tr>
                </table>
                

                <div class="table-doc" style="margin:0px 0 25px">
                    <table width="100%" border="2" style="border-collapse:collapse;text-align: center;">
                        <tr>
                          <th>Sr. No.</th>
                          <th>Product Name</th>
                          <th>Quantity</th>
                          <th>Price Per Unit(Rs.)</th>
                          <th>Type</th>
                          <th>Discount</th>
                          <th>Final Price(Rs.)</th>
                        </tr>
                       
                         
                          <?php
                            $i=1;
                            foreach ($card_data as $row) { ?>
                              <tr>
                                <td><?= $i++;?></td>
                                <?php
                                  $product= $this->db->get_where('product',['id'=>$row['product_id']])->row_array();
                                ?>
                                <td style="padding:10px;"><?= $product['product_name']; ?></td>
                                <td style="padding:10px;"><?= $row['quantity']; ?></td>
                                <td style="padding:10px;"><?= $row['price_per_unit']; ?></td>
                                <td style="padding:10px;"><?= $row['discount_type']; ?></td>
                                <td style="padding:10px;"><?= $row['discount']; ?></td>
                                <td style="padding:10px;"><?= $row['total_price']; ?></td>
                              </tr>

                           <?php } ?>
                           <tr>
                             <th colspan="6">Total Amount.</th>
                             <td colspan="">Rs. <?=$order['amount']?></td>
                           </tr>
                    </table>
                    <br>
                    <table width="100%" border="2" style="border-collapse:collapse;text-align: center;">
                      
                          <tr>
                              <th>User Details</th>
                              <th>Shipping Details</th>
                              <th>Shipping Address</th>
                          </tr>
                          <tr>
                            <?php
                              $users = $this->db->get_where('users',['user_id'=>$order['user_id']])->row_array();
                            ?>
                            <td>
                              User Name : <?= $users['first_name'].' '.$users['last_name'];?> <br>
                              User Phone : <?= $users['phone']?> <br>
                              User Email : <?= $users['email']?> <br>

                            </td>
                            <td>
                              Customer Name : <?= $order['customer_name']?> <br>
                              Customer Phone : <?= $order['customer_phone']?> <br>
                              Customer Email : <?= $order['customer_email']?> <br>
                                 
                            </td>
                            <td>
                              <?= $order['shipping_address'];?>
                                 
                            </td>
                          </tr>
                          
                      
                    </table>
                </div>
                <table width="100%" border="2" style="border-collapse:collapse;text-align: center;">
                    
                    <tbody>
                      <tr>
                        <td colspan="2"><h3>Delivery</h3></td>
                      </tr>
                      <tr>
                        <th>Name</th>
                        <th>Phone</th>
                      </tr>
                      <tr>
                        <?php
                          $delivery_boys = $this->db->get_where('staff',['id'=>$order['delivery_boys_id']])->row_array();
                        ?>
                        <td><?= $delivery_boys['first_name'].' '.$delivery_boys['last_name'];?></td>
                        <td><?= $delivery_boys['phone'];?></td>
                      </tr>
                    </tbody>
                </table>
                <table>
                  <tr>
                         <td>DATE/TIME: ___________________ </td>
                            
                      </tr>
                </table>

            </div>
            
        </div>
    </div>
</body>
</html>