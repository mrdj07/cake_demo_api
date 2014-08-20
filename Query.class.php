<?php

/**
 * Class Query
 *
 * Executes queries.
 */
class Query{

    private $host;
    private $user;
    private $password;
    private $db;
    private $link;

    /**
     * @param string $host
     * @param string $user
     * @param string $password
     * @param string $db
     */
    function __construct($host = '127.0.0.1', $user = 'root', $password = '', $db = 'cakemail'){
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
        $this->db= $db;

        $this->connect();
    }

    /**
     * @throws Exception
     * Connects to the database.
     */
    private function connect(){
        $this->link = @mysql_connect($this->host, $this->user, $this->password);
        if (!$this->link) {
            throw new Exception(mysql_error(), 500);
        }
        if(!mysql_select_db($this->db, $this->link)){
            throw new Exception("Could not select database.", 500);
        }
    }

    /**
     * @param $baseQuery Query to be executed
     * @param array $params Parameters to replace placeholders in query
     * @param string $type Type of query (Select, Update, Delete, Insert)
     * @return int|mixed Returns how many affected rows, or array of results
     * @throws Exception
     * Executes a query.
     */
    public function execute($baseQuery, $params = array(), $type = 'SELECT'){
        foreach($params as $key=> $value){
            if($key[0] != ":"){
                throw new Exception('Invalid parameter.', 500);
            }
            $params[$key] = mysql_real_escape_string($value);
        }
        $query = strtr($baseQuery, $params);

        $result = mysql_query($query);

        if (!$result) {
            throw new Exception('Query error.', 500);
        }

        if($type == 'UPDATE' || $type == 'DELETE'){
            return mysql_affected_rows($this->link);
        }elseif($type == 'INSERT'){
            return mysql_insert_id($this->link);
        }else{
            for($i = 0; $data[$i] = mysql_fetch_assoc($result); $i++);
            array_pop($data);
            if(count($data) == 1){
                return array_pop($data);
            }else{
                return $data;
            }
        }
    }

    public function close(){
        mysql_close($this->link);
    }
}
