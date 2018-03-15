<?php

namespace App\Http\Controllers;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Auth;
class Controller extends BaseController
{
    use DispatchesJobs, ValidatesRequests;


    private $lang;
	 public $user;
    public $title;
    public function __construct()
    {
        $this->middleware('enter');
        $this->languages = config("app.languages");
        $this->lang = \Session::get('lang');
        $this->setTitle('Title not stated');

        if(Auth::check())
        {
            $this->user = Auth::user();
            $this->user->username =str_replace('script','',$this->user->username);

            view()->share('u', $this->user);
        }

    }


    public function setTitle($title)
    {

        $this->title = $title;
        view()->share('title', $this->title);
    }

	
	
	
}
