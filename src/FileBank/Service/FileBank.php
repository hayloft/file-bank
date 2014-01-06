<?php
/**
 * OfficeX: OX (http://ox.hayloft-it.ch/)
 *
 * @link      https://github.com/hayloft/ox
 * @copyright Copyright (c) 2013 Hayloft-IT GmbH (http://www.hayloft-it.ch)
 */

namespace FileBank\Service;

use FileBank\Manager;
use Zend\Form\Form;
use FileBank\Form\Upload as UploadForm;
use FileBank\Entity\File as FileEntity;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\Http\Request;

class FileBank implements EventManagerAwareInterface
{
    use EventManagerAwareTrait;

    /**
     * @var Manager
     */
    protected $manager;

    /**
     * @var UploadForm
     */
    protected $uploadForm;

    /**
     * @param  Request|array $data
     * @param  Form          $form
     * @return bool|FileEntity
     */
    public function validateForm($data, Form $form = null)
    {
        if (null === $form) {
            $form = $this->getUploadForm();
        }

        if ($data instanceof Request) {
            $data = $data->getPost();
        }

        $form->setData($data);
        if ($form->isValid()) {
            $data = $form->getData();
            return $this->getManager()->getFileFromArray($data['file']);
        } else {
            return false;
        }
    }

    /**
     * @param UploadForm $uploadForm
     */
    public function setUploadForm($uploadForm)
    {
        $this->uploadForm = $uploadForm;
    }

    /**
     * @return UploadForm
     */
    public function getUploadForm()
    {
        return $this->uploadForm;
    }

    /**
     * @param Manager $manager
     */
    public function setManager($manager)
    {
        $this->manager = $manager;
    }

    /**
     * @return Manager
     */
    public function getManager()
    {
        return $this->manager;
    }
}
