<style type="text/css">
	.row * {
		box-sizing: border-box;
	}
	.kotak_judul {
		 border-bottom: 1px solid #fff; 
		 padding-bottom: 2px;
		 margin: 0;
	}
	.box-header {
		color: #444;
		display: block;
		padding: 10px;
		position: relative;
	}
	.toggle.ios, .toggle-on.ios, .toggle-off.ios { border-radius: 20px; }
	.toggle.ios .toggle-handle { border-radius: 20px; }
	.breadcrumb{
		float:right;
		background:transparent;
		margin-bottom : 0;
	}
</style>
<?php
$tanggal = date('Y-m');
$txt_periode_arr = explode('-', $tanggal);
	if(is_array($txt_periode_arr)) {
		$txt_periode = $txt_periode_arr[1] . ' ' . $txt_periode_arr[0];
	}

?>

<div class="modal fade" role="dialog" id="confirm_del">
          <div class="modal-dialog" style="width:380px">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><strong>Confirmation</strong></h4>
              </div>
			 
              <div class="modal-body">
				<h4 class="text-center">Apakah anda yakin untuk menghapusnya ? </h4>
				<input type="hidden" id="del_id" value="">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>               
                <button type="button" class="btn btn-success yes_del">Delete</button>               
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>

<div class="modal fade" role="dialog" id="frm_category">
          <div class="modal-dialog" style="width:380px">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Add Form</h4>
              </div>
			 
              <div class="modal-body" style="padding-bottom:2px;">
				
				<form role="form" id="frm_cat" method="post" enctype="multipart/form-data" accept-charset="utf-8" autocomplete="off">
                <!-- text input -->
				<div class="row">
				<div class="form-group">
                  <label>Title</label><span class="label label-danger pull-right region_error"></span>
                  <input type="text" class="form-control" name="form_title" id="form_title" value="" placeholder="Title" autocomplete="off" />
                  <input type="hidden" value="" name="id_form" id="id_form">
                  <input type="hidden" value="" name="id_shipping" id="id_shipping">
                </div>
                
                
				</div>
                
              </form>

              </div>
              <div class="modal-footer" style="margin-top:1px;">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>               
                <button type="button" class="btn btn-success yes_save">Save</button>               
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>


 <div class="box box-success">
 <div class="box-header">
    <button class="btn btn-success add_category"><i class="fa fa-plus"></i> Add Form</button>
	<ol class="breadcrumb">
        <li><a href="<?php echo site_url('list_form');?>">Form Shipping</a></li>
		<li class="active"><a><?php echo $master_shipping->shipping_name;?></a></li>
    </ol>
</div>
<div class="box-body">
<div class='alert alert-info alert-dismissable' id="success-alert">
   
    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
    <div id="id_text"><b>Welcome</b></div>
</div>
	<table id="example88" class="table table-bordered table-striped">
		<thead><tr>
			<th style="text-align:center; width:4%">No.</th>
						
			<th style="text-align:center; width:66%">Form</th>			
					
			<th style="text-align:center; width:30%">Action</th>
		</tr>
		</thead>
		<tbody>
			<?php 
				$i =1;
				$view_sub = '';
				$info = '';	
				
				if(!empty($master_form)){		
					foreach($master_form as $r){	
						$view_sub = '';
						$view_sub = site_url('list_form/form_type/'.$r['id_form']);
						$info = $r['id_form'].'Þ'.$r['nama_form'];
						echo '<tr>';
						echo '<td align="center">'.$i++.'.</td>';						
						echo '<td>'.$r['nama_form'].'</td>';	
						
						echo '<td align="center" style="vertical-align: middle;">		
			<a href="'.$view_sub.'"><button title="List Form" class="btn btn-xs btn-warning"><i class="fa fa-list-ul"></i> List Form</button></a>
			<a href="#" id="'.$info.'" title="Edit" class="edit_category"><button class="btn btn-xs btn-success"><i class="fa fa-edit"></i> Edit</button></a>
			<button title="Delete" id="'.$r['id_form'].'" class="btn btn-xs btn-danger del_category"><i class="fa fa-trash-o"></i> Delete</button>		
						</td>';
						echo '</tr>';
					}
				}
			?>
		</tbody>
	
	</table>
