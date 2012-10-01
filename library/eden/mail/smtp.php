<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * General available methods for common SMTP functionality
 *
 * @package    Eden
 * @cateogry   mail
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Mail_Smtp extends Eden_Class {
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
	
	protected $_socket 		= NULL;
	protected $_boundary	= array();
	
	protected $_subject		= NULL;
	protected $_body		= array();
	
	protected $_to 			= array();
	protected $_cc 			= array();
	protected $_bcc 		= array();
	protected $_attachments = array();
	
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
            $port = $ssl ? 465 : 25;
        }

		$this->_host 		= $host;
		$this->_username 	= $user;
		$this->_password 	= $pass;
		$this->_port 		= $port;
		$this->_ssl 		= $ssl;
		$this->_tls 		= $tls;
		
		$this->_boundary[] = md5(time().'1');
		$this->_boundary[] = md5(time().'2');
	}
	
	/* Public Methods
	-------------------------------*/
	
	/**
	 * Adds an attachment to the email
	 *
	 * @param string filename
	 * @param string data
	 * @param string mime
	 * @return this
	 */
	public function addAttachment($filename, $data, $mime = NULL) {
		Eden_Mail_Error::i()
			->argument(1, 'string')
			->argument(2, 'string')
			->argument(3, 'string', 'null');
			
		$this->_attachments[] = array($filename, $data, $mime);
		return $this;
	}
	
	/**
	 * Adds an email to the bcc list
	 *
	 * @param string email
	 * @param string name
	 * @return this
	 */
	public function addBCC($email, $name = NULL) {
		Eden_Mail_Error::i()
			->argument(1, 'string')
			->argument(2, 'string', 'null');
			
		$this->_bcc[$email] = $name;
		return $this;
	}
	
	/**
	 * Adds an email to the cc list
	 *
	 * @param string email
	 * @param string name
	 * @return this
	 */
	public function addCC($email, $name = NULL) {
		Eden_Mail_Error::i()
			->argument(1, 'string')
			->argument(2, 'string', 'null');
			
		$this->_cc[$email] = $name;
		return $this;
	}
	
	/**
	 * Adds an email to the to list
	 *
	 * @param string email
	 * @param string name
	 * @return this
	 */
	public function addTo($email, $name = NULL) {
		Eden_Mail_Error::i()
			->argument(1, 'string')
			->argument(2, 'string', 'null');
			
		$this->_to[$email] = $name;
		return $this;
	}
	
	/**
	 * Connects to the server
	 * 
	 * @return this
	 */
	public function connect($timeout = self::TIMEOUT, $test = false) {
		Eden_Mail_Error::i()
			->argument(1, 'int')
			->argument(2, 'bool');
			
		$host = $this->_host;
		
		if ($this->_ssl) {
            $host = 'ssl://' . $host;
        } else {
			$host = 'tcp://' . $host;
		}
		
		$errno  =  0;
        $errstr = '';
		$this->_socket = @stream_socket_client($host.':'.$this->_port, $errno, $errstr, $timeout);
        
		if (!$this->_socket || strlen($errstr) > 0 || $errno > 0) {
			//throw exception
			Eden_Mail_Error::i()
				->setMessage(Eden_Mail_Error::SERVER_ERROR)
				->addVariable($host.':'.$this->_port)
				->trigger();
        }
		
		$this->_receive();
		
		if(!$this->_call('EHLO '.$_SERVER['HTTP_HOST'], 250) && !$this->_call('HELO '.$_SERVER['HTTP_HOST'], 250)) {
			$this->disconnect();
            //throw exception
			Eden_Mail_Error::i()
				->setMessage(Eden_Mail_Error::SERVER_ERROR)
				->addVariable($host.':'.$this->_port)
				->trigger();
		}
;
        if ($this->_tls && !$this->_call('STARTTLS', 220, 250)) {
			if(!stream_socket_enable_crypto($this->_socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
				$this->disconnect();
				//throw exception
				Eden_Mail_Error::i()
				->setMessage(Eden_Mail_Error::TLS_ERROR)
				->addVariable($host.':'.$this->_port)
				->trigger();
			}
			
			if(!$this->_call('EHLO '.$_SERVER['HTTP_HOST'], 250) && !$this->_call('HELO '.$_SERVER['HTTP_HOST'], 250)) {
				$this->disconnect();
				//throw exception
				Eden_Mail_Error::i()
				->setMessage(Eden_Mail_Error::SERVER_ERROR)
				->addVariable($host.':'.$this->_port)
				->trigger();
			}
        }
		
		if($test) {
			$this->disconnect();
			return $this;
		}
		
		//login
		if(!$this->_call('AUTH LOGIN', 250, 334)) {
			$this->disconnect();
			//throw exception
			Eden_Mail_Error::i(Eden_Mail_Error::LOGIN_ERROR)->trigger();
		}
		
		if(!$this->_call(base64_encode($this->_username), 334)) {
			$this->disconnect();
			//throw exception
			Eden_Mail_Error::i()->setMessage(Eden_Mail_Error::LOGIN_ERROR);
		}
		
		if(!$this->_call(base64_encode($this->_password), 235, 334)) {
			$this->disconnect();
			//throw exception
			Eden_Mail_Error::i()->setMessage(Eden_Mail_Error::LOGIN_ERROR);
		}
		
		return $this;
	}
	
	/**
	 * Disconnects from the server
	 *
	 * @return this
	 */
	public function disconnect() {
        if ($this->_socket) {
			$this->_send('QUIT');
			
            fclose($this->_socket);
            
			$this->_socket = NULL;
        }
		
        return $this;
	}
	
	/**
	 * Reply to an existing email 
	 *
	 * @param string message id
	 * @param string topic
	 * @return array headers
	 */
	public function reply($messageId, $topic = NULL, array $headers = array()) {
		Eden_Mail_Error::i()
			->argument(1, 'string')
			->argument(2, 'string', 'null');
			
		$headers['In-Reply-To'] = $messageId;
		
		if($topic) {
			$headers['Thread-Topic'] = $topic;
		}
		
		return $this->send($headers);
	}
	
	/**
	 * Resets the class
	 *
	 * @return this
	 */
	public function reset() {
		$this->_subject		= NULL;
		$this->_body		= array();
		$this->_to 			= array();
		$this->_cc 			= array();
		$this->_bcc 		= array();
		$this->_attachments = array();
		
		$this->disconnect();
		
		return $this;
	}
	
	/**
	 * Sends an email
	 *
	 * @param array custom headers
	 * @return array headers
	 */
	public function send(array $headers = array()) {
		//if no socket
		if(!$this->_socket) {
			//then connect
			$this->connect();
		}
		
		$headers 	= $this->_getHeaders($headers);
		$body 		= $this->_getBody();
		
		//add from
		if(!$this->_call('MAIL FROM:<' . $this->_username . '>', 250, 251)) {
			$this->disconnect();
			//throw exception
			Eden_Mail_Error::i()
				->setMessage(Eden_Mail_Error::SMTP_ADD_EMAIL)
				->addVariable($this->_username)
				->trigger();
		}
		
		//add to
		foreach($this->_to as $email => $name) {
			if(!$this->_call('RCPT TO:<' . $email . '>', 250, 251)) {
				$this->disconnect();
				//throw exception
				Eden_Mail_Error::i()
					->setMessage(Eden_Mail_Error::SMTP_ADD_EMAIL)
					->addVariable($email)
					->trigger();
			}
		}
		
		//add cc
		foreach($this->_cc as $email => $name) {
			if(!$this->_call('RCPT TO:<' . $email . '>', 250, 251)) {
				$this->disconnect();
				//throw exception
				Eden_Mail_Error::i()
					->setMessage(Eden_Mail_Error::SMTP_ADD_EMAIL)
					->addVariable($email)
					->trigger();
			}
		}
		
		//add bcc
		foreach($this->_bcc as $email => $name) {
			if(!$this->_call('RCPT TO:<' . $email . '>', 250, 251)) {
				$this->disconnect();
				//throw exception
				Eden_Mail_Error::i()
					->setMessage(Eden_Mail_Error::SMTP_ADD_EMAIL)
					->addVariable($email)
					->trigger();
			}
		}
		
		//start compose
		if(!$this->_call('DATA', 354)) {
			$this->disconnect();
			//throw exception
			Eden_Mail_Error::i(Eden_Mail_Error::SMTP_DATA)->trigger();
		}
		
		//send header data
		foreach($headers as $name => $value) {
			$this->_send($name.': '.$value);
		}
		
		//send body data
		foreach($body as $line) {
			if (strpos($line, '.') === 0) {
                // Escape lines prefixed with a '.'
                $line = '.' . $line;
            }
			
			$this->_send($line);
		}
		
		//tell server this is the end
		if(!$this->_call("\r\n.\r\n", 250)) {
			$this->disconnect();
			//throw exception
			Eden_Mail_Error::i(Eden_Mail_Error::SMTP_DATA)->trigger();
		}
		
		//reset (some reason without this, this class spazzes out)
		$this->_send('RSET');
		
		return $headers;
	}
	/**
	 * Sets body
	 *
	 * @param string body
	 * @param bool is this an html body?
	 * @return this
	 */
	public function setBody($body, $html = false) {
		Eden_Mail_Error::i()
			->argument(1, 'string')
			->argument(2, 'bool');
			
		if($html) {
			$this->_body['text/html'] = $body;
			$body = strip_tags($body);
		}
		
		$this->_body['text/plain'] = $body;
		
		return $this;
	}
	
	/**
	 * Sets subject
	 *
	 * @param string subject
	 * @return this
	 */
	public function setSubject($subject) {
		Eden_Mail_Error::i()->argument(1, 'string');
		$this->_subject = $subject;
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	protected function _addAttachmentBody(array $body) {
		foreach($this->_attachments as $attachment) {
			list($name, $data, $mime) = $attachment;
			$mime 	= $mime ? $mime : Eden_File::i()->getMimeType($name);
			$data 	= base64_encode($data);
			$count 	= ceil(strlen($data) / 998);
			
			$body[] = '--'.$this->_boundary[1];
			$body[] = 'Content-type: '.$mime.'; name="'.$name.'"';
			$body[] = 'Content-disposition: attachment; filename="'.$name.'"';
			$body[] = 'Content-transfer-encoding: base64';
			$body[] = NULL;
			
			for ($i = 0; $i < $count; $i++) {
				$body[] = substr($data, ($i * 998), 998);
			}
			
			$body[] = NULL;
			$body[] = NULL;
		}
		
		$body[] = '--'.$this->_boundary[1].'--';
		
		return $body;
	}
	
	protected function _call($command, $code = NULL) {
		if(!$this->_send($command)) {
			return false;
		}
		
		$receive = $this->_receive();
		
		$args = func_get_args();
		if(count($args) > 1) {	
			for($i = 1; $i < count($args); $i++) {
				if(strpos($receive, (string)$args[$i]) === 0) {
					return true;
				}
			}
			
			return false;
		}
		
		return $receive;
	}
	
	protected function _getAlternativeAttachmentBody() {
		$alternative 	= $this->_getAlternativeBody();
		
		$body = array();
		$body[] = 'Content-Type: multipart/mixed; boundary="'.$this->_boundary[1].'"';
		$body[] = NULL;
		$body[] = '--'.$this->_boundary[1];
		
		foreach($alternative as $line) {
			$body[] = $line;
		}
		
		return $this->_addAttachmentBody($body);
	}
	
	protected function _getAlternativeBody() {
		$plain 	= $this->_getPlainBody();
		$html 	= $this->_getHtmlBody();
			
		$body 	= array();
		$body[] = 'Content-Type: multipart/alternative; boundary="'.$this->_boundary[0].'"';
		$body[] = NULL;
		$body[] = '--'.$this->_boundary[0];
		
		foreach($plain as $line) {
			$body[] = $line;
		}
		
		$body[] = '--'.$this->_boundary[0];
		
		foreach($html as $line) {
			$body[] = $line;
		}
		
		$body[] = '--'.$this->_boundary[0].'--';
		$body[] = NULL;
		$body[] = NULL;
		
		return $body;
	}
	
	protected function _getBody() {
		$type = 'Plain';
		if(count($this->_body) > 1) {
			$type = 'Alternative';
		} else if(isset($this->_body['text/html'])) {
			$type = 'Html';
		}
		
		$method = '_get%sBody';
		if(!empty($this->_attachments)) {
			$method = '_get%sAttachmentBody';
		}
		
		$method = sprintf($method, $type);
		
		return $this->$method();
	}
	
	protected function _getHeaders(array $customHeaders = array()) {
		$timestamp = $this->_getTimestamp();
		
		$subject = trim($this->_subject);
		$subject = str_replace(array("\n", "\r"), '', $subject);
		
		$to = $cc = $bcc = array();
		foreach($this->_to as $email => $name) {
			$to[] = trim($name.' <'.$email.'>');
		}
		
		foreach($this->_cc as $email => $name) {
			$cc[] = trim($name.' <'.$email.'>');
		}
		
		foreach($this->_bcc as $email => $name) {
			$bcc[] = trim($name.' <'.$email.'>');
		}
		
		list($account, $suffix) = explode('@', $this->_username);
		
		$headers = array(
			'Date'			=> $timestamp,
			'Subject'		=> $subject,
			'From'			=> '<'.$this->_username.'>',
			'To'			=> implode(', ', $to));
		
		if(!empty($cc)) {
			$headers['Cc'] = implode(', ', $cc);
		}
		
		if(!empty($bcc)) {
			$headers['Bcc'] = implode(', ', $bcc);
		}
		
		$headers['Message-ID']	= '<'.md5(uniqid(time())).'.eden@'.$suffix.'>';
		
		$headers['Thread-Topic'] = $this->_subject;
		
		$headers['Reply-To'] = '<'.$this->_username.'>';
		
		foreach($customHeaders as $key => $value) {
			$headers[$key] = $value;
		}
		
		return $headers;
	}
	
	protected function _getHtmlAttachmentBody() {
		$html 	= $this->_getHtmlBody();
		
		$body = array();
		$body[] = 'Content-Type: multipart/mixed; boundary="'.$this->_boundary[1].'"';
		$body[] = NULL;
		$body[] = '--'.$this->_boundary[1];
		
		foreach($html as $line) {
			$body[] = $line;
		}
		
		return $this->_addAttachmentBody($body);
	}
	
	protected function _getHtmlBody() {
		$charset 	= $this->_isUtf8($this->_body['text/html']) ? 'utf-8' : 'US-ASCII';
		$html 		= str_replace("\r", '', trim($this->_body['text/html']));
		
		$encoded = explode("\n", $this->_quotedPrintableEncode($html));
		$body 	= array();
		$body[] = 'Content-Type: text/html; charset='.$charset;
		$body[] = 'Content-Transfer-Encoding: quoted-printable'."\n";
		
		foreach($encoded as $line) {
			$body[] = $line;
		}

		$body[] = NULL;
		$body[] = NULL;
		
		return $body;
	}
	
	protected function _getPlainAttachmentBody() {
		$plain 	= $this->_getPlainBody();
		
		$body = array();
		$body[] = 'Content-Type: multipart/mixed; boundary="'.$this->_boundary[1].'"';
		$body[] = NULL;
		$body[] = '--'.$this->_boundary[1];
		
		foreach($plain as $line) {
			$body[] = $line;
		}
		
		return $this->_addAttachmentBody($body);
	}
	
	protected function _getPlainBody() {
		$charset 	= $this->_isUtf8($this->_body['text/plain']) ? 'utf-8' : 'US-ASCII';
		$plane 		= str_replace("\r", '', trim($this->_body['text/plain']));
		$count 		= ceil(strlen($plane) / 998);
		
		$body = array();
		$body[] = 'Content-Type: text/plain; charset='.$charset;
		$body[] = 'Content-Transfer-Encoding: 7bit';
		$body[] = NULL;
		
		for ($i = 0; $i < $count; $i++) {
			$body[] = substr($plane, ($i * 998), 998);
		}
		
		$body[] = NULL;
		$body[] = NULL;
		
		return $body;
	}
	
	protected function _receive() {   
		$data = '';
		$now = time();
		
		while($str = fgets($this->_socket, 1024)) {
			
			$data .= $str;
			
			if(substr($str,3,1) == ' ' || time() > ($now + self::TIMEOUT)) {
				break; 
			}
		}
		
		$this->_debug('Receiving: '. $data);
		return $data;
	}
	
	protected function _send($command) {
		$this->_debug('Sending: '.$command);
		
        return fwrite($this->_socket, $command . "\r\n");
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
	
	private function _getTimestamp() {
		$zone = date('Z');
		$sign = ($zone < 0) ? '-' : '+';
		$zone = abs($zone);
		$zone = (int)($zone / 3600) * 100 + ($zone % 3600) / 60;
		return sprintf("%s %s%04d", date('D, j M Y H:i:s'), $sign, $zone);
	}
	
	private function _isUtf8($string) {
		$regex = array( 
			'[\xC2-\xDF][\x80-\xBF]', 
			'\xE0[\xA0-\xBF][\x80-\xBF]',
			'[\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}',
			'\xED[\x80-\x9F][\x80-\xBF]',
			'\xF0[\x90-\xBF][\x80-\xBF]{2}',
			'[\xF1-\xF3][\x80-\xBF]{3}',
			'\xF4[\x80-\x8F][\x80-\xBF]{2}');
		
		$count = ceil(strlen($string) / 5000);
		for ($i = 0; $i < $count; $i++) {
			if(preg_match('%(?:'. implode('|', $regex).')+%xs', substr($string, ($i * 5000), 5000))) {
				return false;
			}
		}
		
		return true;	
	}
	
	private function _quotedPrintableEncode($input, $line_max = 250) { 
		$hex = array('0','1','2','3','4','5','6','7', 
							  '8','9','A','B','C','D','E','F'); 
		$lines = preg_split("/(?:\r\n|\r|\n)/", $input); 
		$linebreak = "=0D=0A=\r\n"; 
		/* the linebreak also counts as characters in the mime_qp_long_line 
		* rule of spam-assassin */ 
		$line_max = $line_max - strlen($linebreak); 
		$escape = "="; 
		$output = ""; 
		$cur_conv_line = ""; 
		$length = 0; 
		$whitespace_pos = 0; 
		$addtl_chars = 0; 
		
		// iterate lines 
		for ($j=0; $j<count($lines); $j++) { 
		 $line = $lines[$j]; 
		 $linlen = strlen($line); 
		
		 // iterate chars 
		 for ($i = 0; $i < $linlen; $i++) { 
		   $c = substr($line, $i, 1); 
		   $dec = ord($c); 
		
		   $length++; 
		
		   if ($dec == 32) { 
			  // space occurring at end of line, need to encode 
			  if (($i == ($linlen - 1))) { 
				 $c = "=20"; 
				 $length += 2; 
			  } 
		
			  $addtl_chars = 0; 
			  $whitespace_pos = $i; 
		   } elseif ( ($dec == 61) || ($dec < 32 ) || ($dec > 126) ) { 
			  $h2 = floor($dec/16); $h1 = floor($dec%16); 
			  $c = $escape . $hex["$h2"] . $hex["$h1"]; 
			  $length += 2; 
			  $addtl_chars += 2; 
		   } 
		
		   // length for wordwrap exceeded, get a newline into the text 
		   if ($length >= $line_max) { 
			 $cur_conv_line .= $c; 
		
			 // read only up to the whitespace for the current line 
			 $whitesp_diff = $i - $whitespace_pos + $addtl_chars; 
		
			/* the text after the whitespace will have to be read 
			 * again ( + any additional characters that came into 
			 * existence as a result of the encoding process after the whitespace) 
			 * 
			 * Also, do not start at 0, if there was *no* whitespace in 
			 * the whole line */ 
			 if (($i + $addtl_chars) > $whitesp_diff) { 
				$output .= substr($cur_conv_line, 0, (strlen($cur_conv_line) - 
							   $whitesp_diff)) . $linebreak; 
				$i =  $i - $whitesp_diff + $addtl_chars; 
			  } else { 
				$output .= $cur_conv_line . $linebreak; 
			  } 
		
			$cur_conv_line = ""; 
			$length = 0; 
			$whitespace_pos = 0; 
		  } else { 
			// length for wordwrap not reached, continue reading 
			$cur_conv_line .= $c; 
		  } 
		} // end of for 
		
		$length = 0; 
		$whitespace_pos = 0; 
		$output .= $cur_conv_line; 
		$cur_conv_line = ""; 
		
			if ($j<=count($lines)-1) { 
			  $output .= $linebreak; 
			} 
		} // end for 
		
		return trim($output); 
	} // end quoted_printable_encode 
}