<style type="text/css">
	.auth_bg{
		position: relative;
		height: 95vh;
	}
	.all_auth_box{
		height: 80vh;
		overflow-x: hidden;
		overflow-y: scroll;
	}
	.plus_i{
		padding: 3px;
		position: absolute;
		right: 20px;
		top: 20px;
	}
	.plus_i:hover{
		cursor: pointer;
		color: var(--accent-color);
		background: var(--text-light);
		transition: 0.3s;
	}
	.adauth_frm input,.adauth_frm textarea{
		box-shadow: none !important;
	}
	.modal-content{
		background: var(--text-light);
	}
	.modal-body{
		margin-top: -0.5rem !important;
	}
	.modal-header{
		border-bottom: 1px solid black;
		padding-bottom: 0.5rem !important;
		margin: 0 !important;
	}
	.edit_icon,.del_icon{
		font-size: 20px;
		padding: 3px;
		border-radius: 2px;
		cursor: pointer;
	}
	.edit_icon:hover{
		color: var(--accent-color);
		transition: 0.3s;
	}
	.del_icon:hover{
		color: red;
		transition: 0.3s;
	}
</style>

<div class="auth_bg w-100 rounded p-3 shad">
	<div class="del_msg d-none"></div>
	<h3 class="pagesh3">All Authors</h3>
	<i class="fa-solid fa-plus fs-1 plus_i rounded" 
   data-bs-toggle="modal" 
   data-bs-target="#auth_modal"></i>
	<div class="scroll_bar all_auth_box">
		<div class="row">
			<?php
				require('../php/conn.php');
				$auth_sql=$conn->query("SELECT * FROM authors");
				while ($auth_data=$auth_sql->fetch_assoc()) {
					echo '
						<div class="col-4 py-3">
							<div class="card" style="width: 18rem;">
							  <img src="../images/author_image/'.$auth_data["img_name"].'" class="rounded-circle mx-auto" alt="'.$auth_data["img_name"].'" style="height:180px;width:180px;">
							  <div class="card-body">
							    <h5 class="card-title m-0 p-0">'.$auth_data["name"].'</h5>
							    <small class="text-primary">'.$auth_data["bio"].'</small><br>
							    <p class="card-text p-0">'.$auth_data["lba"].'</p>
							    <i class="fa-solid fa-pen-to-square edit_icon" id="'.$auth_data['id'].'" data-bs-toggle="modal" data-bs-target="#edit_auth_modal"></i>
							    <i class="fa-solid fa-trash del_icon" id="'.$auth_data['id'].'"></i>
								</div>
							</div>
						</div>
					';
				}
			?>
		</div>
		<!-- <table class="table table-hover table-dark w-100">
			<thead>
				<tr>
					<th>Id</th>
					<th>Picture</th>
					<th>Name, Bio</th>
					<th>Line By Auther</th>
					<th>Joining Date</th>
				</tr>	
			</thead>
			<tbody>
				<?php
					/*require('../php/conn.php');
					$auth_sql=$conn->query("SELECT * FROM authors");
					while ($auth_data=$auth_sql->fetch_assoc()) {
						echo '
							<tr>
								<td>'.$auth_data["id"].'</td>
								<td><img src="../images/author_image/'.$auth_data["img_name"].'" alt="Author" class="border rounded me-3" width="90"></td>
								<td><h4 class="m-0">'.$auth_data["name"].'</h4><small>'.$auth_data["bio"].'</small></td>
								<td class="w-50"><p>'.$auth_data["lba"].'</p></td>
								<td><p>'.$auth_data["listed_at"].'</p></td>
							</tr>
						';
					}*/
				?>
			</tbody>
		</table> -->
	</div>
</div>

<!-- add author modal start -->
<div class="modal fade text-dark" id="auth_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Author</h1>
        <button type="button" class="btn-close mod_close_btn" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      	<div class="msg"></div>
        <form class="adauth_frm">
        	<div class="form-group">
	        	<label for="profile_picture" class="form-label">Profile Picture</label>
	        	<input type="file" accept="images/*" name="profile_picture" class="form-control" required>
        	</div>
        	<div class="form-group mt-2">
	        	<label for="author_name" class="form-label">Name</label>
	        	<input type="text" name="author_name" class="form-control" placeholder="Enter Author Name" required>
        	</div>
        	<div class="form-group mt-2">
	        	<label for="author_bio" class="form-label">Bio</label>
	        	<input type="text" name="author_bio" class="form-control" placeholder="Investment Expert, Insurance Advisor etc..." required>
        	</div>
        	<div class="form-group mt-2">
	        	<label for="about_author" class="form-label">Line By Author</label>
	        	<textarea type="text" name="about_author" class="form-control" placeholder="Type atleast 50 words by auhtor" required></textarea>
        	</div>
        	<button class="btn btn-dark w-100 mt-3 add_auth_btn" type="submit">Add Now</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!--add author modal end -->

