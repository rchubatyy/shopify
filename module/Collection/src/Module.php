<?php

namespace Collection;

use Laminas\ModuleManager\Feature\ConfigProviderInterface;

use Laminas\ServiceManager\Factory\InvokableFactory;

class Module implements ConfigProviderInterface
{
    public function getConfig() : array
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getControllerConfig(){
      return[
        'factories' => [
          Controller\CollectionController::class => InvokableFactory::class
        ]
      ];
    }

    public function getServiceConfig(){
      return [
        'factories' => [
                Model\CollectionTable::class => function($container) {
                    $tableGateway = $container->get(Model\CollectionTableGateway::class);
                    return new Model\CollectionTable($tableGateway);
                },
                Model\CollectionTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Collection());
                    return new TableGateway('collection', $dbAdapter, null, $resultSetPrototype);
                },
            ]
      ];
    }
}