</div>

</div>
<script src="<?php echo base_url(); ?>assets/bootstrap-toggle/js/bootstrap-toggle.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
	
<script type="text/javascript">
$("#success-alert").hide();
$("input").attr("autocomplete", "off"); 
var id_shipping = '<?php echo $master_shipping->id_shipping;?>';
$('.add_category').click(function(){
	
	$('#frm_cat').find("input[type=text], select, input[type=hidden]").val("");
	$('#blah').attr('src', '');
	$('#frm_category').modal({
		backdrop: 'static',
		keyboard: false
	});
	$('#frm_category').modal('show');
});
$('.edit_category').click(function(){
	$('#frm_cat').find("input[type=text], select").val("");
	$('#blah').attr('src', '');
	var val = $(this).get(0).id;
	var dt = val.split('Þ');
	$('#id_form').val(dt[0]);
	$('#form_title').val(dt[1]);
	
	
	$('#frm_category').modal({
		backdrop: 'static',
		keyboard: false
	});
	$('#frm_category').modal('show');
});

$('.del_category').click(function(){
	var val = $(this).get(0).id;
	$('#del_id').val(val);
	$('#confirm_del').modal({
		backdrop: 'static',
		keyboard: false
	});
	$("#confirm_del").modal('show');
});
$('.yes_del').click(function(){
	var id = $('#del_id').val();
	var url = '<?php echo site_url('list_form/del');?>';
	$.ajax({
		data : {id : id},
		url : url,
		type : "POST",
		success:function(response){
			$('#confirm_del').modal('hide');
			$("#id_text").html('<b>Success,</b> Data telah dihapus');
			$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
				$("#success-alert").alert('close');
				location.reload();
			});			
		}
	});
	
});

$('.yes_save').click(function(){
	var title = $('#form_title').val();
	$('.region_error').text('');
	$('#id_shipping').val(id_shipping);
	if(title <= 0 || title == '') {
		$('.region_error').text('Title harus diisi');
		return false;
	}	
	var dt = $('#frm_cat').serialize();
	var url = '<?php echo site_url('list_form/simpan');?>';
	$.ajax({
		data:dt,
		type:'POST',
		url : url,
		success:function(response){
			
			if(response == 'taken'){
				$('.region_error').text('Title sudah digunakan');
				return false;
			}
			if(response > 0){
				$('#frm_category').modal('hide');
				$("#id_text").html('<b>Success,</b> Data telah disimpan');
				$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
					$("#success-alert").alert('close');
					location.reload();
				});								
			}
		}
	})
	
});
$('.btn_import').click(function(){	
	$('#import_dialog').modal({
		backdrop: 'static',
		keyboard: false
	});
	$('#import_dialog').modal('show');
});
$('.btn_export').click(function(){	
	var url = '<?php echo site_url('category/export_r');?>';
	window.location.href = url;
});


$(function() {               
    $('#example88').dataTable({});
});

$('.first').magnificPopup({
		delegate: 'a',
		type: 'image',
		tLoading: 'Loading image #%curr%...',
		mainClass: 'mfp-img-mobile',
		closeOnContentClick: true,
		closeBtnInside: false,
		fixedContentPos: true,
		gallery: {
			enabled: true,
			navigateByImgClick: true,
			preload: [0,1] // Will preload 0 - before current, and 1 after the current image
		},
		image: {
			tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
			titleSrc: function(item) {
				return item.el.attr('title');
				// return item.el.attr('title') + '<small>by Marsel Van Oosten</small>';
			}
		}
	});
</script>
