<?php
// Detects file name
$path = $_SERVER['SCRIPT_FILENAME'];
if (isset($path)) {
    $current_page = basename($path, '.php');
}
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark home" id="navbar">
    <a class="nav-link" <?php if ($current_page == 'index') {
                            echo 'id="active"';
                        } ?> href="index.php"><i class="fas fa-home"></i></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" <?php if ($current_page == 'aboutUs') {
                                        echo 'id="active"';
                                    } ?> href="aboutUs.php">About Us</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" <?php if ($current_page == 'contactUs') {
                                        echo 'id="active"';
                                    } ?> href="contactUs.php">Contact Us</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" <?php if ($current_page == 'gallery') {
                                        echo 'id="active"';
                                    } ?> href="gallery.php">Gallery</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Dropdown
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-0" action="search.php" method="get">
            <input class="form-control mr-sm-2" name="search" type="search" placeholder="Search" aria-label="Search">
            <button type="submit" class="btn btn-outline-success my-2 my-sm-0"  value="search">Search</button>
        </form>
    </div>
</nav>