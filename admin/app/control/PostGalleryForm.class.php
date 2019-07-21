<?php

/**
 * PostGallery Form Registration
 * @author  Jackson Meires
 */

class PostGalleryForm extends \Adianti\Base\TStandardForm
{
    protected $form; // form
    protected $notebook;
    private $frame;

    /**
     * Class constructor
     * Creates the page and the registration form
     */
    function __construct()
    {
        parent::__construct();
        $this->form = new \Adianti\Wrapper\BootstrapFormWrapper(new TQuickForm('form'));
        $this->form->style = 'width: 100%';

        $post_idFk = filter_input(INPUT_GET, 'post_id');

        // create the form fields
        $id = new THidden('id');
        $post_id = new THidden('post_id');
        $post_id->setValue($post_idFk);
        $title = new TEntry('title');
        $photo_path = new \Adianti\Widget\Form\TFile('photo_path');
        $description = new \Adianti\Widget\Form\TText('description');

        $action_onComplete = new TAction(array($this, 'onComplete'));
        $action_onComplete->setParameter('id', $post_idFk);

        // complete upload action
        $photo_path->setCompleteAction($action_onComplete);
        $photo_path->setAllowedExtensions(['gif', 'png', 'jpg', 'jpeg']);

        // add the fields
        $this->form->addQuickField('ID', $id, '30%');
        $this->form->addQuickField('Titulo', $title, '70%');
        $this->form->addQuickField('Descrição', $description, '70%');
        $this->form->addQuickField('Foto', $photo_path, '70%');

        $this->frame = new TElement('div');
        $this->frame->id = 'photo_frame';
        $this->frame->style = 'width:400px;height:auto;min-height:200px;border:1px solid gray;padding:4px;';
        $row = $this->form->addRow();
        $row->addCell('');
        $row->addCell($this->frame);

        $action_save = new TAction(array($this, 'onSave'));
        $action_save->setParameter('post_id', $post_idFk);

        $action_back = new TAction(array('PostGalleryList', 'onReload'));
        $action_back->setParameter('id', $post_idFk);

        // define the form action
        $btnSave = $this->form->addQuickAction('Save', $action_save, 'fa:floppy-o');
        $btnSave->class = 'btn btn-sm btn-primary';
        $btnBack = $this->form->addQuickAction('Back', $action_back, 'fa:arrow-back-o');
        $btnBack->class = 'btn btn-sm ';

        // add the form to the page
        $panelForm = new TPanelGroup('Formulário Galeria de Fotos Post');
        $panelForm->add($this->form);
        $panelForm->add($this->frame);

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->add($panelForm);

        parent::add($container);
    }

    public function onSave($param = null)
    {
        $object = $this->form->getData('PostGallery');

        $source_file = 'tmp/' . $object->photo_path;
        $target_file = 'attach/postgallery/' . $object->photo_path;
        $finfo = new finfo(FILEINFO_MIME_TYPE);

        // if the user uploaded a source file
        if (!empty($object->photo_path)) {

            if (file_exists($source_file) AND ($finfo->file($source_file) == 'image/png' OR $finfo->file($source_file) == 'image/jpeg')) {
                // move to the target directory
                rename($source_file, $target_file);

            }
        }

        try {
            TTransaction::open('blog');
            // update the photo_path
            $object->photo_path = 'attach/postgallery/' . strtolower($object->photo_path);
            $object->post_id = $param['post_id'];

            $object->store();

            $action = new TAction(array('PostGalleryForm', 'onEdit'));
            $action->setParameter('key', $object->id);
            $action->setParameter('id', $object->post_id);
            $action->setParameter('post_id', $object->post_id);

            $objectPost = $object;
            new TMessage('info', 'Registro salvo com sucesso', $action);

            TTransaction::close();
        } catch (Exception $e) // in case of exception
        {
            $this->form->setData($this->form->getData());
            new TMessage('error', $e->getMessage());
            TTransaction::rollback();
        }

        $image = new TImage($object->photo_path);
        $image->style = 'width: 100%';
        $this->frame->add($image);

        $action = new TAction(array('PostGalleryForm', 'onEdit'));
        $action->setParameter('key', $objectPost->id);
        $action->setParameter('id', $objectPost->post_id);
        $action->setParameter('post_id', $objectPost->post_id);

        new TMessage('info', 'Registro salvo com sucesso', $action);

    }

    /**
     * On complete upload
     */
    public static function onComplete($param)
    {
        $photo_path = strtolower($param['photo_path']);
        new TMessage('info', 'Upload completed: ' . $photo_path);

        // refresh photo_frame
        TScript::create("$('#photo_frame').html('')");
        TScript::create("$('#photo_frame').append(\"<img style=\"width: 100%;display: block;margin-left: auto;margin-right: auto;max-width: 100%;overflow: auto;\" src='tmp/{$photo_path}'>\");");
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

                $object = new PostGallery($key);

                if ($object) {

                    $image = new TImage($object->photo_path);
                    $image->style = 'width: 100%;display: block;margin-left: auto;margin-right: auto;max-width: 100%;overflow: auto;';
                    $this->frame->add($image);
                }

                $this->form->setData($object);

                TTransaction::close();
            }
        } catch (Exception $e) {
            new TMessage('error', $e->getMessage());

            TTransaction::rollback();
        }
    }
}