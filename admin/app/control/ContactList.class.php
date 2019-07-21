<?php

/**
 * ContactList Listing
 * @author  <your name here>
 */
class ContactList extends TStandardList
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
        parent::setActiveRecord('Contact'); // defines the active record
        parent::setFilterField('title'); // defines the filter field
        parent::setDefaultOrder('id', 'desc');

        // creates the form
        $this->form = new BootstrapFormWrapper(new TQuickForm('form_search_Contact'));
        $this->form->setFormTitle('Contacts List');

        // create the form fields
        $filter = new TEntry('subject');
        $filter->setValue(TSession::getValue('Contact_title'));

        // add the fields
        $this->form->addQuickField('Subject:', $filter, '70%');

        // define the form action
        $btn = $this->form->addQuickAction(_t('Find'), new TAction(array($this, 'onSearch')), 'fa:search');
        $btn->class = 'btn btn-sm btn-primary';
        $this->form->addQuickAction(_t('New'), new TAction(array('ContactForm', 'onEdit')), 'fa:plus-circle green');

        // creates a DataGrid
        $this->datagrid = new BootstrapDatagridWrapper(new TQuickGrid);
        $this->datagrid->style = "width: 100%";

        // creates the datagrid columns
        $this->datagrid->addQuickColumn('Name', 'name', 'left', '30%');
        $this->datagrid->addQuickColumn('Subject', 'subject', 'center', '60%');
        $this->datagrid->addQuickColumn('E-mail', 'email', 'center', '30%');

        // add the actions to the datagrid
        $this->datagrid->addQuickAction(_t('Edit'), new TDataGridAction(array('ContactForm', 'onEdit')), 'id', 'fa:edit blue');
        $this->datagrid->addQuickAction(_t('Delete'), new TDataGridAction(array($this, 'onDelete')), 'id', 'fa:trash red');

        // create the datagrid model
        $this->datagrid->createModel();

        // creates the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());

        $panelForm = new TPanelGroup(('Contact List'));
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
