<?php
class Session {

protected $sessionID;

public function __construct(){
    if( !isset($_SESSION) ){
        $this->init_session();
    }
}

public function init_session(){
    session_start();
}

public function get_session_id(){
    return session_id();
}

public function session_exist( $session_name){
    return isset($_SESSION[$session_name]);
}

public function set_session($key,$value){
	$_SESSION[$key]=$value;
}

public function get_session($key){
	return $_SESSION[$key];
}

public function destroySession(){
	if( !isset($_SESSION) )
	{ session_start();}
	session_destroy();
}

}
?>