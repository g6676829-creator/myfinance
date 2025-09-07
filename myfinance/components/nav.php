<style type="text/css">
  .bars_custom{
    box-shadow: none !important;
    border: none;
  }
  
</style>

<nav class="navbar navbar-expand-lg sticky-top bg-dark navbar-dark">
  <div class="container-fluid px-4">
    <a class="navbar-brand fs-4 px-2" href="http://localhost:8080/myfinance/">
      <span class="text-white">Finance</span><span class="text-warning">Routine</span>
    </a>
    <?php
      require("php/conn.php");
      if(!empty($_COOKIE['_enter_u_']))
      {
        $email = base64_decode($_COOKIE['_enter_u_']);
        $data = $conn->query("SELECT name FROM users WHERE email='$email'");
        $aa = $data->fetch_assoc();
        $name = $aa['name'];
        echo "<small class='text-primary me-auto login_ind'>| Hi..".$name."</small>";

      }
    ?>
    <button class="navbar-toggler bars_custom" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="http://localhost:8080/myfinance/">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Blog</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">News</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="http://localhost:8080/myfinance/signup.php">Signup</a>
        </li>

        <?php
          if(empty($_COOKIE['_enter_u_'])) {
            echo '
              <li class="nav-item">
                <a class="nav-link" href="http://localhost:8080/myfinance/login.php">Login</a>
              </li>
            ';
          }
          else {
            echo '
              <li class="nav-item">
                <a class="nav-link text-danger" href="http://localhost:8080/myfinance/logout.php">Logout</a>
              </li>
            ';
          }
        ?>
      </ul>
    </div>
  </div>
</nav>

<script>
  document.addEventListener("DOMContentLoaded", function() {
      var currentUrl = window.location.href;
      var navLinks = document.querySelectorAll('.nav-link');

      navLinks.forEach(function(link) {
          if (link.href === currentUrl) {
            link.classList.add('active');
          }
      });
  });
</script>