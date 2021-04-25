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

$(document).on('click','.delete_data',function(){
  var id= $(this).attr('data-delete');
  $('.delete_class').val(id);
});


$('.cls_priority').change(function(){
  team_id = $(this).attr('team_id');
  val = $(this).val(); 
   $.ajax({
      url:'<?= base_url()?>admin/notic/priority',
      type:'POST',
      data:{'team_id':team_id,'value':val},
      success:function(html){
        location.reload(true);

      }
   });
})








