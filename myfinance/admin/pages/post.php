<?php require '../php/conn.php';?>
<style type="text/css">
	.post_bg{
		position: relative;
		height: 95vh;
	}
	.all_post_box{
		height: 80vh;
		overflow-x: hidden;
		overflow-y: scroll;
	}
	
	.edit_icon,.del_icon{
		padding: 3px;
		border-radius: 2px;
	}
	.edit_icon:hover{
		color: var(--accent-color);
		background: var(--text-light);
		transition: 0.3s;
	}
	.del_icon:hover{
		color: red;
		background: var(--text-light);
		transition: 0.3s;
	}
</style>

<div class="post_bg w-100 rounded p-3 shad">
	<div class="del_msg d-none"></div>
	<h3>All Articles</h3>
	<div class="scroll_bar all_post_box">
		<table class="table table-hover table-dark w-100">
			<thead>
				<tr>
					<th>Banner</th>
					<th>Title, Category</th>
					<th>Publish date</th>
					<th>Status</th>
					<th>Edit</th>
					<th>Delete</th>
				</tr>	
			</thead>
			<tbody>
				<?php
					$post_sql=$conn->query("SELECT * FROM posts ORDER BY id DESC");
					while ($post_data=$post_sql->fetch_assoc()) {
						echo '
							<tr>
								<td><img src="../images/banners/'.$post_data['banner'].'" alt="aliya image" class="border rounded" width="200px"></td>
								<td class="w-25">'.$post_data['title'].'</td>
								<td>'.$post_data['created_at'].'</td>
								<td>'.$post_data['status'].'</td>
								<td><a href="http://localhost:8080/myfinance/admin/edit_article.php?id='.$post_data['id'].'"><i class="fa-solid fa-pen edit_icon fs-5" id="'.$post_data['id'].'"></i></a></td>
								<td><i class="fa-solid fa-trash del_icon fs-5" id="'.$post_data['id'].'"></i></td>
							</tr>
						';
					}
				?>
			</tbody>
		</table>
	</div>
</div>

<script>
	$(document).ready(function () {
		$('.del_icon').each(function () {
			$(this).click(function () {
				let delid = $(this).attr('id');
				//ajax call for delete
				$.ajax({
					type:'POST',
					url:'php/delete_post.php',
					data:{id:delid},
					success:function (deresult) {
						if (deresult.trim()==="success") {
							$('.del_msg').toggleClass('d-none');
							const msg = '<span class="alert alert-danger fs-5">Post Deleted Successfully <i class="fa-solid fa-check-double"></i></span>';
							$('.del_msg').html(msg);
							setTimeout(function () {
								$('.del_msg').toggleClass('d-none');
								$('.del_msg').html("");
								$('[page_name="post"]').click();
							},2500);
						}
						else {
							alert(deresult);
						}
					}
				});
			})
		})
	})
</script>