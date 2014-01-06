<?php

namespace FileBank\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class Upload extends Form
{
    /**
     * Set form name
     */
    public function __construct()
    {
        parent::__construct('file');
    }

    /**
     * Init form
     */
    public function init()
    {
        $this->setAttribute('method', 'post')
            ->setInputFilter(new InputFilter());

        $this->add(array(
            'type' => 'Zend\Form\Element\File',
            'name' => 'file',
            'options' => array(
                'label'    => 'File',
                'required' => true,
            ),
            'attributes' => array(
                'multiple' => true,
            ),
        ));
    }
}
