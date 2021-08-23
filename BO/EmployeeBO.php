<?php
require_once './DAO/EmployeeDAO.php';
class EmployeeBO {
    public $dao;

    public function __construct(){
        try {
            $this->dao = new EmployeeDAO();
        } catch (Exception $e) {
            echo "PDO error connection, try again later";
            file_put_contents("PDOerrors.txt",$e->getMessage(), FILE_APPEND);
        }
    }

    public function getEmployees(){
        $results = $this->dao->getEmployees();

        return $results;
    }

    public function getLastHired(){
        $results = $this->dao->getLastHired();

        return $results;
    }
    public function getDataEmployee($empNo){
        $result = $this->dao->getDataEmp($empNo);

        return $result;
    }
    public function insertEmployee($firstName, $lastName, $birthDate, $gender, $title, $salary, $deptNo){
        $lastEmp = $this->dao->getLastEmp();
        $newEmpNo = $lastEmp->emp_no + 1;
        $insertEmp = $this->dao->insertEmp($newEmpNo,$firstName, $lastName, $birthDate, $gender);
        $insertDept = $this->dao->insertEmpDepart($newEmpNo,$deptNo);
        $insertTitle = $this->dao->insertTitleEmp($newEmpNo, $title);
        $insertSalary = $this->dao->insertSalary($newEmpNo, $salary);

        return true;
    }
}

?>