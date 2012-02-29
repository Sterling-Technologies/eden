(function() {
	//If you are using a database use this...
	//it's set here, so PHP can use this file location as well
	database = Titanium.API.application.dataPath+'/app.db';
	Titanium.Database.openFile(database);
	
	//Loading Quirks
	platform = Titanium.getPlatform();
	//Windows loading quirks
	if(platform == 'win32') {
		var script = document.createElement('script');
		script.type = 'text/php';
		script.src = 'control.php';
		var parent = document.getElementsByTagName('script')[0];
		
		parent.parentNode.insertBefore(script, parent);
	//OSX loading quirks
	} else if(platform == 'osx') {
		Titanium.include('control.php');
	}
	
	//wait for onload to insert output
	window.onload = function() {	
		var div = document.getElementsByTagName('div')[0];
		div.innerHTML = output;
		for(var i = 0, scripts = div.getElementsByTagName('script'); i < scripts.length; i++) {
			eval(scripts[i].text);
		}
	};
	
	//Other Titanium Stuff
})();