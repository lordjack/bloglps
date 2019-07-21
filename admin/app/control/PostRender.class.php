<?php
ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ALL);

class PostRender
{
    /**
     * Render all posts from a category
     */
    static public function renderForCategory($category, $partial)
    {
        $posts = Post::listForCategory($category);
        $content = '';
        if ($posts) {
            foreach ($posts as $post) {
                $content .= self::renderPost($post, $partial);
            }
        }
        return $content;
    }

    /**
     * Render a given post
     */
    static public function renderPost($post, $partial)
    {
        $content = '';

        $postpartial = $partial;
        $date = substr($post->date, 0, 4) . '-' . substr($post->date, 4, 2) . '-' . substr($post->date, 6, 2);
        $postpartial = str_replace('{title}', $post->titulo, $postpartial);
        $postpartial = str_replace('{id}', $post->id, $postpartial);
        $postpartial = str_replace('{date}', \Adianti\Widget\Form\TDate::date2br($post->date), $postpartial);
        $postpartial = str_replace('{body}', $post->body, $postpartial);

        try {
            if (\Functions\Util\Util::onCheckFeaturePage('comment')) {
                $postpartial = str_replace('{comment}', $post->comment, $postpartial);
            } else {
                $postpartial = str_replace('{comment}', 'n', $postpartial);
            }

            if (\Functions\Util\Util::onCheckFeaturePage('photo')) {
                $postpartial = str_replace('{galleryphoto}', self::renderPostGallery($post->id), $postpartial);

            } else {
                $postpartial = str_replace('{galleryphoto}', '', $postpartial);

            }

        } catch (PDOException $e) {
            print_r($e->getMessage());
        }

        return $postpartial;
    }

    /**
     * Render a given post
     */
    static public function renderPostGallery($post_id)
    {
        $objects = PostGallery::listForPost($post_id);
        $div = '<div class="row">';
        try {
            $i = 0;
            foreach ($objects as $object) {

                if (!empty($object->photo_path)) {
                    $div .= "<div class=\"col s12 m6 l3\"><img class=\"materialboxed\" width=\"250\" src='admin/{$object->photo_path}' > </div>";
                    $i++;
                }
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        $div .= "</div>";
        return $div;
    }
}
