<?php

namespace App\Controller;

class SessionController extends AbstractController
{
    public function __construct()
    {
        parent::__construct();

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
}
