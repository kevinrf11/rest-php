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
      case 'getAll':
         $results = $employeeBO->getEmployees();
         echo json_encode($results, JSON_UNESCAPED_UNICODE);
         //echo json_encode("Servicio temporalmente fuera", JSON_UNESCAPED_UNICODE);
         break;
      case 'getLast':
         $results = $employeeBO->getLastHired();
         echo json_encode($results, JSON_UNESCAPED_UNICODE);
         break;
      case 'getDataEmp':
         $empNo = $_GET["empNo"];
         $result = $employeeBO->getDataEmployee($empNo);
         echo json_encode($result, JSON_UNESCAPED_UNICODE);
         break;
      case 'newEmp':
         $firstName = $_POST["firstName"];
         $lastName = $_POST["lastName"];
         $gender = $_POST["gender"];
         $birthDate = $_POST["birthDate"];
         $result = $employeeBO->insertEmployee($firstName, $lastName, $birthDate, $gender);

         //echo json_encode(array($firstName, $lastName, $gender,$birthDate), JSON_UNESCAPED_UNICODE);
         echo json_encode($result, JSON_UNESCAPED_UNICODE);
         break;
      default:
         echo json_encode("Error en el servicio, servicio no encontrado");
         break;
   }
} catch (Exception $e) {
   echo "Error en el controller";
   file_put_contents("Ctrlerrors.txt",$e->getMessage(), FILE_APPEND);
}
