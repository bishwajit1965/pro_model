<?php
require_once '../admin/app/start.php';
// Class included
use CodeCourse\Repositories\AboutUs as AboutUs;
use CodeCourse\Repositories\Category as Category;
use CodeCourse\Repositories\Contact as Contact;
use CodeCourse\Repositories\Core as Core;
use CodeCourse\Repositories\FrontEnd as FrontEnd;
use CodeCourse\Repositories\Helpers as Helpers;
use CodeCourse\Repositories\Link as Link;
use CodeCourse\Repositories\Session as Session;
use CodeCourse\Repositories\SocialMedia as SocialMedia;
use CodeCourse\Repositories\Tag as Tag;

// Classes instantiated
$category = new Category();
$core = new Core();
$aboutUs = new AboutUs();
$contact = new Contact();
$frontEnd = new FrontEnd();
$helpers = new Helpers();
$socialMedia = new SocialMedia();
$link = new Link();
$tag = new Tag();
Session::init();

// Table to be operated on
$table = 'tbl_articles';
$tableCategory = 'tbl_category';
$tableContact = 'tbl_contact';
$tableSocialMedia = 'tbl_social_media';
$tableTag = 'tbl_tag';
$tableLink = 'tbl_link';
$tableAboutUs = 'tbl_about_us';

// Data fetching mode for social links
$limit = ['limit' => '6'];
$order_by = ['order_by' => 'id DESC LIMIT 6'];
?>

<div class="container-fluid py-2 bg-secondary"></div>

