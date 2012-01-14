<?php //-->
/*
 * This file is part a custom application package.
 * (c) 2011-2012 Openovate Labs
 */
require dirname(__FILE__).'/../front.php';

/* Get Application
-------------------------------*/
print front()

/* Set Debug
-------------------------------*/
->setDebug(E_ALL, true)

/* Set Autoload
-------------------------------*/
->setLoader(NULL)

/* Route Classes
-------------------------------*/
->routeClasses(true)

/* Route Methods
-------------------------------*/
->routeMethods(true)

/* Set Paths
-------------------------------*/
->setPaths()


/* Set Timezone
-------------------------------*/
->setTimezone('America/Los_Angeles')

/* Set Database
-------------------------------*/
->addDatabase(array(
  'key' 	=> 'test',
  'type' 	=> 'mysql',
  'default' => true,
  'host' 	=> '127.0.0.1',
  'name' 	=> 'expresso_prod',
  'user' 	=> 'root',
  'pass' 	=> ''))

/* Set Request
-------------------------------*/
->setRequest()

/* Set Response
-------------------------------*/
->setResponse('Front_Page_Index')

/* Get the Response
-------------------------------*/
->getResponse();