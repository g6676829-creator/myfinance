<style type="text/css">
	.media_bg{
		height: 95vh;
		width: 100%;
		position: relative;
	}
	.plus_i{
		padding: 3px;
		position: absolute;
		right: 10px;
		top: 0px;
	}
	.plus_i:hover{
		cursor: pointer;
		color: var(--accent-color);
		background: var(--text-light);
		transition: 0.3s;
	}
	.del_icon:hover{
		cursor: pointer;
		transform: scale(1.09);
		transition: 0.3s;
	}
	.del_icon:hover{
		color: red !important;
	}
	.assets{
		height: 85vh;
		overflow-x: hidden;
		overflow-y: scroll;
	}
</style>

<div class="media_bg">
	<div class="del_msg d-none"></div>
	<h3 class="pagesh3">Media & Assets</h3>
	<i class="fa-solid fa-plus fs-1 plus_i rounded" 
   	data-bs-toggle="modal" 
   	data-bs-target="#media_modal"></i>
	<div class="assets scroll_bar">
		<div class="row">
			<?php
				require('../php/conn.php');
				$media_sql=$conn->query("SELECT * FROM media");
				while ($media_data=$media_sql->fetch_assoc()) {
					echo '
						<div class="col-4 p-3">
							<div class="card">
								<img src="../images/media/'.$media_data["img_name"].'" alt="'.$media_data["alt_tag"].'" class="card-img-top">
								<div class="card-body d-flex justify-content-between p-2">
									<h5 class="card-title">'.$media_data["id"].'. <span class="text-muted">'.$media_data["title_tag"].'</span></h5>
									<i class="fa-solid fa-trash p-2 del_icon" id="'.$media_data["id"].'"></i>
								</div>
							</div>
						</div>
					';
				}
			?>
		</div>
	</div>	
</div>

<!-- modal start -->
<div class="modal fade text-dark" id="media_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      	<h1 class="modal-title fs-5" id="exampleModalLabel">Upload New Media</h1>
        <button type="button" class="btn-close mod_close_btn" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="media_frm">
        	<div class="form-group">
	        	<label for="media_files" class="form-label">Media File</label>
	        	<input type="file" accept="images/*" name="media_files" class="form-control" required>
        	</div>
        	<div class="form-group mt-2">
	        	<label for="file_title" class="form-label">Title Tag</label>
	        	<input type="text" name="file_title" class="form-control" placeholder="Enter Media title tag" required>
        	</div>
        	<div class="form-group mt-2">
	        	<label for="file_alt" class="form-label">Alt Tag</label>
	        	<input type="text" name="file_alt" class="form-control" placeholder="Enter Media alt tag " required>
        	</div>
        	<button class="btn btn-dark w-100 mt-3 add_media_btn" type="submit">Upload</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- modal end -->

<script type="text/javascript">
	$(document).ready(function () {
		$('.media_frm').submit(function (ev) {
			ev.preventDefault();
			$.ajax({
				type:'POST',
				url:'php/insert_media.php',
				data:new FormData(this),
				contentType:false,
				processData:false,
				beforeSend:function () {
					$('.add_media_btn').attr('disabled','disabled');
					$('.add_media_btn').html('Please Wait...');
				},
				success:function (result) {
					$('.add_media_btn').removeAttr('disabled');
					$('.add_media_btn').html('Upload');
					if(result.trim()=="success") {
						$massage='Media uploaded successfully <i class="fa-solid fa-check-double"></i>';
						$('.add_media_btn').removeClass('btn-dark');
						$('.add_media_btn').addClass('btn-success');
						$('.add_media_btn').html($massage);
						setTimeout(function () {
							$('.add_media_btn').removeClass('btn-success');
							$('.add_media_btn').addClass('btn-dark');
							$('.add_media_btn').html('Upload');
							$('.media_frm').trigger('reset');
						},2500);
					}
					else {
						$('.add_media_btn').removeClass('btn-dark');
						$('.add_media_btn').addClass('btn-warning');
						$('.add_media_btn').html(result);
						setTimeout(function () {
							$('.add_media_btn').removeClass('btn-warning');
							$('.add_media_btn').addClass('btn-dark');
							$('.add_media_btn').html('Upload');
							$('.media_frm').trigger('reset');
						},2500);
					}
				}
			})
		});
		//default click on auhtors menu when modal closed
		$('.mod_close_btn').click(function () {
			$('[page_name="media"]').click();
		});
		//delete media coding start
		$('.del_icon').click(function () {
			let id = $(this).attr('id');
			$.ajax({
				type:'POST',
				url:'php/del_media.php',
				data:{id:id},
				success:function (del_result) {
					if(del_result.trim()=="success") {
						const msg = '<span class="alert alert-danger fs-1 shadow">Deleted <i class="fa-solid fa-check-double"></i></span>';
						$('.del_msg').removeClass('d-none');
						$('.del_msg').html(msg);
						setTimeout(function () {
							$('.del_msg').addClass('d-none');
							$('.del_msg').html("");
							$('[page_name="media"]').click();
						},2500);
					}
				}
			})
		});
	})
</script>