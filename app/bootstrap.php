<?php

/**
 * TabellaExample bootstrap file.
 *
 * @copyright  Copyright (c) 2011 Vojtěch Knyttl
 * @package    Tabella
 * @source	   http://knyt.tl
 */
 
require LIBS_DIR . '/Nette/nette.min.php';

use Nette\Diagnostics\Debugger,
	Nette\Environment,
	Nette\Application\Routers\Route,
	Nette\Application\Routers\SimpleRouter;

Debugger::enable( Debugger::DEVELOPMENT );

Environment::loadConfig();

$application = Environment::getApplication();

$router = $application->getRouter();

$router[] = new Route('', array(
        'presenter' => 'Base',
        'action' => 'default',
        'id' => "basic",
), Route::ONE_WAY);

$router[] = new Route('<id>', array(
        'presenter' => 'Base',
        'action' => 'default',
        'id' => null,
));

dibi::connect( Environment::getConfig( 'database' ) );

$application->run();