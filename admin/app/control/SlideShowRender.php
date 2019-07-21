<?php
/**
 * Created by PhpStorm.
 * User: Jackson Meires
 * Date: 24/03/2018
 * Time: 19:02
 */


class SlideShowRender
{

    static public function render()
    {
        $div = '<div class="slider">
    <ul class="slides">';
        try {

            $objects = SlideShow::listAll();

            foreach ($objects as $object) {

                $div .= "<li>";
                if (!empty($object->photo_path)) {
                    $div .= "<img src='admin/{$object->photo_path}' alt='' />";
                }
                $div .= "<div class=\"caption center-align\">
                            <h3>$object->title</h3>
                            <h5 class=\"light grey-text text-lighten-3\">$object->description</h5>
                            <a href='{$object->link}' target='_black' >Leia Mais</a>
                         </div>";
                $div .= "</li>";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        $div .= "</ul>
              </div>";
        return $div;
    }
}