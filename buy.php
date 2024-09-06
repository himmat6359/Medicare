<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Basic Meta Tags -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />

  <title>Medion</title>

  <!-- External Stylesheets -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.3/assets/owl.carousel.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/bootstrap.css" />
  <link href="https://fonts.googleapis.com/css?family=Poppins:400,600,700|Roboto:400,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/responsive.css" />

  <style>
    .card-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-around;
    }
    .card {
      margin: 10px;
      width: 18rem;
    }
    .card img {
      height: 200px;
      object-fit: cover;
    }
  </style>
</head>

<body class="sub_page">
  <div class="hero_area">
    <!-- Header Section -->
    <header class="header_section">
      <div class="container">
        <div class="top_contact-container">
          <div class="tel_container">
            <a href="">
              <img src="images/telephone-symbol-button.png" alt=""> Call : +91 6359495452
            </a>
          </div>
          <div class="social-container">
            <a href=""><img src="images/fb.png" alt="" class="s-1"></a>
            <a href=""><img src="images/twitter.png" alt="" class="s-2"></a>
            <a href=""><img src="images/instagram.png" alt="" class="s-3"></a>
          </div>
        </div>
      </div>
      <div class="container-fluid">
        <nav class="navbar navbar-expand-lg custom_nav-container pt-3">
          <a class="navbar-brand" href="index.html">
            <img src="images/logo.png" alt="">
            <span>MedCar</span>
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="d-flex flex-column flex-lg-row align-items-center w-100 justify-content-between">
              <ul class="navbar-nav">
                <li class="nav-item active"><a class="nav-link" href="index.html">Home <span class="sr-only">(current)</span></a></li>
                <li class="nav-item"><a class="nav-link" href="about.html"> About </a></li>
                <li class="nav-item"><a class="nav-link" href="buy.php"> Online Buy </a></li>
                <li class="nav-item"><a class="nav-link" href="news.html"> News </a></li>
                <li class="nav-item"><a class="nav-link" href="contact.html">Contact us</a></li>
              </ul>
              <form class="form-inline">
                <input type="search" placeholder="Search">
                <button class="btn my-2 my-sm-0 nav_search-btn" type="submit"></button>
              </form>
              <div class="login_btn-contanier ml-0 ml-lg-5">
                  <a href="admin/adminlogin.html">
                  <img src="images/user.png" alt="">
                  <span>Login</span>
                </a>
              </div>
            </div>
          </div>
        </nav>
      </div>
    </header>
    <!-- End Header Section -->
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <div class="container mt-4">
      <h4 class="mt-4">Product List</h4>
      <div class="card-container">
        <?php
          // Database connection
          
            include 'conn.php';
          // Fetch products
          $sql = "SELECT id, name, photo, price, rating FROM products1";
          $result = $conn->query($sql);

      //    <a href='buy.php?id=" . htmlspecialchars($row["id"]) . "' class='btn btn-primary'>Buy Now</a>


          if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
              echo "<div class='card'>
                      <img src='admin/uploads/" . htmlspecialchars($row["photo"]) . "' class='card-img-top' alt='Product Photo'>
                      <div class='card-body'>
                        <h5 class='card-title'>" . htmlspecialchars($row["name"]) . "</h5>
                        <p class='card-text'>Price: ₹" . htmlspecialchars($row["price"]) . "</p>
                        <p class='card-text'>Rating: " . htmlspecialchars($row["rating"]) . " Stars</p>
                        <a href='user/user_login.html" . "' class='btn btn-primary' id='shop'>Buy Now</a>
                      </div>
                    </div>";
            }
          } else {
            echo "<p>No products found</p>";
          }
          $conn->close();
        ?>
      </div>
    </div>
  </div>

  <!-- Info Section -->
  <section class="info_section layout_padding2">
    <div class="container">
      <div class="row">
        <div class="col-md-3">
          <div class="info_contact">
            <h4>Contact</h4>
            <div class="box">
              <div class="img-box"><img src="images/telephone-symbol-button.png" alt=""></div>
              <div class="detail-box"><h6>+91 6359495452</h6></div>
            </div>
            <div class="box">
              <div class="img-box"><img src="images/email.png" alt=""></div>
              <div class="detail-box"><h6>himmat2002@gamil.com</h6></div>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="info_menu">
            <h4>Menu</h4>
            <ul class="navbar-nav">
              <li class="nav-item active"><a class="nav-link" href="index.html">Home <span class="sr-only">(current)</span></a></li>
              <li class="nav-item"><a class="nav-link" href="about.html"> About </a></li>
              <li class="nav-item"><a class="nav-link" href="medicine.html"> Medicine </a></li>
              <li class="nav-item"><a class="nav-link" href="buy.php"> Online Buy </a></li>
            </ul>
          </div>
        </div>
        <div class="col-md-6">
          <div class="info_news">
            <h4>News_letter</h4>
           <h6>The medicines in costs and with assured quality.
               The medicines used in the various national health programmes, 
               emerging and reemerging infections should be addressed in the list.
               and efficacious medicines for its population</h6>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End Info Section -->

  <!-- Footer Section -->
  <section class="container-fluid footer_section">
  </section>
  <!-- End Footer Section -->

  <!-- JavaScript Files -->
  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="js/bootstrap.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/owl.carousel.min.js"></script>
  <script>
    $(".owl-carousel").owlCarousel({
      loop: true,
      margin: 10,
      nav: true,
      navText: [],
      autoplay: true,
      responsive: {
        0: {
          items: 1
        },
        600: {
          items: 2
        },
        1000: {
          items: 4
        }
      }
    });
  </script>
  <script>
    $(".owl-2").owlCarousel({
      loop: true,
      margin: 10,
      nav: true,
      navText: [],
      autoplay: true,
      responsive: {
        0: {
          items: 1
        },
        600: {
          items: 2
        },
        1000: {
          items: 4
        }
      }
    });

   
  </script>
  
</body>
</html>
