<div class="container" style="padding-top: 15px;">
	<!-- Content Header (Page header) -->
	<section class="content-header" style="margin-bottom: 20px;">
		<h2 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0;">
			<i class="fa fa-trophy" style="color: #2563eb; margin-right: 8px;"></i> Rincian Hasil Ujian
		</h2>
		<p style="font-size: 13.5px; color: #64748b; margin-top: 5px;">
			Hasil perolehan nilai dan evaluasi pengerjaan tes Anda.
		</p>
	</section>

	<!-- Main content -->
	<section class="content" style="padding: 0;">
		<div class="row">
			<div class="col-xs-12">
				<div class="box box-success box-solid" style="border-radius: 12px; overflow: hidden; margin-bottom: 25px;">
					<div class="box-header with-border" style="padding: 14px 20px; background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);">
						<div class="box-title" style="font-weight: 700; font-size: 15px;">
							<i class="fa fa-user"></i> Informasi Hasil Peserta
						</div>
					</div><!-- /.box-header -->

					<div class="box-body" style="padding: 24px;">
						<input type="hidden" name="tes-user-id" id="tes-user-id" value="<?php if(!empty($tes_user_id)){ echo $tes_user_id; } ?>">
						<div class="row">
							<div class="col-md-6 col-xs-12">
								<table class="table" style="margin-bottom: 10px;">
									<tr>
										<td style="color: #64748b; font-weight: 600; width: 35%; border-top: none;">Nama Peserta</td>
										<td style="font-weight: 800; color: #0f172a; border-top: none;"><?php if(!empty($user_nama)){ echo htmlspecialchars($user_nama); } ?></td>
									</tr>
									<tr>
										<td style="color: #64748b; font-weight: 600;">Mata Uji</td>
										<td style="font-weight: 700; color: #1e40af;"><?php if(!empty($tes_nama)){ echo htmlspecialchars($tes_nama); } ?></td>
									</tr>
									<tr>
										<td style="color: #64748b; font-weight: 600;">Mulai Pengerjaan</td>
										<td style="color: #334155; font-weight: 500;"><?php if(!empty($tes_mulai)){ echo htmlspecialchars($tes_mulai); } ?></td>
									</tr>
								</table>
							</div>
							<div class="col-md-6 col-xs-12">
								<div style="background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 18px 24px; display: flex; gap: 20px; justify-content: space-around; align-items: center;">
									<div style="text-align: center;">
										<div style="font-size: 12px; font-weight: 700; text-transform: uppercase; color: #64748b;">Nilai Akhir</div>
										<div style="font-size: 32px; font-weight: 800; color: #2563eb; line-height: 1.2;">
											<?php if(!empty($nilai)){ echo htmlspecialchars($nilai); }else{ echo '0'; } ?>
										</div>
									</div>
									<div style="height: 40px; width: 1px; background: #cbd5e1;"></div>
									<div style="text-align: center;">
										<div style="font-size: 12px; font-weight: 700; text-transform: uppercase; color: #64748b;">Jumlah Benar</div>
										<div style="font-size: 26px; font-weight: 800; color: #059669; line-height: 1.2;">
											<?php if(!empty($benar)){ echo htmlspecialchars($benar); }else{ echo '0'; } ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="box-footer" style="padding: 14px 20px; background: #f8fafc; border-top: 1px solid #e2e8f0;">
						<a href="<?php echo site_url().'/tes_dashboard'; ?>" class="btn btn-default" style="border-radius: 8px; font-weight: 600; padding: 7px 18px;">
							<i class="fa fa-arrow-left"></i> Kembali ke Dashboard
						</a>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
					<div class="box">
						<div class="box-header with-border">
							<div class="box-title">Soal dan Jawaban</div>
							<div class="box-tools pull-right">
								<a href="#" onclick="refresh_table()">Refresh Detail Tes</span></a>
							</div>
						</div><!-- /.box-header -->

						<div class="box-body">
							<table id="table-soal" class="table table-bordered">
								<thead>
									<tr>
										<th>No.</th>
										<th>Tipe Soal</th>
										<th>Soal</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td> </td>
										<td> </td>
										<td> </td>
									</tr>
								</tbody>
							</table>                        
						</div>
					</div>
			</div>
		</div>

	</section><!-- /.content -->
</div>



<script lang="javascript">
    function refresh_table(){
        $('#table-soal').dataTable().fnReloadAjax();
    }

    $(function(){
        $('#table-soal').DataTable({
                  "paging": true,
                  "iDisplayLength":10,
                  "bProcessing": false,
                  "bServerSide": true, 
                  "searching": true,
                  "aoColumns": [
    					{"bSearchable": false, "bSortable": false, "sWidth":"20px"},
    					{"bSearchable": false, "bSortable": false, "sWidth":"80px"},
    					{"bSearchable": false, "bSortable": false}],
                  "sAjaxSource": "<?php echo site_url().'/'.$url; ?>/get_datatable/",
                  "autoWidth": false,
                  "fnServerParams": function ( aoData ) {
                    aoData.push( { "name": "tes_user_id", "value": $('#tes-user-id').val()} );
                  }
         });
		 
		$( document ).ready(function() {
			refresh_topik();
		});
    });
</script>