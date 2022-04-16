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


<br/>
 <div class="box box-success">

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
			<th style="text-align:center; width:17%">No.SPK</th>
			<th style="text-align:center; width:17%">User From</th>
			<th style="text-align:center; width:17%">User To</th>
			<th style="text-align:center; width:40%">Message</th>
			
			<th style="text-align:center; width:5%">Action</th>
		</tr>
		</thead>
		<tbody>
			<?php 
				$i =1;
				$status = null;
				$_level = null;
				if(!empty($master_chat)){
					foreach($master_chat as $u){	
						
						
						echo '<tr>';
						echo '<td align="center" style="vertical-align: middle;">'.$i++.'.</td>';
						echo '<td style="vertical-align: middle;">'.$u['spk_no'].'</td>';
						echo '<td style="vertical-align: middle;">'.$u['user_name'].'</td>';
						echo '<td style="vertical-align: middle;">'.$u['user_name_to'].'</td>';
						echo '<td style="vertical-align: middle;">'.$u['pesan'].'</td>';
						echo '<td align="center" style="vertical-align: middle;">
			
			<a href="'.site_url('chat/chat_detail/'.$u['id_chat']).'" title="View Detail"><button class="btn btn-xs btn-info"><i class="fa fa-eye"></i> View Detail</button></a></td>';
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

<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
	
<script type="text/javascript">
$("#success-alert").hide();
$("input").attr("autocomplete", "off"); 

$(function() {               
    $('#example88').dataTable({});
});


</script>