<div class="container-fluid footer-area bg-dark text-white py-2">
    <div class="row">
        <div class="col-sm-3">
            <h5 style="border-bottom:2px solid #DDD;padding-bottom:5px;width:100%;">About us & Other Links:</h5>
            <?php
            $aboutUsData = $aboutUs->select($tableAboutUs);
            if (!empty($aboutUsData)) {
                foreach ($aboutUsData as $about) {
                    ?>
            <p style="color:#DDD;font-size:12px;">
                <?php  echo $helpers->textShorten(htmlspecialchars_decode($about->about_us), 150); ?>
            </p>
            <?php
                }
            } else {
            }
            ?>
            <a href="aboutUs.php" class="btn btn-sm btn-primary"><i class="fas fa-fast-forward"></i> About us in
                detail</a>
            <div class="row mt-3 text-white">
                <div class="col-sm-6 text-white">
                    <h6>SITE LINKS</h6>
                    <ul>
                        <li><a href="">ABOUT US</a></li>
                        <li><a href="">ABOUT US</a></li>
                        <li><a href="">ABOUT US</a></li>
                        <li><a href="">ABOUT US</a></li>
                    </ul>
                </div>
                <div class="col-sm-6 text-white">
                    <h6>VISIT PAGES</h6>
                    <ul>
                        <li><a href="">ABOUT US</a></li>
                        <li><a href="">ABOUT US</a></li>
                        <li><a href="">ABOUT US</a></li>
                        <li><a href="">ABOUT US</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <h5 style="border-bottom:2px solid #DDD;padding-bottom:5px;width:100%;">Random articles:</h5>
            <div class="row no-gutters mb-1">
                <?php
                $article = $frontEnd->selectRandomArticle($table);
                if (!empty($article)) {
                    foreach ($article as $randomData) {
                        ?>
                <div class="col-sm-3 random-articles-photo" style="padding:1px;">
                    <a
                        href="singlePost.php?post_id=<?php echo $randomData->id; ?>">
                        <img src="../admin/article/<?php echo $randomData->photo; ?>"
                            class="w-100 img-thumbnail img-cover" alt="Random article" style="height:72px;"
                            data-toggle="tooltip"
                            title="<?php echo $randomData->description; ?>">
                    </a>
                </div>
                <?php
                    }
                } else {
                    echo "No data is available yet !!!";
                }
                ?>
            </div>
        </div>
        <div class="col-sm-3">
            <style>
                #testimonial>p{
                    font-size:12px;font-size:12px;border-bottom:1px dashed #666;padding-bottom:3px;margin-bottom:10px;margin-top:3px;}
                #testimonial>p:last-child {border-bottom:0px dashed #666;}

            </style>
            <h5 style="border-bottom:2px solid #DDD;padding-bottom:5px;">Recent Testimonials:</h5>
            <?php
            // Will fetch data from database
            $message = $contact->select($tableContact, $order_by);
            if (!empty($message)) {
                foreach ($message as $testimonial) {
                    ?>
            <a href="singleComment.php?id=<?php echo $testimonial->id; ?>" 
                style="color:#DDD;text-decoration:none;">
                <h6 style="margin-bottom:px;font-size:12px;font-weight:800;"><?php echo $testimonial->first_name . ' ' . $testimonial->last_name; ?>
                    says : </h6>
                <div id="testimonial">
                    <?php echo htmlspecialchars_decode($helpers->textShorten($testimonial->message, 62)); ?> 
                </div> 

            </a>
            <?php
                }
            }
            ?>
        </div>
        <div class="col-sm-3">
            <div class="row ">
                <div class="col-sm-12">
                    <h5 style="border-bottom:2px solid #DDD;padding-bottom:5px;">Social Media Site Links:</h5>
                </div>
                <div class="col-sm-12 d-flex justify-content-between">
                    <?php
                    // Will fetch social media data
                    $socialMediaData = $socialMedia->select($tableSocialMedia, $limit);
                    if (!empty($socialMediaData)) {
                        foreach ($socialMediaData as $socialMedia) {
                            ?>
                    <a href="<?php echo $socialMedia->name; ?>"
                        target="blank" style="margin-bottom:5px;">
                        <?php
                            if ($socialMedia->name == 'https://www.facebook.com') {
                                echo '<i class="fab fa-facebook text-white"></i>';
                            } elseif ($socialMedia->name == 'https://www.twitter.com') {
                                echo '<i class="fab fa-twitter text-white"></i>';
                            } elseif ($socialMedia->name == 'https://www.linkedin.com') {
                                echo '<i class="fab fa-linkedin text-white"></i>';
                            } elseif ($socialMedia->name == 'https://www.youtube.com') {
                                echo '<i class="fab fa-youtube text-white"></i>';
                            } elseif ($socialMedia->name == 'https://www.stackoverflow.com') {
                                echo '<i class="fab fa-stack-overflow text-white"></i>';
                            } elseif ($socialMedia->name == 'https://www.github.com') {
                                echo '<i class="fab fa-github text-white"></i>';
                            } else {
                            } ?>
                    </a><br>
                    <?php
                        }
                    }
                        ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <!-- Will fetch links data -->
                    <?php
                    $limit = ['limit' => '1'];
                    $linkData = $link->select($tableLink, $limit);
                    if (!empty($linkData)) {
                        foreach ($linkData as $link) {
                            ?>
                    <h5 style="border-top:2px solid #DDD;padding-top:10px;"><?php echo $link->title; ?>
                    </h5>
                    <p style="font-size:16px;margin-bottom:5px;"><i class="fas fa-envelope"></i>
                        <?php echo $link->email; ?>
                    </p>

                    <p style="font-size:16px;margin-bottom:5px;"><i class="fas fa-phone"></i> <?php echo $link->phone; ?>
                    </p>

                    <p style="font-size:16px;margin-bottom:5px;"><i class="far fa-address-card"></i> <?php echo $link->url; ?>
                    </p>

                    <address style="font-size:16px;margin-bottom:5px;"><i class="fas fa-home"></i>
                        <?php echo $link->address; ?>
                    </address>

                    <div class="row">
                        <div class="col-sm-6">
                            <p style="font-size:16px;margin-bottom:5px;"><i class="fas fa-file-archive"></i> <?php echo $link->zipcode; ?>
                            </p>
                        </div>
                        <div class="col-sm-6">
                            <p style="font-size:16px;margin-bottom:5px;"><i class="fas fa-flag"></i> <?php echo $link->country; ?>
                            </p>
                        </div>
                    </div>
                    <?php
                        }
                    }
                    ?>
                    <!-- /Will fetch links data ends-->
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <!-- Button to Open the Modal -->
                    <button type="button" class="btn btn-primary btn-md mt-2" data-toggle="modal"
                        data-target="#contactForm">
                        <i class="fas fa-envelope"></i> Contact us
                    </button>

                    <!-- The Modal -->
                    <div class="modal" id="contactForm">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header bg-info">
                                    <h4 class="modal-title">Contact us</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <!-- Modal body -->
                                <div class="modal-body">
                                    <form action="processContact.php" method="post">
                                        <div class="form-group">
                                            <input type="text" name="first_name" id=""
                                                class="form-control form-control-sm" placeholder="First name">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="last_name" id="last_name"
                                                class="form-control form-control-sm" placeholder="Last name">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="email" id="email"
                                                class="form-control form-control-sm" placeholder="Email">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="phone" id="phone"
                                                class="form-control form-control-sm" placeholder="Phone">
                                        </div>
                                        <div class="form-group">
                                            <textarea class="form-control form-control-sm" name="message" id="message"
                                                rows="3" placeholder="Message"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="address" id="address" class="form-control"
                                                placeholder="Address">
                                        </div>
                                        <input type="hidden" name="action" value="verify">
                                        <button type="submit" name="submit" value="insert"
                                            class="btn btn-primary btn-sm"> <i class="fas fa-envelope"></i> Send
                                            Message</button>
                                    </form>
                                </div>
                                <!-- Modal footer -->
                                <div class="modal-footer bg-info">
                                    <button type="submit" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>