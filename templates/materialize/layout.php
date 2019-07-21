<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{title}</title>

    <!-- Lato Font -->
    <link href='css/fonts.css?family=Lato:300,400,700' rel='stylesheet' type='text/css'>

    <!-- Stylesheet -->
    <link href="templates/{theme}/css/gallery-materialize.min.css" rel="stylesheet">

    <!-- Material Icons -->
    <link href="templates/{theme}/icons/MaterialIcons.css" rel="stylesheet">
</head>

<body class="blog">

<!-- Navbar and Header -->
<nav class="nav-extended green">
    <div class="nav-background">
        <div class="pattern active" style="background-image: url('img/1400x300.png');"></div>
    </div>
    <div class="nav-wrapper container">
        <a href="{url}" class="brand-logo"><i class="material-icons">camera</i>{title}</a>
        <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
        <ul class="right hide-on-med-and-down">
            {menu}

        </ul>
        <!-- Dropdown Structure -->
        <ul id='feature-dropdown' class='dropdown-content'>
            <li><a href="full-header.html">Fullscreen Header</a></li>
            <li><a href="horizontal.html">Horizontal Style</a></li>
            <li><a href="no-image.html">No Image Expand</a></li>
        </ul>

        <div class="nav-header center">
            {slideshow}
        </div>
    </div>

    <!-- Fixed Masonry Filters -->
    <div class="categories-wrapper green darken-1">
        <div class="categories-container">
            <ul class="categories container">
                {category}
            </ul>
        </div>
    </div>
</nav>

<div id="portfolio" class="section gray">
    <div class="container">
        <div class="gallery row">
            {articles}
            {contact}
        </div>

    </div>

</div><!-- /.container -->

<!-- Core Javascript -->
<script src="templates/{theme}/js/jquery.min.js"></script>
<script src="templates/{theme}/js/imagesloaded.pkgd.min.js"></script>
<script src="templates/{theme}/js/masonry.pkgd.min.js"></script>
<script src="templates/{theme}/js/materialize.js"></script>
<script src="templates/{theme}/js/color-thief.min.js"></script>
<script src="templates/{theme}/js/galleryExpand.js"></script>
<script src="templates/{theme}/js/init.js"></script>


<script>
    $(document).ready(function () {
        $('.slider').slider();
        $('.carousel').carousel();
    });
</script>

</body>
<script id="dsq-count-scr" src="//bloglps.disqus.com/count.js" async></script>
</html>
