<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED); 
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Home</title>

	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/fontawesome/css/fontawesome.min.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
</head>
<body>

<div class="headerHome">
	<div class="container">
		<div class="col-lg-6">
			<h4 class="welcomeHome">Welcome <?=ucwords($this->session->userdata("username"))?>,</h4>
		</div>
		<div class="col-lg-6">
			<a onclick="logout()" class=" pull-right logoutHome"><h4>Logout</h4></a>
		</div>
	</div>
</div>
	<div class ="container contentHome">
		<div class="col-lg-3">
			<h4>Data Pembayaran Bonus</h4>		
		</div>
		<div class="col-lg-8">
			<a href="<?=base_url()?>index.php/bonus/" class="btn btn-primary"><i class="fa fa-add"></i> Tambah</a>

<div class="tblHome">
			<table id="dtb_bonus" class="table table-bordered table-striped">
				<thead>
					<th>No.</th>
					<th>Nominal</th>
					<th>Action</th>
				</thead>
				<tbody>
					<?php
					$no=1;
					foreach ($listBonus as $key) {?>
						<tr>
							<td><?=$no?>.</td>
							<td>Rp <?=number_format($key->nominal)?></td>
							<?php
							if ($this->session->userdata("groupID")=="1") {
								$btn='<a onclick="showData('.$key->ID.')" class="btn btn-success">Edit</a> <a onclick="delData('.$key->ID.')" class="btn btn-danger">Delete</a>';
							}else{
								$btn='';
							}
							?>
							<td>
								<a href="<?=base_url()?>index.php/bonus/detail/<?=$key->ID?>" class="btn btn-primary">Detail</a> <?=$btn?>
							</td>

						</tr>

						<?php
						$no++;
					}
					?>

				</tbody>
			</table>
			</div>
		</div>
	</div>

	<div class="modal" id="modalEdit" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Edit Pembayaran Bonus</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="formEdit" class="form-horizontal" method="post">
						<div class="form-group">
							<label class="control-label col-lg-4">Total Pembayaran Bonus</label>
							<div class="col-lg-6">
								<input type="text" id="nominal1" class="form-control" placeholder="Total Pembayaran Bonus" required>
								<input type="hidden" name="nominal" id="nominal" class="form-control" placeholder="Total Pembayaran Bonus">
							</div>
						</div>
						<input type="hidden" name="ID" id="idEdit" class="form-control" placeholder="Total Pembayaran Bonus">
					</div>
					<div class="modal-footer">
						<input type="submit" class="btn btn-primary" value="Submit">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
	<script src="<?=base_url()?>assets/bootstrap/js/bootstrap.js"></script>
	<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript">
		$("#dtb_bonus").dataTable();

		function logout() {
			$.ajax({
				type:"POST",
				dataType:"JSON",
				url:"<?=base_url()?>index.php/home/logout/",
				success:function(response) {
					if (response.msg=="good") {
						window.location='<?=base_url()?>';
					}else{
						alert(response.msg);
					}
				}
			});
		}

		function showData(ID) {
			$.ajax({
				type:"POST",
				dataType:"JSON",
				data:{"ID":ID},
				url:"<?=base_url()?>index.php/home/showModalEdit/",
				success:function(response) {
					$("#idEdit").val(ID);
					$("#nominal1").val(response.nominal1);
					$("#nominal").val(response.nominal);
					$("#modalEdit").modal("show");
				}
			});	
		}

		$("#nominal1").bind("change keyup",function (event) {
			if(event.which >= 37 && event.which <= 40){
				event.preventDefault();
			}

			$(this).val(function(index,value) {
				return value
				.replace(/\D/g, "")
				.replace(/([0-9])$/, '$1')  
				.replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ",")

			})
			$("#nominal").val($("#nominal1").val().replace(/,/g,''));
		})
		$(document).ready(function() {
			

			$("form#formEdit").submit(function(e) {
				var data=$("#formEdit").serialize();
				$.ajax({
					type:"POST",
					dataType:"JSON",
					data:data,
					url:"<?=base_url()?>index.php/home/editData/",
					success:function(response) {
						if (response.msg=="good") {
							alert("Success!");
							window.location='<?=base_url()?>';
						}else{
							alert(response.msg);
						}
					}
				});
				e.preventDefault();
			});
		})

		function delData(ID) {
			if (confirm("Yakin hapus data ini?")) {
				$.ajax({
					type:"POST",
					dataType:"JSON",
					data:{"ID":ID},
					url:"<?=base_url()?>index.php/home/delData/",
					success:function(response) {
						if (response.msg=="good") {
							alert("Success!");
							window.location='<?=base_url()?>';
						}else{
							alert(response.msg);
						}
					}
				});		
			}
		}

	</script>
</body>
</html>
