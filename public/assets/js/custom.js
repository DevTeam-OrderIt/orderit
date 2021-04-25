var base_url = window.location.origin;

$(document).on('change','.products',function(){
     product_id = $('.products').val();
     $.ajax({
        url:base_url+'/admin/order/price_calculate',
        type:'POST',
        data:{'id':product_id},
        success:function(res){
          product = '';
          result = JSON.parse(res);
          option = '';
          $.each(result.all_unit, function( index, value ) {
            if(result.selected_unit==value.unite_value){
                selected='selected';
            }else{
              selected='';
            }

            option +='<option value="'+value.unite_value+'" '+selected+' >'+value.unite_name+'</option>';
          });

          //mrp_price = result.mrp_price*result.selected_unit;
          mrp_price = result.mrp_price;
          if (result.discount_type=='%') {
            discount = (mrp_price*result.discount)/100;
          }else{
            discount = result.discount;
          }
          offer_price = mrp_price-discount;
          total_amount = (offer_price/result.selected_unit)*result.selected_unit;
          unit_price = mrp_price+'/'+result.selected_unit_name;
          if (result.discount_type=='%') {
            discount_type_selected='selected';
          }else if (result.discount_type=='%') {
            discount_type_selected='selected';
          } else {
            discount_type_selected='';
          }
          
          //console.log(result);
          product += '<div class="row" id='+product_id+' >'
                  +'<div class="col-sm-2">'
                  +'<input type="hidden" name="unit_set" class="unit_set'+product_id+'" value="'+result.selected_unit+'">'
                  +'<label for="exampleInputPassword1">Product</label>'
                  +'<input type="hidden" name="product_id[]" value="'+product_id+'">'
                  +'<input type="text" readonly name="product[]" class="form-control" id="product_id" value="'+result.product_name+'"></div>'
                  +'<div class="col-sm-2">'
                  +'<label for="exampleInputPassword1">Mrp price</label>'
                  +'<input type="number" readonly name="price_per_unit[]" class="form-control" id="price_per_unit'+product_id+'" value="'+result.mrp_price+'"></div>'
                  +'<div class="col-sm-1">'
                  +'<label for="exampleInputPassword1">Offer</label>'
                  +'<input type="number" readonly name="" class="form-control" id="offer_price'+product_id+'" value="'+offer_price+'"></div>'
                  +'<div class="col-sm-1">'
                  +'<label for="exampleInputPassword1">Unit Price</label>'
                  +'<span>'+unit_price+'</span></div>'
                  //+'<input type="number" readonly name="" class="form-control" value="'+unit_price+'"></div>'
                  +'<div class="col-sm-1">'
                  +'<label for="exampleInputPassword1">Quantity</label>'
                  +'<select name="quantity[]" class="form-control quantity'+product_id+'" id="quantity">'+option+'</select></div>' 
                  +'<div class="col-sm-1">'
                  +'<label for="exampleInputPassword1">Type</label>'
                  +'<select name="discount_type[]" class="form-control discount_type" id="discount_type'+product_id+'">'
                  //+'<option value="'+result.discount_type+'">'+result.discount_type+'</option>'
                  +'<option value="rs" '+discount_type_selected+' >rs</option><option value="%" '+discount_type_selected+'>%</option>'
                  +'</select></div>'
                  +'<div class="col-sm-1">'
                  +'<label for="exampleInputPassword1">Discount</label>'
                  +'<input type="text" name="discount[]" class="form-control discount" value="'+result.discount+'" id="discount'+product_id+'"></div>'
                  +'<div class="col-sm-2">'
                  +'<label for="exampleInputPassword1">Total Price</label>'
                  +'<input type="text"readonly name="price[]" class="form-control prices" id="price'+product_id+'" value="'+total_amount+'"></div>'
                  +'<div class="col-sm-1">'
                  +'<a href="javascript:void;" class="delete_row" id="'+product_id+'" ><i class="fa fa-times"></i></a></div>'
                  

                  +'</div>';
          $("#wrap").append(product);
          get_total_price();

        }
     });
   });



$(document).on('click','.delete_row',function(){
   product_id = $(this).attr('id');
   $("#" + product_id).remove();
   get_total_price();
   

});


$(document).on('change','#quantity',function(){
    product_id = $(this).parent().parent('div').attr('id');
    quantity = parseFloat($('.quantity'+product_id).val());
    mrp_price = parseFloat($('#price_per_unit'+product_id).val());
    discount_type = $('#discount_type'+product_id).val();
    discount = $('#discount'+product_id).val();
    unit_set = $('.unit_set'+product_id).val();
    
    price_calculate(mrp_price,discount_type,discount,quantity,unit_set);
    
    
  
});


