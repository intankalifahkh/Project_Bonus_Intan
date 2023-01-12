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
		<div class="col-lg-12">
			<h4>Detail Pembayaran Bonus</h4>		
		</div>
		<div class="col-lg-12">
			<form id="formAdd" class="form-horizontal" method="post">
				<div class="form-group">
					<label class="control-label col-lg-3">Total Pembayaran Bonus</label>
					<label class="control-label col-lg-3">Rp <?=number_format($bonus->nominal)?></label>
				</div>
				<?php
				if ($this->session->userdata("groupID")=="1") {?>
					

					<div class="form-group">
						<div class="col-lg-3">
							<input type="text" name="nama1" id="nama1" class="form-control" placeholder="Nama" required>
						</div>
						<div class="col-lg-3">
							<input type="text" name="persenBonus1" id="persenBonus1" class="form-control" placeholder="Persentase Bonus" value="0" required>
						</div>
						<div class="col-lg-1">
							%
						</div>
						<div class="col-lg-1">
							Rp
						</div>
						<div class="col-lg-3">
							<input type="text" id="nominalBonusc1" class="form-control" placeholder="Nominal Bonus" required readonly>
							<input type="hidden" name="nominalBonus1" id="nominalBonus1" class="form-control" placeholder="Total Pembayaran Bonus" required>
						</div>
					</div>
					<input type="hidden" name="headerID" class="form-control" placeholder="Total Pembayaran Bonus" value="<?=$bonus->ID?>">

					<div class="form-group">
						<div class="col-lg-3">&nbsp;</div>
						<div class="col-lg-3">
							<input type="submit" name="submit" class="btn btn-primary" value="Submit">
							<a href="<?=base_url()?>" class="btn btn-success">Kembali</a>
						</div>
					</div>
				<?php }else{
					?>
					<div class="form-group">
						<div class="col-lg-3">&nbsp;</div>
						<div class="col-lg-7 pull-right">
							<a href="<?=base_url()?>" class="btn btn-success">Kembali</a>
						</div>
					</div>
				<?php }
				?> 
			</form>
		</div>

		<div class="col-lg-12">
			<table id="dtb_bonus_detail" class="table table-bordered table-striped">
				<thead>
					<th>No.</th>
					<th>Nama</th>
					<th>Persentase Bonus</th>
					<th>Nominal Bonus</th>
					<?php
					if ($this->session->userdata("groupID")=="1") {
						echo '<th>Action</th>';
					}
					?>
				</thead>
				<tbody>
					<?php
					$no=1;
					$persenBonus=0;
					foreach ($listBonus as $key) {?>
						<tr>
							<td><?=$no?>.</td>
							<td><?=$key->nama?></td>
							<td><?=$key->persenBonus?>% <input type="hidden" id="persenBonusnya<?=$key->ID?>" value="<?=$key->persenBonus?>"></td>
							<td>Rp <?=number_format($key->nominalBonus)?></td>
							<?php

							if ($this->session->userdata("groupID")=="1") {?>
								<td>
									<a onclick="showData('<?=$key->ID?>')" class="btn btn-success">Edit</a> <a onclick="delData('<?=$key->ID?>')" class="btn btn-danger">Delete</a>
								</td>
								<?php
							}
							?>
							

						</tr>

						<?php
						$persenBonus+=$key->persenBonus;
						$no++;
					}
					?>

				</tbody>
			</table>
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
							<div class="col-lg-3">
								<input type="text" name="nama1" id="nama1Up" class="form-control" placeholder="Nama" required>
							</div>
							<div class="col-lg-3">
								<input type="text" name="persenBonus1" id="persenBonus1Up" class="form-control" placeholder="Persentase Bonus" value="0" required>
							</div>
							<div class="col-lg-1">
								%
							</div>
							<div class="col-lg-1">
								Rp
							</div>
							<div class="col-lg-3">
								<input type="text" id="nominalBonusc1Up" class="form-control" placeholder="Nominal Bonus" required readonly>
								<input type="hidden" name="nominalBonus1" id="nominalBonus1Up" class="form-control" placeholder="Total Pembayaran Bonus" required>
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

		$("#dtb_bonus_detail").dataTable();
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

		
		$("#persenBonus1,#persenBonus1Up").bind("change keyup",function (event) {
			if(event.which >= 37 && event.which <= 40){
				event.preventDefault();
			}
			var nominal='<?=$bonus->nominal?>';

			var i = 1;
			var persen=$("#persenBonus"+i).val()==""?0:$("#persenBonus"+i).val();
			var persenUp=$("#persenBonus1Up").val()==""?0:$("#persenBonus1Up").val();
			if (nominal!="") {
				var totalBonus=(parseInt(nominal)*parseInt(persen))/100;
				$("#nominalBonus"+i).val(totalBonus);
				$("#nominalBonusc"+i).val(formatRupiah($("#nominalBonus"+i).val()));

				var totalBonusUp=(parseInt(nominal)*parseInt(persenUp))/100;
				$("#nominalBonus1Up").val(totalBonusUp);
				$("#nominalBonusc1Up").val(formatRupiah($("#nominalBonus1Up").val()));
			}

		})
		

		function formatRupiah(angka) {
			sisa=angka.length%3;
			rupiah=angka.substr(0,sisa);
			ribuan=angka.substr(sisa).match(/\d{3}/gi);
			if(ribuan){
				separator = sisa ? '.' : '';
				rupiah += separator + ribuan.join('.');
			}
			return rupiah
		}

		$(document).ready(function() {
			

			$("form#formAdd").submit(function(e) {
				var data=$("#formAdd").serialize();
				var jmlPersen=0;
				var totalPersen='<?=$persenBonus?>';
				var txtPersen=$("#persenBonus1").val();
				jmlPersen+=parseInt(txtPersen);
				jmlPersen+=parseInt(totalPersen);
				console.log(jmlPersen);
				if (jmlPersen<100) {
					alert("Persentase bonus kurang dari 100!");
				}else if (jmlPersen>100) {
					alert("Persentase bonus lebih dari 100!");
				}else{

					$.ajax({
						type:"POST",
						dataType:"JSON",
						data:data,
						url:"<?=base_url()?>index.php/bonus/addDetail/",
						success:function(response) {
							if (response.msg=="good") {
								alert("Success!");
								window.location='<?=base_url()?>index.php/bonus/detail/<?=$this->uri->segment(3)?>';
							}else{
								alert(response.msg);
							}
						}
					});
				}
				e.preventDefault();
			});

			$("form#formEdit").submit(function(e) {
				var data=$("#formEdit").serialize();
				var jmlPersen=0;
				var id=$("#idEdit").val();
				var persenLama=$("#persenBonusnya"+id).val();
				var totalPersen='<?=$persenBonus?>';
				var totalPersenNew=parseInt(totalPersen) - parseInt(persenLama);
				var txtPersen=$("#persenBonus1Up").val();
				jmlPersen+=parseInt(txtPersen);
				jmlPersen+=parseInt(totalPersenNew);
				if (jmlPersen>100) {
					alert("Persentase bonus lebih dari 100!");
				}else{

					$.ajax({
						type:"POST",
						dataType:"JSON",
						data:data,
						url:"<?=base_url()?>index.php/bonus/editData/",
						success:function(response) {
							if (response.msg=="good") {
								alert("Success!");
								window.location='<?=base_url()?>index.php/bonus/detail/<?=$this->uri->segment(3)?>';
							}else{
								alert(response.msg);
							}
						}
					});
				}
				e.preventDefault();
			});
		})

		function showData(ID) {
			$.ajax({
				type:"POST",
				dataType:"JSON",
				data:{"ID":ID},
				url:"<?=base_url()?>index.php/bonus/showModalEdit/",
				success:function(response) {
					$("#idEdit").val(ID);
					$("#nama1Up").val(response.nama);
					$("#persenBonus1Up").val(response.persenBonus);
					$("#nominalBonusc1Up").val(response.nominalBonus1);
					$("#nominalBonus1Up").val(response.nominalBonus);
					$("#modalEdit").modal("show");
				}
			});	
		}
		function delData(ID) {
			if (confirm("Yakin hapus data ini?")) {
				$.ajax({
					type:"POST",
					dataType:"JSON",
					data:{"ID":ID},
					url:"<?=base_url()?>index.php/bonus/delData/",
					success:function(response) {
						if (response.msg=="good") {
							alert("Success!");
							window.location='<?=base_url()?>index.php/bonus/detail/<?=$this->uri->segment(3)?>';
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
