<?php

/**
 * PostGalleryList Listing
 * @author  <your name here>
 */
class PostGalleryList extends \Adianti\Base\TStandardList
{
    protected $form;     // registration form
    protected $datagrid; // listing
    protected $pageNavigation;

    /**
     * Class constructor
     * Creates the page, the form and the listing
     */
    public function __construct()
    {
        parent::__construct();

        parent::setDatabase('blog'); // defines the database
        parent::setActiveRecord('PostGallery'); // defines the active record
        parent::setFilterField('title'); // defines the filter field
        parent::setDefaultOrder('id', 'desc');

        $post_id = !empty(filter_input(INPUT_GET, 'id')) ? filter_input(INPUT_GET, 'id') : filter_input(INPUT_GET, 'post_id');
        $criteria = new \Adianti\Database\TCriteria();
        $criteria->add(new \Adianti\Database\TFilter('post_id', '=', $post_id));
        parent::setCriteria($criteria);

        // creates the form
        $this->form = new BootstrapFormWrapper(new TQuickForm('form_search_PostGallery'));
        $this->form->setFormTitle('Listagem de Galeria dos Posts');

        TTransaction::open('blog');

        $title_post = new TLabel('');
        try {
            $title_post->setValue((new Post($post_id))->titulo);

        } catch (Exception $e) {
            new \Adianti\Widget\Dialog\TMessage('error', $e->getMessage());
        }
        TTransaction::close();

        // add the fields
        $this->form->addQuickField('Titulo', $title_post, '70%');

        $action_new = new \Adianti\Control\TAction(array('PostGalleryForm', 'onEdit'));
        $action_new->setParameter('post_id', $post_id);

        $action_back = new TAction(array('PostList', 'onLoad'));
        $action_back->setParameter('id', $post_id);

        // define the form action
        $this->form->addQuickAction(_t('New'), $action_new, 'fa:plus-circle green');
        $this->form->addQuickAction('Voltar', $action_back, 'fa:arrow-left');

        // creates a DataGrid
        $this->datagrid = new \Adianti\Wrapper\BootstrapDatagridWrapper(new \Adianti\Widget\Wrapper\TQuickGrid());
        $this->datagrid->enablePopover('Image', "<img style='width:30%' src='{photo_path}'> ");

        $this->datagrid->style = "width: 100%";

        // creates the datagrid columns
        $this->datagrid->addQuickColumn('Title', 'title', 'left', '20%');
        $this->datagrid->addQuickColumn('Description', 'description', 'center', '70%');
        $this->datagrid->addQuickColumn('Published', 'published', 'center', '10%');

        $action_edit = new \Adianti\Widget\Datagrid\TDataGridAction(array('PostGalleryForm', 'onEdit'));
        $action_edit->setParameter('post_id', $post_id);

        $action_delete = new TDataGridAction(array($this, 'onDelete'));
        $action_delete->setParameter('id', $post_id);
        $action_delete->setParameter('post_id', $post_id);

        // add the actions to the datagrid
        $this->datagrid->addQuickAction(_t('Edit'), $action_edit, 'id', 'fa:edit blue');
        $this->datagrid->addQuickAction(_t('Delete'), $action_delete, 'id', 'fa:trash red');

        // create the datagrid model
        $this->datagrid->createModel();

        // creates the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());

        $panelForm = new TPanelGroup(('Listagem de Galeria dos Posts'));
        $panelForm->add($this->form);

        $panelGrid = new TPanelGroup;
        $panelGrid->add($this->datagrid);
        $panelGrid->addFooter($this->pageNavigation);

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 90%';
        $container->add($panelForm);
        $container->add($panelGrid);

        // add the container inside the page
        parent::add($container);
    }

    function onLoad()
    {

    }
}
