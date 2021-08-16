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
         break;
      case 'getLast':
         $results = $employeeBO->getLastHired();
         echo json_encode($results, JSON_UNESCAPED_UNICODE);
         break;
      case 'getDataEmp':
         $empNo = $_GET["empNo"];
         $result = $employeeBO->getDataEmployee($empNo);
         echo json_encode($result);
         break;
      default:
         echo json_encode("Error en el servicio, servicio no encontrado");
         break;
   }
} catch (Exception $e) {
   echo "Error en el controller";
   file_put_contents("Ctrlerrors.txt",$e->getMessage(), FILE_APPEND);
}