<!--edit auhtor modal start -->
<div class="modal fade text-dark" id="edit_auth_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Author</h1>
        <button type="button" class="btn-close mod_close_btn" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="edit_auth_frm">
        	<div class="form-group">
	        	<label for="profile_picture" class="form-label">Profile Picture</label>
	        	<input type="file" accept="images/*" name="profile_picture" class="form-control">
        	</div>
        	<div class="form-group mt-2">
	        	<label for="author_name" class="form-label">Name</label>
	        	<input type="text" name="author_name" class="form-control name" placeholder="Enter Author Name" required>
        	</div>
        	<div class="form-group mt-2">
	        	<label for="author_bio" class="form-label">Bio</label>
	        	<input type="text" name="author_bio" class="form-control bio" placeholder="Investment Expert, Insurance Advisor etc..." required>
        	</div>
        	<div class="form-group mt-2">
	        	<label for="about_author" class="form-label">Line By Author</label>
	        	<textarea type="text" name="about_author" class="form-control lba" placeholder="Type atleast 50 words by auhtor" required></textarea>
        	</div>
        	<input type="hidden" name="id" class="hidden_id">
        	<button class="btn btn-dark w-100 mt-3 edit_auth_btn" type="submit">Save</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!--edit auhtor modal end -->


<script type="text/javascript">
	$(document).ready(function () {
		$('.adauth_frm').submit(function (event) {
			event.preventDefault();
			$.ajax({
				type:'POST',
				url:'php/insert_auth.php',
				data:new FormData(this),
				contentType:false,
				processData:false,
				beforeSend:function () {
					$('.add_auth_btn').attr('disabled','disabled');
					$('.add_auth_btn').html('Please Wait...');
				},
				success:function (result) {
					$('.add_auth_btn').removeAttr('disabled');
					$('.add_auth_btn').html('Add Now');
					if (result.trim()=='inserted') {
						$massage="<p class='alert alert-success mt-3'>New Author Listed Successfully</p>";
						$('.msg').html($massage);
						setTimeout(function () { 
							$('.msg').html('');
							$('.adauth_frm').trigger('reset');
						},2500);
					}
				}
			})
		})
		//author editing code
		$('.edit_icon').each(function () {
			$(this).click(function () {
				let id = $(this).attr('id');
				//get auhtor data
				$.ajax({
					type:'POST',
					url:'php/edit_author.php',
					data:{id:id},
					success:function (result) {
						let data = JSON.parse(result);
						$('.name').val(data.name);
						$('.bio').val(data.bio);
						$('.lba').val(data.lba);
						$('.hidden_id').val(data.id);
						// submit the edit form
						$('.edit_auth_frm').submit(function (ev) {
							ev.preventDefault();
							//ajax for update
							$.ajax({
								type:'POST',
								url:'php/update_author.php',
								data:new FormData(this),
								contentType:false,
								processData:false,
								beforeSend:function () {
									$('.edit_auth_btn').html('Please Wait...');
									$('.edit_auth_btn').attr('disabled','disabled');
								},
								success:function (result) {
									//$('.edit_auth_btn').html('Save');
									$('.edit_auth_btn').removeAttr('disabled');
									if (result.trim()=="success") {
										$('.edit_auth_btn').html('Author details updated <i class="fa-solid fa-check-double"></i>');
										$('.edit_auth_btn').removeClass('btn-dark');
										$('.edit_auth_btn').addClass('btn-success');
										setTimeout(function (argument) {
											$('.edit_auth_btn').html('Save');
											$('.edit_auth_btn').removeClass('btn-success');
											$('.edit_auth_btn').addClass('btn-dark');
										},2500);
									}
									else {
										alert(result);
									}
								}
							})
						})
					}
				})
			})
		});
		//delete author functionalty
		$('.del_icon').each(function () {
			$(this).click(function () {
				let id = $(this).attr('id');
				//ajax for delete
				$.ajax({
					type:'POST',
					url:'php/delete_author.php',
					data:{id:id},
					success:function (delresult) {
						if(delresult.trim()==="success") {
							let delmsg = '<span class="alert alert-danger fs-5">Author Deleted Successfully <i class="fa-solid fa-check-double"></i></span>';
							$('.del_msg').html(delmsg);
							$('.del_msg').toggleClass('d-none');
							setTimeout(function () {
								$('.del_msg').html("");
								$('.del_msg').toggleClass('d-none');
								$('[page_name="auth"]').click();
							},2500);
						}
						else {
							alert(delresult);
						}
					}
				})
			})
		})
		//default click on auhtors menu when modal closed
		$('.mod_close_btn').click(function () {
			$('[page_name="auth"]').click();
		})
	})
</script>