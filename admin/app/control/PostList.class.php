<?php

/**
 * PostList Listing
 * @author  <your name here>
 */
class PostList extends TStandardList
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
        parent::setActiveRecord('Post'); // defines the active record
        parent::setFilterField('titulo'); // defines the filter field
        parent::setDefaultOrder('id', 'desc');

        // creates the form
        $this->form = new BootstrapFormWrapper(new TQuickForm('form_search_Post'));
        $this->form->setFormTitle('Posts');

        // create the form fields
        $filter = new TEntry('title');
        $filter->setValue(TSession::getValue('Post_title'));

        // add the fields
        $this->form->addQuickField('Titulo:', $filter, '70%');

        // define the form action
        $btn = $this->form->addQuickAction(_t('Find'), new TAction(array($this, 'onSearch')), 'fa:search');
        $btn->class = 'btn btn-sm btn-primary';
        $this->form->addQuickAction(_t('New'), new TAction(array('PostForm', 'onEdit')), 'fa:plus-circle green');

        // creates a DataGrid
        $this->datagrid = new BootstrapDatagridWrapper(new TQuickGrid);
        $this->datagrid->style = "width: 100%";

        // creates the datagrid columns
        $id = $this->datagrid->addQuickColumn('ID', 'id', 'center', '10%');
        $title = $this->datagrid->addQuickColumn(_t('Title'), 'titulo', 'left', '60%');
        $category_name = $this->datagrid->addQuickColumn(_t('Category'), 'category_name', 'center', '30%');

        // add the actions to the datagrid
        $this->datagrid->addQuickAction(_t('Edit'), new TDataGridAction(array('PostForm', 'onEdit')), 'id', 'fa:edit blue');
        $this->datagrid->addQuickAction(_t('Delete'), new TDataGridAction(array($this, 'onDelete')), 'id', 'fa:trash red');
        if (\Functions\Util\Util::onCheckFeaturePage('photo')) {
            $this->datagrid->addQuickAction('Add Foto', new \Adianti\Widget\Datagrid\TDataGridAction(array('PostGalleryList', 'onReload')), 'id', 'fa:photo');
        }

        // create the datagrid model
        $this->datagrid->createModel();

        // creates the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());

        $panelForm = new TPanelGroup(('Página List'));
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
