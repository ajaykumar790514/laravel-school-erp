<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
{
    public function unreadcontacts(){
    	 //$contacts=Contacts::::where('status', '=', '0')->get();
    	 $contacts=Contacts::where('status', '=', '0')->orderBy('id', 'desc')->get();
    	 return $contacts;
    }
}
