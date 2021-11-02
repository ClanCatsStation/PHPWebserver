#!/usr/bin/env php
<?php

/*
 *---------------------------------------------------------------
 * Pure php webserver
 *---------------------------------------------------------------
 *
 * This is the source code for the tutorial:
 */

use ClanCats\Station\PHPServer\Server;
use ClanCats\Station\PHPServer\Request;
use ClanCats\Station\PHPServer\Response;

require 'vendor/autoload.php';

$cliOption = getopt("p:", ['port:']);

// the next argument should be the port if not use 8000
if (count($cliOption) === 0) {
	$port = 8000;
} else {
	$port = $cliOption['port'] ?? $cliOption['p'];
}

// create a new server instance
$server = new Server('127.0.0.1', $port);

// start listening
$server->listen(function (Request $request) {
	// print information that we recived the request
	echo $request->method() . ' ' . $request->uri() . "\n";

	// return a response containing the request information
	return new Response('<pre>' . print_r($request, true) . '</pre>');
});
