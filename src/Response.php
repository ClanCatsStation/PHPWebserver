<?php namespace ClanCats\Station\PHPServer;

class Response 
{
	/**
	 * An array of the available HTTP response codes
	 *
	 * @var array
	 */
	protected static $statusCodes = [
		// Informational 1xx
		100 => 'Continue',
		101 => 'Switching Protocols',
	
		// Success 2xx
		200 => 'OK',
		201 => 'Created',
		202 => 'Accepted',
		203 => 'Non-Authoritative Information',
		204 => 'No Content',
		205 => 'Reset Content',
		206 => 'Partial Content',
	
		// Redirection 3xx
		300 => 'Multiple Choices',
		301 => 'Moved Permanently',
		302 => 'Found', // 1.1
		303 => 'See Other',
		304 => 'Not Modified',
		305 => 'Use Proxy',
		// 306 is deprecated but reserved
		307 => 'Temporary Redirect',
	
		// Client Error 4xx
		400 => 'Bad Request',
		401 => 'Unauthorized',
		402 => 'Payment Required',
		403 => 'Forbidden',
		404 => 'Not Found',
		405 => 'Method Not Allowed',
		406 => 'Not Acceptable',
		407 => 'Proxy Authentication Required',
		408 => 'Request Timeout',
		409 => 'Conflict',
		410 => 'Gone',
		411 => 'Length Required',
		412 => 'Precondition Failed',
		413 => 'Request Entity Too Large',
		414 => 'Request-URI Too Long',
		415 => 'Unsupported Media Type',
		416 => 'Requested Range Not Satisfiable',
		417 => 'Expectation Failed',
	
		// Server Error 5xx
		500 => 'Internal Server Error',
		501 => 'Not Implemented',
		502 => 'Bad Gateway',
		503 => 'Service Unavailable',
		504 => 'Gateway Timeout',
		505 => 'HTTP Version Not Supported',
		509 => 'Bandwidth Limit Exceeded'
	];
	
	/**
	 * Returns a simple response based on a status code
	 *
	 * @param int			$status
	 * @return Response
	 */
	public static function error( $status )
	{
		return new static( "<h1>PHPServer: ".$status." - ".static::$statusCodes[$status]."</h1>", $status );
	}
	
	/**
	 * The current response status
	 *
	 * @var int
	 */
	protected $status = 200;
	
	/**
	 * The current response body
	 *
	 * @var string
	 */
	protected $body = '';
	
	/**
	 * The current response headers
	 *
	 * @var array
	 */
	protected $headers = [];
	
	/**
	 * Construct a new Response object
	 *
	 * @param string 		$body
	 * @param int 			$status
	 * @return void
	 */
	public function __construct( $body, $status = null )
	{
		if ( !is_null( $status ) )
		{
			$this->status = $status;
		}
		
		$this->body = $body;
		
		// set inital headers
		$this->header( 'Date', gmdate( 'D, d M Y H:i:s T' ) );
		$this->header( 'Content-Type', 'text/html; charset=utf-8' );
		$this->header( 'Server', 'PHPServer' );
	}
	
	/**
	 * Return the response body
	 *
	 * @return string
	 */
	public function body()
	{
		return $this->body;
	}
	
	/**
	 * Add or overwrite an header parameter header 
	 *
	 * @param string 			$key
	 * @param string 			$value
	 * @return void
	 */
	public function header( $key, $value )
	{
		$this->headers[ucfirst($key)] = $value;
	}
	
	/**
	 * Build a header string based on the current object
	 *
	 * @return string
	 */
	public function buildHeaderString()
	{
		$lines = [];
		
		// response status 
		$lines[] = "HTTP/1.1 ".$this->status." ".static::$statusCodes[$this->status];
		
		// add the headers
		foreach( $this->headers as $key => $value )
		{
			$lines[] = $key.": ".$value;
		}
		
		return implode( " \r\n", $lines )."\r\n\r\n";
	}
	
	/**
	 * Create a string out of the response data
	 *
	 * @return string
	 */
	public function __toString()
	{
		return $this->buildHeaderString().$this->body();
	}
}