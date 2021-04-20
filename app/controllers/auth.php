<?php
class auth extends Controller
{
    public function index()
    {
        $this->view('users/index', ['Page' => 'includes/users/login']);
    }
    public function login()
    {
        $this->view('users/index', ['Page' => 'includes/users/login']);
    }
    public function register()
    {
        $this->view('users/index', ['Page' => 'includes/users/login']);
    }

}