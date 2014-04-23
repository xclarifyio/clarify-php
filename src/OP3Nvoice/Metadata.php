<?php

namespace OP3Nvoice;

class Metadata extends Client
{
    public function load($id)
    {
        echo __CLASS__ . ' - ' . $id;
    }
}