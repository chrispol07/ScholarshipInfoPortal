<?php
ob_start();
date_default_timezone_set("Asia/Manila");

$action = $_GET['action'];
include 'admin_class.php';
$crud = new Action();
if($action == 'login'){
	$login = $crud->login();
	if($login)
		echo $login;
}
if($action == 'login2'){
	$login = $crud->login2();
	if($login)
		echo $login;
}
if($action == 'logout'){
	$logout = $crud->logout();
	if($logout)
		echo $logout;
}
if($action == 'signup'){
	$save = $crud->signup();
	if($save)
		echo $save;
}
if($action == 'save_user'){
	$save = $crud->save_user();
	if($save)
		echo $save;
}
if($action == 'update_user'){
	$save = $crud->update_user();
	if($save)
		echo $save;
}
if($action == 'delete_user'){
	$save = $crud->delete_user();
	if($save)
		echo $save;
}
if($action == 'save_course'){
	$save = $crud->save_course();
	if($save)
		echo $save;
}
if($action == 'delete_course'){
	$save = $crud->delete_course();
	if($save)
		echo $save;
}
if($action == 'save_year'){
	$save = $crud->save_year();
	if($save)
		echo $save;
}
if($action == 'delete_year'){
	$save = $crud->delete_year();
	if($save)
		echo $save;
}
if($action == 'save_events'){
	$save = $crud->save_events();
	if($save)
		echo $save;
}
if($action == 'delete_events'){
	$save = $crud->delete_events();
	if($save)
		echo $save;
}
if($action == 'save_criteria'){
	$save = $crud->save_criteria();
	if($save)
		echo $save;
}
if($action == 'delete_criteria'){
	$save = $crud->delete_criteria();
	if($save)
		echo $save;
}
if($action == 'save_question'){
	$save = $crud->save_question();
	if($save)
		echo $save;
}
if($action == 'delete_question'){
	$save = $crud->delete_question();
	if($save)
		echo $save;
}

if($action == 'save_criteria_order'){
	$save = $crud->save_criteria_order();
	if($save)
		echo $save;
}

if($action == 'save_question_order'){
	$save = $crud->save_question_order();
	if($save)
		echo $save;
}
if($action == 'save_org'){
	$save = $crud->save_org();
	if($save)
		echo $save;
}
if($action == 'delete_org'){
	$save = $crud->delete_org();
	if($save)
		echo $save;
}
if($action == 'save_student'){
	$save = $crud->save_student();
	if($save)
		echo $save;
}
if($action == 'delete_student'){
	$save = $crud->delete_student();
	if($save)
		echo $save;
}
if($action == 'save_restriction'){
	$save = $crud->save_restriction();
	if($save)
		echo $save;
}
if($action == 'save_evaluation'){
	$save = $crud->save_evaluation();
	if($save)
		echo $save;
}

if($action == 'get_evaluation'){
	$get = $crud->get_evaluation();
	if($get)
		echo $get;
}
if($action == 'get_report'){
	$get = $crud->get_report();
	if($get)
		echo $get;
}
ob_end_flush();
?>
