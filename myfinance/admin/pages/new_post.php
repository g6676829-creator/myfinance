<?php require('../php/conn.php');?>
<style type="text/css">
	.post_bg{
		width: 100%;
		height: 95vh;
		background: var(--dark-400);
		position: relative;
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
        padding: 1rem;
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
	/*.tag-item {
	    background-color: var(--dark-300);
	    color: white;
	    padding: 5px 10px;
	    border-radius: 15px;
	    margin-right: 5px;
	    margin-bottom: 5px;
	    display: inline-flex;
	    align-items: center;
	}

	.tag-remove {
	    margin-left: 5px;
	    cursor: pointer;
	}

	.tag-remove:hover {
	    color: red;
	}*/
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
	    background-color: var(--dark-400) !important;
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
</style>
<div class="post_bg rounded shad">
	<h3 class="pagesh3">Create New Post</h3>
	<div class="resmsg d-none"></div>
	<div class="new_post scroll_bar">
		<form class="new_post_frm px-3">

			<div class="form-group">
				<label for="author" class="form-label">Authors</label>
				<select class="form-control slct w-50" name="author" required>
					<option value="none">Select Author</option>
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
					<option value="none">Select category</option>
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
				<input class="form-control w-50" type="text" name="post_title"  placeholder="Write post title here using focus keyword...">
			</div>

			<div class="form-group mt-3">
				<label for="postContent" class="form-label">Content</label>
				<button class="btn btn-primary btn-sm ms-3 form-label editor_switch_btn" type="button">Editor</button>
				<div class="froala_editor">
					<textarea id="postContent" class="froala_editor_content" name="postContent"></textarea>
				</div>
				<div class="editor d-none" id="post-content" contenteditable="true">
                   Start writing your post here in html formating...
                </div>
                <input id="hidden_content" type="hidden">
			</div>

			<div class="form-group mt-3">
				<label for="highlight" class="form-label">Highlights</label>
				<textarea class="form-control highlight" type="text" name="highlight" maxlength="250" placeholder="Write short summary of your post here under 150 words..." rows="3"></textarea>
			</div>

			<div class="form-group mt-3">
				<label for="meta_desc" class="form-label">SEO Meta Description</label>
				<textarea class="form-control" name="meta_desc" maxlength="160" placeholder="For Google Search Results..."></textarea>
			</div>

			<!-- <div class="form-group mt-3">
			    <label for="tags" class="form-label">Tags</label>
			    <div class="input-group w-50">
			        <input type="text" class="form-control" id="tag-input" placeholder="Add tags (comma separated)">
			        <button class="btn btn-outline-light" type="button" id="add-tag-btn">Add</button>
			    </div>
			    <div id="tags-container" class="d-flex flex-wrap mt-2"></div>
			    <input type="hidden" name="tags" id="hidden-tags">
			</div> -->


			<div class="form-group mt-3">
				<label for="banner" class="form-label">Featured image</label>
				<input type="file" name="banner" class="form-control w-50" accept="images
				/*">
			</div>

			<div class="form-group my-3 w-50">
				<label for="url" class="form-label">Url Slugs</label>
				<div class="input-group">
					<snap class="input-group-text">https://myfinance/</snap>
					<input class="form-control" type="text" name="url"  placeholder="Create custom url slug...">
				</div>	
			</div>
			
			
			<input id="hidden_status" type="hidden" name="status">
			<div class="post_control">
				<button class="btn btn-warning" type="submit" disabled>Preview</button>
				<button class="btn btn-info mx-3 sub_btn" type="submit" status="draft">Draft</button>
				<button class="btn btn-primary sub_btn" type="submit" status="publish">Publish</button>
			</div>
		</form>
	</div>
</div>

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
		 // Tags functionality
	    /*const tags = [];
	    
	    $('#add-tag-btn').click(function() {
	        const tagInput = $('#tag-input').val().trim();
	        if (tagInput) {
	            const newTags = tagInput.split(',').map(tag => tag.trim()).filter(tag => tag !== '');
	            
	            newTags.forEach(tag => {
	                if (!tags.includes(tag) && tag !== '') {
	                    tags.push(tag);
	                    renderTags();
	                }
	            });
	            
	            $('#tag-input').val('');
	        }
	    });
	    
	    $('#tag-input').keypress(function(e) {
	        if (e.which === 13 || e.which === 44) { // Enter or comma
	            e.preventDefault();
	            $('#add-tag-btn').click();
	        }
	    });
	    
	    function renderTags() {
	        const tagsContainer = $('#tags-container');
	        tagsContainer.empty();
	        
	        tags.forEach((tag, index) => {
	            const tagElement = $(`
	                <div class="tag-item">
	                    ${tag}
	                    <span class="tag-remove" data-index="${index}">×</span>
	                </div>
	            `);
	            tagsContainer.append(tagElement);
	        });
	        
	        $('#hidden-tags').val(tags.join(','));
	    }
	    
	    $(document).on('click', '.tag-remove', function() {
	        const index = $(this).data('index');
	        tags.splice(index, 1);
	        renderTags();
	    });*/
	    //tags functionality end

	    //ajax for submition start
		$('.sub_btn').click(function () {
			//get the status
			const status = $(this).attr('status');
			$('#hidden_status').val(status);
			//get the content
			const content = $('#post-content').html();
			$('#hidden_content').val(content);
			$.ajax({
				type:'POST',
				url:'php/insert_article.php',
				data:new FormData($('.new_post_frm')[0]),
				contentType:false,
				processData:false,
				success:function (result) {
					if(result.trim()=="success") {
						$('.resmsg').removeClass('d-none');
						$('.resmsg').html('<div class="text-center rounded p-3 text-success fs-5">Post Added Successfully <br><i class="fa-solid fa-check-double fs-3"></i></div>');
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
		    $('.new_post_frm').on('submit', function(ev) {
		        ev.preventDefault();
		    });
		});
		//ajax for submition end
	});
</script>