$(document).on('change','.discount_type',function(){
  product_id = $(this).parent().parent('div').attr('id');
  discount_type = $(this).val();
  discount = $('#discount'+product_id).val();
  quantity = parseFloat($('.quantity'+product_id).val());
  mrp_price = parseFloat($('#price_per_unit'+product_id).val());
  unit_set = $('.unit_set'+product_id).val();

  price_calculate(mrp_price,discount_type,discount,quantity,unit_set);
  // mrp_price = price_per_unit*quantity;
  //   if (discount_type=='%') {
  //     discount = (mrp_price*discount)/100;
  //   }else{
  //     discount = discount;
  //   }
  //   total_amount = mrp_price-discount*quantity;
  //   $("#price"+product_id).val(total_amount.toFixed(2));


});

$(document).on('keyup','.discount',function(){
  product_id = $(this).parent().parent('div').attr('id');
  discount = $(this).val();
  
  discount_type = $('#discount_type'+product_id).val();
  
  quantity = parseFloat($('.quantity'+product_id).val());
  mrp_price = parseFloat($('#price_per_unit'+product_id).val());
  unit_set = $('.unit_set'+product_id).val();
  //alert(quantity); 
  if (discount_type=='%'){
    if(discount>100){
      alert('discount must less then mrp price');
      $(':input[type="submit"]').prop('disabled', true);
      return false;
    }else{
      $(':input[type="submit"]').prop('disabled', false);
    }
    
  }else if(discount_type=='rs'){
    if (discount > mrp_price) {
    alert('discount must less then mrp price');
    $(':input[type="submit"]').prop('disabled', true);
    return false;
   }
  }
  else {
    $(':input[type="submit"]').prop('disabled', false);
  }


  price_calculate(mrp_price,discount_type,discount,quantity,unit_set);
  /*mrp_price = price_per_unit*quantity;
    if (discount_type=='%') {
      discount = (mrp_price*discount)/100;
    }else{
      discount = discount;
    }
    total_amount = mrp_price-discount*quantity;
    $("#price"+product_id).val(total_amount.toFixed(2));*/
});


function price_calculate(mrp_price,discount_type,discount,quantity,unit_set){
    
    if (discount_type=='%') {
      discount = (mrp_price*discount)/100;
    }else{
      discount = discount;
    }
    offer_price = mrp_price-discount;
    total_amount = (offer_price/unit_set)*quantity;
    $("#price"+product_id).val(total_amount.toFixed(2));
    get_total_price();


}

function get_total_price(){
    var sum = 0.0;
    $(".prices").each(function(){
     var prices = $(this).val();
     sum += parseFloat(prices);
     });

    $('.total_amount').html(sum);
}




$(document).on('click','.view_order',function(){
     product_id = $(this).attr('data-id');
     $.ajax({
        url:base_url+'/admin/order/get_order_details',
        type:'POST',
        data:{'id':product_id},
        success:function(res){
          result = JSON.parse(res);
          $(".order_id").text(result.order_id);
          $(".product_list").append(result.product_name);
          $(".quantity").text(result.quantity);
          $(".discount").text(result.discount);
          $(".unit_name").text(result.unit_name);
          $(".price_per_unit").text(result.price_per_unit);
          $(".total_price").text(result.total_price);
          $(".amount").text(result.amount);
          $(".user_name").text(result.user_name);
          $(".customer_name").text(result.customer_name);
          $(".customer_phone").text(result.customer_phone);
          $(".customer_email").text(result.customer_email);
          $(".shipping_address").text(result.shipping_address);
          $(".delivery_boy").text(result.delivery_boy);
          $(".product-id").val(result.id);
          
        }
     });
   });

$(document).on('change','.users',function(){
     user_id = $(this).val();
     $.ajax({
        url:base_url+'/admin/order/get_user_details',
        type:'POST',
        data:{'id':user_id},
        success:function(res){
          result = JSON.parse(res);
          $(".customer_name").val(result.name);
          $(".customer_phone").val(result.phone);
          $(".customer_email").val(result.email);
          $(".shiping_address").val(result.address);
          
        }
     });



});


$(document).on('click','.view_order',function(){
     staff_id = $(this).attr('data');
     
     $.ajax({
        url:base_url+'/admin/staff/monthly_order',
        type:'POST',
        data:{'id':staff_id},
        success:function(data){
          $("#orders").html(data);
        }
     });
   });


/*======================Product calculation=======================================*/




