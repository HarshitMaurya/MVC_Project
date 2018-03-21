<?php

namespace Controller;

session_start();


class LogoutController
{
    function get(){
        session_unset();
        session_destroy();
        header("location:/");
    }
}