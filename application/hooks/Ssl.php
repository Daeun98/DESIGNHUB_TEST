<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function redirect_ssl() {
    if(!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == ""){
		$redirect = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		header("Location: $redirect");
	}
}