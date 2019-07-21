<?php

/**
 * SlideShowList Listing
 * @author  <your name here>
 */
class SlideShowList extends TStandardList
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
        parent::setActiveRecord('SlideShow'); // defines the active record
        parent::setFilterField('title'); // defines the filter field
        parent::setDefaultOrder('id', 'desc');

        // creates the form
        $this->form = new BootstrapFormWrapper(new TQuickForm('form_search_SlideShow'));
        $this->form->setFormTitle('SlideShows List');

        // create the form fields
        $filter = new TEntry('title');
        $filter->setValue(TSession::getValue('SlideShow_title'));

        // add the fields
        $this->form->addQuickField('Title:', $filter, '70%');

        // define the form action
        $btn = $this->form->addQuickAction(_t('Find'), new TAction(array($this, 'onSearch')), 'fa:search');
        $btn->class = 'btn btn-sm btn-primary';
        $this->form->addQuickAction(_t('New'), new TAction(array('SlideShowForm', 'onEdit')), 'fa:plus-circle green');

        // creates a DataGrid
        $this->datagrid = new BootstrapDatagridWrapper(new TQuickGrid);
        $this->datagrid->enablePopover('Image', "<img style='width:30%' src='{photo_path}'> ");

        $this->datagrid->style = "width: 100%";

        // creates the datagrid columns
        $this->datagrid->addQuickColumn('Title', 'title', 'left', '20%');
        $this->datagrid->addQuickColumn('Description', 'description', 'center', '70%');
        $this->datagrid->addQuickColumn('Published', 'published', 'center', '10%');

        // add the actions to the datagrid
        $this->datagrid->addQuickAction(_t('Edit'), new TDataGridAction(array('SlideShowForm', 'onEdit')), 'id', 'fa:edit blue');
        $this->datagrid->addQuickAction(_t('Delete'), new TDataGridAction(array($this, 'onDelete')), 'id', 'fa:trash red');

        // create the datagrid model
        $this->datagrid->createModel();

        // creates the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());

        $panelForm = new TPanelGroup(('SlideShow List'));
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
