<?php

namespace FileBank;

use FileBank\Service\FileBank as FileBankService;
use FileBank\View\Helper\FileBank;
use Zend\ServiceManager\ServiceLocatorInterface;

class Module
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'FileBank'         => 'FileBank\Service\Factory',
                'FileBank\Service' => function (ServiceLocatorInterface $sm) {
                    $service = new FileBankService();
                    $service->setManager($sm->get('FileBank'));
                    $service->setUploadForm($sm->get('FormElementManager')->get('FileBank\Form\Upload'));
                    return $service;
                },
            )
        ); 
    }
    
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'getFileById' => function ($sm) {
                    $locator = $sm->getServiceLocator();
                    $config = $locator->get('Configuration');
                    $params = $config['FileBank']['params'];
                    
                    $viewHelper = new View\Helper\FileBank();
                    $viewHelper->setService($locator->get('FileBank'));
                    $viewHelper->setParams($params);
                    
                    return $viewHelper;
                },
            ),
        );

    }
}