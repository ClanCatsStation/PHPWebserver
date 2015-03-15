<?php namespace ClanCats\Station\PHPServer;

use ClanCats\Station\PHPServer\Exception;

class Request 
{
	/**
	 * The request method
	 *
	 * @var string 
	 */
	protected $method = null;
	
	/**
	 * The requested uri
	 *
	 * @var string
	 */
	protected $uri = null;
	
	/**
	 * The request params
	 *
	 * @var array
	 */
	protected $parameters = [];
	
	/**
	 * The request params
	 *
	 * @var array
	 */
	protected $headers = [];
	
	/**
	 * Create new request instance using a string header
	 *
	 * @param string 			$header
	 * @return Request
	 */
	public static function withHeaderString( $header )
	{
		$lines = explode( "\n", $header );
		
		// method and uri
		list( $method, $uri ) = explode( ' ', array_shift( $lines ) );
		
		$headers = [];
		
		foreach( $lines as $line )
		{
			// clean the line
			$line = trim( $line );
			
			if ( strpos( $line, ': ' ) !== false )
			{
				list( $key, $value ) = explode( ': ', $line );
				$headers[$key] = $value;
			}
		}	
		
		// create new request object
		return new static( $method, $uri, $headers );
	}
	
	/**
	 * Request constructor
	 *
	 * @param string 			$method
	 * @param string 			$uri
	 * @param array 			$headers
	 * @return void
	 */
	public function __construct( $method, $uri, $headers = [] ) 
	{
		$this->headers = $headers;
		$this->method = strtoupper( $method );
		
		// split uri and parameters string
		@list( $this->uri, $params ) = explode( '?', $uri );

		// parse the parmeters
		parse_str( $params, $this->parameters );
	}
	
	/**
	 * Return the request method
	 *
	 * @return string
	 */
	public function method()
	{
		return $this->method;
	}
	
	/**
	 * Return the request uri
	 *
	 * @return string
	 */
	public function uri()
	{
		return $this->uri;
	}
	
	/**
	 * Return a request header
	 *
	 * @return string
	 */
	public function header( $key, $default = null )
	{
		if ( !isset( $this->headers[$key] ) )
		{
			return $default;
		}
		
		return $this->headers[$key];
	}
	
	/**
	 * Return a request parameter
	 *
	 * @return string
	 */
	public function param( $key, $default = null )
	{
		if ( !isset( $this->parameters[$key] ) )
		{
			return $default;
		}
		
		return $this->parameters[$key];
	}
}