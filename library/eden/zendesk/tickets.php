<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Zen Desk Tickets 
 *
 * @package    Eden
 * @category   zendesk
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com 
 */
class Eden_ZenDesk_Tickets extends Eden_ZenDesk_Base {
	/* Constants
	-------------------------------*/
	const TICKETS_GET_LIST		= 'https://%s.zendesk.com/api/v2/tickets.json';
	const TICKETS_GET_SPECIFIC	= 'https://%s.zendesk.com/api/v2/tickets/%s.json';
	const TICKETS_UPDATE_BULK	= 'https://%s.zendesk.com/api/v2/tickets/update_many.json';
	const TICKETS_DELETE_BULK	= 'https://%s.zendesk.com/api/v2/tickets/destroy_many.json';
	const TICKETS_DELETE		= 'https://%s.zendesk.com/api/v2/tickets/%s.json';
	const TICKETS_COLLABORATORS	= 'https://%s.zendesk.com/api/v2/tickets/%s/collaborators.json';
	const TICKETS_INCIDENTS		= 'https://%s.zendesk.com/api/v2/tickets/%s/incidents.json';
	const TICKETS_GET_AUDITS	= 'https://%s.zendesk.com/api/v2/tickets/%s/audits.json';
	const TICKETS_SHOW_AUDITS	= 'https://%s.zendesk.com/api/v2/tickets/%s/audits/%s.json';
	const TICKETS_TRUST_AUDITS	= 'https://%s.zendesk.com/api/v2/tickets/%s/audits/%s/trust.json';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_query = array();
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}

	/* Public Methods
	-------------------------------*/
	/**
	 * Returns a listing of tickets. Tickets are ordered 
	 * chronologically by created date, from oldest to newest.
	 *
	 * @return array
	 */
	public function getList() {
		
		return $this->_getResponse(sprintf(self::TICKETS_GET_LIST, $this->_subdomain));
	}
	
	/**
	 * Returns a specific of tickets. Tickets are ordered 
	 * chronologically by created date, from oldest to newest.
	 *
	 * @param string|integer
	 * @return array
	 */
	public function getTicket($ticketId) {
		//argument 1 must be a string or integer
		Eden_ZenDesk_Error::i()->argument(1, 'string', 'int');		
		
		return $this->_getResponse(sprintf(self::TICKETS_GET_SPECIFIC, $this->_subdomain, $ticketId));
	}
	
	/**
	 * Create a ticket
	 *
	 * @param string
	 * @param string
	 * @return array
	 */
	public function createTicket($subject, $comment) {
		//argument test
		Eden_ZenDesk_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		$this->_query['ticket']['subject'] 			= $subject;
		$this->_query['ticket']['comment']['value'] = $comment;
		
		return $this->_post(sprintf(self::TICKETS_GET_LIST, $this->_subdomain), $this->_query);
	}
	
	/**
	 * Update a ticket
	 *
	 * @param string|integer
	 * @return array
	 */
	public function updateTicket($ticketId) {
		//argument 1 must be a string or integer
		Eden_ZenDesk_Error::i()->argument(1, 'string', 'int');	
		
		return $this->_put(sprintf(self::TICKETS_GET_SPECIFIC, $this->_subdomain, $ticketId), $this->_query);
	}
	
	/**
	 * Bulk Updating Tickets
	 *
	 * @param array Ticket IDs you want to update
	 * @return array
	 */
	public function bulkUpdateTicket($ticketIds) {
		//argument 1 must be a array
		Eden_ZenDesk_Error::i()->argument(1, 'array');	
		
		$this->_query['ids'] = implode(',', $ticketIds);
		
		return $this->_put(sprintf(self::TICKETS_UPDATE_BULK, $this->_subdomain), $this->_query);
	}
	
	/**
	 * Delete Tickets
	 *
	 * @param string Ticket ID you want to delete
	 * @return array
	 */
	public function deleteTicket($ticketId) {
		//argument 1 must be a array
		Eden_ZenDesk_Error::i()->argument(1, 'array');	
		
		return $this->_post(sprintf(self::TICKETS_DELETE, $this->_subdomain, $ticketId));
	}
	
	/**
	 * Bulk delete Tickets
	 *
	 * @param array Ticket IDs you want to delete
	 * @return array
	 */
	public function bulkDelete($ticketIds) {
		//argument 1 must be a array
		Eden_ZenDesk_Error::i()->argument(1, 'array');	
		
		$this->_query['ids'] = implode(',', $ticketIds);
		
		return $this->_put(sprintf(self::TICKETS_DELETE_BULK, $this->_subdomain), $this->_query);
	}
	
	/**
	 * List Collaborators for a Ticket
	 *
	 * @param array Ticket ID 
	 * @return array
	 */
	public function getTicketCollarorators($ticketId) {
		//argument 1 must be a string
		Eden_ZenDesk_Error::i()->argument(1, 'string');	
		
		return $this->_getResponse(sprintf(self::TICKETS_COLLABORATORS, $this->_subdomain, $ticketId), $this->_query);
	}
	
	/**
	 * Returns Ticket Incidents
	 *
	 * @param string Ticket ID 
	 * @return array
	 */
	public function getTicketIncidents($ticketId) {
		//argument 1 must be a string
		Eden_ZenDesk_Error::i()->argument(1, 'string');	
		
		return $this->_getResponse(sprintf(self::TICKETS_INCIDENTS, $this->_subdomain, $ticketId), $this->_query);
	}
	
	/**
	 * Returns Ticket Audits
	 *
	 * @param string Ticket ID 
	 * @return array
	 */
	public function getTicketAudits($ticketId) {
		//argument 1 must be a string
		Eden_ZenDesk_Error::i()->argument(1, 'string');	
		
		return $this->_getResponse(sprintf(self::TICKETS_GET_AUDITS, $this->_subdomain, $ticketId), $this->_query);
	}
	
	/**
	 * Returns Show Ticket Audits
	 *
	 * @param string Ticket ID 
	 * @param string Audit ID
	 * @return array
	 */
	public function showTicketAudits($ticketId, $auditId) {
		//argument test
		Eden_ZenDesk_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		return $this->_getResponse(sprintf(self::TICKETS_SHOW_AUDITS, $this->_subdomain, $ticketId, $auditId), $this->_query);
	}
	
	/**
	 * Returns Show Ticket Audits
	 *
	 * @param string Ticket ID 
	 * @param string Audit ID
	 * @return array
	 */
	public function markAsTrusted($ticketId, $auditId) {
		//argument test
		Eden_ZenDesk_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		return $this->_getResponse(sprintf(self::TICKETS_TRUST_AUDITS, $this->_subdomain, $ticketId, $auditId), $this->_query);
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	/**
	 * A unique external id, you can use this to link Zendesk tickets to local records
	 *
	 * @param string
	 * @return this
	 */
	public function setExternalId($externalId) {
		//argument 1 must be a string 
		Eden_ZenDesk_Error::i()->argument(1, 'string');	
		
		$this->_query['ticket']['external_id'] = $externalId;
		
		return $this;
	}
	
	/**
	 * The type of this ticket, i.e. "problem", "incident", "question" or "task"
	 *
	 * @param string
	 * @return this
	 */
	public function setTicketType($type) {
		//argument 1 must be a string
		Eden_ZenDesk_Error::i()->argument(1, 'string');	
	
		$this->_query['ticket']['type'] = $type;
		
		return $this;
	}
	
	/**
	 * The value of the subject field for this ticket
	 *
	 * @param string
	 * @return this
	 */
	public function setSubject($subject) {
		//argument 1 must be a string
		Eden_ZenDesk_Error::i()->argument(1, 'string');	
	
		$this->_query['ticket']['subject'] = $subject;
		
		return $this;
	}
	
	/**
	 * Priority, defines the urgency with which the ticket should be 
	 * addressed: "urgent", "high", "normal", "low"
	 *
	 * @param string
	 * @return this
	 */
	public function setPriority($priority) {
		//argument 1 must be a string
		Eden_ZenDesk_Error::i()->argument(1, 'string');	
	
		$this->_query['ticket']['priority'] = $priority;
		
		return $this;
	}
	
	/**
	 * The state of the ticket, "new", "open", "pending", "hold", "solved", "closed"
	 *
	 * @param string
	 * @return this
	 */
	public function setStatus($status) {
		//argument 1 must be a string
		Eden_ZenDesk_Error::i()->argument(1, 'string');	
	
		$this->_query['ticket']['status'] = $status;
		
		return $this;
	}
	
	/**
	 * The user who requested this ticket
	 *
	 * @param integer
	 * @return this
	 */
	public function setRequesterId($requesterId) {
		//argument 1 must be a integer
		Eden_ZenDesk_Error::i()->argument(1, 'int');	
	
		$this->_query['ticket']['requester_id'] = $requesterId;
		
		return $this;
	}
	
	/**
	 * What agent is currently assigned to the ticket
	 *
	 * @param integer
	 * @return this
	 */
	public function setAssigneeId($assigneeId) {
		//argument 1 must be a integer
		Eden_ZenDesk_Error::i()->argument(1, 'int');	
	
		$this->_query['ticket']['assignee_id'] = $assigneeId;
		
		return $this;
	}
	
	/**
	 * The group this ticket is assigned to
	 *
	 * @param integer
	 * @return this
	 */
	public function setGroupId($groupId) {
		//argument 1 must be a integer
		Eden_ZenDesk_Error::i()->argument(1, 'int');	
	
		$this->_query['ticket']['group_id'] = $groupId;
		
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}