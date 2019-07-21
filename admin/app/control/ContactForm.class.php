<?php

/**
 * Contact Form Registration
 * @author  Jackson Meires
 */
class ContactForm extends TWindow
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
        parent::setTitle('Contact Form');
        $this->form = new BootstrapFormWrapper(new TQuickForm('form_feature'));
        $this->form->style = 'width: 100%';

        // sample values:
        // 600, 400 (absolute size)
        // 0.6, 0.4 (relative size 60%, 40%)
        parent::setSize(550, 355); // (600, 400)

        // absolute left, top
        // parent::setPosition( 100, 100 );

        // create the form fields
        $id = new THidden('id');
        $name = new TEntry('name');
        $email = new TEntry('email');
        $subject = new TEntry('subject');
        $text = new \Adianti\Widget\Form\TText('text');

        // add the fields
        $this->form->addQuickField('ID', $id, '30%');
        $this->form->addQuickField('Name', $name, '70%');
        $this->form->addQuickField('E-mail', $email, '70%');
        $this->form->addQuickField('Subject', $subject, '70%');
        $this->form->addQuickField('Text', $text, '70%');

        $action_save = new TAction(array($this, 'onSave'));

        // define the form action
        $btn = $this->form->addQuickAction('Save', $action_save, 'fa:floppy-o');
        $btn->class = 'btn btn-sm btn-primary';

        // add the form to the page
        $panelForm = new TPanelGroup();
        $panelForm->add($this->form);

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->add($panelForm);

        parent::add($container);
    }

    public function onSave($param = null)
    {

        try {
            $object = $this->form->getData('Contact');

            TTransaction::open('blog');

            $object->store();

            TTransaction::close();

            $action = new TAction(array('ContactList', 'onReload'));
            new TMessage('info', 'Registro salvo com sucesso', $action);

        } catch (Exception $e) {
            $this->form->setData($this->form->getData());

            new TMessage('error', $e->getMessage());

            TTransaction::rollback();
        }
    }

    /**
     * method onEdit()
     * Executed whenever the user clicks at the edit button
     */
    function onEdit($param)
    {
        try {
            if (isset($param['key'])) {
                $key = $param['key'];

                TTransaction::open('blog');

                $object = new Contact($key);

                $this->form->setData($object);

                TTransaction::close();
            }
        } catch (Exception $e) {
            new TMessage('error', $e->getMessage());

            TTransaction::rollback();
        }
    }
}
