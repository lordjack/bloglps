<?php

class ContactRender
{
    /**
     * Render the category index
     */

    static public function onSave1($data)
    {

    }


    static public function onSave($data)
    {
        var_dump($data);

        TTransaction::open('blog');
        $categories = Contact::listAll();

        var_dump($categories);
        TTransaction::close();
    }
}
