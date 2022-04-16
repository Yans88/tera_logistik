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

<div class="modal fade" role="dialog" id="frm_user">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Add User</h4>
              </div>
			 
              <div class="modal-body" style="padding-bottom:2px;">
				
				<form role="form" id="form_users" autocomplete="off">
                <!-- text input -->
				<div class="row">
				<div class="col-md-6">
                <div class="form-group">
                  <label>Username</label><span class="label label-danger pull-right username_error"></span>
                  <input type="text" class="form-control" name="username" id="username" value="" placeholder="Username" autocomplete="off" />
                  <input type="hidden" value="" name="id_user" id="id_user">
                </div>
				
				 <div class="form-group">
                  <label>Name</label><span class="label label-danger pull-right name_error"></span>
                  <input type="text" class="form-control" name="name" id="name" value="" placeholder="Name" autocomplete="off" />
                </div>	

				
				
				
				</div>				
				
				<div class="col-md-6">
				<div class="form-group">
                  <label>Password</label><span class="label label-danger pull-right password_error"></span>
                  <input type="text" class="form-control" name="password" id="password" value="" placeholder="Password" autocomplete="off" />
                </div>
				
				
				
				<div class="form-group">
                  <label>Status</label><span class="label label-danger pull-right status_error"></span>
                  <select class="form-control" name="status" id="status" >
					  <option value="">-- Pilih Status --</option>
					  <option value="1">Active</option>
					  <option value="0">Inactive</option>
				  </select>
                </div>	
				
				
				
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
    <a href="#"><button class="btn btn-success add_user"><i class="fa fa-plus"></i> Add User</button></a>
</div>
<div class="box-body">
<div class='alert alert-info alert-dismissable' id="success-alert">
   
    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
    <div id="id_text"><b>Welcome</b></div>
</div>
	<!-- <div class="row">
    <div class="col-xs-12"> -->
      <div class="table-responsive">
	<table id="example88" class="table table-bordered table-striped">
		<thead><tr>
			<th style="text-align:center; width:4%">No.</th>
			<th style="text-align:center; width:20%">Username</th>
			<th style="text-align:center; width:20%">Name</th>
			
			<th style="text-align:center; width:10%">Status</th>
			<th style="text-align:center; width:15%">Action</th>
		</tr>
		</thead>
		<tbody>
			<?php 
				$i =1;
				$status = null;
				$_level = null;
				if(!empty($users)){
					foreach($users as $u){	
						
						$info = $u['operator_id'].'Þ'.ucwords($this->converter->decode($u['_user'])).'Þ'.$u['status'].'Þ'.$u['name'].'Þ'.$this->converter->decode($u['_pass']);					
						$status = null;
						$_level = null;						
						if($u['status'] == 1){
							$status = '<small class="label label-success bg-green">Active</small>';
						}else if($u['status'] == 0){
							$status = '<small class="label label-danger">Inactive</small>';
						}else{
							$status = '';
						}
						
						echo '<tr>';
						echo '<td align="center" style="vertical-align: middle;">'.$i++.'.</td>';
						echo '<td style="vertical-align: middle;">'.ucwords($this->converter->decode($u['_user'])).'</td>';
						echo '<td style="vertical-align: middle;">'.ucwords($u['name']).'</td>';
						
						
						echo '<td align="center" style="vertical-align: middle;">'.$status.'</td>';
						echo '<td align="center" style="vertical-align: middle;">
			<a href="#" title="Edit" id="'.$info.'" class="edit_user"><button class="btn btn-xs btn-success"><i class="fa fa-edit"></i> Edit</button></a>
			<a href="#" title="Delete" id="'.$u['operator_id'].'" class="del_user"><button class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i> Delete</button></a></td>';
						echo '</tr>';
					}
				}
			?>
		</tbody>
	
	</table>
</div>
</div>
<!-- </div>
</div> -->

</div>
<link href="<?php echo base_url(); ?>assets/datetimepicker/jquery.datetimepicker.css" rel="stylesheet" type="text/css" />	
<script src="<?php echo base_url(); ?>assets/datetimepicker/jquery.datetimepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
	
<script type="text/javascript">
$("#success-alert").hide();
$("input").attr("autocomplete", "off"); 
$('.del_user').click(function(){
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
	var url = '<?php echo site_url('user/del');?>';
	$.ajax({
		data : {id : id},
		url : url,
		type : "POST",
		success:function(response){
			$('#confirm_del').modal('hide');
			$("#id_text").html('<b>Success,</b> Data user telah dihapus');
			$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
				$("#success-alert").alert('close');
				location.reload();
			});			
		}
	});
	
});

$('#tgl_lahir').datetimepicker({
	dayOfWeekStart : 1,
	changeYear: false,
	timepicker:false,
	scrollInput:false,
	format:'d-m-Y',
	lang:'en',
	maxDate: '<?php echo date('d/m/Y');?>'
});

$('.yes_save').click(function(){
	var id_user = $('#id_user').val();
	var username = $('#username').val();
	
	var password = $('#password').val();
	
	
	var status = $('#status').val();	
	var name = $('#name').val();
	level = 1;		
	$('.username_error').text('');
	$('.name_error').text('');
	
	$('.password_error').text('');
	$('.level_error').text('');
	$('.status_error').text('');
	
	if(username <= 0 || username == '') {
		$('.username_error').text('Username harus diisi');
		return false;
	}
	if(name <= 0 || name == '') {
		$('.name_error').text('Name harus diisi');
		return false;
	}
	
	if(status == '') {
		$('.status_error').text('Status harus dipilih');
		return false;
	}
	
	if(id_user <=0 || id_user == ''){
		if(password <=0 || password == ''){
			$('.password_error').text('Password harus diisi');
			return false;
		}
		
	}
	
	var dt = $('#form_users').serialize();
	var url = '<?php echo site_url('user/save');?>';
	$.ajax({
		data:dt,
		type:'POST',
		url : url,
		success:function(response){
			if(response == 'taken'){
				$('.username_error').text('Username sudah digunakan');
				return false;
			}
			if(response > 0){
				$('#frm_user').modal('hide');
				$("#id_text").html('<b>Success,</b> Data user telah disimpan');
				$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
					$("#success-alert").alert('close');
					location.reload();
				});								
			}
		}
	})
});

$('.add_user').click(function(){
	$('.username_error').text('');
	$('.fullname_error').text('');	
	$('.password_error').text('');
	$('.level_error').text('');
	$('.status_error').text('');
	$('.email_error').text('');
	$('#form_users').find("input[type=text], select, input[type=hidden]").val("");
	$('#frm_user').modal({
		backdrop: 'static',
		keyboard: false
	});
	$('#frm_user').modal('show');
});
$(function() {               
    $('#example88').dataTable({});
});
$('.edit_user').click(function(){
	$('.username_error').text('');
	$('.fullname_error').text('');
	
	$('.password_error').text('');
	$('.level_error').text('');
	$('.status_error').text('');
	$('.email_error').text('');
	$('#form_users').find("input[type=text], select").val("");
	var val = $(this).get(0).id;
	var dt = val.split('Þ');
	$('#id_user').val(dt[0]);
	$('#username').val(dt[1]);
	
	$('#status').val(dt[2]);
	$('#name').val(dt[3]);	
	
	$('#password').val(dt[4]);	
	
	$('#frm_user').modal({
		backdrop: 'static',
		keyboard: false
	});
	$('#frm_user').modal('show');
});

</script>
