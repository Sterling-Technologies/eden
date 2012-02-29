} namespace {
if(!function_exists('app')) {
	require_once('app.php');
}
} namespace __kroll__namespace__1 {

/* Get Application
-------------------------------*/
$output = \app()

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

/* Set Database
-------------------------------*/
//->addDatabase('default', 'sqlite', $database)

/* Get the Response
-------------------------------*/
->getResponse();
