<!DOCTYPE html>
<html lang="en-US">


<head>
    <title>خدمة وفرلى - برعاية ايفاز</title>
    <meta charset="utf-8">
    <meta content="IE=edge" http-equiv="x-ua-compatible">
    <meta content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no" name="viewport">
    <link href="https://fonts.googleapis.com/css?family=Lateef" rel="stylesheet">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="yes" name="apple-touch-fullscreen">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/responsive.css">
    <link rel="shortcut icon" href="images/favicon.ico">
</head>

<body>

    <div class="loader-app">
        <!--<h3>وفرلى</h3>-->
        <img src="images/logo.png" alt="وفرلى">
        <div class="ld ld-ring ld-spin-fast huge"></div>
    </div>
    <div id="main">
        <div id="slide-out-right" class="side-nav">
            <ul class="collapsible" data-collapsible="accordion">
                <li class="current-item"><a href="index.blade.php"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
                <li>
                    <div class="collapsible-header"><i class="fa fa-shopping-bag"></i> التصنيفات <span class="angle-left fa fa-angle-left"></span></div>
                    <div class="collapsible-body">
                        <ul>
                            <li><a href="category.blade.php">تصنيف 1</a></li>
                            <li><a href="category.blade.php">تصنيف 1</a></li>
                            <li><a href="category.blade.php">تصنيف 1</a></li>
                            <li><a href="category.blade.php">تصنيف 1</a></li>
                        </ul>
                    </div>
                </li>
                <li>
                    <div class="line-separator"></div>
                </li>
                <li><a href="terms.blade.php"><i class="fa fa-edit"></i> سياسة الموقع</a></li>
                <li><a href="login.blade.php"><i class="fa fa-sign-in"></i> دخول</a></li>
                <li><a href="signup.blade.php"><i class="fa fa-user"></i> تسجيل</a></li>
                <li><a href="#"><i class="fa fa-sign-out"></i> خروج</a></li>
            </ul>
        </div>
        <div id="page">
            <div class="top-navbar">
                <div class="top-navbar-right"><a href="#" id="menu-right" data-activates="slide-out-right"><i class="fa fa-bars"></i></a></div>
                <div class="top-navbar-left back_btn"><a data-activates="slide-out-right"><i class="fa fa-caret-left"></i></a></div>
                <div class="top-navbar-left"><a href="search.blade.php" data-activates="slide-out-right"><i class="fa fa-search"></i></a></div>
                <div class="site-title" *ngIf="logo">
                    <!--<h1>وفرلى</h1>-->
                    <img src="images/logo.png" alt="وفرلى">
                </div>
            </div>
            <div class="content-container">
                <!-- HERE IS CONTENTS -->
                <div class="pages verify-page">
                    <div class="maleo-card signup animated fadeInUp">
                        <h3 class="maleo-card_title big-title text-center">رمز التفعيل</h3>
                        <div class="form-content">
                            <p class="app-desc">من فضلك! أدخل رمز التفعيل المرسل لك. ثم أضغط تفعيل.</p>
                            <div class="input-field with-icon"><span class="icon"><i class="fa fa-phone"></i></span><input id="login" type="text" placeholder="رقم التليفون"></div>
                            <button class="btn-large block margin-bottom" type="button">تفعيل</button>
                        </div>
                    </div>
                </div>
                <!-- //HERE IS CONTENTS -->
            </div>
            <div class="footer">
                <div class="social-footer">
                    <a href="#" class="facebook"><i class="fa fa-facebook"></i></a>
                    <a href="#" class="twitter"><i class="fa fa-twitter"></i></a>
                </div>
                <div class="copyright">Copyright © 2017 – iVAS</div>
            </div>
            <div id="to-top" class="main-bg"><i class="fa fa-chevron-up"></i></div>
        </div>
    </div>



    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <script type="text/javascript" src="js/jquery.mixitup.min.js"></script>
    <script type="text/javascript" src="js/slick.min.js"></script>
    <script type="text/javascript" src="js/jquery.swipebox.min.js"></script>
    <script type="text/javascript" src="js/custom.js"></script>
</body>


</html>