<div class="col-sm-3 right-sidebar py-1">
    <div class="social-site-heading bg-secondary p-1 text-white">
        <h4>Social site links</h4>
    </div>
    <div class="social-links d-flex flex-row justify-content-between bg-dark p-1"></a>
        <a href="https://www.facebook.com" target="blank"> <i class="fab fa-facebook"></i> </a>
        <a href="https://www.twitter.com" target="blank"> <i class="fab fa-twitter"></i> </a>
        <a href="https://www.linkidin.com" target="blank"> <i class="fab fa-linkedin"></i> </a>
        <a href="https://www.github.com" target="blank"> <i class="fab fa-github"></i> </a>
        <a href="https://www.youtube.com" target="blank"> <i class="fab fa-youtube"></i> </a>
    </div>
    <div class="pagelinks mt-4">
        <div class="social-site-heading bg-secondary p-1 text-white">
            <h4>Social site links</h4>
        </div>
        <form action="processFrontEnd.php" method="post">
            <div class="btn-group d-flex flex-row justify-content-between" role="group" aria-label="Basic example">
                <button type="submit" class="btn btn-primary" name="submit" value="category" style="width:33.3%;">Category</button>
                <button type="submit" class="btn btn-success" name="submit" value="tag" style="width:33.3%;">Tags</button>
                <button type="submit type=" submit" class="btn btn-info" name="submit" value="archive" style="width:33.3%;">Archive</button>
                <input type="hidden" name="action" value="verify">
            </div>
        </form>
        <?php
        require_once '../admin/app/start.php';

        // Class included
        use CodeCourse\Repositories\FrontEnd as FrontEnd;
        use CodeCourse\Repositories\Session as Session;

        // Classes instantiated
        $frontEnd = new FrontEnd();
        Session::init();
        // Will display all the messages validation/insert/update/delete
        $message = Session::get('message');
        if (!empty($message)) {
            echo $message;
            Session::set('message', null);
        }
        ?>
    </div>
</div>
