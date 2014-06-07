<?php

namespace OP3Nvoice;

/**
 * @deprecated Deprecated since version 0.8, to be removed in 1.0.
 */
class Audio extends Client
{
    public function __construct($key)
    {
        parent::__construct($key);

        trigger_error("\\OP3Nvoice\\Audio has been deprecated in v0.8 and will be removed by v1.0. Please use \\OP3Nvoice\\Bundle instead.", E_USER_NOTICE);
    }
}