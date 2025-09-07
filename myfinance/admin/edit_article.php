<?php require 'php/conn.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- froala editor files -->
    <link href="editor/froala_editor.pkgd.min.css" rel="stylesheet">
    <!-- jquery cdn -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	<title>Edit Article</title>
	<style type="text/css">
		.edit_article_bg{
			width: 100%;
			height: 100vh;
			background: #424242;
			position: relative;
			color: #fff
		}
		.new_post{
			width: 100%;
			height: 83vh;
			overflow-x: hidden;
			overflow-y: scroll;
		}
		
		.new_post_frm input,.new_post_frm textarea{
			box-shadow: none !important;
			background: inherit !important;
		}

		.editor{
			min-height: 300px;
	        border: 1px solid #d1d5db;
	        border-radius: 0.375rem;
	        padding: 2rem;
	    }
	    [contenteditable="true"] {
		    outline: none;
		}
		.new_post_frm input,
		.new_post_frm textarea,
		.new_post_frm select {
		    color: white !important;
		}

		.new_post_frm input::placeholder,
		.new_post_frm textarea::placeholder {
		    color: #a0a0a0 !important;
		    opacity: 1 !important;
		}
		
		.post_control{
			width: fit-content;
			height: fit-content;
			border-radius: 10px;
			padding: 7px;
			position: absolute;
			top: 0;
			right: 0;
		}
		.new_post_frm select, 
		.new_post_frm select option {
			box-shadow: none !important;
		    background-color: #424242 !important;
		    color: white !important;
		    border: 1px solid white;
		}
		.resmsg{
			width: 100%;
			height: 95vh;
			background: rgba(0, 0, 0, 0.7);
			position: absolute;
			top: 0;
			left: 0;
			z-index: 9999;
		}
		.resmsg div{
			width: fit-content;
			background: white;
			margin: 20% auto;
		}
		.pageh3{
			border-bottom: 3px solid #4e4e4e;
			padding: 9px;
			font-weight: normal;
		}
		/*scrollbar design*/
		.scroll_bar::-webkit-scrollbar {
		  width: 3px;
		}

		.scroll_bar::-webkit-scrollbar-track {
		  background: transparent;
		}

		.scroll_bar::-webkit-scrollbar-thumb {
		  background: var(--accent-color);
		  border-radius: 3px;
		}
		.scroll_bar::-webkit-scrollbar-thumb:hover {
		    background: var(--accent-color);
		}
	</style>
