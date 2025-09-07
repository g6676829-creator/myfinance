<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>dashboard : finance routine</title>
	<link rel="icon" type="image/png" href="images/new_logo.png">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- froala editor files -->
    <link href="editor/froala_editor.pkgd.min.css" rel="stylesheet">
    <!-- jquery cdn -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
	<div class="left shad p-3">
		<div class="header sticky-top">
			<a class="navbar-brand fs-4 cust_logo pb-2" href="http://localhost:8080/myfinance/">
		      <span class="text-white">Admin/</span><span class="text-warning">Dashborad</span>
		    </a>
		</div>
		<div class="menu_box mt-3 py-3 rounded scroll_bar">
			<ul class="text-white">
				<li class="menu_items" page_name="auth">Authors</li>
				<li class="menu_items" page_name="cat">Category</li>
				<li class="menu_items" page_name="media">Media Assets</li>
				<li class="menu_items" page_name="post">Post</li>
				<li class="menu_items" page_name="new_post">New Post <i class="fa-solid fa-plus"></i></li>
			</ul>
		</div>
	</div>
	<div class="right p-3"></div>


	<!-- jquery code and js soureces -->
	<script type="text/javascript">
		$(document).ready(function () {
			$('.menu_items').each(function () {
				$(this).click(function () {
					let page_name = $(this).attr('page_name');
					//ajax for pages
					$.ajax({
						type:'POST',
						url:'pages/'+page_name+'.php',
						beforeSend:function () {
							$('.right').html('<div class="text-center py-5">Loading...</div>');
						},
						success:function (response) {
							$('.right').html(response);
						}
					});
				});
			});
			$('[page_name="new_post"]').click();
		});
	</script>
	<!-- Froala Editor JS Files -->
    <script src="editor/froala_editor.pkgd.min.js"></script>
    <!-- bootstrap cdn -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>