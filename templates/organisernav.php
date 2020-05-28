<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
    <a href="#" class="navbar-brand"><strong>HackCovid</strong></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
        &nbsp;
        <span class="navbar-text" style="color: #eee;"><?php echo $_SESSION['name']; ?></span>&nbsp;
            <li class="nav-item">
                <a href="newhackathon.php" class="btn btn-success nav-link" style="color: #eee;">New Hackathons</a>
            </li>&nbsp;
            <li class="nav-item">
                <a href="logout.php" class="btn btn-danger nav-link" style="color: #eee;">Log Out</a>
            </li>
        </ul>
    </div>
</nav>
<br>