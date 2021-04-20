<?php
use Carbon\Carbon;
class Home extends Controller{
   public function index()
   {
      $time = "Now: %s" . Carbon::now();
      $str = new \Str\Str('quang ba0');
      $str = (string)$str->delimit('-');
      $this->view('includes/gual/main' , ['Page' => 'gual/main' , 'time' => $time , 'slug' => $str]);
   }
}