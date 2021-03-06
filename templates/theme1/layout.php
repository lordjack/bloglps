<!DOCTYPE html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>{title}</title>
    <link rel="stylesheet" id="twentytwelve-fonts-css" href="templates/theme1/include/css.css" type="text/css"
          media="all">
    <link rel="stylesheet" id="twentytwelve-style-css" href="templates/theme1/include/style.css" type="text/css"
          media="all">

    <!-- css SlideShow -->
    <link rel="stylesheet" href="lib/slideshow/dist/css/unslider.css">
    <!-- fim css SlideShow -->

<body class="home blog custom-font-enabled single-author">
<div id="page" class="hfeed site">
    <header id="masthead" class="site-header" role="banner">
        <hgroup>
            <h1 class="site-title"><a href="{url}" title="Theme Preview" rel="home">{title}</a></h1>
            <h2 class="site-description">{subtitle}</h2>
        </hgroup>

        <nav id="site-navigation" class="main-navigation" role="navigation">
            <h3 class="menu-toggle">Menu</h3>
            <a class="assistive-text" href="#content" title="Skip to content">Skip to content</a>
            <div class="nav-menu">
                <ul>
                    {category}
                </ul>
            </div>
        </nav><!-- #site-navigation -->

    </header><!-- #masthead -->

    <div id="main" class="wrapper">
        <div id="primary" class="site-content">

            <div class="automatic-slider"> {slideshow}</div>

            <div id="content" role="main">
                {contact}
                {articles}

            </div><!-- #content -->
        </div><!-- #primary -->


        <div id="secondary" class="widget-area" role="complementary">
            <aside id="categories-3" class="widget widget_categories">
                {sidepanel}
            </aside>
        </div><!-- #secondary -->
    </div><!-- #main .wrapper -->
</div><!-- #page -->
<!-- There'll be a load of other stuff here -->
<script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="lib/slideshow/src/js/unslider.js"></script> <!-- but with the right path! -->
<script>
    jQuery(document).ready(function ($) {
        $('.automatic-slider').unslider({
            autoplay: true,
            arrows: false
        });
    });
</script>
</body>
</html>
