<style type="text/css">
media (min-width: 768px)
.col-sm-offset-2 {
    margin-left: 16.66666667%;
}
.select2 {
width:100%!important;
border-radius: 0px !important;
}
hr {
    border-top: 1px solid #555;
	margin-top:0;
	margin-bottom:5px;
}
.form-control[readonly]{
	background-color: #fff;
	cursor:text;
}
tbody > tr > td {vertical-align: middle !important;}
.custom-file-input::-webkit-file-upload-button {
		visibility: hidden;
	}
	.custom-file-input::before {
	  content: 'Select Photo';
	  display: inline-block;
	  background: -webkit-linear-gradient(top, #f9f9f9, #e3e3e3);
	  border: 1px solid #999;
	  border-radius: 3px;
	  padding: 1px 4px;
	  outline: none;
	  white-space: nowrap;
	  -webkit-user-select: none;
	  cursor: pointer;
	  text-shadow: 1px 1px #fff;
	  font-weight: 700;  
	}
	.custom-file-input:hover::before {	 
	  color: #d3394c;
	}

	.custom-file-input:active::before {
	  background: -webkit-linear-gradient(top, #e3e3e3, #f9f9f9);
	  color: #d3394c;
	}

</style>
<?php
$id_input = !empty($master_inputan) ? (int)$master_inputan->id_input : 0;
$title = !empty($master_inputan) ? $master_inputan->title : '';
$name = !empty($master_inputan) ? $master_inputan->name : '';
$type = !empty($master_inputan) ? $master_inputan->type : '';


?>
<div class="modal fade" role="dialog" id="confirm_warning">
          <div class="modal-dialog" style="width:360px">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><strong>Warning</strong></h4>
              </div>
			 
              <div class="modal-body">
				<h4 class="text-center txt_info">Data telah disimpan </h4>
				
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">Ok</button>               
                            
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>
<div class="modal fade" role="dialog" id="confirm_success">
          <div class="modal-dialog" style="width:380px">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><strong>Success</strong></h4>
              </div>
			 
              <div class="modal-body">
				<h4 class="text-center">Data telah disimpan </h4>
				
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-success btn_ok">Ok</button>               
                            
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>
<div class="box box-info">
            
            <!-- /.box-header -->
            <!-- form start -->
             <form role="form" id="frm_item" accept-charset="utf-8" autocomplete="off">
              <div class="box-body">
			  <div class="row">
			  <div class="col-sm-12">
                <div class="form-group">
                  <label for="supplier">Label</label><span class="label label-danger pull-right lbl_error"></span>
                  <input type="text" class="form-control" name="lbl" id="lbl" value="<?php echo $title;?>" placeholder="Label">
				  <input type="hidden" class="form-control" name="id_form" id="id_form" value="<?php echo $id_form;?>">
				  <input type="hidden" class="form-control" name="id_input" id="id_input" value="<?php echo $id_input;?>">
                </div>
                
				
              </div>		  
              </div>
			  
			  <div class="row">
				<div class="col-md-3">
				<div class="form-group">
                  <label for="merk">Name</label><span class="label label-danger pull-right name_error"></span>
                  <input type="text" class="form-control" name="name" id="name" value="<?php echo $name;?>" placeholder="Name">
                </div>			
				</div>
			  <div class="col-md-3">
                <div class="form-group">
                  <label for="supplier">Type</label><span class="label label-danger pull-right tipe_error"></span>
                  <select class="form-control" name="tipe" id="tipe" onchange="chg_tipe(this,0)">
						<option value="">- Type -</option>
						<option value="free_text" <?php echo $type == 'free_text' ? ' selected' : '';?>>Free Text</option>
						<option value="textarea" <?php echo $type == 'textarea' ? ' selected' : '';?>>Textarea</option>
						<option value="date" <?php echo $type == 'date' ? ' selected' : '';?>>Date</option>
						<option value="radio" <?php echo $type == 'radio' ? ' selected' : '';?>>Radio</option>
						<option value="checkbox" <?php echo $type == 'checkbox' ? ' selected' : '';?>>Checkbox</option>
						<option value="dropdown" <?php echo $type == 'dropdown' ? ' selected' : '';?>>Dropdown</option>
						<option value="time" <?php echo $type == 'time' ? ' selected' : '';?>>Time</option>
						<option value="number" <?php echo $type == 'number' ? ' selected' : '';?>>Number</option>
						<option value="video" <?php echo $type == 'video' ? ' selected' : '';?>>Video</option>
						<option value="image" <?php echo $type == 'image' ? ' selected' : '';?>>Image</option>
					</select>
                </div>			
              </div>
			 
              </div>
			 
			 <div class="row mc">
				
			  <div class="col-sm-12 _opt">
			  <h4><strong>Option</strong></h4>
				<div class="table-responsive">
	<table class="table table-condensed table-hover" id="tbl_item">
		<thead><tr>
			<th style="text-align:center; width:4%">No.</th>
            <th style="text-align:center; width:20%">Title</th>		
			<th style="text-align:center; width:10%">Value</th>			
								
			<th style="text-align:center; width:5%"><button type="button" class="btn btn-success add_item btn-xs" style="margin-bottom:5px"><i class="fa fa-plus"></i> Add</button></th>
		</tr>
		</thead>
		<tbody>
			<?php 
				$ii=1;
				if(!empty($dt_opt)){
					foreach($dt_opt as $do){
						echo '<tr>';
						
						echo '<td align="center">'.$ii.'.</td>';
						echo '<td><input type="text" class="form-control" name="opt[]" id="opt_'.$ii.'" value="'.$do['title'].'" placeholder="Option"></td>';
						echo '<td><input type="text" class="form-control" name="val[]" id="val_'.$ii.'" value="'.$do['value'].'" placeholder="Value"></td>';
						echo "<td align='center'><button class='btn btn-default' id='HapusBayar'><i class='fa fa-times' style='color:red;'></i></button></td>";
						echo '<input type="hidden" name="id_opt[]" id="id_opt_'.$ii.'" value="'.$do['id_opt'].'">';
						echo '</tr>';
						$ii++;
					}
				}
			?>
		</tbody>
	
	</table>
</div>
                
              </div>		  
              </div>
			  
			  
			  
             
             
              <!-- /.box-body -->

             <div class="box-footer">
               
                <button type="button" class="btn btn-danger btn_canc"><i class="glyphicon glyphicon-remove"></i> Cancel</button>
                <button type="button" class="btn btn-success btn_save"><i class="fa fa-check"></i> Save</button>
              </div>
            </form>
          </div>


<link href="<?php echo base_url(); ?>assets/datetimepicker/jquery.datetimepicker.css" rel="stylesheet" type="text/css" />	
<script src="<?php echo base_url(); ?>assets/datetimepicker/jquery.datetimepicker.js"></script>	
<script type="text/javascript">
$('.mc').hide();
function barisBaru(){		
	var Nomor = $('#tbl_item tbody tr').length + 1;
	var Baris = "<tr>";
		
		Baris += "<td align='center'>"+Nomor+".</td>";
		Baris += "<td>";
		Baris += "<input type='text' class='form-control' name='opt[]' id='opt_"+Nomor+"' value='' placeholder='Option'>";					
		Baris += "</td>";		
		Baris += "<td><input type='text' class='form-control' name='val[]' id='val_"+Nomor+"' value='' placeholder='Value'></td>";		
		Baris += "<td align='center'><button class='btn btn-default' id='HapusBayar'><i class='fa fa-times' style='color:red;'></i></button></td>";
		Baris += "<input type='hidden' name='id_opt[]' id='id_opt_"+Nomor+"' value=''>";
		Baris += "</tr>";

	$('#tbl_item tbody').append(Baris);
	
}
$('.add_item').click(function(){
	barisBaru();	
});
var id_form = '<?php echo (int)$id_form;?>';
var val_edit = '<?php echo $type;?>';
$('.btn_save').click(function(){
	$('.lbl_error').text('');
	$('.tipe_error').text('');	
	$('.name_error').text('');	
	$('.btn_canc').attr('disabled', true);
	$('.btn_save').attr('disabled', true);
	var tipe = $('#tipe').val();	
	var lbel = $('#lbl').val();	
	var name = $('#name').val();
	if(lbel <= 0 || lbel == '') {
		$('.btn_canc').attr('disabled', false);
		$('.btn_save').attr('disabled', false);
		$('.lbl_error').text('Label must be filed');
		return false;
	}
	if(name <= 0 || name == '') {
		$('.btn_canc').attr('disabled', false);
		$('.btn_save').attr('disabled', false);
		$('.name_error').text('Name must be filed');
		return false;
	}
	if(tipe <= 0 || tipe == '') {
		$('.btn_canc').attr('disabled', false);
		$('.btn_save').attr('disabled', false);
		$('.tipe_error').text('Type must be filed');
		return false;
	}	
	var _no = 1;
	var Nomor = $('#tbl_item tbody tr').length + 1;
	var TotalIndex = $('#tbl_item tbody tr').length;
	if(tipe == 'radio' || tipe=='dropdown' || tipe=='checkbox'){
		$('#tbl_item tbody tr').each(function(){		
			var select_val = $(this).find('td:nth-child(2) input').val();
			var qty_val = $(this).find('td:nth-child(3) input').val();
			
			if(select_val === '' || qty_val === ''){
				$('.txt_info').text('');
				$('.txt_info').html('Silahkan isi terlebih dahulu data pada baris <b>'+_no+'</b> untuk melanjutkan');
				$('#confirm_warning').modal({
					backdrop: 'static',
					keyboard: false
				});
				$('.btn_canc').attr('disabled', false);
				$('.btn_save').attr('disabled', false);
				$('#confirm_warning').modal('show');
				return false;
			}
			if(_no == TotalIndex){
				simpan_input();
			}
			_no++;
		});
	}else{
		simpan_input();
	}
	
});
function simpan_input(){
	var url = '<?php echo site_url('list_form/simpan_input');?>';
	var dt = $('#frm_item').serialize();
	$.ajax({
		data:dt,
		type:'POST',
		url : url,
		success:function(response){				
			if(response > 0){
				$('#confirm_success').modal({
					backdrop: 'static',
					keyboard: false
				});
				$('#confirm_success').modal('show');							
			}
		}
	})	
}
$('.btn_ok').click(function(){	
	window.location = '<?php echo site_url('list_form/list_input');?>/'+id_form;
});
if(val_edit != ''){	
	chg_tipe(val_edit, 1);
}
function chg_tipe(val, show){
	if(show == 1) var _val = val;
	if(show == 0) var _val = val.value;
	$('.mc').hide();
	
	if(_val == 'radio' || _val=='dropdown' || _val=='checkbox'){		
		$('.mc').show();
	}
	
}

$('.btn_canc').click(function(){
	window.location = '<?php echo site_url('list_form/list_input');?>/'+id_form;
});
$(document).on('click', '#HapusBayar', function(e){
	e.preventDefault();
	$(this).parent().parent().remove();
	 // $(this).closest("tr").remove();
	var Nomor = 1;
	$('#tbl_item tbody tr').each(function(){
		$(this).find('td:nth-child(1)').html(Nomor+'.');
		
		Nomor++;
	});	
});

</script>