</head>
<body>
	<div class="edit_article_bg scroll_bar p-3">
		<h3 class="pagesh3">Edit this article</h3>
		<div class="resmsg d-none"></div>
		<div class="new_post scroll_bar">
			<form class="update_post_frm px-3">

				<?php
					$id=$_GET['id'];
					//fetch post data first
					$post_sql=$conn->query("SELECT * FROM posts WHERE id='$id'");
					$post_data=$post_sql->fetch_assoc();
					//fetch auth data
					$auth_id=$post_data['auth_id'];
					$old_auth_sql=$conn->query("SELECT * FROM authors WHERE id='$auth_id'");
					$old_auth_data=$old_auth_sql->fetch_assoc();
					//fetch category data
					$old_cat_url=$post_data['cat'];
					$old_cat_name=str_replace('-',' ',$old_cat_url);
					$old_cat_name=ucwords($old_cat_name);					
				?>

				<div class="form-group">
					<label for="author" class="form-label">Authors</label>
					<select class="form-control slct w-50" name="author" required>
						<option value="<?php echo $old_auth_data['id'];?>"><?php echo $old_auth_data['name'];?></option>
						<?php
							$sql=$conn->query("SELECT * FROM authors");
							while ($auth_data=$sql->fetch_assoc()) {
								echo "<option value='".$auth_data['id']."'>".$auth_data['name']."</option>";
							}
						?>
					</select>
				</div>

				<div class="form-group mt-3">
					<label for="category" class="form-label">Category</label>
					<select class="form-control slct w-50" name="cat" required>
						<option value="<?php echo $old_cat_url; ?>"><?php echo $old_cat_name;?></option>
						<?php
							$sql=$conn->query("SELECT * FROM categories");
							while ($cat_data=$sql->fetch_assoc()) {
								echo "<option value='".$cat_data['cat_url']."'>".$cat_data['cat_name']."</option>";
							}
						?>
					</select>
				</div>

				<div class="form-group mt-3">
					<label for="post_title" class="form-label">Title</label>
					<input class="form-control w-50" type="text" name="post_title"  value="<?php echo $post_data['title'];?>">
				</div>

				<div class="form-group mt-3">
					<label for="postContent" class="form-label">Content</label>
					<button class="btn btn-primary btn-sm ms-3 form-label editor_switch_btn" type="button">Editor</button>
					<div class="froala_editor">
						<textarea id="postContent" class="froala_editor_content" name="postContent"><?php echo $post_data['content'];?></textarea>
					</div>
					<div class="editor d-none scroll_bar" id="post-content" contenteditable="true">
	                   <?php 
						    // Step 1: Remove data-* attributes
						    $cleaned_data = preg_replace('/\sdata-[^=]+="[^"]*"/', '', $post_data['content']);

						    // Step 2: Decode existing HTML entities (like &lt; to <)
						    $decoded_data = html_entity_decode($cleaned_data);

						    // Step 4: Encode again to display as raw HTML code
						    $html_data = htmlspecialchars($decoded_data);

						    // Step 5: Output as plain text (preserve formatting)
						    echo "$html_data";
						?>
	                </div>
	                <input id="hidden_content" type="hidden">
	                <input type="hidden" name="id" value="<?php echo $post_data['id'];?>">
				</div>

				<div class="form-group mt-3">
					<label for="highlight" class="form-label">Highlights</label>
					<textarea class="form-control highlight" type="text" name="highlight" rows="3" maxlength="250"><?php echo $post_data['summary'];?></textarea>
				</div>

				<div class="form-group mt-3">
					<label for="meta_desc" class="form-label">SEO Meta Description</label>
					<textarea class="form-control" name="meta_desc" maxlength="160"><?php echo $post_data['meta_desc'];?></textarea>
				</div>

				<div class="form-group mt-3">
					<label for="banner" class="form-label">Featured image</label>
					<input type="file" name="banner" class="form-control w-50" accept="images
					/*">
				</div>

				<div class="form-group mt-3">
					<label for="status" class="form-label">Title</label>
					<input class="form-control w-50" type="text" name="status"  value="<?php echo $post_data['status'];?>">
				</div>				
			
				<div class="post_control">
					<button class="btn btn-warning me-3" type="submit" disabled>Preview</button>
					<button class="btn btn-primary sub_btn" type="submit">Update</button>
				</div>
			</form>
		</div>
	</div>


	<!-- Froala Editor JS Files -->
    <script src="editor/froala_editor.pkgd.min.js"></script>
    <!-- bootstrap cdn -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	<script type="text/javascript">
	// Initialize Froala Editor with Heading Options
    new FroalaEditor('#postContent', {
        toolbarButtons: {
            moreText: {
                buttons: ['bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript'],
                buttonsVisible: 6
            },
            moreParagraph: {
                buttons: ['paragraphFormat', 'alignLeft', 'alignCenter', 'alignRight', 'alignJustify', 'formatOL', 'formatUL'],
                buttonsVisible: 4
            },
            moreRich: {
                buttons: ['insertLink', 'insertImage', 'insertVideo', 'insertTable', 'emoticons', 'fontAwesome', 'specialCharacters', 'embedly'],
                buttonsVisible: 4
            },
            moreMisc: {
                buttons: ['undo', 'redo', 'fullscreen', 'print', 'getPDF', 'spellChecker', 'selectAll', 'html', 'help'],
                buttonsVisible: 4
            }
        },
        // Enable Heading Formats (H1, H2, H3, etc.)
        paragraphFormat: {
            N: 'Normal',
            H1: 'Heading 1',
            H2: 'Heading 2',
            H3: 'Heading 3',
            H4: 'Heading 4',
            PRE: 'Code'
        },
        // Other settings
        heightMin: 300,
        placeholderText: 'Write your blog post here...',
        charCounterCount: true,
        toolbarSticky: true,
    });
	$(document).ready(function () {
		$('.editor_switch_btn').click(function () {
			if($(this).html()=="Editor") {
				$(this).html("HTML");
				$('.froala_editor').addClass('d-none');
				$('.froala_editor_content').removeAttr('name');
				$('#hidden_content').attr('name','postContent');
				$('.editor').removeClass('d-none');
			}
			else {
				$(this).html("Editor");
				$('#hidden_content').removeAttr('name');
				$('.froala_editor_content').attr('name','postContent');
				$('.froala_editor').removeClass('d-none');
				$('.editor').addClass('d-none');
			}
		});
		 
	    //ajax for submition start
		$('.sub_btn').click(function () {
			//get the content
			const content = $('#post-content').html();
			$('#hidden_content').val(content);
			$.ajax({
				type:'POST',
				url:'php/update_article.php',
				data:new FormData($('.update_post_frm')[0]),
				contentType:false,
				processData:false,
				success:function (result) {
					if(result.trim()=="updated") {
						$('.resmsg').removeClass('d-none');
						$('.resmsg').html('<div class="text-center rounded p-3 text-success fs-5">Post Updated Successfully <br><i class="fa-solid fa-check-double fs-3"></i></div>');
						setTimeout(function () {
							$('.resmsg').addClass('d-none');
							$('.resmsg').html('');
							$('[page_name="new_post"]').click();
						},2500);
					}
					else {
						$('.resmsg').removeClass('d-none');
						$('.resmsg').html('<div class="text-center rounded p-3 text-warning fw-semibold fs-5">'+result+'</div>');
						setTimeout(function () {
							$('.resmsg').addClass('d-none');
							$('.resmsg').html('');
						},2500);
					}	
				}
			});
			// Prevent normal form submission
		    $('.update_post_frm').on('submit', function(ev) {
		        ev.preventDefault();
		    });
		});
		//ajax for submition end
	});
	</script>
</body>
</html>