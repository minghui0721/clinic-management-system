<?php
session_start();
ini_set('display_errors', 1);
Class Action {
	private $db;

	public function __construct() {
		ob_start();
   	include 'db_connect.php';
    
    $this->db = $conn;
	}
	function __destruct() {
	    $this->db->close();
	    ob_end_flush();
	}

	function login(){
		extract($_POST);
		$qry = $this->db->query("SELECT * FROM users where username = '".$username."' and password = '".$password."' ");
		if($qry->num_rows > 0){
			foreach ($qry->fetch_array() as $key => $value) {
				if($key != 'passwors' && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
				return 1;
		}else{
			return 3;
		}
	}
	function login2(){
		extract($_POST);
		$qry = $this->db->query("SELECT * FROM users where username = '".$email."' and password = '".md5($password)."' ");
		if($qry->num_rows > 0){
			foreach ($qry->fetch_array() as $key => $value) {
				if($key != 'passwors' && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
				return 1;
		}else{
			return 3;
		}
	}
	function logout(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:login.php");
	}
	function logout2(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:../index.php");
	}

	function save_user(){
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", username = '$username' ";
		$data .= ", password = '$password' ";
		$data .= ", type = '$type' ";
		if(empty($id)){
			$save = $this->db->query("INSERT INTO users set ".$data);
		}else{
			$save = $this->db->query("UPDATE users set ".$data." where id = ".$id);
		}
		if($save){
			return 1;
		}
	}
	function signup(){
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", contact = '$contact' ";
		$data .= ", address = '$address' ";
		$data .= ", username = '$email' ";
		$data .= ", password = '".md5($password)."' ";
		$data .= ", type = 3";
		$chk = $this->db->query("SELECT * FROM users where username = '$email' ")->num_rows;
		if($chk > 0){
			return 2;
			exit;
		}
			$save = $this->db->query("INSERT INTO users set ".$data);
		if($save){
			$qry = $this->db->query("SELECT * FROM users where username = '".$email."' and password = '".md5($password)."' ");
			if($qry->num_rows > 0){
				foreach ($qry->fetch_array() as $key => $value) {
					if($key != 'passwors' && !is_numeric($key))
						$_SESSION['login_'.$key] = $value;
				}
			}
			return 1;
		}
	}

	function save_settings(){
		extract($_POST);
		$data = " name = '".str_replace("'","&#x2019;",$name)."' ";
		$data .= ", email = '$email' ";
		$data .= ", contact = '$contact' ";
		$data .= ", about_content = '".htmlentities(str_replace("'","&#x2019;",$about))."' ";
		if($_FILES['img']['tmp_name'] != ''){
						$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
						$move = move_uploaded_file($_FILES['img']['tmp_name'],'../assets/img/'. $fname);
					$data .= ", cover_img = '$fname' ";

		}
		
		// echo "INSERT INTO system_settings set ".$data;
		$chk = $this->db->query("SELECT * FROM system_settings");
		if($chk->num_rows > 0){
			$save = $this->db->query("UPDATE system_settings set ".$data);
		}else{
			$save = $this->db->query("INSERT INTO system_settings set ".$data);
		}
		if($save){
		$query = $this->db->query("SELECT * FROM system_settings limit 1")->fetch_array();
		foreach ($query as $key => $value) {
			if(!is_numeric($key))
				$_SESSION['setting_'.$key] = $value;
		}

			return 1;
				}
	}

	
	function save_category(){
		extract($_POST);
		$data = " name = '$name', description = '$description' ";
		if(!empty($_FILES['img']['tmp_name'])){
			$fname = strtotime(date("Y-m-d H:i"))."_".$_FILES['img']['name'];
			$move = move_uploaded_file($_FILES['img']['tmp_name'], '../assets/img/'.$fname);
			if($move){
				$data .=", img_path = '$fname' ";
			}
		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO medical_specialty SET ".$data);
		}else{
			$save = $this->db->query("UPDATE medical_specialty SET ".$data." WHERE id=".$id);
		}
		if($save)
			return 1;
	}

	
	function delete_category(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM medical_specialty where id = ".$id);
		if($delete)
			return 1;
	}


	function save_doctor(){
		extract($_POST);
		$data = " name = '$name' ";

		$data .= ", name_pref = '$name_pref' ";
		$data .= ", clinic_address = '$address' ";
		$data .= ", contact = '$contact' ";
		$data .= ", email = '$email' ";
		if(!empty($_FILES['img']['tmp_name'])){
			$fname = strtotime(date("Y-m-d H:i"))."_".$_FILES['img']['name'];
			$move = move_uploaded_file($_FILES['img']['tmp_name'], '../assets/img/'.$fname);
			if($move){
				$data .=", img_path = '$fname' ";
			}
		}
		$data .=" , specialty_ids = '[".implode(",",$specialty_ids)."]' ";
		if(empty($id)){
			$save = $this->db->query("INSERT INTO doctors_list set ".$data);
			$did= $this->db->insert_id;
		}else{
			$save = $this->db->query("UPDATE doctors_list set ".$data." where id=".$id);
		}
		
		if($save){
			$data = "doctor_id = '$did'";
			$data .= ", name = 'DR.$name, $name_pref'";
			$data .= ", address = '$address'";
			$data .= ", contact = '$contact'";
			$data .= ", username = '$email'";

			if (!empty($password)) {
				$data .= ", password = '" . $password ."' ";
			}
			$data .= ", type = 2";
	
			if(empty($did)){
				$chk = $this->db->query("SELECT * FROM users where username = '$email'")->num_rows;
				if($chk > 0){
					return 2; // Username already exists
					exit;
				}
				$save = $this->db->query("INSERT INTO users set ".$data);
			} else if (!empty($did)) {
				$chk = $this->db->query("SELECT * FROM users where username = '$email'")->num_rows;
				if($chk > 0){
					return 2; // Username already exists
					exit;
				} else{
					$save = $this->db->query("INSERT INTO users set ".$data);
					return 1;
				}
			}
			return 1; // Success
		} else {
			return 0; // Error saving doctor
		}
	}
	

	function delete_doctor(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM doctors_list where id = ".$id);
		if($delete)
			return 1;
	}

	function save_schedule(){
		extract($_POST);
		foreach($days as $k => $val){
			$data = " doctor_id = '$doctor_id' ";
			$data .= ", day = '$days[$k]' ";
			$data .= ", time_from = '$time_from[$k]' ";
			$data .= ", time_to = '$time_to[$k]' ";
			if(isset($check[$k])){
				if($check[$k]>0)
				$save[] = $this->db->query("UPDATE doctors_schedule set ".$data." where id =".$check[$k]);
			else
				$save[] = $this->db->query("INSERT INTO doctors_schedule set ".$data);
			}
		}

			if(isset($save)){
				return 1;
			}
	}



	function save_staff()
{
    extract($_POST);
    $data = " name = '$name' ";
    $data .= ", address = '$address' ";
    $data .= ", contact_number = '$contact' ";
    $data .= ", email = '$email' ";
    $data .= ", salary = '$salary' ";

    // Image upload
    $img_path = '';
    if (!empty($_FILES['img']['tmp_name'])) {
        $fname = strtotime(date("Y-m-d H:i")) . "_" . $_FILES['img']['name'];
        $move = move_uploaded_file($_FILES['img']['tmp_name'], '../assets/img/' . $fname);
        if ($move) {
            $data .= ", img_path = '$fname' ";
        }
    }

    if (empty($staff_id)) {
        $save = $this->db->query("INSERT INTO staff_list SET " . $data);
        $staff_id = $this->db->insert_id;
    } else {
        $save = $this->db->query("UPDATE staff_list SET " . $data . " WHERE staff_id = " . $staff_id);
    }

    if ($save) {
		$user_data = " doctor_id = 0 ";
		$user_data .= ", name = '$name' ";
		$user_data .= ", address = '$address' ";
		$user_data .= ", contact = '$contact' ";
		$user_data .= ", username = '$email' ";
	
		if (!empty($password)) {
			$user_data .= ", password = '" . $password . "' ";
		}
	
		$user_data .= ", type = 4 ";
	
		if (empty($staff_id)) {
			$chk = $this->db->query("SELECT * FROM users WHERE username = '$email'")->num_rows;
			if ($chk > 0) {
				return 2; // Email already exists
				exit;
			}
			$save_user = $this->db->query("INSERT INTO users SET " . $user_data);
		} else if (!empty($staff_id)) { // Changed to else if condition
			$check_existing_user = $this->db->query("SELECT * FROM users WHERE username = '$email'");
			if ($check_existing_user->num_rows > 0) {
				return 2; // Email already exists
				exit;
			} else {
				$save_user = $this->db->query("INSERT INTO users SET " . $user_data); // Moved here
				return 1;
			}
		}
	}
	
	return 0; // Failed
}	


	function delete_staff() {
		extract($_POST);
		$delete = $this->db->query("DELETE FROM staff_list WHERE staff_id = " . $staff_id);
		if($delete){
			return 1;
		} else{
			return 0;
		}
	}	
	




	function set_appointment()
{
    extract($_POST);
    $doc = $this->db->query("SELECT * FROM doctors_list WHERE id = " . $doctor_id);
    $schedule = date('Y-m-d', strtotime($date)) . ' ' . date('H:i', strtotime($time)) . ":00";
    $day = date('l', strtotime($date));
    $time = date('H:i', strtotime($time)) . ":00";
    $sched = date('H:i', strtotime($time));

    // Check if it's a new appointment or update
    $services = isset($_GET['id']) && !empty($_GET['id']) ? $_GET['services'] : $service_type;

    // Validate type of services field
    if (empty($services)) {
        return json_encode(array('status' => 2, "msg" => "Please select a type of service."));
        exit;
    }

    $doc_sched_check = $this->db->query("SELECT * FROM doctors_schedule WHERE doctor_id = $doctor_id AND day = '$day' AND ('$time' BETWEEN time_from AND time_to)");
    if ($doc_sched_check->num_rows <= 0) {
        return json_encode(array('status' => 2, "msg" => "Appointment schedule not valid for the selected doctor's schedule."));
        exit;
    }

    $data = " doctor_id = '$doctor_id' ";
    $data .= isset($patient_id) ? ", patient_id = '$patient_id' " : ", patient_id = '" . $_SESSION['login_id'] . "' ";
    $data .= ", schedule = '$schedule' ";
    $data .= ", services = '$services' ";

    if (isset($status)) {
        $data .= ", status = '$status' ";
    }

    if (isset($id) && !empty($id)) {
        $save = $this->db->query("UPDATE appointment_list SET " . $data . " WHERE id = " . $id);
    } else {
        $save = $this->db->query("INSERT INTO appointment_list SET " . $data);
    }

    if ($save) {
        return json_encode(array('status' => 1));
    }
}





	function delete_appointment(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM appointment_list where id = ".$id);
		if($delete)
			return 1;
	}
	
	

}