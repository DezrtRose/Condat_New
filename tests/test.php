<?php
// Start the session
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title>Nepcoms ICT</title>
    <link href="styles/style.css" rel="stylesheet" type="text/css"/>


    <link href="fmslideshow_assets/fmslideshow.min.css" rel="stylesheet" type="text/css"/>
    <link href="styles/flexslider.css" rel="stylesheet" type="text/css"/>
    <link href="remodal/remodal.css" rel="stylesheet" type="text/css"/>
    <link href="remodal/remodal-default-theme.css" rel="stylesheet" type="text/css"/>
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="http://cufon.shoqolate.com/js/cufon-yui.js"></script>
    <script src="fmslideshow_assets/note-this.cufonfonts.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include depricated functions for fmslide -->
    <script src="http://code.jquery.com/jquery-migrate-1.0.0.js"></script>
    <!--<script src="fmslideshow_assets/jquery-1.6.2.min.js"></script>-->
    <script src="fmslideshow_assets/fmslideshow.min.js"></script>
    <script src="js/jquery.flexslider-min.js"></script>
    <script src="remodal/remodal.js"></script>

    <script>

        jQuery(function ($) {
            $('#jq_fmslideshow').fmslideshow({

                //Note: if you need to modify further see the available variable in fmslideshow.js file.

                banner_width: 940,
                banner_height: 400,

                image_background: "fmslideshow_assets/bg.png",
                image_topShadow: "fmslideshow_assets/top_border.png",
                image_bottomShadow: "fmslideshow_assets/bottom_border.png",

                background_fullScreen: true,
                background_move: true,
                background_moveDistance: 700,

                buttons_type: 1,
                buttons_autoHide: true,

                button_nextPrevious_autoHide: true,
                button_nextPrevious_type: 1,
                button_next_align: "C",
                button_next_spacing: "0,420",
                button_previous_align: "C",
                button_previous_spacing: "0,-420"

            });
        });

    </script>


    <style type="text/css">
        @font-face {
            font-family: 'BebasNeueRegular';
            src: url('fonts/BebasNeue-webfont.eot');
            src: url('fonts/BebasNeue-webfont.eot?#iefix') format('embedded-opentype'),
            url('fonts/BebasNeue-webfont.woff') format('woff'),
            url('fonts/BebasNeue-webfont.ttf') format('truetype'),
            url('fonts/BebasNeue-webfont.svg#BebasNeueRegular') format('svg');
            font-weight: normal;
            font-style: normal;

        }
    </style>


</head>

<body>
<div id="snav" class="en">
    <ul>
        <li> <a href="#modal"> <i class="fa fa-star"></i> <span>Special Offer</span> </a> </li>
    </ul>
</div>

<div class="header_liner"></div>
<div id="wrapper">
    <div class="container">
        <div class="header">
            <div class="logo"><a href="index.php"><img src="images/logo.jpg"/></a></div>
            <div class="menu">
                <ul>
                    <li class="active"><a href="index.php">home</a></li>
                    <li><a href="whoweare.php">who we are</a></li>
                    <li><a href="whatwedo.php">what we do</a></li>
                    <li><a href="ourwork.php">our work</a></li>
                    <li><a href="contact.php">contact us</a></li>

                </ul>
            </div>
            <!-- End of menu  -->
        </div>
        <!-- End of header  -->
    </div>
    <!-- End of container  -->


    <div id="jq_fmslideshow" style="position:relative; overflow:hidden; background-color:#fbfbfb" align="left">

        <div id="fmslideshow" style="visibility:hidden">


            <!--Slide 1 -->
            <div>

                <img data-align="TC" data-spacing="0,0" data-inOutDirection="L" data-inOutDistance="50" class="imgSty"
                     src="image_slideshow/image1.png" alt="fmslideshow"/>

                <div data-align="C" data-spacing="-40,0" data-inOutDirection="RL" data-inOutDistance="30"
                     class="divStyle">
                    <span class="txtLarge" style="background-color:#fff; color:#000">Growing Your Business</span>
                </div>

                <div data-align="C" data-spacing="20,0" data-inOutDirection="LR" data-inOutDistance="30"
                     class="divStyle">
                 <span class="txtMedium" style=" color:#000; background-color:#fff;">
