<?php
/**
 * Post Active Record
 * @author  <your-name-here>
 */
class PostGallery extends TRecord
{
    const TABLENAME = 'post_gallery';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'max'; // {max, serial}
    
    private $post;

    /**
     * Constructor method
     */
    public function __construct($id = NULL)
    {
        parent::__construct($id);
        parent::addAttribute('photo_path');
        parent::addAttribute('post_id');
        parent::addAttribute('title');
        parent::addAttribute('description');
    }

    /**
     * Method get_post_name
     * Sample of usage: $post->post->attribute;
     * @returns post instance
     */
    public function get_post_name()
    {
        // loads the associated object
        if (empty($this->post))
            $this->post = new Post($this->post_id);
    
        // returns the associated object
        return $this->post->name;
    }

    static public function listForPost($post_id)
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('post_id', '=', $post_id));
        
        $repos = new TRepository('PostGallery');
        return $repos->load($criteria);
    }
}