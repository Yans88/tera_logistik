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
 <div class="box-header hide">
    
	
         <form action="" method="post" autocomplete="off" id="search_report">
			<input type="hidden" name="id_chat" id="id_chat" value="<?php echo $master_chat->id_chat;?>" />
			<button type="button" id="btn_export" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-share-alt"></i> Export</button>          
		</form>
    
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
			<th style="text-align:center; width:17%">User From</th>
			<th style="text-align:center; width:17%">User To</th>
			<th style="text-align:center; width:45%">Message</th>
			<th style="text-align:center; width:12%">Created Date</th>
		</tr>
		</thead>
		<tbody>
			<?php 
				$i =1;
				$status = null;
				$_level = null;
				if(!empty($chat_detail)){
					foreach($chat_detail as $u){	
						
						
						echo '<tr>';
						echo '<td align="center" style="vertical-align: middle;">'.$i++.'.</td>';
						
						echo '<td style="vertical-align: middle;">'.$u['user_name_from'].'</td>';
						echo '<td style="vertical-align: middle;">'.$u['user_name_to'].'</td>';
						echo '<td style="vertical-align: middle;">'.$u['pesan'].'</td>';
						echo '<td style="vertical-align: middle;">'.date('d-m-Y H:i', strtotime($u['created_at'])).'</td>';
						
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

$("#btn_export").click(function(){	
	var url = '<?php echo site_url('chat/export_chat');?>';
	$('#search_report').attr('action', url);
	$('#search_report').submit();
});

</script>
