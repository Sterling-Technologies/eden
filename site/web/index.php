<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
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
->addRoot(dirname(__FILE__).'/..')
->addRoot(dirname(__FILE__).'/../model')

/* Set Class Routing
-------------------------------*/
->setClasses('../front/config/classes.php')

/* Set Method Routing
-------------------------------*/
->setMethods('../front/config/methods.php')

/* Set Paths
-------------------------------*/
->setPaths()

/* Start Filters
-------------------------------*/
->startFilters(array('Front_Handler'))

/* Trigger Init Event
-------------------------------*/
->trigger('init')

/* Set Timezone
-------------------------------*/
->setTimezone('America/Los_Angeles')

/* Set Database
-------------------------------*/
//->addDatabase(include('front/config/database.php'))

/* Set Cache
-------------------------------*/
//->setCache('front/cache')

/* Set Page Routes
-------------------------------*/
->setPages('pages.php')

/* Trigger Init Event
-------------------------------*/
->trigger('config')

/* Start Session
-------------------------------*/
->startSession()

/* Trigger Session Event
-------------------------------*/
->trigger('session')

/* Set Request
-------------------------------*/
->setRequest()

/* Trigger Request Event
-------------------------------*/
->trigger('request')

/* Set Response
-------------------------------*/
->setResponse('Front_Page_Index')

/* Trigger Response Event
-------------------------------*/
->trigger('response')

/* Get the Response
-------------------------------*/
->getResponse();
 echo eden()
	->Eden_Getsatisfaction_Oauth("vbk4bs1klldy", "snw77ih836aoqoiylu2jgc286zy586as")
	->getLoginUrl('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);