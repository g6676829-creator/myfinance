<?php require '../php/conn.php';?>
<style type="text/css">
	.cat_frm input,.edit_cat_frm input{
	box-shadow: none !important;
	border: none;
	}

	.edit_icon:hover,.del_icon:hover{
		cursor: pointer;
		transform: scale(1.09);
		transition: 0.3s;
	}
	.del_icon:hover{
		color: red !important;
	}
</style>
<div class="row">
	<div class="del_msg d-none"></div>
	<div class="col-6 p-3">
		<div class="adc_box rounded p-3 shad">
			<h3 class="pagesh3">Add New Category</h3>
			<form class="cat_frm">
				<label for="category_name" class="form-label">Category Name</label>
				<input type="text" name="category_name" class="form-control category_name" placeholder="*Type new category name here..." required>
				<button type="submit" class="btn btn-info w-100 mt-3 text-dark fw-semibold save_btn">Save</button>
			</form>
			<div class="msg"></div>
		</div>	
	</div>
	<div class="col-6 p-3">
		<div class="allc_box p-3 shad rounded">
			<h3>All Categories</h3>
			<div class="teb_box scroll_bar" style="height: 50vh; overflow-y: scroll;">
				<table class="table table-dark table-hover cust_table">
					<tr>
						<th>Id</th>
						<th>Name</th>
						<th>Edit</th>
						<th>Delete</th>
					</tr>
					<?php
						$cat_sql=$conn->query("SELECT * FROM categories");
						if ($cat_sql->num_rows>0) {
							//fetch and print data in table bia loop
							while ($data=$cat_sql->fetch_assoc()) {
								echo "
									<tr>
										<td>".$data['id']."</td>
										<td>".$data['cat_name']."</td>
										<td><i class='fa-solid fa-pen-to-square text-primary edit_icon' id=".$data['id']." data-bs-toggle='modal' data-bs-target='#edit_cat_modal'></i></td>
										<td><i class='fa-solid fa-trash text-warning del_icon' id=".$data['id']."></i></td>
									</tr>
								";
							}
						}						
					?>	
				</table>
			</div>
		</div>
	</div>
</div>

<!-- model for edit start -->
<div class="modal fade text-dark" id="edit_cat_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" style="background-color: var(--dark-500);">
      <div class="modal-header">
        <h1 class="modal-title fs-5 text-light" id="exampleModalLabel">Edit Category</h1>
        <button type="button" class="btn-close mod_close_btn" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      	<form class="edit_cat_frm">
					<label for="edit_cat_name" class="form-label text-light">Category Name</label>
					<input type="text" name="category_name" class="form-control edit_cat_name border" required>
					<input class="hidden_id" type="hidden" name="hidden_id">
					<button type="submit" class="btn btn-primary w-100 mt-3 fw-semibold update_btn">Update</button>
				</form>
				<div class="edit_msg"></div>
      </div>
    </div>
  </div>
</div>
<!-- model for edit end -->

<script type="text/javascript">
	$(document).ready(function () {
		$('.cat_frm').submit(function (e) {
			e.preventDefault();
			let cat_name = $('.category_name').val();
			$.ajax({
				type:'POST',
				url:'php/insert_cat.php',
				data:{cat_name:cat_name},
				beforeSend:function () {
					$('.save_btn').html('Please Wait...');
					$('.save_btn').attr('disabled','disabled');
				},
				success:function (result) {
					$('.save_btn').html('Save');
					$('.save_btn').removeAttr('disabled');
					if (result.trim()==='success') {
						$massage="<p class='alert alert-success mt-3'>New Category Added Successfully</p>";
						$('.msg').html($massage);
						setTimeout(function () { 
							$('.msg').html('');
							$('[page_name="cat"]').click();
						},2500);
					}
					else {
						$massage="<p class='alert alert-warning mt-3'>"+result+"</p>";
						$('.msg').html($massage);
						setTimeout(function () {
							$('.msg').html('');
							$('[page_name="cat"]').click();
						},2500);		
					}
				}
			})
		});
		//edit category code
		$('.edit_icon').each(function () {
			$(this).click(function () {
				let edit_id = $(this).attr('id');
				//get category data
				$.ajax({
					type:'POST',
					url:'php/get_cat_data.php',
					data:{id:edit_id},
					success:function (result) {
						const data = JSON.parse(result);
						$('.edit_cat_name').val(data.cat_name);
						$('.hidden_id').val(data.id);
					}
				});
				//update category
				$('.edit_cat_frm').submit(function (ev) {
					ev.preventDefault();
					$.ajax({
						type:'POST',
						url:'php/update_category.php',
						data:new FormData(this),
						contentType:false,
						processData:false,
						beforeSend:function () {
							$('.update_btn').attr('disabled','disabled');
							$('.update_btn').html('Please Wait...');
						},
						success:function (update_re) {
							$('.update_btn').removeAttr('disabled');
							$('.update_btn').html('Update');
							if (update_re.trim()==="success") {
								$massage="<p class='alert alert-success mt-3'>Category Updated Successfully</p>";
								$('.edit_msg').html($massage);
								setTimeout(function () { 
									$('.edit_msg').html('');
									$('.mod_close_btn').click();
									$('[page_name="cat"]').click();
								},2500);
							}
							else {
								$massage="<p class='alert alert-warning mt-3'>"+result+"</p>";
								$('.edit_msg').html($massage);
								setTimeout(function () {
									$('.edit_msg').html('');
									$('.mod_close_btn').click();
									$('[page_name="cat"]').click();
								},2500);	
							}
						}
					})
				})
			})
		});
		//delete category coding
		$('.del_icon').each(function () {
			$(this).click(function () {
				let delid = $(this).attr('id');
				//ajax call for delete category
				$.ajax({
					type:'POST',
					url:'php/delete_cat.php',
					data:{id:delid},
					success:function (delresult) {
						if(delresult.trim()==="success") {
							let delmsg = '<span class="alert alert-danger fs-5">Category Deleted Successfully <i class="fa-solid fa-check-double"></i></span>';
							$('.del_msg').html(delmsg);
							$('.del_msg').toggleClass('d-none');
							setTimeout(function () {
								$('.del_msg').html("");
								$('.del_msg').toggleClass('d-none');
								$('[page_name="cat"]').click();
							},2500);
						}
						else {
							alert(delresult);
						}
					}
				})
			})
		})
	})
</script>