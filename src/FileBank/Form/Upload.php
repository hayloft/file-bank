<?php

namespace FileBank\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class Upload extends Form
{
    /**
     * @param null|int|string $name    Optional name for the element
     * @param array           $options Optional options for the element
     */
    public function __construct($name = 'file', $options = array())
    {
        parent::__construct($name, $options);
    }

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
