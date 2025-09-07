<?php 
    require 'php/conn.php';
    $cat=$_GET['cat'];
    $replaced_word=str_replace('-',' ',$cat);
    $capitalized_cat=ucfirst($replaced_word);    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finance Routine : post by category</title>
    <meta name="description" content="Simplify finance and unlock wealth - Your ultimate guide to personal finance, investing, and money management.">
    <link rel="icon" type="image/png" href="images/new_logo.png">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">    
</head>
<body>    
    <?php require('components/nav.php');?>


    <section class="home_sec fade-in">
        <div class="row home_row">
            <div class="col-md-8 rec_box">
                <div class="row pop_article">
                    <h3><?php echo $capitalized_cat; ?></h3>
                    <?php
                        $post_sql=$conn->query("SELECT * FROM posts WHERE cat='$cat' AND status='publish'");

                        while ($post_data=$post_sql->fetch_assoc()) {
                            //fetch author
                            $auth_id=$post_data['auth_id'];
                            $auth_sql=$conn->query("SELECT * FROM authors WHERE id='$auth_id'");
                            $auth_data=$auth_sql->fetch_assoc();
        
                            echo '
                                <div class="col-md-6 p-lg-3 pt-3">
                                    <div class="card custom_card">
                                       <img src="images/banners/'.$post_data['banner'].'" class="card-img-top" alt="thumnail">
                                        <div class="card-body">
                                            <h5 class="card-title">'.$post_data['title'].'</h5>
                                            <p class="card-text">'.$post_data['summary'].'</p>
                                        </div>

                                        <div class="card-footer d-flex justify-content-between align-items-center">
                                            <a href="http://localhost:8080/myfinance/article_info.php?id='.$post_data['id'].'" class="btn btn-outline-info">Read...</a>
                                            <div class="author ms-auto">
                                                <div class="author_image me-3">
                                                    <img src="images/author_image/'.$auth_data['img_name'].'" width="50px">
                                                </div>
                                                <span>By :<b> '.$auth_data['name'].'</b><br><small>'.$post_data['created_at'].'</small></span>
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

<!-- Why Choose Us Section -->
<section class="benefits py-4 fade-in" style="background: rgba(255, 255, 255, 0.9);">
  <div class="container">
    
    <!-- Heading -->
    <div class="text-center mb-4">
      <h2 style="font-weight:700; font-size:2.2rem;">Why Choose <span style="color:var(--primary-color);">Finance Routine?</span></h2>
      <p style="font-size:1.2rem;">We help you make money work for your lifestyle</p>
    </div>

    <!-- Benefits Cards -->
    <div class="row">
      
      <!-- Benefit 1 -->
      <div class="col-md-4 mb-3">
        <div class="card h-100" style="border:none; box-shadow:0 5px 15px rgba(0,0,0,0.3); border-radius:10px;">
          <div class="card-body text-center p-3">
            <img src="images/saving_icon.png" alt="Save Money" width="100">
            <h3 style="font-weight:600;">Smart Luxury Living</h3>
            <p style="color:#666;">"5-star lifestyle at 3-star cost" - Learn smart ways to enjoy life without overspending</p>
          </div>
        </div>
      </div>

      <!-- Benefit 2 -->
      <div class="col-md-4 mb-3">
        <div class="card h-100" style="border:none; box-shadow:0 5px 15px rgba(0,0,0,0.3); border-radius:10px;">
          <div class="card-body text-center p-3">
            <img src="images/investing_icon.png" alt="Invest Small" width="100">
            <h3 style="font-weight:500;">Small Savings, Big Results</h3>
            <p style="color:#666;">Turn ₹500/month into ₹25L+ with our simple investment plans. Perfect for beginners!</p>
          </div>
        </div>
      </div>

      <!-- Benefit 3 -->
      <div class="col-md-4 mb-3">
        <div class="card h-100" style="border:none; box-shadow:0 5px 15px rgba(0,0,0,0.3); border-radius:10px;">
          <div class="card-body text-center p-3">
            <img src="images/statistic_icon.png" alt="Save for Future" width="100">
            <h3 style="font-weight:500;">Salary to Retirement</h3>
            <p style="color:#666;">The simple 20% saving trick most people miss. Secure your future without sacrifice.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>



    <?php require("components/footer.php");?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>