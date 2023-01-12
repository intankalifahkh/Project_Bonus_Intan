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
			<h4>Add Pembayaran Bonus</h4>		
		</div>
		<div class="col-lg-12">
			<form id="formAdd" class="form-horizontal" method="post">
				<div class="form-group">
					<label class="control-label col-lg-3">Total Pembayaran Bonus</label>
					<div class="col-lg-4">
						<input type="text" id="nominal1" class="form-control" placeholder="Total Pembayaran Bonus" required>
						<input type="hidden" name="nominal" id="nominal" class="form-control" placeholder="Total Pembayaran Bonus" required>
					</div>
				</div>
				<div class="form-group">
					<div class="col-lg-3">
						<input type="text" name="nama[]" id="nama1" class="form-control" placeholder="Nama" value="Buruh 1" required readonly>
					</div>
					<div class="col-lg-3">
						<input type="text" name="persenBonus[]" id="persenBonus1" class="form-control" placeholder="Persentase Bonus" value="0" required>
					</div>
					<div class="col-lg-1">
						%
					</div>
					<div class="col-lg-1">
						Rp
					</div>
					<div class="col-lg-3">
						<input type="text" id="nominalBonusc1" class="form-control" placeholder="Nominal Bonus" required readonly>
						<input type="hidden" name="nominalBonus[]" id="nominalBonus1" class="form-control" placeholder="Total Pembayaran Bonus" required>
					</div>
				</div>
				<div class="form-group">
					<div class="col-lg-3">
						<input type="text" name="nama[]" id="nama2" class="form-control" placeholder="Nama" value="Buruh 2" required readonly>
					</div>
					<div class="col-lg-3">
						<input type="text" name="persenBonus[]" id="persenBonus2" class="form-control" placeholder="Persentase Bonus" value="0" required>
					</div>
					<div class="col-lg-1">
						%
					</div>
					<div class="col-lg-1">
						Rp
					</div>
					<div class="col-lg-3">
						<input type="text" id="nominalBonusc2" class="form-control" placeholder="Nominal Bonus" required readonly>
						<input type="hidden" name="nominalBonus[]" id="nominalBonus2" class="form-control" placeholder="Total Pembayaran Bonus" required>
					</div>
				</div>
				<div class="form-group">
					<div class="col-lg-3">
						<input type="text" name="nama[]" id="nama3" class="form-control" placeholder="Nama" value="Buruh 3" required readonly>
					</div>
					<div class="col-lg-3">
						<input type="text" name="persenBonus[]" id="persenBonus3" class="form-control" placeholder="Persentase Bonus" value="0" required>
					</div>
					<div class="col-lg-1">
						%
					</div>
					<div class="col-lg-1">
						Rp
					</div>
					<div class="col-lg-3">
						<input type="text" id="nominalBonusc3" class="form-control" placeholder="Nominal Bonus" required readonly>
						<input type="hidden" name="nominalBonus[]" id="nominalBonus3" class="form-control" placeholder="Total Pembayaran Bonus" required>
					</div>
					<div class="col-lg-1" id="btnTambah4">
						<a onclick="tambahData('4')" class="btn btn-primary">Tambah</a>
					</div>
				</div>
				<div id="lytBonus4"></div>
				<input type="hidden" name="jmlData" id="jmlData" value="3">
				<div class="form-group">
					<div class="col-lg-3">&nbsp;</div>
					<div class="col-lg-3">
						<input type="submit" name="submit" class="btn btn-primary" value="Submit">
						<a href="<?=base_url()?>" class="btn btn-success">Kembali</a>
					</div>
				</div>
			</form>
		</div>
	</div>


	<script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
	<script src="<?=base_url()?>assets/bootstrap/js/bootstrap.js"></script>
	<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript">

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
			var nominal=$("#nominal1").val().replace(/,/g,'');
			$("#nominal").val(nominal);
			for (var i = 1; i <= $("#jmlData").val(); i++) {
				var persen=$("#persenBonus"+i).val()==""?0:$("#persenBonus"+i).val();
				if (nominal!="") {
					var totalBonus=(parseInt(nominal)*parseInt(persen))/100;
					$("#nominalBonus"+i).val(totalBonus);
					$("#nominalBonusc"+i).val(formatRupiah($("#nominalBonus"+i).val()));
				}
			}
		})
		$("#persenBonus1,#persenBonus2,#persenBonus3").bind("change keyup",function (event) {
			if(event.which >= 37 && event.which <= 40){
				event.preventDefault();
			}
			var nominal=$("#nominal").val();

			for (var i = 1; i <= $("#jmlData").val(); i++) {
				var persen=$("#persenBonus"+i).val()==""?0:$("#persenBonus"+i).val();
				if (nominal!="") {
					var totalBonus=(parseInt(nominal)*parseInt(persen))/100;
					$("#nominalBonus"+i).val(totalBonus);
					$("#nominalBonusc"+i).val(formatRupiah($("#nominalBonus"+i).val()));
				}
			}
		})
		

		function tambahData(i) {
			var ii=parseInt(i)+1;
			var lyt=$("#lytBonus"+i).html('<div class="form-group">'+
				'<div class="col-lg-3">'+
				'<input type="text" name="nama[]" id="nama'+i+'" class="form-control" placeholder="Nama" value="Buruh '+i+'" required readonly>'+
				'</div>'+
				'<div class="col-lg-3">'+
				'<input type="text" name="persenBonus[]" id="persenBonus'+i+'" class="form-control" placeholder="Persentase Bonus" value="0" required>'+
				'</div>'+
				'<div class="col-lg-1">'+
				'%'+
				'</div>'+
				'<div class="col-lg-1">'+
				'Rp'+
				'</div>'+
				'<div class="col-lg-3">'+
				'<input type="text" id="nominalBonusc'+i+'" class="form-control" placeholder="Nominal Bonus" required readonly>'+
				'<input type="hidden" name="nominalBonus[]" id="nominalBonus'+i+'" class="form-control" placeholder="Total Pembayaran Bonus" required>'+
				'</div>'+
				'<div class="col-lg-1" id="btnTambah'+ii+'">'+
				'<a onclick="tambahData('+ii+')" class="btn btn-primary">Tambah</a>'+
				'</div>'+
				'</div>'+
				'<div id="lytBonus'+ii+'"></div>');
			$("#btnTambah"+i).prop("hidden",true);
			$("#jmlData").val(i);

			$("#persenBonus"+i).bind("change keyup",function (event) {
				if(event.which >= 37 && event.which <= 40){
					event.preventDefault();
				}
				var nominal=$("#nominal").val();
				var persen=$("#persenBonus"+i).val()==""?0:$("#persenBonus"+i).val();
				if (nominal!="") {
					var totalBonus=(parseInt(nominal)*parseInt(persen))/100;
					$("#nominalBonus"+i).val(totalBonus);
					$("#nominalBonusc"+i).val(formatRupiah($("#nominalBonus"+i).val()));
				}
			})

		}

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
				for (var i = 1; i <= $("#jmlData").val(); i++) {
					var txtPersen=$("#persenBonus"+i).val();
					jmlPersen+=parseInt(txtPersen);
				}
				if (jmlPersen<100) {
					alert("Persentase bonus kurang dari 100!");
				}else if (jmlPersen>100) {
					alert("Persentase bonus lebih dari 100!");
				}else{

					$.ajax({
						type:"POST",
						dataType:"JSON",
						data:data,
						url:"<?=base_url()?>index.php/bonus/add/",
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
				e.preventDefault();
			});
		})
	</script>
</body>
</html>
