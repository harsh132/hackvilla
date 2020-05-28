<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Freelancer - Start Bootstrap Theme</title>
        <!-- Font Awesome icons (free version)-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet">
        <!-- Fonts CSS-->
        <link rel="stylesheet" href="css/heading.css">
        <link rel="stylesheet" href="css/body.css">
    </head>
    <body id="page-top">
        <nav class="navbar navbar-expand-lg bg-secondary fixed-top" id="mainNav">
            <div class="container"><a class="navbar-brand js-scroll-trigger" href="#page-top">HACKCOVID</a>
                <button class="navbar-toggler navbar-toggler-right font-weight-bold bg-primary text-white rounded" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">Menu <i class="fas fa-bars"></i></button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#contests">CONTESTS</a>
                        </li>
                        <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#participate">PARTICIPATE</a>
                        </li>
                        <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#organize">ORGANIZE</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <header class="masthead bg-primary text-white text-center">
            <div class="container d-flex align-items-center flex-column">
                <!-- Masthead Avatar Image--><img class="masthead-avatar mb-5" src="assets/img/avataaars.svg" alt="">
                <!-- Masthead Heading-->
                <h1 class="masthead-heading mb-0">START HACKING</h1>
                <!-- Icon Divider-->
                <div class="divider-custom divider-light">
                    <div class="divider-custom-line"></div>
                    <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                    <div class="divider-custom-line"></div>
                </div>
                <!-- Masthead Subheading-->
                <p class="pre-wrap masthead-subheading font-weight-light mb-0">Graphic Artist - Web Designer - Illustrator</p>
            </div>
        </header>
        <section class="page-section portfolio" id="contests">
            <div class="container">
                <!-- Portfolio Section Heading-->
                <div class="text-center">
                    <h2 class="page-section-heading text-secondary mb-0 d-inline-block">HACKATHONS</h2>
                </div>
                <!-- Icon Divider-->
                <div class="divider-custom">
                    <div class="divider-custom-line"></div>
                    <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                    <div class="divider-custom-line"></div>
                </div>
                <!-- Portfolio Grid Items-->
                <h4>
                Login to participate now for free.
                </h4>
                <?php
                require_once "utils.php";
                $stmt=$conn->query("SELECT hackathons.id,hackathons.name AS hname,hackathons.contestdate,organisers.name AS oname,hackathons.status FROM hackathons INNER JOIN organisers ON hackathons.organiser_id=organisers.id ORDER BY hackathons.status");
                $row=$stmt->fetchAll(PDO::FETCH_ASSOC);
                if(count($row)==0)
                {
                ?>
                <div class="alert alert-secondary">No Hackathons.</div>
                <br><br>
                <?php
                }
                else
                {
                    ?>
                    <table class="table table-light table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th style="min-width: 50%;">Name</th>
                                <th>Organiser</th>
                                <th>Date-Time</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                    <?php
                    foreach($row as $r)
                    {
                        echo '<tr><td>'.$r['hname'].'</td><td>'.$r['oname'].'</td><td>'.$r['contestdate'].'</td><td><a href="details.php?id='.$r['id'].'" class="btn btn-primary btn-sm">Details</a></td></tr>';
                    }
                    echo '</tbody></table><br>';
                }
                ?>
            </div>
        </section>
        
        <section class="page-section bg-primary text-white mb-0" id="participate">
            <div class="container">
                <!-- About Section Heading-->
                <div class="text-center">
                    <h2 class="page-section-heading d-inline-block text-white">PARTICIPATE</h2>
                </div>
                <!-- Icon Divider-->
                <div class="divider-custom divider-light">
                    <div class="divider-custom-line"></div>
                    <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                    <div class="divider-custom-line"></div>
                </div>
                <p style="text-align: center;">
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Maxime aliquam repudiandae vero exercitationem culpa eius eveniet nostrum, iusto, suscipit labore quidem fugiat sequi! Eveniet eos dolorum voluptas accusamus, voluptatum cupiditate!
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Temporibus asperiores impedit amet ex iste laboriosam quaerat ullam, iusto deserunt molestiae. Temporibus minima eveniet explicabo error ut placeat vero veritatis doloremque?
                    <br><br><br>
                    <a href="participants/signup.php" class="btn btn-success">Sign Up</a>&nbsp;
                    <a href="participants/login.php" class="btn btn-success">Login</a>
                </p>
            </div>
        </section>
        <section class="page-section" id="organize">
            <div class="container">
                <!-- Contact Section Heading-->
                <div class="text-center">
                    <h2 class="page-section-heading text-secondary d-inline-block mb-0">ORGANIZE</h2>
                </div>
                <!-- Icon Divider-->
                <div class="divider-custom">
                    <div class="divider-custom-line"></div>
                    <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                    <div class="divider-custom-line"></div>
                </div>
                <p style="text-align: center;">
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Maxime aliquam repudiandae vero exercitationem culpa eius eveniet nostrum, iusto, suscipit labore quidem fugiat sequi! Eveniet eos dolorum voluptas accusamus, voluptatum cupiditate!
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Temporibus asperiores impedit amet ex iste laboriosam quaerat ullam, iusto deserunt molestiae. Temporibus minima eveniet explicabo error ut placeat vero veritatis doloremque?
                    <br><br><br>
                    <a href="organisers/signup.php" class="btn btn-success">Sign Up</a>&nbsp;
                    <a href="organisers/login.php" class="btn btn-success">Login</a>
                </p>
            </div>
        </section>
        <footer class="footer text-center">
            <div class="container">
                <div class="row">
                    <!-- Footer Location-->
                    <div class="col-lg-4 mb-5 mb-lg-0">
                        <h4 class="mb-4">LOCATION</h4>
                        <p class="pre-wrap lead mb-0">Patna, Bihar, India</p>
                    </div>
                    <!-- Footer Social Icons-->
                    <div class="col-lg-4 mb-5 mb-lg-0">
                        <h4 class="mb-4">AROUND THE WEB</h4><a class="btn btn-outline-light btn-social mx-1" href="https://www.facebook.com/hackcovid"><i class="fab fa-fw fa-facebook-f"></i></a><a class="btn btn-outline-light btn-social mx-1" href="https://www.twitter.com/hackcovid"><i class="fab fa-fw fa-twitter"></i></a><a class="btn btn-outline-light btn-social mx-1" href="https://www.linkedin.com/in/hackcovid"><i class="fab fa-fw fa-linkedin-in"></i></a><a class="btn btn-outline-light btn-social mx-1" href="https://www.dribble.com/hackcovid"><i class="fab fa-fw fa-dribbble"></i></a>
                    </div>
                    <!-- Footer About Text-->
                    <div class="col-lg-4">
                        <h4 class="mb-4">ABOUT</h4>
                        <p class="pre-wrap lead mb-0">Hackcovid is website designed for allowing students to take part in hackathons.</p>
                    </div>
                </div>
            </div>
        </footer>
        <!-- Copyright Section-->
        <section class="copyright py-4 text-center text-white">
            <div class="container"><small class="pre-wrap">Copyright © Hackcovid 2020</small></div>
        </section>
        <!-- Scroll to Top Button (Only visible on small and extra-small screen sizes)-->
        <div class="scroll-to-top d-lg-none position-fixed"><a class="js-scroll-trigger d-block text-center text-white rounded" href="#page-top"><i class="fa fa-chevron-up"></i></a></div>
        <!-- Bootstrap core JS-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
        <!-- Third party plugin JS-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
        <!-- Contact form JS-->
        <script src="assets/mail/jqBootstrapValidation.js"></script>
        <script src="assets/mail/contact_me.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>