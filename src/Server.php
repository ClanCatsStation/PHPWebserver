<?php namespace ClanCats\Station\PHPServer;

class Server 
{
	/**
	 * The current host
	 *
	 * @var string
	 */
	protected $host = null;
	
	/**
	 * The current port
	 *
	 * @var int
	 */
	protected $port = null;
	
	/**
	 * The binded socket
	 * 
	 * @var resource
	 */
	protected $socket = null;
	
	/**
	 * Construct new Server instance
	 * 
	 * @param string 			$host
	 * @param int 				$port
	 * @return void
	 */
	public function __construct( $host, $port )
	{
		$this->host = $host;
		$this->port = (int) $port;
		
		$this->socket = socket_create(AF_INET, SOCK_STREAM, 0);
		
		if ( !socket_bind($this->socket, $address, $port) )
		;
	}
	
	/**
	 * Bind the socket
	 *
	 * @throws ClanCats\Station\PHPServer\Exception
	 * @return void
	 */
	protected function bind()
	{
		
	}
}