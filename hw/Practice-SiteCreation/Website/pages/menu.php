<form class="d-flex" action="index.php?page=home" method="post">
    <input class="form-control me-2" type="text" name="login" placeholder="Login" aria-label="Login" required>
    <input class="form-control me-2" type="password" name="password" placeholder="Password" aria-label="Password" required>
    <button class="btn btn-outline-success" type="submit" name="loginbtn">Login</button>
</form>

<div class="container-fluid">
    <a class="navbar-brand" href="index.php?page=home">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
            <a href="index.php?page=home" class="nav-link">Home</a>
            <a href="index.php?page=upload" class="nav-link">Upload</a>
            <a href="index.php?page=gallery" class="nav-link">Gallery</a>
            <a href="index.php?page=registration" class="nav-link">Registration</a>
        </div>
    </div>
</div>