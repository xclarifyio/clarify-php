<?php

namespace OP3Nvoice;

class Tracks extends Client
{
    public function load($id)
    {
        echo __CLASS__ . ' - ' . $id;
    }
}