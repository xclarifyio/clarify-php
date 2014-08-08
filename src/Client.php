<?php

namespace OP3Nvoice;

use Guzzle\Http;
use OP3Nvoice\Exceptions\InvalidEnumTypeException;
use OP3Nvoice\Exceptions\InvalidIntegerArgumentException;
use OP3Nvoice\Metadata;
use OP3Nvoice\Tracks;
use OP3Nvoice\Exceptions\InvalidJSONException;
use OP3Nvoice\Exceptions\InvalidResourceException;

abstract class Client extends \Clarify\Client { }
