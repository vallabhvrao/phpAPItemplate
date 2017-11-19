<?php

//------------------------------------------------------------------------------ Field Details Class
class userClass {

    public $api;
    public $debugMode = false;


// Private functions
    private function generateRandomToken(){
        return substr(md5(rand(999, 999999)), 0, 8);
    }

    private function getUserIdFromAuthToken($authToken){
        $resp = array();
        try {

            $query = "select userId from users where authToken = :authToken";
            $rs = $this->api->prepare($query);
            $rs->bindValue(":authToken", $authToken);
            $rs->execute();
            
            if ($rs->rowCount() == 0) {
                $resp['status'] = "error";
                $resp['message'] = '[{"status" : "error", "message" : "Invaid User Auth Token"}]';
            } else {
                $rs_row = $rs->fetch(PDO::FETCH_ASSOC);
                $resp['status'] = "success";
                $resp['userId'] = $rs_row['userId'];
            }

        } catch(PDOException $e) {
            $resp['status'] = "error";
            $resp['message']='[{"status":"error","message":"' . preg_replace("/[\r\n]+/", " ", $e->getMessage()) . '"}]';

        } finally {
            return $resp;
        }
    }

    private function form_validated() {
        return true;
    }

    private function valid_user($user){
        try{
            $query = "SELECT COUNT( * ) FROM usesrs WHERE userId =:id AND authToken = :token";
            $rs = $this->api->prepare($query);
            $rs->bindValue(":id",$user['id']);
            $rs->bindValue(":token",$user['token']);
            $rs->execute();
            if ($rs->rowCount() == 0) 
                return 0;
            else 
                return 1;
        } catch (PDOException $e) {
            $this->log_errors_in_file($e->getMessage());
            return 0;
        }
    }

    private function log_errors_in_file($log_message){
        try {
            $logs = fopen("error.log", "a") or die("Unable to open file!");
            fwrite($logs, $log_message);
            fclose($logs);
        } catch (PDOException $e) {
            return 0;
        }
    }

    private function generateActivationToken($emailId){
        $token = $this->generateRandomToken();
        try {
            $query = "UPDATE `evaluators` SET `status`=:status,`activationToken`=:activationToken WHERE emailId = :emailId";
            $rs = $this->api->prepare($query);
            $rs->bindValue(":emailId", $emailId);
            $rs->bindValue(":status", 0);
            $rs->bindValue(":activationToken", $token);
            $rs->execute();
            return $token;
        } catch (PDOException $e) {
            $token = $this->log_errors_in_file($e->getMessage());
        }
    }

    private function error_cought($e){
        return '[{"status":"error","message":"' . preg_replace("/[\r\n]+/", " ", $e->getMessage()) . '"}]'
    }


// Public functions
    public function validate_UserEmail($emailId) {
        try {
            $query = "select emailId from users where emailId = :emailId";
            $rs = $this->api->prepare($query);
            $rs->bindValue(":emailId", $emailId);
            $rs->execute();
            if ($rs->rowCount() != 0) {
                return '[{"status" : "error", "message" : "This Email-id already registered."}]';
            } else {
                return '[{"status":"success", "message" : "Available"}]';
            }
        } catch (PDOException $e) {
            return $this->error_cought($e);
        }
    }

    public function register($values) {
        try {
            $validation_message = $this->form_validated();
            if ($validation_message != "ok") {
                return '[{"status" : "error", "message" : "' . $validation_message . '"}]';
            }

            $hashed_password = password_hash($values['password'], PASSWORD_DEFAULT);

            $values_list=":emailId,:firstName,:lastName,:password";
            $fields_list="emailId,firstName,lastName,password";
            $query = "insert into users ($fields_list) values($values_list)";
            $rs = $this->api->prepare($query);
            $rs->bindValue(":emailId",$values['emailId']);
            $rs->bindValue(":firstName",$values['firstName']);
            $rs->bindValue(":lastName",$values['lastName']);
            $rs->bindValue(":password",$hashed_password);
            $rs->execute();
 
            return '[{"status" : "success", "message" : "Thank you for registering"}]';
        } catch (PDOException $e) {
            return $this->error_cought($e);
        }
    }

    public function login($emailId, $password) {
        try {
            $query = "select users.* from users where emailId = :emailId";
            $rs = $this->api->prepare($query);
            $rs->bindValue(":emailId", $emailId);
            $rs->execute();
            
            if ($rs->rowCount() == 0) {
                return '[{"status" : "error","message":"Invaid Email-ID/Password."}]';
            }

            $rs_row = $rs->fetch(PDO::FETCH_ASSOC);
            if (!password_verify($password, $rs_row['password'])) {
                return '[{"status" : "error","message":"Invaid Email-ID/Password."}]';
            }

            $user_data = array();
            $user_data['id'] = $rs_row['userId'];
            $user_data['emailId'] = $rs_row['emailId'];
            $user_data['firstName'] = $rs_row['firstName'];
            $user_data['lastName'] = $rs_row['lastName'];

            $token = $this->generateRandomToken();
            $query = "update evaluators set authToken = :authToken where userId = :userId";
            $rs=$this->api->prepare($query);
            $rs->bindValue(":authToken", $token);
            $rs->bindValue(":userId", $rs_row['userId']);
            $rs->execute();
            
            $user_data['authToken'] = $token;

            $user_data = json_encode($user_data);

            return '[{"status" : "success", 
                    "userData":'.$user_data.'}]';

        } catch (PDOException $e) {
            return $this->error_cought($e);
        }
    }

    public function logout() {
        try {
            $query = "UPDATE `users` SET `status`=:status,`activationToken`=:activationToken WHERE emailId = :emailId";
            $rs = $this->api->prepare($query);
            $rs->bindValue(":emailId", $emailId);
            $rs->bindValue(":status", 0);
            $rs->bindValue(":activationToken", NULL);
            $rs->execute();
            return $token;
        } catch (PDOException $e) {
            $token = $this->log_errors_in_file($e->getMessage());
            return $this->error_cought($e);
        }
    }

    public function get_bills($bill_no,$user) {
        try{

            if(!$this->valid_user($user)){
                return '[{"status" : "error", "data" : "Auth Failed"}]';
            }

            $query = "SELECT * from bills where bill_no = :bill_no";
            $rs = $this->api->prepare($query);
            $rs->bindValue(":bill_no",$bill_no);
            $rs->execute();
            $data = json_encode($rs->fetchAll(PDO::FETCH_ASSOC));
            return '[{"status" : "success", "data" : ' . $data . '}]';

        } catch (PDOException $e) {
            return $this->error_cought($e);
        }
    }
    
}
