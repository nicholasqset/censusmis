<?php

/**
 * Description of Controller
 *
 * @author nicholasgakumo@gmail.com
 */

class Controller {

    public function save() {
        global $db;
//        var_dump($db);
//        $db->debug = 1;

        $data = array();

        $firstname = filter_input(INPUT_POST, 'firstname');
        $middlename = filter_input(INPUT_POST, 'middlename');
        $lastname = filter_input(INPUT_POST, 'lastname');
        $dob = filter_input(INPUT_POST, 'dob');
        $gender = filter_input(INPUT_POST, 'gender');
        $nationalid = filter_input(INPUT_POST, 'nationalid');
        $location = filter_input(INPUT_POST, 'location');

        $orm = new ADODB_Active_Record('census', array("ID"), $db);
        
        $orm->firstname = $firstname;
        $orm->middlename = $middlename;
        $orm->lastname = $lastname;
        $orm->dob = $dob;
        $orm->gender = $gender;
        $orm->nationalid = $nationalid;
        $orm->location = $location;

        if (!$orm->Save()) {
            $data['status'] = 0;
            $data['message'] = 'Fail: ' . $orm->ErrorMsg();
        } else {
            $data['status'] = 1;
            $data['message'] = 'Success';


        }

        return json_encode($data);
    }

    public function update() {
        global $db;
//        var_dump($db);
//        $db->debug = 1;

        $data = array();

        $id = filter_input(INPUT_POST, 'id');
        $firstname = filter_input(INPUT_POST, 'firstname');
        $middlename = filter_input(INPUT_POST, 'middlename');
        $lastname = filter_input(INPUT_POST, 'lastname');
        $dob = filter_input(INPUT_POST, 'dob');
        $gender = filter_input(INPUT_POST, 'gender');
        $nationalid = filter_input(INPUT_POST, 'nationalid');
        $location = filter_input(INPUT_POST, 'location');

        $orm = new ADODB_Active_Record('census', array("ID"), $db);
        $orm->Load('id='.$id);
        
        $orm->firstname = $firstname;
        $orm->middlename = $middlename;
        $orm->lastname = $lastname;
        $orm->dob = $dob;
        $orm->gender = $gender;
        $orm->nationalid = $nationalid;
        $orm->location = $location;

        if (!$orm->Save()) {
            $data['status'] = 0;
            $data['message'] = 'Fail: ' . $orm->ErrorMsg();
        } else {
            $data['status'] = 1;
            $data['message'] = 'Success';


        }

        return json_encode($data);
    }
    
    public function delete() {
        global $db;
        $id = filter_input(INPUT_POST, 'id');
        $delete = $db->Execute("DELETE FROM census where id = ".$id);
        if (!$delete->Save()) {
            $data['status'] = 0;
            $data['message'] = 'Fail: ' . $db->ErrorMsg();
        } else {
            $data['status'] = 1;
            $data['message'] = 'Success';
        }
        return json_encode($data);
    }
    
}
