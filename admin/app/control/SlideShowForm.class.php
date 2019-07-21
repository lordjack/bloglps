<?php

/**
 * SlideShow Form Registration
 * @author  Jackson Meires
 */

class SlideShowForm extends \Adianti\Base\TStandardForm
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
        $this->form = new \Adianti\Wrapper\BootstrapFormWrapper(new TQuickForm('form_feature'));
        $this->form->style = 'width: 100%';

        // create the form fields
        $id = new THidden('id');
        $title = new TEntry('title');
        $photo_path = new \Adianti\Widget\Form\TFile('photo_path');
        $link = new TEntry('link');
        $description = new \Adianti\Widget\Form\TText('description');
        $published = new \Adianti\Widget\Form\TRadioGroup('published');

        $publishedArray = [];
        $publishedArray['S'] = 'SIM';
        $publishedArray['N'] = 'NÃO';

        $published->addItems($publishedArray);

        // complete upload action
        $photo_path->setCompleteAction(new TAction(array($this, 'onComplete')));
        $photo_path->setAllowedExtensions(['gif', 'png', 'jpg', 'jpeg']);

        // add the fields
        $this->form->addQuickField('ID', $id, '30%');
        $this->form->addQuickField('Title', $title, '70%');
        $this->form->addQuickField('Text', $description, '70%');
        $this->form->addQuickField('Link', $link, '70%');
        $this->form->addQuickField('Photo', $photo_path, '70%');
        $this->form->addQuickField('Published', $published, '70%');

        $this->frame = new TElement('div');
        $this->frame->id = 'photo_frame';
        $this->frame->style = 'width:400px;height:auto;min-height:200px;border:1px solid gray;padding:4px;';
        $row = $this->form->addRow();
        $row->addCell('');
        $row->addCell($this->frame);

        $action_save = new TAction(array($this, 'onSave'));

        // define the form action
        $btnSave = $this->form->addQuickAction('Save', $action_save, 'fa:floppy-o');
        $btnSave->class = 'btn btn-sm btn-primary';
        $btnBack = $this->form->addQuickAction('Back', new TAction(array('SlideShowList', 'onReload')), 'fa:arrow-back-o');
        $btnBack->class = 'btn btn-sm ';

        // add the form to the page
        $panelForm = new TPanelGroup('SlideShow Form');
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
        $object = $this->form->getData('SlideShow');

        $source_file = 'tmp/' . $object->photo_path;
        $target_file = 'attach/slideshow/' . $object->photo_path;
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
            $object->photo_path = 'attach/slideshow/' . strtolower($object->photo_path);
            $object->store();

            $action = new TAction(array('SlideShowList', 'onReload'));
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

        $action = new TAction(array('SlideShowList', 'onReload'));
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

                $object = new SlideShow($key);

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