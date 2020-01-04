<?php
class Encrypt_model extends CI_Model {

        function encrypt($password){
            return sha1($password);
        }
}

?>