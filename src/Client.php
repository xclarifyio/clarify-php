<?php

namespace OP3Nvoice;

use Guzzle\Http;
use OP3Nvoice\Exceptions\InvalidEnumTypeException;
use OP3Nvoice\Exceptions\InvalidIntegerArgumentException;
use OP3Nvoice\Metadata;
use OP3Nvoice\Tracks;
use OP3Nvoice\Exceptions\InvalidJSONException;
use OP3Nvoice\Exceptions\InvalidResourceException;

/**
 * This is the base class that all of the individual media-related classes extend. At the moment, it simply initializes
 *   the connection by setting the user agent and the base URI for the API calls.
 */
abstract class Client extends \Clarify\Client { }
