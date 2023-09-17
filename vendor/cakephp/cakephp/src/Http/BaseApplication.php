<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         3.3.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
namespace Cake\Http;

use Cake\Console\CommandCollection;
use Cake\Controller\ControllerFactory;
use Cake\Core\ConsoleApplicationInterface;
use Cake\Core\HttpApplicationInterface;
use Cake\Core\Plugin;
use Cake\Core\PluginApplicationInterface;
use Cake\Core\PluginCollection;
use Cake\Event\EventDispatcherTrait;
use Cake\Event\EventManager;
use Cake\Event\EventManagerInterface;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\RoutingApplicationInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Base class for full-stack applications
 *
 * This class serves as a base class for applications that are using
 * CakePHP as a full stack framework. If you are only using the Http or Console libraries
 * you should implement the relevant interfaces directly.
 *
 * The application class is responsible for bootstrapping the application,
 * and ensuring that middleware is attached. It is also invoked as the last piece
 * of middleware, and delegates request/response handling to the correct controller.
 */
abstract class BaseApplication implements
    ConsoleApplicationInterface,
    HttpApplicationInterface,
    PluginApplicationInterface,
    RoutingApplicationInterface
{
    use EventDispatcherTrait;

    /**
     * @var string Contains the path of the config directory
     */
    protected $configDir;

    /**
     * Plugin Collection
     *
     * @var \Cake\Core\PluginCollection
     */
    protected $plugins;

    /**
     * Controller factory
     *
     * @var \Cake\Http\ControllerFactoryInterface|null
     */
    protected $controllerFactory;

    /**
     * Constructor
     *
     * @param string $configDir The directory the bootstrap configuration is held in.
     * @param \Cake\Event\EventManagerInterface $eventManager Application event manager instance.
     * @param \Cake\Http\ControllerFactoryInterface $controllerFactory Controller factory.
     */
    public function __construct(
        string $configDir,
        ?EventManagerInterface $eventManager = null,
        ?ControllerFactoryInterface $controllerFactory = null
    ) {
        $this->configDir = rtrim($configDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        $this->plugins = Plugin::getCollection();
        $this->_eventManager = $eventManager ?: EventManager::instance();
        $this->controllerFactory = $controllerFactory;
    }

    /**
     * @param \Cake\Http\MiddlewareQueue $middlewareQueue The middleware queue to set in your App Class
     * @return \Cake\Http\MiddlewareQueue
     */
    abstract public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue;

    /**
     * @inheritDoc
     */
    public function pluginMiddleware(MiddlewareQueue $middleware): MiddlewareQueue
    {
        foreach ($this->plugins->with('middleware') as $plugin) {
            $middleware = $plugin->middleware($middleware);
        }

        return $middleware;
    }

    /**
     * @inheritDoc
     */
    public function addPlugin($name, array $config = [])
    {
        if (is_string($name)) {
            $plugin = $this->plugins->create($name, $config);
        } else {
            $plugin = $name;
        }
        $this->plugins->add($plugin);

        return $this;
    }

    /**
     * Get the plugin collection in use.
     *
     * @return \Cake\Core\PluginCollection
     */
    public function getPlugins(): PluginCollection
    {
        return $this->plugins;
    }

    /**
     * @inheritDoc
     */
    public function bootstrap(): void
    {
        require_once $this->configDir . 'bootstrap.php';
    }

    /**
     * @inheritDoc
     */
    public function pluginBootstrap(): void
    {
        foreach ($this->plugins->with('bootstrap') as $plugin) {
            $plugin->bootstrap($this);
        }
    }

    /**
     * {@inheritDoc}
     *
     * By default this will load `config/routes.php` for ease of use and backwards compatibility.
     *
     * @param \Cake\Routing\RouteBuilder $routes A route builder to add routes into.
     * @return void
     */
    public function routes(RouteBuilder $routes): void
    {
        // Only load routes if the router is empty
        if (!Router::routes()) {
            require $this->configDir . 'routes.php';
        }
    }

    /**
     * @inheritDoc
     */
    public function pluginRoutes(RouteBuilder $routes): RouteBuilder
    {
        foreach ($this->plugins->with('routes') as $plugin) {
            $plugin->routes($routes);
        }

        return $routes;
    }

    /**
     * Define the console commands for an application.
     *
     * By default all commands in CakePHP, plugins and the application will be
     * loaded using conventions based names.
     *
     * @param \Cake\Console\CommandCollection $commands The CommandCollection to add commands into.
     * @return \Cake\Console\CommandCollection The updated collection.
     */
    public function console(CommandCollection $commands): CommandCollection
    {
        return $commands->addMany($commands->autoDiscover());
    }

    /**
     * @inheritDoc
     */
    public function pluginConsole(CommandCollection $commands): CommandCollection
    {
        foreach ($this->plugins->with('console') as $plugin) {
            $commands = $plugin->console($commands);
        }

        return $commands;
    }

    /**
     * Invoke the application.
     *
     * - Convert the PSR response into CakePHP equivalents.
     * - Create the controller that will handle this request.
     * - Invoke the controller.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request The request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function handle(
        ServerRequestInterface $request
    ): ResponseInterface {
        if ($this->controllerFactory === null) {
            $this->controllerFactory = new ControllerFactory();
        }

        if (Router::getRequest() !== $request) {
            Router::setRequest($request);
        }

        $controller = $this->controllerFactory->create($request);

        return $this->controllerFactory->invoke($controller);
    }
}