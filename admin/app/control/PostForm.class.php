<?php

/**
 * PostForm Registration
 * @author  <your name here>
 */
class PostForm extends TStandardForm
{
    protected $form; // form
    protected $notebook;

    /**
     * Class constructor
     * Creates the page and the registration form
     */
    function __construct()
    {
        parent::__construct();

        // creates the form
        $this->form = new BootstrapFormWrapper(new TQuickForm('form_Post'));
        $this->form->style = 'width: 100%';
        $this->form->setFormTitle(_t('Post'));

        // defines the database
        parent::setDatabase('blog');

        // defines the active record
        parent::setActiveRecord('Post');

        // create the form fields
        $id = new THidden('id');
        $title = new TEntry('titulo');
        $body = new THtmlEditor('body');
        $keywords = new TEntry('keywords');
        $comment = new \Adianti\Widget\Form\TCombo('comment');
        $date = new \Adianti\Widget\Form\TDate('date');
        $category_id = new TDBCombo('category_id', 'blog', 'Category', 'id', 'name');

        $id->setEditable(FALSE);

        $body->setSize(500, 250);

        $comment->addItems(['s' => 'SIM', 'n' => 'NÃO']);

        // add the fields
        $this->form->addQuickField('ID', $id, '30%');
        $this->form->addQuickField(_t('Title'), $title, '70%');
        $this->form->addQuickField(_t('Keywords'), $keywords, '70%');
        $this->form->addQuickField(_t('Category'), $category_id, '70%');
        $this->form->addQuickField(_t('Date'), $date, 120);
        if (\Functions\Util\Util::onCheckFeaturePage('comment')) {
            $this->form->addQuickField('Comentário', $comment, 120);
        }
        $this->form->addQuickField('<b style="font-size: 14px.=;">Conteúdo</b>', $body, '95%');

        // define the form action
        $btn = $this->form->addQuickAction(_t('Save'), new TAction(array($this, 'onSave')), 'fa:floppy-o');
        $btn->class = 'btn btn-sm btn-primary';
        $this->form->addQuickAction('Voltar', new TAction(array('PostList', 'onLoad')), '');

        // add the form to the page
        $panelForm = new TPanelGroup('Formulário de Postagem');
        $panelForm->add($this->form);

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 90%';
        $container->add($panelForm);

        parent::add($container);
    }


    /**
     * method onSave()
     * Executed whenever the user clicks at the save button
     */
    function onSave()
    {
        try {
            // open a transaction with database
            TTransaction::open('blog');

            // get the form data
            $object = $this->form->getData('Post');

            // validate data
            $this->form->validate();

            // stores the object
            $object->store();

            // fill the form with the active record data
            $this->form->setData($object);

            // close the transaction
            TTransaction::close();

            // shows the success message
            new TMessage('info', TAdiantiCoreTranslator::translate('Record saved'));
            // reload the listing
        } catch (Exception $e) // in case of exception
        {
            // get the form data
            $object = $this->form->getData($this->activeRecord);

            // fill the form with the active record data
            $this->form->setData($object);

            // shows the exception error message
            new TMessage('error', $e->getMessage());

            // undo all pending operations
            TTransaction::rollback();
        }
    }
}
