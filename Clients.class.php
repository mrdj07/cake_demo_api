<?php

require_once("Query.class.php");
/**
 * Class Clients
 *
 * Clients Controller
 */
class Clients{
    /**
     * @return array
     * GET /clients
     * Returns the list of clients in JSON.
     */
    public function doList(){
        try{
            $query = new Query();
            $data = $query->execute("SELECT * FROM Clients;");
            $query->close();
            if(count($data) > 0){
                return $this->returnData(200, 'application/json', '', $data);
            }else{
                return $this->returnData(404, 'application/json', '');
            }
        }catch(Exception $e){
            return $this->returnData($e->getCode(), 'application/json', $e->getMessage());
        }
	}

    /**
     * @param int $clientId
     * @return array
     * GET /clients/{clientId}
     * Returns the client's information in JSON.
     */
    public function doGet($clientId = NULL){
        if($clientId){
            try{
                $query = new Query();
                $data = $query->execute("SELECT * FROM Clients where id=:id;", array(':id' => $clientId));
                $query->close();
                if(count($data) > 0){
                    return $this->returnData(200, 'application/json', '', $data);
                }else{
                    return $this->returnData(404, 'application/json', 'No entry found.');
                }
            }catch(Exception $e){
                return $this->returnData($e->getCode(), 'application/json', $e->getMessage());
            }
        }else{
            return $this->returnData(400, 'application/json', 'Missing parameter.');
        }
	}

    /**
     * @param int $clientId
     * @return array
     * PUT /clients/{clientId}
     * Returns the id of the client in JSON.
     */
	public function doSet($clientId = NULL){
        if($clientId){
            try{
                $queryData = $this->validate($this->getData('_PUT'));
                $query = new Query();
                $affectedRows = $query->execute("UPDATE Clients SET firstname=':firstname', lastname=':lastname' where id=:id;", array(':id' => $clientId, ':firstname' => $queryData['firstname'], ':lastname' => $queryData['lastname']), 'UPDATE');
                $query->close();
                if($affectedRows == 0){
                    return $this->returnData(400, 'application/json', 'No rows affected.');
                }else{
                    return $this->returnData(200, 'application/json', '', array('id' => $clientId));
                }
            }catch(Exception $e){
                return $this->returnData($e->getCode(), 'application/json', $e->getMessage());
            }
        }else{
            return $this->returnData(400, 'application/json', 'Missing parameter.');
        }
	}

    /**
     * @return array
     * POST /clients/
     * Returns the id of the client in JSON.
     */
	public function doCreate(){
        try{
            $queryData = $this->validate($this->getData('_POST'));
            $query = new Query();
            $lastId = $query->execute("INSERT INTO Clients(firstname, lastname) VALUES (':firstname',':lastname');", array(':firstname' => $queryData['firstname'], ':lastname' => $queryData['lastname']), 'INSERT');
            $query->close();
            return $this->returnData(200, 'application/json', '', array('id' => $lastId));
        }catch(Exception $e){
            return $this->returnData($e->getCode(), 'application/json', $e->getMessage());
        }
	}

    /**
     * @param int $clientId
     * @return array
     * DELETE /clients/{clientId}
     * Returns the id of the client in JSON.
     */
	public function doDelete($clientId = NULL){
        if($clientId){
            try{
                $query = new Query();
                $affectedRows = $query->execute("DELETE FROM Clients where id=:id;", array(':id' => $clientId), 'DELETE');
                $query->close();
                if($affectedRows == 0){
                    return $this->returnData(400, 'application/json', 'No rows affected.');
                }else{
                    return $this->returnData(200, 'application/json', '', array('id' => $clientId));
                }
            }catch(Exception $e){
                return $this->returnData($e->getCode(), 'application/json', $e->getMessage());
            }
        }else{
            return $this->returnData(400, 'application/json', 'Missing parameter.');
        }
	}

    /**
     * @param $data
     * @return array
     * @throws Exception
     * Validates if the sent data fits with the Client model.
     */
    private function validate($data){
        $validation = array('firstname' => 'string', 'lastname' => 'string');
        $matches = 0;
        $validated = array();
        foreach($data as $key => $value){
            if(array_key_exists($key, $validation)){
                switch($validation[$key]){
                    case "string":
                        if(is_string($value)){
                            $validated[$key] = stripslashes($value);
                            $matches++;
                        }
                        break;
                    case "int":
                        if(is_numeric($value)){
                            $validated[$key] = stripslashes($value);
                            $matches++;
                        }
                        break;
                }
            }
        }
        if($matches != count($validation)){
            throw new Exception('Invalid data', 400);
        }else{
            return $validated;
        }
    }

    /**
     * @param $type
     * @return array
     * Gets the data according to the Request type.
     */
    private function getData($type){
        parse_str(file_get_contents('php://input'), $vars);
        $GLOBALS[$type] = $vars;
        return $vars;
    }

    /**
     * @param $code HTTP Response Code
     * @param $type Content-Type
     * @param string $message Response Message
     * @param string $data Response Data
     * @return array
     * Returns data formatted for the Response class.
     */
    private function returnData($code, $type, $message = '', $data = ''){
        return array('code' => $code, 'type'=> $type, 'message' => $message, 'data' => $data);
    }
}
