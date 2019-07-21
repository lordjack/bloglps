<?php

ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ALL);

define('THEME', 'materialize');
define('ROOT', getcwd());

chdir('admin');
require_once 'admin/init.php';
require_once 'lib/route/Route.php';

new TSession;

TTransaction::open('blog');


// render a category
Route::get('show_category', function ($args) {
    $partial_article = file_get_contents(ROOT . '/templates/' . THEME . '/partials/article.html');
    $partial_category = file_get_contents(ROOT . '/templates/' . THEME . '/partials/category.html');

    $category_id = (int)$args['category_id'];
    $category = isset($args['category_id']) ? $args['category_id'] : Category::getFirst();
    $categories = CategoryRender::render($category_id, $partial_category);
    $articles = PostRender::renderForCategory($category_id, $partial_article);
    $category = new Category($category_id);

    render_content(['articles' => $articles, 'category' => $categories]);
});

// render a post
Route::get('show_post', function ($args) {
    $partial_article = file_get_contents(ROOT . '/templates/' . THEME . '/partials/article.html');
    $partial_category = file_get_contents(ROOT . '/templates/' . THEME . '/partials/category.html');

    $post_id = isset($args['post_id']) ? (int)$args['post_id'] : NULL;
    $post = new Post($post_id);
    $articles = PostRender::renderPost(new Post($post_id), $partial_article);
    $categories = CategoryRender::render($post->category_id, $partial_category);

    render_content(['articles' => $articles, 'category' => $categories]);
});

// send contact
Route::get('send_contact', function ($args) {
//ContactRender::onSave()
    $partial_article = file_get_contents(ROOT . '/templates/' . THEME . '/partials/article.html');
    $partial_category = file_get_contents(ROOT . '/templates/' . THEME . '/partials/category.html');

    $post_id = isset($args['post_id']) ? (int)$args['post_id'] : NULL;
    $post = new Post($post_id);
    $articles = PostRender::renderPost(new Post($post_id), $partial_article);
    $categories = CategoryRender::render($post->category_id, $partial_category);

    render_content(['articles' => $articles, 'category' => $categories]);
});

// default action
Route::get('', function ($args) {
    $category_id = 1;
    $year = !empty($args['year']) ? (int)$args['year'] : date('Y');

    Route::run('show_category', ['category_id' => $category_id, 'year' => $year]);
});

// render page content
function render_content($replaces)
{
    $content = new Content(1);

    $partial_contact = file_get_contents(ROOT . '/templates/' . THEME . '/partials/contact.php');
    $layout_content = file_get_contents(ROOT . '/templates/' . THEME . '/layout.php');
    $layout_content = str_replace('{theme}', THEME, $layout_content);
    $layout_content = str_replace('{url}', $_SERVER['SCRIPT_NAME'], $layout_content);
    $layout_content = str_replace('{title}', $content->title, $layout_content);

    try {
        if (\Functions\Util\Util::onCheckFeaturePage('slideshow')) {
            if (empty(filter_input(INPUT_GET, 'action')) && empty(filter_input(INPUT_GET, 'page'))) {
                $layout_content = str_replace('{slideshow}', SlideShowRender::render(), $layout_content);
            } else {
                $layout_content = str_replace('{slideshow}', '<h1>BLOG</h1><div class="tagline">Professional</div>', $layout_content);
            }
        } else {
            $layout_content = str_replace('{slideshow}', '  <h1>BLOG</h1><div class="tagline">Professional</div>', $layout_content);
        }

        if (\Functions\Util\Util::onCheckFeaturePage('contact')) {
            if (filter_input(INPUT_GET, 'page') == 'contact') {
                $layout_content = str_replace('{contact}', $partial_contact, $layout_content);
                $layout_content = str_replace('{articles}', '', $layout_content);
                $layout_content = str_replace('{slideshow}', '<h1>BLOG</h1><div class="tagline">Professional</div>', $layout_content);
            } else {
                $layout_content = str_replace('{contact}', '', $layout_content);
            }
            $layout_content = str_replace('{menu}', '<li class="active"><a href="index.php">In&iacute;cio</a></li>
            <li><a href="index.php?action=show_post&post_id=5">Sobre</a></li>
            <li><a href="index.php?page=contact">Contato</a>
            </li>', $layout_content);
        } else {
            $layout_content = str_replace('{contact}', '', $layout_content);
            $layout_content = str_replace('{menu}', '<li class="active"><a href="index.php">In&iacute;cio</a></li>
            <li><a href="index.php?action=show_post&post_id=5">Sobre</a></li>
            </li>', $layout_content);
        }
    } catch (Exception $e) {
        print_r($e->getMessage());
    }
    $layout_content = str_replace('{subtitle}', $content->subtitle, $layout_content);
    // $layout_content = str_replace('{sidepanel}', $content->sidepanel, $layout_content);

    foreach ($replaces as $key => $value) {
        $layout_content = str_replace('{' . $key . '}', $value, $layout_content);
    }
    echo $layout_content;
}

TTransaction::close();
