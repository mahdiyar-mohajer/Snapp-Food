<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Session\SessionManager;
use Symfony\Component\HttpFoundation\Response;

class StartSession
{
    protected $session;

    public function __construct(Application $application)
    {
        $this->session = $application['session'];
    }

    public function handle(Request $request)
    {
        $this->session->start();

        return $request;
    }
}
