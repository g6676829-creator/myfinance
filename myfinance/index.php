<?php require 'php/conn.php';?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finance Routine : the personal finance blog</title>
    <meta name="description" content="Simplify finance and unlock wealth - Your ultimate guide to personal finance, investing, and money management.">
    <link rel="icon" type="image/png" href="images/new_logo.png">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>    
</head>
<body>    
    <?php require('components/nav.php');?>

    <section class="hero text-center fade-in">
        <h1>Understand finance, create wealth—simply.</h1>
        <p>Simplify finance, unlock wealth—your journey to a richer life starts here.</p>
        <form class="d-flex search_form" role="search">
            <div class="input-group me-2">
                <input type="search" class="form-control custom_search" placeholder="Search..." required>
                <button class="btn btn-outline-warning" type="submit">
                  <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
    </section>

    <section class="home_sec fade-in">
        <div class="row home_row">
            <div class="col-md-8 rec_box">
                <div class="rec_content row">
                    <h3>Recent Article</h3>
                    <?php
                        $post_sql=$conn->query("SELECT * FROM posts WHERE status='publish' ORDER BY id DESC LIMIT 1");
                        $post_data=$post_sql->fetch_assoc();
                        //author data
                        $auth_id=$post_data['auth_id'];
                        $auth_sql=$conn->query("SELECT * FROM authors WHERE id='$auth_id'");
                        $auth_data=$auth_sql->fetch_assoc();
                    ?>
                    <div class="col-md-6 p-2">
                        <img src="images/banners/<?php echo $post_data['banner'];?>" class="card-img-top rounded">
                    </div>
                    <div class="col-md-6 p-2">
                        <h1 class="title fs-3"><?php echo $post_data['title'];?></h1>
                        <div class="article-meta">
                            <span class="reading-time px-2 rounded bg-info text-white"><?php echo $post_data['cat'];?></span>
                            <span class="comments-count px-2 rounded bg-primary text-white"><?php echo $post_data['created_at'];?> By : <?php echo $auth_data['name'];?></span>
                        </div>
                    </div>
                    <hr>
                    <div class="col-12">
                        <p class="bg-light rounded"><?php echo $post_data['summary'];?></p>
                    <a href="http://localhost:8080/myfinance/article_info.php?id=<?php echo $post_data['id'];?>" target="_blank"><button class="btn btn-outline-primary">Read Continue...</button></a>
                    </div>
                </div>
                <div class="row pop_article mt-3">
                    <h3 class="mt-3">Popular Article</h3>
                    <?php
                        $post_sql=$conn->query("SELECT * FROM posts WHERE status='publish' ORDER BY id DESC LIMIT 6");

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
                <!-- more popular article section -->
                <h3 class="bg-light rounded mt-3">More Popular Article</h3>
                <div class="m_pop_sec">
                    
                    <div class="m_pop_art_row d-flex">
                        <?php
                            $mpsql=$conn->query("SELECT * FROM posts WHERE status='publish' ORDER BY rand() LIMIT 10;");
                            while ($mp_data=$mpsql->fetch_assoc()) {
                                echo '
                                    <div class="m_pop_art px-3">
                                        <div class="card custom_card">
                                            <div class="card-body">
                                                <h5 class="card-title">'.$mp_data["title"].'</h5>
                                                <p class="card-text">'.$mp_data["summary"].'</p>
                                            </div>

                                            <div class="card-footer d-flex justify-content-between align-items-center">
                                                <a href="http://localhost:8080/myfinance/article_info.php?id='.$mp_data["id"].'" class="btn btn-outline-info">Read...</a>
                                            </div>
                                        </div>
                                    </div>  
                                ';
                            }
                        ?>  
                    </div>
                </div>
                <!-- Financial Resources Section -->
                <div class="resources-section fade-in">
                    <h2 class="resources-title">Financial Tools & Resources</h2>
                    <div class="resource-tools">
                        <div class="resource-tool">
                            <div class="tool-icon">
                                <i class="fas fa-calculator"></i>
                            </div>
                            <h3 class="tool-title">SIP Calculator</h3>
                            <p class="tool-description">Calculate how much your systematic investments can grow over time.</p>
                            <a href="http://localhost:8080/myfinance/sip_cal.php" class="btn btn-sm btn-outline-primary">Calculate Now</a>
                        </div>
                        
                        <div class="resource-tool">
                            <div class="tool-icon">
                                <i class="fas fa-exchange-alt"></i>
                            </div>
                            <h3 class="tool-title">Currency Converter</h3>
                            <p class="tool-description">Convert between currencies with up-to-date exchange rates.</p>
                            <a href="http://localhost:8080/myfinance/currency_con.php" class="btn btn-sm btn-outline-primary">Convert</a>
                        </div>
                        
                        <div class="resource-tool">
                            <div class="tool-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <h3 class="tool-title">Investment Returns</h3>
                            <p class="tool-description">Project potential returns on your investments with different scenarios.</p>
                            <a href="http://localhost:8080/myfinance/investment_ret.php" class="btn btn-sm btn-outline-primary">Estimate</a>
                        </div>
                        
                        <div class="resource-tool">
                            <div class="tool-icon">
                                <i class="fas fa-file-invoice-dollar"></i>
                            </div>
                            <h3 class="tool-title">Tax Calculator</h3>
                            <p class="tool-description">Estimate your income tax liability for the current financial year.</p>
                            <a href="http://localhost:8080/myfinance/tax_cal.php" class="btn btn-sm btn-outline-primary">Calculate Tax</a>
                        </div>
                    </div>
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
    <script>
        $(document).ready(function () {
            $('.search_form').submit(function (sev) {
                sev.preventDefault();
                const keyword = $('.custom_search').val();
                location.href="http://localhost:8080/myfinance/search.php?keyword="+keyword;
            })
        })
    </script>
</body>
</html>