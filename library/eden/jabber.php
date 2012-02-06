<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */
 
require_once dirname(__FILE__).'/class.php';

/**
 * XMPP/Jabber abstract for IM clients. 
 *
 * @package    Eden
 * @category   jabber
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Jabber extends Eden_Event {
	/* Constants
	--------------------------------*/
	//connection types
	const AOL_HOST = 'xmpp.oscar.aol.com';
	const AOL_PORT = 5222;
	
	const GOOGLE_HOST = 'gmail.com';
	const GOOGLE_PORT = 5222;
	
	const JABBER_HOST = 'jabber.org';
	const JABBER_PORT = 5222;
	
	const MSN_HOST = 'messenger.live.com';
	const MSN_PORT = 5222;
	
	const YAHOO_HOST = 'chat.live.yahoo.com';
	const YAHOO_PORT = 5222;
	
	//presence types
	const PRESENCE_ONLINE		= 'online';
	const PRESENCE_OFFLINE		= 'offline';
    const PRESENCE_AWAY 		= 'away';
    const PRESENCE_CHAT 		= 'chat';
    const PRESENCE_DND 			= 'dnd';
    const PRESENCE_XA 			= 'xa';
	
	const TYPE_CHAT 	= 'chat';
	const TYPE_NORMAL 	= 'normal';
	const TYPE_ERROR 	= 'error';
	const TYPE_GROUP 	= 'groupchat';
	const TYPE_HEADLINE = 'headline';
	
	const AUTH_NOOP			= 0;
	const AUTH_STARTED		= 1;
	const AUTH_CHALLENGE	= 2;
	const AUTH_FAILIURE		= 3;
	const AUTH_PROCEED		= 4;
	const AUTH_SUCCESS		= 5;
	
	const ONLINE = 'Online';
	
	/* Public Properties
	--------------------------------*/
	/* Protected Properties
	--------------------------------*/
	protected $_host = NULL;
	protected $_port = NULL;
	protected $_user = NULL;
	protected $_pass = NULL;
	
	protected $_ssl = false;
	protected $_tls = false;
	
	protected $_negotiation = self::AUTH_NOOP;
	
	protected $_connection 	= NULL;
	protected $_jabberId 	= NULL;
	protected $_streamId 	= NULL;
	protected $_presence	= NULL;
	protected $_session		= false;
	
	protected $_resource = NULL;
	
	protected static $_presences = array(
		self::PRESENCE_DND, 
		self::PRESENCE_AWAY, 
		self::PRESENCE_CHAT, 
		self::PRESENCE_XA);
	
	protected static $_types = array(
		self::TYPE_CHAT,
		self::TYPE_NORMAL,
		self::TYPE_ERROR,
		self::TYPE_GROUP,
		self::TYPE_HEADLINE);
		
	protected static $_authentications = array(
		'stream:stream',
		'stream:features',
		'challenge',
		'failiure',
		'proceed',
		'success');
		
	protected static $_queries = array(
		'bind_1',	'sess_1',
		'reg_1',	'reg_2',
		'unreg_1',	'roster_1',
		'push');
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	/* Magic
	--------------------------------*/
	public function __construct($host, $port, $user, $pass, $ssl = false, $tls = true) {
		Eden_Jabber_Error::i()
			->argument(1, 'string')
			->argument(2, 'int')
			->argument(3, 'string')
			->argument(4, 'string')
			->argument(5, 'bool')
			->argument(6, 'bool');
		
		$this->_host = $host;
		$this->_port = $port;
		$this->_user = $user;
		$this->_pass = $pass;
		
		$this->_ssl = $ssl && $this->_canUseSSL();
		$this->_tls = $tls && $this->_canUseTLS();
		
		// Change port if we use SSL
		if ($this->_port == 5222 && $this->_ssl) {
			$this->_port = 5223;
		}
	}
	
	/* Public Methods
	--------------------------------*/
	/**
	 * Defines a resource name.
	 * This is usuall your app name.
	 *
	 * @param string
	 * @return this
	 */
	public function setResource($name) {
		Eden_Jabber_Error::i()->argument(1, 'string');
		$this->_resource = $name;
		return $this;
	}
	
	/**
	 * Returns Meta Data
	 *
	 * @return array
	 */
	public function getMeta() {
		return array(
			'host' 			=> $this->_host,
			'port' 			=> $this->_port,
			'user' 			=> $this->_user,
			'ssl' 			=> $this->_ssl,
			'tls' 			=> $this->_tls,
			'negotiation' 	=> $this->_negotiation,
			'connection' 	=> $this->_connection,
			'jabberId' 		=> $this->_jabberId,
			'streamId' 		=> $this->_streamId,
			'presence' 		=> $this->_presence,
			'session' 		=> $this->_session);
	}
	
	/**
	 * Generic start up
	 *
	 * @return this
	 */
	public function start() {
		$this->connect();
		while($this->_connection) {
			set_time_limit(60);
			$response = $this->_response($this->listen());
			if($response === false) {
				break;
			}
		}		
		return $this->disconnect();
	}
	
	/**
	 * Connects to the remote server
	 *
	 * @param number timeout
	 * @return this
	 */
	public function connect($timeout = 10) {
		Eden_Jabber_Error::i()->argument(1, 'int');
		
		//if already connected
		if($this->_connection) {
			//do nothing more
			return $this;
		}
		
		$host = $this->_host;
		
		//if dns_get_record function exists
		if (function_exists('dns_get_record')) {
			//get the dns record
			$record = @dns_get_record("_xmpp-client._tcp.$host", DNS_SRV);
			
			//if the record is not empty
			if(!empty($record) && !empty($record[0]['target'])) {
				//set the target to be the host
				$host = $record[0]['target'];
			}
		}
		
		//fix for ssl
		if($this->_ssl) {
			$host = 'ssl://' . $host;
		}
		
		//try to open a connection
		try {
			$this->_connection = fsockopen($host, $port, $errorno, $errorstr, $timeout);
		} catch(_Exception $e) {
			//throw an exception
			Eden_Jabber_Error::i()->setMessage(Eden_Jabber_Error::CONNECTION_FAILED)
				->addVariable($host)
				->addVariable($port)
				->trigger();
		}
		
		socket_set_blocking($this->_connection, 0);
		socket_set_timeout($this->_connection, 60);
		
		//send off what a typical jabber server opens with
		$this->send("<?xml version='1.0' encoding='UTF-8' ?>\n");
		$this->send("<stream:stream to='".$this->_host."' xmlns='jabber:client'".
			"xmlns:stream='http://etherx.jabber.org/streams' version='1.0'>\n");
		
		$this->trigger('connected', $this);
		
		//start listening
		$this->_response($this->listen());
		
		return $this;
	}

	/**
	 * Disconnects from the server
	 *
	 * @return this
	 */
	public function disconnect() {
		//if its connected
		if ($this->_connection) {
			// disconnect gracefully
			if (isset($this->_presence)) {
				$this->setPresence(self::PRESENCE_OFFLINE, self::PRESENCE_OFFLINE, NULL, 'unavailable');
			}
			
			//close the stream
			$this->send('</stream:stream>');
			
			//close the connection
			return fclose($this->_connection);
			
			$this->_connection = NULL;
			
			$this->trigger('disconnected', $this);
		}
		
		return $this;
	}
	
	/**
	 * Listens for imcoming data
	 *
	 * @return string XML
	 */
	public function listen($timeout = 10) {
		//if not connected
		if (!$this->_connection) {
			//throw exception
			Eden_Jabber_Error::i(Eden_Jabber_Error::NOT_CONNECTED)->trigger();
		}
		
		$start = time();
		$data = '';
		
		do {
			//get the incoming data
			$read = trim(fread($this->_connection, 4096));
			//append it to the buffer
			$data .= $read;
		//keep going till timeout or connection was terminated or data is complete (denoted by > )
		} while (time() <= $start + $timeout 
		&& !feof($this->_connection) 
		&& ($data == '' 
		|| $read != '' 
		|| (substr(rtrim($data), -1) != '>')));
		
		//if there is data
		if ($data != '') {
			//parse the xml and return
			return $this->_parseXml($data);
		} else {
			//return nothing
			return NULL;
		}
	}
	
	/**
	 * Sends xml data to host 
	 *
	 * @param string xml
	 * @return this
	 */
	public function send($xml) {
		//if not connected
		if (!$this->_connection) {
			//throw exception
			Eden_Jabber_Error::i(Eden_Jabber_Error::NOT_CONNECTED)->trigger();
		}
		
		//clean the XML
		$xml = trim($xml);
		
		//send the XML off
		fwrite($this->connection, $xml);
		
		return $this;
	}
	
	/**
	 * Set the presence of a user
	 * 
	 * @param string presence title
	 * @param string message
	 * @param string|array to
	 * @param bool type
	 * @return this
	 */
	public function setPresence($show = NULL, $message = NULL, $to = NULL, $type = NULL) {
		Eden_Jabber_Error::i()
			->argument(1, 'string', 'null')
			->argument(2, 'string', 'null')
			->argument(3, 'array', 'string', 'null')
			->argument(4, 'string', 'null');
		
		//if to is a string
		if (is_string($to)) {
			//make it into an array
        	$to = array($to);
		}
		
		//if no JID
		if (!isset($this->_jabberId)) {
			//throw exception
			Eden_Jabber_Error::i(Eden_Jabber_Error::NO_JID)->trigger();
		}
		
		//fix show
		$show = strtolower($show);
		$show = in_array($show, self::$_presences) ? '<show>'. $show .'</show>' : '';
		
		//fix type
		$type = $type ? ' type="'.$type.'"' : '';
		
		//fix from
		$from = 'from="'.$this->_jabberId.'"';
		
		//fix message
		$message = $message ? '<status>' . htmlspecialchars($message) .'</status>' : '';
		
		//walk to
		foreach ($to as $user) {
			//fix to
			$to = $user ? 'to="'.$user.'"' : '';
			//send prensense to user
			$this->send('<presence '.$from.' '.$to.$type.'>' . $show . $message . '</presence>');
		}
		
		return $this;
	}
	
	/**
	 * Sends a message to a user
	 * 
	 * @param string to whom to send to
	 * @param string text
	 * @param string subject
	 * @param string message type
	 * @return this
	 */
	public function to($to, $text, $subject = '', $type = 'chat') {
		Eden_Jabber_Error::i()
			->argument(1, 'string')
			->argument(2, 'string')
			->argument(3, 'string', 'null')
			->argument(4, 'string');
			
		//if no JID
		if (!isset($this->_jabberId)) {
			//throw exception
			Eden_Jabber_Error::i(Eden_Jabber_Error::NO_JID)->trigger();
		}
		
		//if type is not one of the valid types
		if (!in_array($type, self::$_types)) {
			//set it to chat
			$type = self::TYPE_CHAT;
		}
		
		//send the message
		return $this->send("<message from='" . htmlspecialchars($this->_jabberId) . 
			"' to='" . htmlspecialchars($to) . "' type='".$type."' id='" . uniqid('msg') . "'>
			<subject>" . htmlspecialchars($subject) . "</subject>
			<body>" . htmlspecialchars($text) . "</body>
			</message>");
	}
	
	/**
	 * Requests for roster
	 * 
	 * @param string message
	 * @return this
	 */
	public function getRoster() {
		$this->send('<iq from="'.$this->_jabberId.'" type="get" id="roster_1"><query xmlns="jabber:iq:roster"/></iq> ');
		return $this;
	}
	
	/* Protected Methods
	--------------------------------*/
	protected function _canUseSSL() {
		return @extension_loaded('openssl');
	}
	
	protected function _canUseTLS() {
		return @extension_loaded('openssl') 
		&& function_exists('stream_socket_enable_crypto') 
		&& function_exists('stream_get_meta_data') 
		&& function_exists('socket_set_blocking') 
		&& function_exists('stream_get_wrappers');
	}
	
	protected function _parseXml($data, $skip_white = 1, $encoding = 'UTF-8') {
		$data = trim($data);
		
		//if the data does not start with an XML header
		if (substr($data, 0, 5) != '<?xml') {
			// modify the data
			$data = '<root>'. $data . '</root>';
		}
 		
		$vals = $index = $array = array();
		
		//parse xml to an array
		$parser = xml_parser_create($encoding);
		xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
		xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, $skip_white);
		xml_parse_into_struct($parser, $data, $vals, $index);
		xml_parser_free($parser);

		$i = 0;
		//get the tag name
		$tagname = $vals[$i]['tag'];
		
		$array[$tagname][0]['@'] = (isset($vals[$i]['attributes'])) ? $vals[$i]['attributes'] : array();
		$array[$tagname][0]['#'] = $this->_getDepth($vals, $i);
		
		//if the data does not start with an XML header
		if (substr($data, 0, 5) != '<?xml') {
			//get the root
			$array = $array['root'][0]['#'];
		}
		
		return $array;
	}
	
	protected function _response($xml) {
		//if the xml is not an array
		//or if it is empty
		if (!is_array($xml) || !sizeof($xml)) {
			//do nothing
			return $this;
		}

		// did we get multiple elements? do one after another
		// array('message' => ..., 'presence' => ...)
		if (sizeof($xml) > 1) {
			foreach ($xml as $key => $value) {
				$this->_response(array($key => $value));
			}
			
			return $this;
		// or even multiple elements of the same type?
		// array('message' => array(0 => ..., 1 => ...))
		} else if (sizeof(reset($xml)) > 1) {
			foreach (reset($xml) as $value) {
				$this->_response(array(key($xml) => array(0 => $value)));
			}
			return $this;
		}
		
		$command = key($xml);
		
		if(in_array($command, self::$_authentications)) {
			return $this->_authenticate($command, $xml);
		}
		
		if($command == 'iq') {
			// we are not interested in IQs we did not expect
			if (!isset($xml['iq'][0]['@']['id'])) {
				return $this;
			}
			
			$command = $xml['iq'][0]['@']['id'];
			
			return $this->_query($command, $xml);
		}
		
		if($command == 'message') {
			// we are only interested in content...
			if (!isset($xml['message'][0]['#']['body'])) {
				return $this;
			}
			
			$body = $xml['message'][0]['#']['body'][0]['#'];
			$from = $xml['message'][0]['@']['from'];
			
			$subject = NULL;
			if (isset($xml['message'][0]['#']['subject'])) {
				$subject = $xml['message'][0]['#']['subject'][0]['#'];
			}
			
			$this->trigger('message', $this, $from, $body, $subject);
			
			return $this;
		}
	}
	
	protected function _authenticate($command, $xml) {
		//response switch
		switch ($command) {
			case 'stream:stream':
				// Connection initialized (or after authentication). Not much to do here...
				if (isset($xml['stream:stream'][0]['#']['stream:features'])) {
					// we already got all info we need
					$features = $xml['stream:stream'][0]['#'];
				} else {
					$features = $this->listen();
				}

				$second_time = isset($this->_streamId);
				$this->_streamId = $xml['stream:stream'][0]['@']['id'];

				if ($second_time) {
					// If we are here for the second time after TLS, we need to continue logging in
					//if there are no features
					if (!sizeof($features)) {
						//throw exception
						Eden_Jabber_Error::i(Eden_Jabber_Error::NO_FEATURES)->trigger();
					}
			
					return $this->_response($features);
				}
				
				//we are on the first step
				$this->_negotiation = self::AUTH_STARTED;
				
				// go on with authentication?
				if (isset($features['stream:features'][0]['#']['bind']) || $this->_negotiation == self::AUTH_PROCEED) {
					return $this->_response($features);
				}
				
				break;

			case 'stream:features':
				// Resource binding after successful authentication
				if ($this->_negotiation == self::AUTH_SUCCESS) {
					// session required?
					$this->_session = isset($xml['stream:features'][0]['#']['session']);

					$this->send("<iq type='set' id='bind_1'><bind xmlns='urn:ietf:params:xml:ns:xmpp-bind'>".
						"<resource>" . htmlspecialchars($this->_resource) . '</resource></bind></iq>');
						
					return $this->_response($this->listen());
				}

				// Let's use TLS if SSL is not enabled and we can actually use it
				if (!$this->_ssl && $this->_tls && $this->_canSSL() && 
					isset($xml['stream:features'][0]['#']['starttls'])) {
					$this->send("<starttls xmlns='urn:ietf:params:xml:ns:xmpp-tls'/>\n");
					return $this->_response($this->listen());
				}

				// Does the server support SASL authentication?

				// I hope so, because we do (and no other method).
				if (isset($xml['stream:features'][0]['#']['mechanisms'][0]['@']['xmlns']) && 
					$xml['stream:features'][0]['#']['mechanisms'][0]['@']['xmlns'] == 'urn:ietf:params:xml:ns:xmpp-sasl') {
					// Now decide on method
					$methods = array();

					foreach ($xml['stream:features'][0]['#']['mechanisms'][0]['#']['mechanism'] as $value) {
						$methods[] = $value['#'];
					}

					// we prefer DIGEST-MD5
					// we don't want to use plain authentication (neither does the server usually) if no encryption is in place

					// http://www.xmpp.org/extensions/attic/jep-0078-1.7.html
					// The plaintext mechanism SHOULD NOT be used unless the underlying stream is encrypted (using SSL or TLS)
					// and the client has verified that the server certificate is signed by a trusted certificate authority.

					if (in_array('DIGEST-MD5', $methods)) {
						$this->send("<auth xmlns='urn:ietf:params:xml:ns:xmpp-sasl' mechanism='DIGEST-MD5'/>");
					} else if (in_array('PLAIN', $methods) && ($this->_ssl || $this->_negotiation == self::AUTH_PROCEED)) {
						$this->send("<auth xmlns='urn:ietf:params:xml:ns:xmpp-sasl' mechanism='PLAIN'>"
							. base64_encode(chr(0) . $this->_user . '@' . $this->_host . chr(0) . $this->_pass) .
							'</auth>');
					} else if (in_array('ANONYMOUS', $methods)) {
						$this->send("<auth xmlns='urn:ietf:params:xml:ns:xmpp-sasl' mechanism='ANONYMOUS'/>");
					} else {
						// not good...
						//disconnect
						$this->disconnect();
						//throw an exception
						Eden_Jabber_Error::i(Eden_Jabber_Error::NO_AUTH_METHOD)->trigger();
					}

					return $this->_response($this->listen());
				} 
				
				// ok, this is it. bye.
				//disconnect
				$this->disconnect();
				//throw an exception
				Eden_Jabber_Error::i(Eden_Jabber_Error::NO_SASL)->trigger();
				break;

			case 'challenge':
				// continue with authentication...a challenge literally -_-
				$this->_negotiation = self::AUTH_CHALLENGE;
				$decoded = base64_decode($xml['challenge'][0]['#']);
				$decoded = $this->_parseData($decoded);
				
				if (!isset($decoded['digest-uri'])) {
					$decoded['digest-uri'] = 'xmpp/'. $this->_host;
				}

				// better generate a cnonce, maybe it's needed
				$decoded['cnonce'] = base64_encode(md5(uniqid(mt_rand(), true)));

				// second challenge?
				if (isset($decoded['rspauth'])) {
					$this->send("<response xmlns='urn:ietf:params:xml:ns:xmpp-sasl'/>");
				} else {
					// Make sure we only use 'auth' for qop (relevant for $this->_encryptPass())
					// If the <response> is choking up on the changed parameter we may need to adjust _encryptPass() directly
					if (isset($decoded['qop']) && $decoded['qop'] != 'auth' && strpos($decoded['qop'], 'auth') !== false) {
						$decoded['qop'] = 'auth';
					}

					$response = array(
						'username'	=> $this->_user,
						'response'	=> $this->_encryptPass(array_merge($decoded, array('nc' => '00000001'))),
						'charset'	=> 'utf-8',
						'nc'		=> '00000001',
						'qop'		=> 'auth');			// only auth being supported
					
					foreach (array('nonce', 'digest-uri', 'realm', 'cnonce') as $key) {
						if (isset($decoded[$key])) {
							$response[$key] = $decoded[$key];
						}
					}
					
					$this->send("<response xmlns='urn:ietf:params:xml:ns:xmpp-sasl'>" . 
					base64_encode($this->_implodeData($response)) . '</response>');
				}

				return $this->_response($this->listen());

			case 'failure':
				$this->_negotiation = self::AUTH_FAILIURE;
				$this->trigger('failiure', $this);
				//disconnect
				$this->disconnect();
				//throw an exception
				Eden_Jabber_Error::i(Eden_Jabber_Error::SERVER_FAILED)->trigger();

			case 'proceed':
				// continue switching to TLS
				$meta = stream_get_meta_data($this->_connection);
				socket_set_blocking($this->_connection, 1);

				if (!stream_socket_enable_crypto($this->_connection, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
					//'Error: TLS mode change failed.'
					Eden_Jabber_Error::i(Eden_Jabber_Error::SERVER_FAILED)->trigger();
				}

				socket_set_blocking($this->_connection, $meta['blocked']);
				$this->_negotiation = self::AUTH_PROCEED;

				// new stream
				$this->send("<?xml version='1.0' encoding='UTF-8' ?" . ">\n");
				$this->send("<stream:stream to='".$this->_host."' xmlns='jabber:client' ".
				"xmlns:stream='http://etherx.jabber.org/streams' version='1.0'>\n");

				return $this->_response($this->listen());

			case 'success':
				// Yay, authentication successful.
				$this->send("<stream:stream to='".$this->_host."' xmlns='jabber:client' ".
				"xmlns:stream='http://etherx.jabber.org/streams' version='1.0'>\n");
				
				$this->_negotiation = self::AUTH_SUCCESS;
				
				// we have to wait for another response
				return $this->_response($this->listen());
		}
		
		return $this;
	}
	
	protected function _query($command, $xml) {
		// multiple possibilities here
		switch ($command) {
			case 'bind_1':
				$this->_jabberId = $xml['iq'][0]['#']['bind'][0]['#']['jid'][0]['#'];
				$this->trigger('loggedin', $this);
				// and (maybe) yet another request to be able to send messages *finally*
				if ($this->_session) {
					$this->send("<iq to='".$this->_host."' type='set' id='sess_1'>
						<session xmlns='urn:ietf:params:xml:ns:xmpp-session'/></iq>");
						
					return $this->_response($this->listen());
				}

				return $this;

			case 'sess_1':
				return $this;

			case 'reg_1':
				$this->send("<iq type='set' id='reg_2'><query xmlns='jabber:iq:register'><username>" . 
				htmlspecialchars($this->_user)."</username><password>".htmlspecialchars($this->_pass) . 
				"</password></query></iq>");
				
				return $this->_response($this->listen());

			case 'reg_2':
				// registration end
				if (isset($xml['iq'][0]['#']['error'])) {
					//'Warning: Registration failed.'
					return $this;
				}
				
				$this->trigger('registered', $this);
				
				return $this;

			case 'unreg_1':
				$this->trigger('unregistered', $this);
				return $this;
			
			case 'roster_1':
				if (!isset($xml['iq'][0]['#']['query'][0]['#']['item'])) {
					//'Warning: No Roster Returned.'
					return $this;
				} 
				
				$roster = array();
				foreach($xml['iq'][0]['#']['query'][0]['#']['item'] as $item) {
					$jid = $item['@']['jid'];
					$subscription = $item['@']['subscription'];
					$roster[$jid] = $subscription;
				}
				
				$this->trigger('roster', $this, $roster);
				break;
			
			case 'push':
				if (!isset($xml['iq'][0]['#']['query'][0]['#']['item'][0]['@']['ask'])) {
					//'Request for push denied.'
					return $this;
				} 
				
				$attributes = $xml['iq'][0]['#']['query'][0]['#']['item'][0]['@'];
				
				if($attributes['ask'] == 'subscribe'
				 && strpos($this->_user.'@'.$this->_host, $attributes['jid']) === false) {
					$this->setPresence(
						self::PRESENCE_CHAT, 
						self::ONLINE, 
						$attributes['jid'], 
						'subscribed');
						
					$this->setPresence(
						self::PRESENCE_CHAT, 
						self::ONLINE, 
						$attributes['jid']);
				}
				
				$this->trigger('subscribe', $this, $attributes['ask'], $attributes['jid']);
				break;
			//'Notice: Received unexpected IQ.'
			default: break;
		}
		
		return $this;
	}
	
	protected function _getDepth($vals, &$i) {
		$children = array();

		if (isset($vals[$i]['value'])) {
			array_push($children, $vals[$i]['value']);
		}

		while (++$i < sizeof($vals)) {
			switch ($vals[$i]['type']) {
				case 'open':
					$tagname = (isset($vals[$i]['tag'])) ? $vals[$i]['tag'] : '';
					$size = (isset($children[$tagname])) ? sizeof($children[$tagname]) : 0;

					if (isset($vals[$i]['attributes'])) {
						$children[$tagname][$size]['@'] = $vals[$i]['attributes'];
					}

					$children[$tagname][$size]['#'] = $this->_getDepth($vals, $i);

					break;

				case 'cdata':
					array_push($children, $vals[$i]['value']);
					break;

				case 'complete':
					$tagname = $vals[$i]['tag'];
					$size = (isset($children[$tagname])) ? sizeof($children[$tagname]) : 0;
					$children[$tagname][$size]['#'] = (isset($vals[$i]['value'])) ? $vals[$i]['value'] : array();

					if (isset($vals[$i]['attributes'])) {
						$children[$tagname][$size]['@'] = $vals[$i]['attributes'];
					}

					break;

				case 'close':
					return $children;
					break;
			}
		}

		return $children;
	}
	
	protected function _encryptPass($data) {
		// let's me think about <challenge> again...
		foreach (array('realm', 'cnonce', 'digest-uri') as $key) {
			if (!isset($data[$key])) {
				$data[$key] = '';
			}
		}

		$pack = md5($this->_user . ':' . $data['realm'] . ':' . $this->_pass);

		if (isset($data['authzid'])) {
			$a1 = pack('H32', $pack)  . sprintf(':%s:%s:%s', $data['nonce'], $data['cnonce'], $data['authzid']);
		} else {
			$a1 = pack('H32', $pack)  . sprintf(':%s:%s', $data['nonce'], $data['cnonce']);
		}

		// should be: qop = auth
		$a2 = 'AUTHENTICATE:'. $data['digest-uri'];

		return md5(sprintf('%s:%s:%s:%s:%s:%s', md5($a1), $data['nonce'], $data['nc'], $data['cnonce'], $data['qop'], md5($a2)));
	}
	
	protected function _parseData($data) {
		$data = explode(',', $data);
		$pairs = array();
		$key = false;

		foreach ($data as $pair) {
			$dd = strpos($pair, '=');

			if ($dd) {
				$key = trim(substr($pair, 0, $dd));
				$pairs[$key] = trim(trim(substr($pair, $dd + 1)), '"');
			} else if (strpos(strrev(trim($pair)), '"') === 0 && $key) {
				// We are actually having something left from "a, b" values, add it to the last one we handled.
				$pairs[$key] .= ',' . trim(trim($pair), '"');
				continue;
			}
		}

		return $pairs;
	}
	
	protected function _implodeData($data) {
		$return = array();
		foreach ($data as $key => $value) {
			$return[] = $key . '="' . $value . '"';
		}
		return implode(',', $return);
	}
	
	/* Private Methods
	-------------------------------*/
}

/**
 * XMPP/Jabber exception
 */
class Eden_Jabber_Error extends Eden_Error {
	/* Constants
	-------------------------------*/
	const CONNECTION_FAILED 	= 'Connection to %s on port %s failed';
	const NO_FEATURES			= 'Error: No feature information from server available';
	const NOT_CONNECTED			= 'Not connected';
	const NO_JID				= 'No jid given.';
	const NO_AUTH_METHOD		= 'No authentication method supported';
	const NO_SASL				= 'Server does not offer SASL authentication';
	const SERVER_FAILED			= 'Server sent a failiure message';
	const TLS_CHANGE_FAILED		= 'TLS mode change failed';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i($message = NULL, $code = 0) {
		$class = __CLASS__;
		return new $class($message, $code);
	}
	
	/* Public Methods
	-------------------------------*/
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}