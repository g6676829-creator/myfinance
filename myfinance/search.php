<?php require 'php/conn.php';?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finance Routine : Search result</title>
    <meta name="description" content="Simplify finance and unlock wealth - Your ultimate guide to personal finance, investing, and money management.">
    <link rel="icon" type="image/png" href="images/new_logo.png">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">    
</head>
<body>    
    <?php require('components/nav.php');?>
    <div class="container-fluid py-4 home_row">
        <div class="row">
            <div class="col-md-8 px-4">
                <div class="row search_bg">
                    <h3>Search Result...</h2>
                    <?php
                        $keyword=$_GET['keyword'];
                        $sql=$conn->query("SELECT * FROM posts WHERE title LIKE '%$keyword%' OR content LIKE '%$keyword%' AND status='publish';");
                        while ($data=$sql->fetch_assoc()) {
                            echo '
                                <div class="col-md-6 px-5 py-4">
                                <div class="card shadow" style="width: 18rem;">
                                  <img src="images/banners/'.$data["banner"].'" class="card-img-top" alt="...">
                                  <div class="card-body">
                                    <h5 class="card-title">'.$data["title"].'</h5><hr>
                                    <a href="http://localhost:8080/myfinance/article_info.php?id='.$data['id'].'" class="btn btn-primary">Read More</a>
                                  </div>
                                </div>
                                </div>   
                            ';
                        }
                    ?>
                </div>
            </div>
            <div class="col-md-4">
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
                <!-- About Author Widget -->
                <div class="sidebar-widget fade-in mt-4">
                    <h3 class="widget-title">About The Admin</h3>
                    <div class="d-flex align-items-center mb-3">
                        <?php
                            //fetch author
                            $auth_sql=$conn->query("SELECT * FROM authors WHERE id=1");
                            $auth_data=$auth_sql->fetch_assoc();
                        ?>
                        <img src="images/author_image/<?php echo $auth_data['img_name'];?>" alt="Author" class="rounded-circle me-3" width="100" style="height: 100px;">
                        <div>
                            <h4 class="mb-1"><?php echo $auth_data['name'];?></h4>
                            <p class="text-muted mb-0">Finance Expert</p>
                        </div>
                    </div>
                    <p><?php echo $auth_data['lba'];?></p>
                    <div class="social-sharing">
                        <a href="#" class="facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="twitter"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="linkedin"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="instagram" style="background: #E1306C;"><i class="fab fa-instagram"></i></a>
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
    </div>   
    <?php require("components/footer.php");?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>