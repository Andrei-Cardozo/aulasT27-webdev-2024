<?php
    class $conexaoDB {
        private $host;
        private $porta;
        private $userName;
        private $password;
        private $database;

        public function setHost($host) {
            $this->host =$host;
        }
        public function setPorta($porta) {
            $this->porta =$porta;
        }
        public function setUserName($userName){
            $this->userName =$userName;
        }
        public function setPassword($password){
            $this->password =$password;
        }
        public function setDatabase(){

        }
        public function conectar(){
            try {
                $this->dbconn = pg_connect($this->getConnectionString)
                if($this->dbconn){
                    return true;
                }
            } catch (Exception $e){

            } 
        } 
        private function getConnectionString(){
            return "host=". $this->host .
                    " port=". $this->porta .
                    " dbname=". $this->database .
                    " user=". $this->userName . 
                    " password=". $this->password . 
        }
    }
?>