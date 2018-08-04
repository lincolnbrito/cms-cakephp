<?php

namespace ContactManager;

use Cake\Core\BasePlugin;
use Cake\Core\PluginApplicationInterface;

/**
 * Plugin for ContactManager
 */
class Plugin extends BasePlugin
{
    public function middleware($middleware)
    {
        // add middleware here
        return $middleware;
    }

    public function console($commands)
    {
        // add console commands here
        return $commands;
    }

    public function bootstrap(PluginApplicationInterface $app)
    {
        // add constants, load configuration defaults
        // by default will load 'config/bootstrap.php' in the plugin
        parent::bootstrap($app);
    }

    public function routes($routes)
    {
        // add routes.
        // by default will load 'config/routes.php' in the plugin
        parent::routes($routes);
    }
}
