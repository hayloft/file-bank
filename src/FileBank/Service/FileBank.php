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
use Zend\Http\Request;

class FileBank
{
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
     * @return array|false
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
            return $form->getData();
        } else {
            return false;
        }
    }

    /**
     * Save data from array
     *
     * @param array|Form $files
     * @param array      $keywords
     */
    public function saveData($files, array $keywords = array())
    {
        if ($files instanceof Form) {
            $files = $files->getData();
        }

        foreach ($files as $file) {
            $sourceFilePath = null;
            $name           = null;

            if (isset($file['name'])) {
                $sourceFilePath = $file['name'];
                $name           = $file['name'];
            }
            if (isset($file['tmp_name'])) {
                $sourceFilePath = $file['tmp_name'];
                if (null === $name) {
                    $name = basename($file['tmp_name']);
                }
            }

            $this->getManager()->save($sourceFilePath, $keywords, $name);
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
