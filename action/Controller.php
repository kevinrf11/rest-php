<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once './BO/EmployeeBO.php';

try {
   $employeeBO = new EmployeeBO();
   $uri = $_SERVER["REQUEST_URI"];
   $splitUri = explode("/",$uri);
   $action = explode("?", $splitUri[1]);

   switch ($action[0]) {
      case 'getLast':
         $results = $employeeBO->getLastHired();
         echo json_encode($results, JSON_UNESCAPED_UNICODE);
         break;
      case 'getDataEmp':
         $empNo = $_GET["empNo"];
         if (empty($empNo)) {
            echo json_encode("Employee number is null", JSON_UNESCAPED_UNICODE);
         }
         else{
            $result = $employeeBO->getDataEmployee($empNo);
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
         }
         break;
      case 'newEmp':
         $data = json_decode(file_get_contents('php://input'), true);
         $firstName = ($data["firstName"]);
         $lastName = ($data["lastName"]);
         $gender = ($data["gender"]);
         $birthDate = ($data["birthDate"]);
         $deptNo = ($data["deptNo"]);
         $salary = ($data["salary"]);
         $title = ($data["title"]);
         if (empty($firstName) ||empty($lastName) || empty($gender) || empty($birthDate) || empty($deptNo) || empty($salary) || empty($title) ) {
            echo json_encode("Missing parameters",JSON_UNESCAPED_UNICODE);
         } else {
            $result = $employeeBO->insertEmployee($firstName, $lastName, $birthDate, $gender, $title, $salary, $deptNo);
            echo json_encode($result, JSON_UNESCAPED_UNICODE);         
         }
         break;
      default:
         echo json_encode("404 not found");
         break;
   }
} catch (Exception $e) {
   echo "Controller error";
   file_put_contents("Ctrlerrors.txt",$e->getMessage(), FILE_APPEND);
}
