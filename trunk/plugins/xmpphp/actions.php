<?php
require_once 'XMPPHP/XMPP.php';
class jabber {
    var $conn;
    public function __construct() {
        global $jabber_srv,$jabber_port,$jabber_login,$jabber_pwd,$jabber_area;
        $this->conn = new XMPP($jabber_srv, $jabber_port, $jabber_login, $jabber_pwd, 'xmpphp', $jabber_area, $printlog=False, $loglevel=LOGGING_INFO);
        $this->conn->connect();
        $this->conn->processUntil('session_start');
    }
    function send($to,$msg) {
        $this->conn->message($to, $msg);
    }
    public function __destruct() {
        $this->conn->disconnect();
    }
}
?>
