<?php
namespace MyApp;
ob_start();
require_once 'init.php';
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use lib\vendor\sessionmanger;
use lib\vendor\class_factory;
use MyApp\helpers\allowed;
use MyApp\helpers\connection;
use MyApp\helpers\message;
class handle implements MessageComponentInterface
{
	use sessionmanger,allowed,connection,message;
	public function __construct() {
		sessionmanger::start();
		// $this->connections = new \SplObjectStorage;
	}

	public function onOpen(ConnectionInterface $connection) {
		$this->request = $this->handle_query($connection);
		if($this->is_allowed_request($this->request)){
			$this->register_connection($connection);
		}else{
			$this->onClose($connection);
		}
	}

	public function onClose(ConnectionInterface $connection) {
		$this->unset_connection($connection);
	}

	public function onMessage(ConnectionInterface $from,  $data) {
		if($this->is_register_connection($from)){
			$this->request = $this->handle_query($from);

			// Check If Message Has Target And Is Valid Target
			// Then Route Client Message To Target Instance :)
			$connect_db = class_factory::create_instance("lib\database\db_connection");
			$this->message($this->request['type'],$data) ? class_factory::create_instance("MyApp\\$this->instance",[$this->connections,$from,$this->data]) : $this->onClose($from);
			
			// Con Is A Global Variable That Store DB Connection
			$con = null; //Close Connection
		}else{
			$this->unset_connection($from);
		}
	}

	public function onError(ConnectionInterface $connection, \Exception $e) {
		$this->onClose($connection);
	}
}
ob_end_flush();