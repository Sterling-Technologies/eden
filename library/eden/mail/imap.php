<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * General available methods for common IMAP functionality
 *
 * @package    Eden
 * @category   mail
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Mail_Imap extends Eden_Class {
	/* Constants
	-------------------------------*/
	const TIMEOUT		= 30;
	const NO_SUBJECT	= '(no subject)';
	
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
	
	protected $_tag		 	= 0;
	protected $_total		= 0;
	protected $_buffer		= NULL;
	protected $_socket 		= NULL;
	protected $_mailbox		= NULL;
	protected $_mailboxes	= array();
	
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
            $port = $ssl ? 993 : 143;
        }
		
		$this->_host 		= $host;
		$this->_username 	= $user;
		$this->_password 	= $pass;
		$this->_port 		= $port;
		$this->_ssl 		= $ssl;
		$this->_tls 		= $tls;
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Connects to the server
	 * 
	 * @return this
	 */
	public function connect($timeout = self::TIMEOUT, $test = false) {
		Eden_Mail_Error::i()->argument(1, 'int')->argument(2, 'bool');
		
		if($this->_socket) {
			return $this;
		}
		
		$host = $this->_host;
		
		if ($this->_ssl) {
            $host = 'ssl://' . $host;
        }
		
		$errno  =  0;
        $errstr = '';
        
		$this->_socket = @fsockopen($host, $this->_port, $errno, $errstr, $timeout);
        
		if (!$this->_socket) {
			//throw exception
			Eden_Mail_Error::i()
				->setMessage(Eden_Mail_Error::SERVER_ERROR)
				->addVariable($host.':'.$this->_port)
				->trigger();
        }

        if (strpos($this->_getLine(), '* OK') === false) {
			$this->disconnect();
            //throw exception
			Eden_Mail_Error::i()
				->setMessage(Eden_Mail_Error::SERVER_ERROR)
				->addVariable($host.':'.$this->_port)
				->trigger();
        }

        if ($this->_tls) {
            $this->_send('STARTTLS');
            if (!stream_socket_enable_crypto($this->_socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
				$this->disconnect();
            	//throw exception
				Eden_Mail_Error::i()
				->setMessage(Eden_Mail_Error::TLS_ERROR)
				->addVariable($host.':'.$this->_port)
				->trigger();
            }
        }
		
		if($test) {
			fclose($this->_socket);
            
			$this->_socket = NULL;
			return $this;
		}
		
		//login
		$result = $this->_call('LOGIN', $this->_escape($this->_username, $this->_password));
		
		if(strpos(implode(' ', $result), 'OK') === false) {
			$this->disconnect();
			//throw exception
			Eden_Mail_Error::i(Eden_Mail_Error::LOGIN_ERROR)->trigger();
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
            $this->_send('LOGOUT');
			
            fclose($this->_socket);
            
			$this->_socket = NULL;
        }
		
        return $this;
	}
	
	/**
	 * Returns the active mailbox
	 *
	 * @return string
	 */
	public function getActiveMailbox() {
		return $this->_mailbox;
	}
	
	/**
	 * Returns a list of emails given the range
	 *
	 * @param number start
	 * @param number range
	 * @param bool add threads
	 * @return array
	 */
	public function getEmails($start = 0, $range = 10) {
		Eden_Mail_Error::i()
			->argument(1, 'int', 'array')
			->argument(2, 'int');
			
		//if not connected
		if(!$this->_socket) {
			//then connect
			$this->connect();
		}
		
		//if the total in this mailbox is 0
		//it means they probably didn't select a mailbox
		//or the mailbox selected is empty
		if($this->_total == 0) {
			//we might as well return an empty array
			return array();
		}
		
		//if start is an array
        if (is_array($start)) {
			//it is a set of numbers
            $set = implode(',', $start);
			//just ignore the range parameter
		//start is a number 
        } else {
			//range must be grater than 0
			$range = $range > 0 ? $range : 1;
			//start must be a positive number
			$start = $start >= 0 ? $start : 0;
			
			//calculate max (ex. 300 - 4 = 296)
			$max = $this->_total - $start;
			
			//if max is less than 1
			if($max < 1) {
				//set max to total (ex. 300)
				$max = $this->_total;
			}
			
			//calculate min (ex. 296 - 15 + 1 = 282)
			$min = $max - $range + 1;
			
			//if min less than 1
			if($min < 1) {
				//set it to 1
				$min = 1;
			}
			
			//now add min and max to set (ex. 282:296 or 1 - 300)
			$set = $min . ':' . $max; 
			
			//if min equal max
			if($min == $max) {
				//we should only get one number
				$set = $min; 
			}
        }
		
		$items = array('UID', 'FLAGS', 'BODY[HEADER]');
		
		//now lets call this
		$emails = $this->_getEmailResponse('FETCH', array($set, $this->_getList($items)));
		
		//this will be in ascending order
		//we actually want to reverse this
		$emails = array_reverse($emails);
		
		return $emails;
    }
	
	/**
	 * Returns the total number of emails in a mailbox
	 *
	 * @return number
	 */
	public function getEmailTotal() {
		return $this->_total;	
	}
	
	/**
	 * Returns a list of mailboxes
	 *
	 * @return array
	 */
	public function getMailboxes() {
		if(!$this->_socket) {
			$this->connect();
		}
        
		$response = $this->_call('LIST', $this->_escape('', '*'));
		
		$mailboxes = array();	
		foreach($response as $line) {
			if (strpos($line, 'Noselect') !== false || strpos($line, 'LIST') == false) {
				continue;
			}
			
			$line = explode('"', $line);
			
			if(strpos(trim($line[0]), '*') !== 0 ) {
				continue;
			}
			
			$mailboxes[] = $line[count($line)-2];
		}
		
		return $mailboxes;
    }
	
	/**
	 * Returns a list of emails given a uid or set of uids
	 *
	 * @param number|array uid/s
	 * @return array
	 */
	public function getUniqueEmails($uid, $body = false) {
		Eden_Mail_Error::i()
			->argument(1, 'int', 'string', 'array')
			->argument(2, 'bool');
		//if not connected
		if(!$this->_socket) {
			//then connect
			$this->connect();
		}
		
		//if the total in this mailbox is 0
		//it means they probably didn't select a mailbox
		//or the mailbox selected is empty
		if($this->_total == 0) {
			//we might as well return an empty array
			return array();
		}
		
		//if uid is an array
        if (is_array($uid)) {
            $uid = implode(',', $uid);
		}
		
		//lets call it
		$items 		= array('UID', 'FLAGS', 'BODY[HEADER]');
		
		if($body) {
			$items 	= array('UID', 'FLAGS', 'BODY[]');
		}
		
		$first 		= is_numeric($uid) ? true : false;
		return $this->_getEmailResponse('UID FETCH', array($uid, $this->_getList($items)), $first);
    }
	
	/**
	 * Moves an email to another mailbox
	 *
	 * @param number uid
	 * @param string mailbox
	 * @return this
	 */
	public function move($uid, $mailbox) {
		Eden_Mail_Error::i()->argument(1, 'int', 'string')->argument(2, 'string');
		if(!$this->_socket) {
			$this->connect();
		}
		
		if(!is_array($uid)) {
			$uid = array($uid);
		}
		
		$this->_call('UID COPY '.implode(',', $uid).' '.$mailbox);
		
		return $this->remove($uid);
	}
	
	/**
	 * Remove an email from a mailbox
	 *
	 * @param number uid
	 * @return this
	 */
	public function remove($uid) {
		Eden_Mail_Error::i()->argument(1, 'int', 'string', 'array');
		
		if(!$this->_socket) {
			$this->connect();
		}
		
		if(!is_array($uid)) {
			$uid = array($uid);
		}
		
		$this->_call('UID STORE '.implode(',', $uid).' FLAGS.SILENT \Deleted');
		
		return $this;
	}
	
	/**
	 * Searches a mailbox for specific emails
	 *
	 * @param array filter
	 * @param string sort
	 * @param string order ASC|DESC
	 * @param number start
	 * @param number range
	 * @param bool or search?
	 * @return array
	 */
	public function search(array $filter, $start = 0, $range = 10, $or = false, $body = false) {
		Eden_Mail_Error::i()
			->argument(2, 'int')
			->argument(3, 'int')
			->argument(4, 'bool')
			->argument(5, 'bool');
		
		if(!$this->_socket) {
			$this->connect();
		}
		
		//build a search criteria
		$search = $not = array();
		foreach($filter as $where) {
			if(is_string($where)) {
				$search[] = $where;
				continue;
			}
			
			if($where[0] == 'NOT') {
				$not = $where[1]; 
				continue;
			}
			
			$item = $where[0].' "'.$where[1].'"';
			if(isset($where[2])) {
				$item .= ' "'.$where[2].'"';
			}
			
			$search[] = $item;
		}
		
		//if this is an or search
		if($or && count($search) > 1) {
			//item1
			//OR (item1) (item2)
			//OR (item1) (OR (item2) (item3))
			//OR (item1) (OR (item2) (OR (item3) (item4)))
			$query = NULL;
			while($item = array_pop($search)) {
				if(is_null($query)) {
					$query = $item;
				} else if(strpos($query, 'OR') !== 0) {
					$query = 'OR ('.$query.') ('.$item.')';
				} else {
					$query = 'OR ('.$item.') ('.$query.')';
				}
			}
			$search = $query;			
		//this is an and search
		} else {
			$search = implode(' ', $search);
		}
		
		//do the search
		$response = $this->_call('UID SEARCH '.$search);
		
		//get the result
		$result = array_pop($response);
		//if we got some results
		if(strpos($result, 'OK') !== false) {
			//parse out the uids
			$uids = explode(' ', $response[0]);
			array_shift($uids);
			array_shift($uids);
			
			foreach($uids as $i => $uid) {
				if(in_array($uid, $not)) {
					unset($uids[$i]);
				}
			}
			
			if(empty($uids)) {
				return array();
			}
			
			$uids = array_reverse($uids);
			
			//pagination
			$count = 0;
			foreach($uids as $i => $id) {
				if($i < $start) {
					unset($uids[$i]);
					continue;
				}
				
				$count ++;
				
				if($range != 0 && $count > $range) {
					unset($uids[$i]);
					continue;
				}
			}
			
			//return the email details for this
			return $this->getUniqueEmails($uids, $body);
		}
		
		//it's not okay just return an empty set
		return array();
	}
	
	/**
	 * Returns the total amount of emails
	 *
	 * @param array filter
	 * @return number
	 */
	public function searchTotal(array $filter, $or = false) {
		Eden_Mail_Error::i()->argument(2, 'bool');
		
		if(!$this->_socket) {
			$this->connect();
		}
		
		//build a search criteria
		$search = array();
		foreach($filter as $where) {
			$item = $where[0].' "'.$where[1].'"';
			if(isset($where[2])) {
				$item .= ' "'.$where[2].'"';
			}
			
			$search[] = $item;
		}
		
		//if this is an or search
		if($or) {
			$search = 'OR ('.implode(') (', $search).')';
		//this is an and search
		} else {
			$search = implode(' ', $search);
		}
		
		$response = $this->_call('UID SEARCH '.$search);
		
		//get the result
		$result = array_pop($response);
		
		//if we got some results
		if(strpos($result, 'OK') !== false) {
			//parse out the uids
			$uids = explode(' ', $response[0]);
			array_shift($uids);
			array_shift($uids);
			
			return count($uids);
		}
		
		//it's not okay just return 0
		return 0;
	}
	
	/**
	 * IMAP requires setting an active mailbox 
	 * before getting a list of mails
	 *
	 * @param string name of mailbox
	 * @return false|this
	 */
	public function setActiveMailbox($mailbox) {
		Eden_Mail_Error::i()->argument(1, 'string');
		
		if(!$this->_socket) {
			$this->connect();
		}
		
		$response = $this->_call('SELECT', $this->_escape($mailbox));
		$result = array_pop($response);
		
		foreach($response as $line) {
			if(strpos($line, 'EXISTS') !== false) {
				list($star, $this->_total, $type) = explode(' ', $line, 3);
				break;
			}	
		}
		
		if(strpos($result, 'OK') !== false) {
			$this->_mailbox = $mailbox;
			
			return $this;
		}
		
		return false;
	}
	
	/* Protected Methods
	-------------------------------*/
	protected function _call($command, $parameters = array()) {
		if(!$this->_send($command, $parameters)) {
			return false;
		}
		
		return $this->_receive($this->_tag);
	}
	
    protected function _getLine() {
        $line = fgets($this->_socket);
		
		if($line === false) {
			$this->disconnect();
		}
		
		$this->_debug('Receiving: '.$line);
		
		return $line;
    }
	
	protected function _receive($sentTag) {   
		$this->_buffer = array();
		
		$start = time();
		
        while (time() < ($start + self::TIMEOUT)) {
			list($receivedTag, $line) = explode(' ', $this->_getLine(), 2);
			$this->_buffer[] = trim($receivedTag . ' ' . $line);
			if($receivedTag == 'TAG'.$sentTag) {
				return $this->_buffer;
			}
			
        }
		
        return NULL;
    }
	
	protected function _send($command, $parameters = array()) {
        $this->_tag ++;

        $line = 'TAG' . $this->_tag . ' ' . $command;

		if(!is_array($parameters)) {
			$parameters = array($parameters);
		}

        foreach ($parameters as $parameter) {
            if (is_array($parameter)) {
                if (fputs($this->_socket, $line . ' ' . $parameter[0] . "\r\n") === false) {
                    return false;
                }
				
                if (strpos($this->_getLine(), '+ ') === false) {
                    return false;
                }
				
                $line = $parameter[1];
            } else {
                $line .= ' ' . $parameter;
            }
        }
		
		$this->_debug('Sending: '.$line);
		
        return fputs($this->_socket, $line . "\r\n");
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
	
	private function _escape($string) {
        if (func_num_args() < 2) {
            if (strpos($string, "\n") !== false) {
                return array('{' . strlen($string) . '}', $string);
            } else {
                return '"' . str_replace(array('\\', '"'), array('\\\\', '\\"'), $string) . '"';
            }
        }
        $result = array();
        foreach (func_get_args() as $string) {
            $result[] = $this->_escape($string);
        }
        return $result;
    }
	
	private function _getEmailFormat($email, $uniqueId = NULL, array $flags = array()) {
		//if email is an array
		if(is_array($email)) {
			//make it into a string
			$email = implode("\n", $email);
		}
		
		//split the head and the body
		$parts = preg_split("/\n\s*\n/", $email, 2);
		
		$head = $parts[0]; 
		$body = NULL;
		if(isset($parts[1]) && trim($parts[1]) != ')') {
			$body = $parts[1];
		}
		
		$lines = explode("\n", $head);
		$head = array();
		foreach($lines as $line) {
			if(trim($line) && preg_match("/^\s+/", $line)) {
				$head[count($head)-1] .= ' '.trim($line);
				continue;
			}
			
			$head[] = trim($line);
		}
		
		$head = implode("\n", $head);
		
		$recipientsTo = $recipientsCc = $recipientsBcc = $sender = array();
		
		//get the headers
		$headers1 	= imap_rfc822_parse_headers($head);
		$headers2 	= $this->_getHeaders($head);
		
		//set the from
		$sender['name'] = NULL;
		if(isset($headers1->from[0]->personal)) {
			$sender['name'] = $headers1->from[0]->personal;
			//if the name is iso or utf encoded
			if(preg_match("/^\=\?[a-zA-Z]+\-[0-9]+.*\?/", strtolower($sender['name']))) {
				//decode the subject
				$sender['name'] = str_replace('_', ' ', mb_decode_mimeheader($sender['name']));
			}
		}
		
		$sender['email'] = $headers1->from[0]->mailbox . '@' . $headers1->from[0]->host;
		
		//set the to
		if(isset($headers1->to)) {
			foreach($headers1->to as $to) {
				if(!isset($to->mailbox, $to->host)) {
					continue;
				}
				
				$recipient = array('name'=>NULL);
				if(isset($to->personal)) {
					$recipient['name'] = $to->personal;
					//if the name is iso or utf encoded
					if(preg_match("/^\=\?[a-zA-Z]+\-[0-9]+.*\?/", strtolower($recipient['name']))) {
						//decode the subject
						$recipient['name'] = str_replace('_', ' ', mb_decode_mimeheader($recipient['name']));
					}
				}
				
				$recipient['email'] = $to->mailbox . '@' . $to->host;
				
				$recipientsTo[] = $recipient;
			}
		}
		
		//set the cc
		if(isset($headers1->cc)) {
			foreach($headers1->cc as $cc) {
				$recipient = array('name'=>NULL);
				if(isset($cc->personal)) {
					$recipient['name'] = $cc->personal;
					
					//if the name is iso or utf encoded
					if(preg_match("/^\=\?[a-zA-Z]+\-[0-9]+.*\?/", strtolower($recipient['name']))) {
						//decode the subject
						$recipient['name'] = str_replace('_', ' ', mb_decode_mimeheader($recipient['name']));
					}
				}
				
				$recipient['email'] = $cc->mailbox . '@' . $cc->host;
				
				$recipientsCc[] = $recipient;
			}
		}
		
		//set the bcc
		if(isset($headers1->bcc)) {
			foreach($headers1->bcc as $bcc) {
				$recipient = array('name'=>NULL);
				if(isset($bcc->personal)) {
					$recipient['name'] = $bcc->personal;				
					//if the name is iso or utf encoded
					if(preg_match("/^\=\?[a-zA-Z]+\-[0-9]+.*\?/", strtolower($recipient['name']))) {
						//decode the subject
						$recipient['name'] = str_replace('_', ' ', mb_decode_mimeheader($recipient['name']));
					}
				}
				
				$recipient['email'] = $bcc->mailbox . '@' . $bcc->host;
				
				$recipientsBcc[] = $recipient;
			}
		}
		
		//if subject is not set
		if(!isset( $headers1->subject ) || strlen(trim($headers1->subject)) === 0) {
			//set subject
			$headers1->subject = self::NO_SUBJECT;
		}
		
		//trim the subject
		$headers1->subject = str_replace(array('<', '>'), '', trim($headers1->subject));
		
		//if the subject is iso or utf encoded
		if(preg_match("/^\=\?[a-zA-Z]+\-[0-9]+.*\?/", strtolower($headers1->subject))) {
			//decode the subject
			$headers1->subject = str_replace('_', ' ', mb_decode_mimeheader($headers1->subject));
		}
		
		//set thread details
		$topic 	= isset($headers2['thread-topic']) ? $headers2['thread-topic'] : $headers1->subject;
		$parent = isset($headers2['in-reply-to']) ? str_replace('"', '', $headers2['in-reply-to']) : NULL;
		
		//set date
		$date = isset($headers1->date) ? strtotime($headers1->date) : NULL;
		
		//set message id
		if(isset($headers2['message-id'])) {
			$messageId = str_replace('"', '', $headers2['message-id']);
		} else {
			$messageId = '<eden-no-id-'.md5(uniqid()).'>';
		}
		
		$attachment = isset($headers2['content-type']) && strpos($headers2['content-type'], 'multipart/mixed') === 0;
		
		$format = array(
			'id'			=> $messageId,
			'parent'		=> $parent,
			'topic'			=> $topic,
			'mailbox'		=> $this->_mailbox,
			'uid'			=> $uniqueId,
			'date'			=> $date,
			'subject'		=> str_replace('’', '\'', $headers1->subject),
			'from'			=> $sender,
			'flags'			=> $flags,
			'to'			=> $recipientsTo,
			'cc'			=> $recipientsCc,
			'bcc'			=> $recipientsBcc,
			'attachment'	=> $attachment);
		
		if(trim($body) && $body != ')') {
			//get the body parts
			$parts = $this->_getParts($email);
			
			//if there are no parts
			if(empty($parts)) {
				//just make the body as a single part
				$parts = array('text/plain' => $body);
			} 
			
			//set body to the body parts
			$body = $parts;
			
			//look for attachments
			$attachment = array();
			//if there is an attachment in the body
			if(isset($body['attachment'])) {
				//take it out
				$attachment = $body['attachment'];
				unset($body['attachment']);
			}
			
			$format['body']			= $body;
			$format['attachment']	= $attachment;
		}
		
		return $format;
	} 
	
	private function _getEmailResponse($command, $parameters = array(), $first = false) {
		//send out the command
		if(!$this->_send($command, $parameters)) {
			return false;
		}
		
		$messageId 	= $uniqueId = $count = 0;
		$emails 	= $email = array();
		$start 		= time();
		
		//while there is no hang
        while (time() < ($start + self::TIMEOUT)) {
			//get a response line
			$line = str_replace("\n", '', $this->_getLine());

			//if the line starts with a fetch 
			//it means it's the end of getting an email
			if(strpos($line, 'FETCH') !== false && strpos($line, 'TAG'.$this->_tag) === false) {
				//if there is email data
				if(!empty($email)) {
					//create the email format and add it to emails
					$emails[$uniqueId] = $this->_getEmailFormat($email, $uniqueId, $flags);
					
					//if all we want is the first one
					if($first) {
						//just return this
						return $emails[$uniqueId];
					}
					
					//make email data empty again
					$email = array();
				}
				
				//if just okay
				if(strpos($line, 'OK') !== false) {
					//then skip the rest
					continue;
				}
				
				//if it's not just ok
				//it will contain the message id and the unique id and flags
				$flags = array();
				if(strpos($line, '\Answered' ) !== false) {
					$flags[] = 'answered';
				}
				
				if(strpos($line, '\Flagged' ) !== false) {
					$flags[] = 'flagged';
				}
				
				if(strpos($line, '\Deleted' ) !== false) {
					$flags[] = 'deleted';
				}
				
				if(strpos($line, '\Seen' ) !== false) {
					$flags[] = 'seen';
				}
				
				if(strpos($line, '\Draft' ) !== false) {
					$flags[] = 'draft';
				}
				
				$findUid = explode(' ', $line);
				foreach($findUid as $i => $uid) {
					if(is_numeric($uid)) {
						$uniqueId = $uid;
					}
					if(strpos(strtolower($uid), 'uid') !== false) {
						$uniqueId = $findUid[$i+1];
						break;
					}
				}
				
				//skip the rest
				continue;
			} 
			
			//if there is a tag it means we are at the end
			if(strpos($line, 'TAG'.$this->_tag) !== false) {
				
				//if email details are not empty and the last line is just a )
				if(!empty($email) && strpos(trim($email[count($email) -1]), ')') === 0) {
					//take it out because that is not part of the details
					array_pop($email);
				}
					
				//if there is email data
				if(!empty($email)) {
					//create the email format and add it to emails
					$emails[$uniqueId] = $this->_getEmailFormat($email, $uniqueId, $flags);
					
					//if all we want is the first one
					if($first) {
						//just return this
						return $emails[$uniqueId];
					}
				}
				
				//break out of this loop
				break;
			}
			
			//so at this point we are getting raw data
			//capture this data in email details
			$email[] = $line;	
        }
		
		return $emails;
	}
	
	private function _getHeaders($rawData) {
		if(is_string($rawData)) {
			$rawData = explode("\n", $rawData);
		}
		
		$key = NULL;
		$headers = array();
		foreach($rawData as $line) {
			$line = trim($line);
			if(preg_match("/^([a-zA-Z0-9-]+):/i", $line, $matches)) {
				$key = strtolower($matches[1]);
				if(isset($headers[$key])) {
					if(!is_array($headers[$key])) {
						$headers[$key] = array($headers[$key]);
					}
					
					$headers[$key][] = trim(str_replace($matches[0], '', $line));
					continue;
				} 
				
				$headers[$key] = trim(str_replace($matches[0], '', $line));
				continue;
			} 
			
			if(!is_null($key) && isset($headers[$key])) {
				if(is_array($headers[$key])) {
					$headers[$key][count($headers[$key])-1] .= ' '.$line;	
					continue;
				}
				
				$headers[$key] .= ' '.$line; 
			}
		}
		
		return $headers;
	}
	
	private function _getList($array) {
		$list = array();
        foreach ($array as $key => $value) {
            $list[] = !is_array($value) ? $value : $this->_getList($v);
        }
        return '(' . implode(' ', $list) . ')';
	}
	
	private function _getParts($content, array $parts = array()) {
		//separate the head and the body
		list($head, $body) = preg_split("/\n\s*\n/", $content, 2);
		//front()->output($head);
		//get the headers
		$head = $this->_getHeaders($head);
		//if content type is not set
		if(!isset($head['content-type'])) {
			return $parts;
		}
		
		//split the content type
		if(is_array($head['content-type'])) {
			$type = array($head['content-type'][1]);
			if(strpos($type[0], ';') !== false) {
				$type = explode(';', $type[0], 2);
			}
		} else {
			$type = explode(';', $head['content-type'], 2);
		}
		
		//see if there are any extra stuff
		$extra = array();
		if(count($type) == 2) {
			$extra = explode('; ', str_replace(array('"', "'"), '', trim($type[1])));
		}
		
		//the content type is the first part of this
		$type = trim($type[0]);
		
		
		//foreach extra
		foreach($extra as $i => $attr) {
			//transform the extra array to a key value pair
			$attr = explode('=', $attr, 2);
			if(count($attr) > 1) {
				list($key, $value) = $attr;
				$extra[$key] = $value;
			}
			unset($extra[$i]);
		}
		
		//if a boundary is set
		if(isset($extra['boundary'])) {
			//split the body into sections
			$sections = explode('--'.str_replace(array('"', "'"), '', $extra['boundary']), $body);
			//we only want what's in the middle of these sections
			array_pop($sections);
			array_shift($sections);
			
			//foreach section
			foreach($sections as $section) {
				//get the parts of that
				$parts = $this->_getParts($section, $parts);	
			}
		//if name is set, it's an attachment
		} else {
			
			//if encoding is set
			if(isset($head['content-transfer-encoding'])) {
				//the goal here is to make everytihg utf-8 standard
				switch(strtolower($head['content-transfer-encoding'])) {
					case 'binary':
						$body = imap_binary($body);
					case 'base64':
						$body = base64_decode($body);
						break;
					case 'quoted-printable':
						$body = quoted_printable_decode($body);
						break;
					case '7bit':
						$body = mb_convert_encoding ($body, 'UTF-8', 'ISO-2022-JP');
						break;
					default:
						$body = str_replace(array("\n", ' '), '', $body);
						break;
				}
			}
			
			if(isset($extra['name'])) {
				//add to parts
				$parts['attachment'][$extra['name']][$type] = $body;
			//it's just a regular body
			} else {
				//add to parts
				$parts[$type] = $body;
			}
		}
		return $parts;
	}
	
}
