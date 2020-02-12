<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    private $title;
	private $message;
	private $image_url;
	private $data;
	private $type;

	function __construct(){

	}

	public function setTitle($title){
		$this->title = $title;
	}

	public function setMessage($message){
		$this->message = $message;
	}

	public function setImage($imageUrl){
		$this->image_url = $imageUrl;
	}


	public function setType($type){
		$this->type = $type;
	}


	public function setPayload($data){
		$this->data = $data;
	}

	public function getNotification(){
		$notification 				= array();
		$notification['title'] 		= $this->title;
		$notification['message'] 	= $this->message;
		$notification['image'] 		= $this->image_url;
		$notification['type'] 		= $this->type;
		return $notification;
	}
}
