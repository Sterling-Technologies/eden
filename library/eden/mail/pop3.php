<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * General available methods for common POP3 functionality
 *
 * @package    Eden
 * @category   mail
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Mail_Pop3 extends Eden_Class {
	/* Constants
	-------------------------------*/
	const TIMEOUT			= 30;
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_host		= NULL;
	protected $_port		= NULL;
	protected $_ssl		 	= false;
	protected $_tls		 	= false;
	
	protected $_username	= NULL;
	protected $_password	= NULL;
	protected $_timestamp	= NULL;
	
	protected $_socket 		= NULL;
	
	/* Private Properties
	-------------------------------*/
	private $_debugging		= false;
	
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($host, $user, $pass, $port = NULL, $ssl = false, $tls = false) {
		Eden_Mail_Error::i()
			->argument(1, 'string')
			->argument(2, 'string')
			->argument(3, 'string')
			->argument(4, 'int', 'null')
			->argument(5, 'bool')
			->argument(6, 'bool');
			
		if (is_null($port)) {
            $port = $ssl ? 995 : 110;
        }

		$this->_host 		= $host;
		$this->_username 	= $user;
		$this->_password 	= $pass;
		$this->_port 		= $port;
		$this->_ssl 		= $ssl;
		$this->_tls 		= $tls;
		
		$this->_connect();
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Connects to the server
	 *
	 * @return this
	 */
	public function connect($test = false) {
		Eden_Mail_Error::i()->argument(1, 'bool');
		
		if($this->_loggedin) {
			return $this;
		}
		
		$host = $this->_host;
		
		if ($this->_ssl) {
            $host = 'ssl://' . $host;
        }
		
		$errno  =  0;
        $errstr = '';
        
		$this->_socket = fsockopen($host, $this->_port, $errno, $errstr, self::TIMEOUT);
        
		if (!$this->_socket) {
			//throw exception
			Eden_Mail_Error::i()->setMessage(Eden_Mail_Error::SERVER_ERROR)
				->addVariable($host.':'.$this->_port)
				->trigger();
        }
		
		$welcome = $this->_receive();

        strtok($welcome, '<');
        $this->_timestamp = strtok('>');
        if (!strpos($this->_timestamp, '@')) {
            $this->_timestamp = null;
        } else {
            $this->_timestamp = '<' . $this->_timestamp . '>';
        }

        if ($this->_tls) {
            $this->_call('STLS');
            if (!stream_socket_enable_crypto($this->_socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
				$this->disconnect();
            	//throw exception
				Eden_Mail_Error::i()->setMessage(Eden_Mail_Exception::TLS_ERROR)
					->addVariable($host.':'.$this->_port)
					->trigger();
            }
        }
		
		//login
		if ($this->_timestamp) {
            try {
                $this->_call('APOP '.$this->_username .' ' . md5($this->_timestamp . $this->_password));
                return;
            } catch (Exception $e) {
                // ignore
            }
        }

        $this->_call('USER '.$this->_username);
        $this->_call('PASS '.$this->_password);
		
		return $this;
	}
	
	/**
	 * Disconnects from the server
	 *
	 * @return this
	 */
	public function disconnect() {
		if (!$this->_socket) {
            return;
        }

        try {
            $this->request('QUIT');
        } catch (Exception $e) {
            // ignore error - we're closing the socket anyway
        }

        fclose($this->_socket);
        $this->_socket = NULL;
	}
	
	/**
	 * Returns a list of emails given the range
	 *
	 * @param number start
	 * @param number range
	 * @return array
	 */
	public function getEmails($start = 0, $range = 10) {
		Eden_Mail_Error::i()
			->argument(1, 'int')
			->argument(2, 'int');
		
		$total = $this->getEmailTotal();
		$total = $total['messages'];
		
		if($total == 0) {
			return array();
		}
		
        if (!is_array($start)) {
			$range = $range > 0 ? $range : 1;
			$start = $start >= 0 ? $start : 0;
			$max = $total - $start;

			if($max < 1) {
				$max = $total;
			}
			
			$min = $max - $range + 1;
			
			if($min < 1) {
				$min = 1;
			}
			
			$set = $min . ':' . $max; 
			
			if($min == $max) {
				$set = $min; 
			}
        }
		
		
		$emails = array();
		for($i = $min; $i <= $max; $i++) {
			$emails[] = $this->_call('RETR '.$i, true);
		}
		
		return $emails;
    }
	
	/**
	 * Returns the total number of emails in a mailbox
	 *
	 * @return number
	 */
	public function getEmailTotal() {
		list($messages, $octets) = explode(' ', $this->_call('STAT'));

		return array('messages' => $messages, 'octets' => $octets);	
	}
	
	/**
	 * Remove an email from a mailbox
	 *
	 * @param number uid
	 * @param string mailbox
	 * @return this
	 */
	public function remove($msgno) {
		Eden_Mail_Error::i()->argument(1, 'int', 'string');
		
		$this->_call("DELE $msgno");
		
		if(!$this->_loggedin || !$this->_socket) {
			return false;
		}
		
		if(!is_array($msgno)) {
			$msgno = array($msgno);
		}
		
		foreach($msgno as $number) {
			$this->_call('DELE '.$number);
		
		}
		
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	protected function _call($command, $multiline = false) {
		if(!$this->_send($command)) {
			return false;
		}
		
		return $this->_receive($multiline);
	}
	
	protected function _receive($multiline = false) {
		$result = @fgets($this->_socket);
        $status = $result = trim($result);
        $message = '';
		
		if (strpos($result, ' ')) {
            list($status, $message) = explode(' ', $result, 2);
        }

        if ($status != '+OK') {
            return false;
        }

        if ($multiline) {
            $message = '';
            $line = fgets($this->_socket);
            while ($line && rtrim($line, "\r\n") != '.') {
                if ($line[0] == '.') {
                    $line = substr($line, 1);
                }
				$this->_debug('Receiving: '.$line);
                $message .= $line;
                $line = fgets($this->_socket);
            };
        }

        return $message;
    }

	protected function _send($command) {
		
		$this->_debug('Sending: '.$command);
		
        return fputs($this->_socket, $command . "\r\n");
   }
	/* Private Methods
	-------------------------------*/
	private function _debug($string) {
		if($this->_debugging) {
			$string = htmlspecialchars($string);
			
			
			echo '<pre>'.$string.'</pre>'."\n";
		}
		return $this;
	}
}