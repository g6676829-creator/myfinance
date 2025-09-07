<?php require 'php/conn.php';?>
<?php
    $id=$_GET['id'];
    $post_sql=$conn->query("SELECT * FROM posts WHERE id='$id'");
    $post_data=$post_sql->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finance Routine : the personal finance blog</title>
    <meta name="description" content="<?php echo $post_data['meta_desc'];?>">
    <link rel="icon" type="image/png" href="images/new_logo.png">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>    
    <?php require('components/nav.php');?>

    <section class="fade-in reading_page">
        <div class="row">
            <div class="col-md-8 read_box">
                <div class="art_info row">
                    
                    <h1 class="bg-light rounded"><?php echo $post_data['title'];?></h1>

                    <div class="col-md-6">
                        <img src="images/banners/<?php echo $post_data['banner'];?>" class="card-img-top rounded">
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted rounded p-2 bg-light"><?php echo $post_data['summary'];?></p>
                        <div class="article-meta">
                            <span class="reading-time px-2 rounded bg-info text-white"><?php echo $post_data['cat'];?></span>
                            <span class="comments-count px-2 rounded bg-primary text-white"><?php echo $post_data['created_at'];?></span>
                        </div>
                    </div>
                    <hr>
                    <article>
                        <div class="col-12 bg-light rounded">
                           <?php echo htmlspecialchars_decode($post_data['content']); ?>
                        </div>
                    </article>
                    <hr>
                    <div class="ur-tools row bg-light rounded py-2">
                        <div class="col-md-5 d-flex align-items-center justify-content-around">
                            <div class="like_ele">
                                <span class="text-muted p-2 fs-5"><?php echo $post_data['like_count'];?></span>
                                <button class="btn btn-outline-primary like_btn"><i class="fa-regular fa-thumbs-up fs-5 like_icon"></i></button>
                            </div>
                            <div class="share_ele">
                                <button class="btn btn-outline-primary share_btn"><i class="fa-solid fa-share-from-square fs-5"></i></button>
                            </div>    
                        </div>
                        <div class="col-md-7">
                            <form class="comment_frm">
                                <textarea class="form-control shadow comment_input mt-3" placeholder="Write your feedback on this post..." style="outline: none; box-shadow: none;border-bottom: 2px solid black;" required></textarea>
                                <button class="btn btn-primary w-100 mt-3 post_com_btn" type="submit">Post</button>
                            </form>
                        </div>
                        <div class="pubcom row col-12">
                            <?php
                                //fetch comment count 'cc'
                                $cc=$conn->query("SELECT * FROM comments WHERE artid='$id';");
                                $cc=$cc->num_rows;
                            ?>
                            <div class="container-fluid mt-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Comments<span class="text-muted p-2 fs-5"><?php echo $cc; ?></h5>
                                        <?php
                                            $comm_sql=$conn->query("SELECT * FROM comments WHERE artid='$id' ORDER BY id DESC LIMIT 5;");
                                            while ($comm_aa=$comm_sql->fetch_assoc()) {
                                                $u_id=$comm_aa['u_id'];
                                                //fetch user name
                                                $user_sql=$conn->query("SELECT name FROM users WHERE id='$u_id';");
                                                $user_aa=$user_sql->fetch_assoc();
                                                echo '
                                                    <div>
                                                        <i class="fa-solid fa-user"></i><span class="fw-bold"> '.$user_aa['name'].' : </span><span class="text-muted text-left">'.$comm_aa['comtext'].'</span>
                                                    </div> 
                                                ';
                                            }
                                        ?>
                                        
                                        <!-- Collapsible Content (Hidden by Default) -->
                                        <div class="collapse mt-2" id="collapseExample">
                                            <div class="card card-body bg-light">
                                                <?php
                                                    $all_comm_sql=$conn->query("SELECT * FROM comments WHERE artid='$id' ORDER BY id DESC LIMIT 50 OFFSET 5;");
                                                    while ($all_comm_aa=$all_comm_sql->fetch_assoc()) {
                                                        $u_id=$all_comm_aa['u_id'];
                                                        //fetch user name
                                                        $user_sql=$conn->query("SELECT name FROM users WHERE id='$u_id';");
                                                        $user_aa=$user_sql->fetch_assoc();
                                                        echo '
                                                            <div>
                                                                <i class="fa-solid fa-user"></i><span class="fw-bold"> '.$user_aa['name'].' : </span><span class="text-muted text-left">'.$all_comm_aa['comtext'].'</span>
                                                            </div> 
                                                        ';
                                                    }
                                                ?>
                                            </div>
                                        </div>

                                        <!-- Toggle Button -->
                                        <button 
                                            class="btn btn-primary mt-3" 
                                            type="button" 
                                            data-bs-toggle="collapse" 
                                            data-bs-target="#collapseExample" 
                                            aria-expanded="false" 
                                            aria-controls="collapseExample"
                                        >
                                            See More
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row pop_article mt-3">
                    <h3 class="mt-3">Popular Article</h3>
                    <?php
                        $pop_post_sql=$conn->query("SELECT * FROM posts WHERE status='publish' ORDER BY id DESC LIMIT 3");

                        while ($pop_post_data=$pop_post_sql->fetch_assoc()) {
                            //fetch author
                            $auth_id=$pop_post_data['auth_id'];
                            $auth_sql=$conn->query("SELECT * FROM authors WHERE id='$auth_id'");
                            $auth_data=$auth_sql->fetch_assoc();
        
                            echo '
                                <div class="col-md-6 p-lg-3 pt-3">
                                    <div class="card custom_card">
                                       <img src="images/banners/'.$pop_post_data['banner'].'" class="card-img-top" alt="thumnail">
                                        <div class="card-body">
                                            <h5 class="card-title">'.$pop_post_data['title'].'</h5>
                                            <p class="card-text">'.$pop_post_data['summary'].'</p>
                                        </div>

                                        <div class="card-footer d-flex justify-content-between align-items-center">
                                            <a href="http://localhost:8080/myfinance/article_info.php?id='.$pop_post_data['id'].'" class="btn btn-outline-info">Read...</a>
                                            <div class="author ms-auto">
                                                <div class="author_image me-3">
                                                    <img src="images/author_image/'.$auth_data['img_name'].'" width="50px">
                                                </div>
                                                <span>By :<b> '.$auth_data['name'].'</b><br><small>'.$pop_post_data['created_at'].'</small></span>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            ';
                        }
                    ?>
                </div>
            </div>
            <div class="col-md-4 aa_box">
                <!-- About Author Widget -->
                <div class="sidebar-widget fade-in">
                    <?php
                        $aot_id=$post_data['auth_id'];//aut is stand for about the author of this article
                        $aot_sql=$conn->query("SELECT * FROM authors WHERE id='$aot_id'");
                        $aot_data=$aot_sql->fetch_assoc();
                    ?>
                    <h3 class="widget-title">About The Author Of This Article</h3>
                    <div class="d-flex align-items-center mb-3">
                        <img src="images/author_image/<?php echo $aot_data['img_name'];?>" alt="Author" class="rounded-circle me-3" width="100" style="height: 100px;">
                        <div>
                            <h4 class="mb-1"><?php echo $aot_data['name'];?></h4>
                            <p class="text-muted mb-0"><?php echo $aot_data['bio'];?></p>
                        </div>
                    </div>
                    <p><?php echo $aot_data['lba'];?></p>
                    <div class="social-sharing">
                        <a href="#" class="facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="twitter"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="linkedin"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="instagram" style="background: #E1306C;"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <!-- all articles section -->
                <div class="aa_background">
                    <h3>Browse All</h3>
                    <div class="aa_content fs-6 text-primary px-2">
                        <div class="allpost">
                            <?php
                                $all_post_sql=$conn->query("SELECT * FROM posts WHERE status='publish'");
                                while ($all_post_data=$all_post_sql->fetch_assoc()) {
                                    echo '
                                        <div class="post bg-white border p-3 rounded shadow mt-3">
                                            <a href="http://localhost:8080/myfinance/article_info.php?id='.$all_post_data['id'].'"><label>'.$all_post_data['title'].'</label></a><hr>
                                            <div class="article-meta">
                                                <span class="reading-time bg-dark text-white px-2 rounded">'.$all_post_data['cat'].'</span>
                                                <span class="views-count">'.$all_post_data['created_at'].'</span>
                                            </div>
                                        </div>     
                                    ';
                                }
                            ?>                           
                        </div>                    
                    </div>
                </div>
                
                <!-- Categories Widget -->
                <div class="sidebar-widget fade-in mt-4">
                    <h3 class="widget-title">Categories</h3>
                    <ul class="category-list">
                        <?php
                            $cat_sql=$conn->query("SELECT * FROM categories");
                            if ($cat_sql->num_rows>0) {
                                //fetch and print data in table bia loop
                                while ($data=$cat_sql->fetch_assoc()) {
                                    echo '
                                        <li><a href="http://localhost:8080/myfinance/post_by_cat.php?cat='.$data["cat_url"].'">'.$data["cat_name"].' <span class="category-count">24</span></a></li>
                                    ';
                                }
                            }                       
                        ?>  
                    </ul>
                </div>
            </div>
        </div>        
    </section>

    <?php require("components/footer.php");?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
   
    <script type="text/javascript">
        $(document).ready(function () {
            $('.comment_frm').submit(function (ev) {
                ev.preventDefault();
                const art_id = <?php echo $post_data['id'];?>;
                const comment = $('.comment_input').val();
                $.ajax({
                    type:'POST',
                    url:'php/store_comment.php',
                    data:{
                        art_id:art_id,
                        comment:comment
                    },
                    success:function (response) {
                        if (response.trim()=="success") {
                            $('.post_com_btn').html('Done <i class="fa-solid fa-check-double"></i>');
                            $('.post_com_btn').toggleClass("btn-primary");
                            $('.post_com_btn').toggleClass("btn-success");
                            setTimeout(function () {
                                $('.post_com_btn').html('Post');
                                $('.post_com_btn').toggleClass("btn-primary");
                                $('.post_com_btn').toggleClass("btn-success");
                                $('.comment_frm').trigger('reset');
                            },2500);
                        }
                        else {
                            alert(response);
                        }
                    }
                })
            });
            // Share Button Functionality
            $('.share_btn').click(function () {
                const shareData = {
                    title: "<?php echo addslashes($post_data['title']); ?>",
                    text: "<?php echo addslashes($post_data['summary']); ?>",
                    url: window.location.href
                };

                if (navigator.share) {
                    // For supported devices (mobile mostly)
                    navigator.share(shareData)
                        .then(() => console.log('Thanks for sharing!'))
                        .catch(console.error);
                } 
                else {
                    // Fallback for unsupported browsers
                    navigator.clipboard.writeText(shareData.url).then(function () {
                        alert("Link copied to clipboard!");
                    }, function () {
                        alert("Failed to copy link.");
                    });
                }
            });
            //like functionality
            $('.like_btn').click(function () {
                const post_id = <?php echo $post_data['id'];?>;
                //ajax call for update like count
                $.ajax({
                    type:"POST",
                    url:"php/update_like.php",
                    data:{
                            id:post_id
                        },
                    success:function (liked) {
                        if (liked.trim()=="success") {
                            //$('.like_icon').toggleClass('fa-regular');
                            $('.like_icon').toggleClass('fa-solid');
                        }
                        else {
                            alert(liked);
                        }
                    }
                })
            })
        })
    </script>
</body>
</html>