Locally,Socially & Organically</span>
                </div>

            </div>


            <!--Slide 3 -->
            <div>
                <img data-align="BL" data-spacing="0,50" data-inOutDirection="BB" data-inOutDistance="50" class="imgSty"
                     src="image_slideshow/image2.png" alt="fmslideshow"/>

                <div data-align="TR" data-spacing="70,0" data-inOutDirection="RL" class="divStyle" style="width:460px">
                    <span class="txtLarge" style="background-color:#000000">WEB DESIGNING</span>
                </div>

                <div data-align="TR" data-spacing="20,0" data-inOutDirection="LR" class="divStyle"
                     data-inOutDistance="60" style="width:400px">
                    <span class="txtMedium" style="background-color:#000000;">We build creative, effective & professional websites</span>
                </div>

            </div>


            <!--Slide 10 -->
            <div>

                <img data-align="LC" data-spacing="150,0" data-inOutDirection="L" data-inOutDistance="25" class="imgSty"
                     src="image_slideshow/seo.png" alt="fmslideshow"/>

                <div data-align="TC" data-spacing="70,220" data-inOutDirection="BR" data-inOutDistance="20"
                     class="divStyle" style="width:400px">
                    <span class="txtMedium" style="background-color:#000000; color:#FFF">SIMPLIFYING THE</span>
                </div>

                <div data-align="TC" data-spacing="5,195" data-inOutDirection="BR" data-inOutDistance="20"
                     class="divStyle" style="width:360px">
                    <span class="txtMedium"
                          style="background-color:#000000; color:#FFF">EVER-CHANGING WORLD OF</span></span>
                </div>

                <div data-align="TC" data-spacing="10,220" data-inOutDirection="BR" data-inOutDistance="20"
                     class="divStyle" style="width:400px">
                    <span class="txtMedium"
                          style="background-color:#000000; color:#FFF">INTERNET TECHNOLOGIES.</a></span>
                </div>

            </div>


            <!--Slide 11 -->
            <div>

                <img data-align="TC" data-spacing="50,0" data-inOutDirection="TB" data-inOutDistance="25" class="imgSty"
                     src="image_slideshow/image10.png" alt="fmslideshow"/>

                <img data-align="TL" data-spacing="50,100" data-inOutDirection="LL" data-inOutDistance="50"
                     class="imgSty" src="image_slideshow/image13.png" alt="fmslideshow"/>

                <img data-align="TR" data-spacing="50,100" data-inOutDirection="RR" data-inOutDistance="50"
                     class="imgSty" src="image_slideshow/image14.png" alt="fmslideshow"/>

                <div data-align="BC" data-spacing="100,0" data-inOutDirection="BT" data-inOutDistance="20"
                     class="divStyle">
                    <span class="txtExMedium" style="color:#000;">Design & Development that reap rewards</span><br/>

                </div>

            </div>

            <!-- End slide-->


        </div>

    </div>


    <div class="container">
        <div class="packages">

            <ul>
                <li>
                    <ul>
                        <li><a href="#"><img src="images/website_design_ico.jpg"/></a></li>
                        <li><a href="#"><h3>Web Design</h3></a><a href="#"><p>the front door of your business</p></a>
                        </li>

                    </ul>
                </li>
                <li>
                    <ul>
                        <li><a href="#"><img src="images/seo_ico.jpg"/></a></li>
                        <li><a href="#"><h3>Search Engine Op. (SEO)</h3></a><a href="#"><p>be found and increase
                                    sales</p></a></li>

                    </ul>
                </li>
                <li>
                    <ul>
                        <li><a href="#"><img src="images/website_design_ico.jpg"/></a></li>
                        <li><a href="#"><h3>Logo Design</h3></a><a href="#"><p>have a clear, professional image</p></a>
                        </li>

                    </ul>
                </li>

                <li>
                    <ul>
                        <li><a href="#"><img src="images/web_redesign_ico.jpg"/></a></li>
                        <li><a href="#"><h3>Website re-design</h3></a><a href="#"><p>tweaking your site to
                                    perfection</p></a></li>

                    </ul>
                </li>
                <li>
                    <ul>
                        <li><a href="#"><img src="images/animation_ico.jpg"/></a></li>
                        <li><a href="#"><h3>Animation</h3></a><a href="#"><p>keep yourself interactive </p></a></li>

                    </ul>
                </li>
                <li>
                    <ul>
                        <li><a href="#"><img src="images/ecommerce.jpg"/></a></li>
                        <li><a href="#"><h3>eCommerce</h3></a><a href="#"><p>stand out from your competitors.</p></a>
                        </li>

                    </ul>
                </li>

                <li>
                    <ul>
                        <li><a href="#"><img src="images/websit_redesign_ico2.jpg"/></a></li>
                        <li><a href="#"><h3>Blogs / CMS Systems</h3></a><a href="#"><p>take full control of your
                                    website</p></a></li>

                    </ul>
                </li>
                <li>
                    <ul>
                        <li><a href="#"><img src="images/mobile_app_ico.jpg"/></a></li>
                        <li><a href="#"><h3>Mobile App Design</h3></a><a href="#"><p>get your website on Mobile!</p></a>
                        </li>

                    </ul>
                </li>
                <li>
                    <ul>
                        <li><a href="#"><img src="images/social_media_ico.jpg"/></a></li>
                        <li><a href="#"><h3>Social Media Networking</h3></a><a href="#"><p>network with other
                                    businesses</p></a></li>

                    </ul>
                </li>
            </ul>
        </div>
        <!-- End of packages  -->
        <div class="fun_and_innovative">
            <h1>our work is fun and innovative</h1>

            <p>if your goal is high, we are design and marketing agency that can take you there. We are the company
                which is more thana website design, development and search engine optimization(SEO) agency</p>
            <img src="images/our_process.jpg">
            <span>Every client is considered important. Whether you are a startup or a huge corporation - if you appeciate quality, then we are the company for you. Your website is you hardest working employee; invest wisely in it </span>
        </div>
        <!-- End of fun and innovative  -->

        <?php include 'our_clients.php'; ?>
        <div class="our_products">
            <h2><a href="#">our products</a></h2>

            <div class="display">
                <a href="http://www.moneytransfer.webunisoft.com"><img src="images/our_prod_img.jpg" width="149"
                                                                       height="180"/></a>

                <p align="right">Record Client Details<br/>
                    Print Receipt<br/>
                    Create austrac report in minutes<br/>
                    multiuser access<br/>
                    allow agent to use is<br/>
                    full support provided</p>
            </div>

        </div>
        <!-- End of our_products  -->
        <div class="clr"></div>

    </div>
    <!-- End of container  -->
    <?php include 'footer.php'; ?>

</div>
<!-- End of wrapperr  -->
<div class="remodal" data-remodal-id="modal" role="dialog" aria-labelledby="modal1Title" aria-describedby="modal1Desc">
    <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
    <div>
        <h2 id="modal1Title" class="modal-title">Special Offer</h2>

        <p id="modal1Desc" class="modal-body">
            Develop your website starting from <strong>$500</strong>* only. For more info, <a href="contact.php">contact
                us</a>.<br/>
            Offer valid from March to April.
            <br/>
            <br/>
            <br/>
            <small>*Conditions Apply!</small>
        </p>
    </div>
    <br>
    <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
    <a href="contact.php" class="remodal-confirm">OK</a>
</div>


<?php
//check if first time
if (!isset($_SESSION['modal'])){
    $_SESSION['modal'] = true;
?>

<script type="text/javascript">
    $(document).ready(function (e) {
        var inst = $('[data-remodal-id=modal]').remodal({
            modifier: 'with-red-theme'
        });
        inst.open();
    });
</script>

<?php } ?>

</body>
</html>