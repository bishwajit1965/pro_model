<div class="row text-white justify-content-center" style="background-color:#838383;">
    <div class="container-fluid top-footer py-2 text-white" style="margin-bottom:0;background:#222222;">
        <div class="row">
            <div class="col-sm-3 footer-text">
                <h6 class="text-uppercase">Location</h6>
                <div id="map" style="width:100%;height:160px;">
                    <script>
                    var map;

                    function initMap() {
                        map = new google.maps.Map(document.getElementById('map'), {
                            center: {
                                lat: -23.1697102,
                                lng: 89.213707
                            },
                            zoom: 14
                        });
                    }
                    </script>
                </div>
            </div>
            <div class="col-sm-3 footer-text">
                <style>
                #about_us {
                    line-height: 8px;
                    font-size: 14px;
                    padding-bottom: 0px;
                    font-weight: 600;
                    color: #DDD;
                }
                </style>
                <h6 class="text-uppercase">About us</h6>
                <?php
                include '../../admin/app/start.php';

                use Codecourse\Repositories\FrontEnd as FrontEnd;
                use Codecourse\Repositories\Helpers as Helpers;

                $frontEnd = new FrontEnd();
                $helpers = new Helpers();
                $result = $frontEnd->getAboutUsData($tableAboutUs);
                if (!empty($result)) {
                    foreach ($result as $aboutUs) { ?>
                <p id="about_us"><i class="fas fa-mobile-alt"></i> <?= $aboutUs->phone; ?></p>
                <p id="about_us"><i class="fas fa-envelope"></i> <?= $aboutUs->email; ?></p>
                <p id="about_us"><i class="fas fa-envelope"></i> <?= $aboutUs->url; ?></p>
                <p id="about_us"><i class="fas fa-address-card"></i> <?= $aboutUs->address; ?></p>
                <p id="about_us"><?= $helpers->textShorten(htmlspecialchars_decode($aboutUs->description), 45); ?></p>
                <?php }
                } ?>
            </div>
            <div class="col-sm-3 footer-text">
                <h6 class="text-uppercase">Latest Testimonials</h6>
                <ul style="list-style:none;padding:0px;">
                    <?php
                    $result = $frontEnd->getContactMessage($tableContactUs);
                    if ($result) {
                        foreach ($result as $contctData) {
                            ?>
                    <a href="testimonials.php?testimonial_id=<?= $contctData->id; ?>">
                        <li>
                            <span
                                style="background-color:#DDD;width:11px;height:11px;border-radius:50%;margin-right:8px;float:left;"></span>
                            <p style="font-size:12px;font-weight:500;line-height:11px;color:#c0c0c0;margin-bottom:5px;">
                                <?php echo $helpers->textShorten($contctData->message, 50); ?>
                            </p>
                            <p
                                style="font-size:14px; font-weight:600; line-height:10px; color:#c0c0c0; margin-left:24px; text-transform:italic;">
                                -
                                <?php echo ucfirst($contctData->first_name) . ' ' . ucfirst($contctData->last_name); ?>
                            </p>
                        </li>
                    </a>
                    <?php
                        }
                    }
                    ?>
                </ul>
            </div>
            <div class="top-social-links footer-text col-sm-3">
                <h6 class="text-uppercase">Follow us on social sites</h6>
                <div class="d-flex justify-content-between mb-4 footer-area">
                    <?php
                    $socialMediaData = $frontEnd->socialMediaDataView($tableSocialMedia);
                    if (!empty($socialMediaData)) {
                        foreach ($socialMediaData as $mediaData) { ?>
                    <a href="<?= $mediaData->site_name; ?>" target="blank">
                        <?php
                                if ($mediaData->site_name == 'http://www.facebook.com') {
                                    echo '<i class="fab fa-facebook-square"></i>';
                                } elseif ($mediaData->site_name == 'https://www.twitter.com') {
                                    echo '<i class="fab fa-twitter"></i>';
                                } elseif ($mediaData->site_name == 'http://www.linkedin.com') {
                                    echo '<i class="fab fa-linkedin"></i>';
                                } elseif ($mediaData->site_name == 'https://www.github.com') {
                                    echo '<i class="fab fa-github"></i>';
                                } elseif ($mediaData->site_name == 'https://www.plus.google.com') {
                                    echo '<i class="fab fa-google-plus"></i>';
                                } elseif ($mediaData->site_name == 'https://www.youtube.com') {
                                    echo '<i class="fab fa-youtube"></i>';
                                } else { }
                            }
                        }
                        ?>
                    </a>
                </div>
                <div class="facebook justify-content-around">
                    <a href="http://www.facebook.com" target="blank"><img src="../img/logo/facebookProfile.jpg"
                            class="img-fluid img-thumbnail" alt="Facebook"></a>
                </div>
            </div>
        </div>
    </div>
    <!-- Bottom footer bar -->
    <div class="container-fluid d-flex flex-column justify-content-center" style="background-color:#111111;">
        <div class="bottom-footer-bar d-flex justify-content-center py-2">
            <span><?php echo date('Y'); ?> All rights reserved</span>
        </div>
    </div>
    <!-- Bottom footer bar -->
</div>