<?php
require_once './connection/DBConnection.php';

require_once './model/Employee.php';
require_once './model/Salary.php';
require_once './model/Title.php';

class EmployeeDAO{
    private $conn;
    public function __construct(){
        try {
            $database = new Connection();
            $db = $database->connect();
            $this->conn = $db;
        } catch (Exception $e) {
            echo $e->getMessage();
        }   
    }
    public function getEmployees(){
        try {
            $sql = 'SELECT * FROM employees;';
            $statement = $this->conn->query($sql);
            $listUsers = array();
            $statement->setFetchMode(PDO::FETCH_CLASS, "Employee");
            while ($row = $statement->fetch()) {
                array_push($listUsers, $row);
            }
            
            return $listUsers;
        } catch (Exception $e) {
            echo "PDO statement error";
            file_put_contents("Stmterrors.txt",$e->getMessage(), FILE_APPEND);
      }
    }

    public function getLastHired(){
        try {
            $sql = 'SELECT employees.emp_no, employees.first_name, employees.last_name, departments.dept_name, titles.title,salaries.salary, employees.hire_date FROM employees 
            INNER JOIN salaries ON employees.emp_no = salaries.emp_no
            INNER JOIN dept_emp ON dept_emp.emp_no = employees.emp_no
            INNER JOIN departments ON dept_emp.dept_no = departments.dept_no
            INNER JOIN titles ON titles.emp_no = employees.emp_no
            WHERE salaries.to_date > NOW() 
            AND salaries.from_date < NOW()
            AND titles.from_date < NOW()
            AND titles.to_date > NOW()
            AND dept_emp.to_date > NOW()
            AND dept_emp.from_date < NOW()
            ORDER BY employees.hire_date DESC
            LIMIT 50;';
            $statement = $this->conn->query($sql);
            $results = $statement->fetchAll(PDO::FETCH_ASSOC);
            
            return $results;
        } catch (Exception $e) {
            echo "PDO statement error";
            file_put_contents("Stmterrors.txt",$e->getMessage(), FILE_APPEND);
        }
    }

    public function getDataEmp($empNo){
        try {
            if (empty($empNo)) {
                throw new Exception("Error Processing Request, parameter is null", 1);
            }
            $sql = 'SELECT employees.emp_no, employees.first_name, employees.last_name, employees.gender,departments.dept_name, titles.title,salaries.salary, employees.hire_date, employees.birth_date FROM employees 
            INNER JOIN salaries ON employees.emp_no = salaries.emp_no
            INNER JOIN dept_emp ON dept_emp.emp_no = employees.emp_no
            INNER JOIN departments ON dept_emp.dept_no = departments.dept_no
            INNER JOIN titles ON titles.emp_no = employees.emp_no
            WHERE salaries.to_date > NOW() 
            AND salaries.from_date < NOW()
            AND titles.from_date < NOW()
            AND titles.to_date > NOW()
            AND dept_emp.to_date > NOW()
            AND dept_emp.from_date < NOW()
            AND employees.emp_no = :empNo
            LIMIT 1;';
            $statement = $this->conn->prepare($sql);
            $statement->execute(array("empNo"=>intval($empNo)));
            $result = $statement->fetch(PDO::FETCH_ASSOC);

            return $result;
        } catch (Exception $e) {
            //Show errors
            echo "PDO statement error";
            file_put_contents("Stmterrors.txt",$e->getMessage(), FILE_APPEND);
        }
    }
    public function getLastEmp(){
        try {
            $sql = "SELECT * FROM employees ORDER BY emp_no DESC LIMIT 1;";
            $statement = $this->conn->prepare($sql);
            $statement->execute();
            $employee = new Employee();
            $statement->setFetchMode(PDO::FETCH_INTO, $employee);
            $result = $statement->fetch();
            
            return $result;
        } catch (Exception $e) {
            echo "PDO statement error";
            file_put_contents("Stmterrors.txt",$e->getMessage(), FILE_APPEND);
        }
    }
    public function insertEmp($newEmpNo,$first_name, $last_name, $birth_date, $gender){
        try {
            if (empty($first_name) || empty($last_name) || empty($birth_date) || empty($gender)) {
                throw new Exception("Error Processing Request, parameter is null", 1);
            }
            $newEmp = new Employee(intval($newEmpNo), $first_name, $last_name, $birth_date,$gender, date('Y-m-d'));
            $statement = $this->conn->prepare("INSERT INTO employees(emp_no,first_name,last_name,birth_date,gender,hire_date) value(:emp_no,:first_name, :last_name, :birth_date, :gender, :hire_date);");
            $statement->execute((array)$newEmp);

            return $newEmp;
        } catch (Exception $e) {
            echo "PDO statement error";
            file_put_contents("Stmterrors.txt",$e->getMessage(), FILE_APPEND);
            return array($first_name, $last_name, $birth_date, $gender);
        }
    }
    public function insertSalary($empNo, $salary){
        try {
            if (empty($empNo) || empty($salary)) {
                throw new Exception("Error Processing Request, parameter is null", 1);
            }
            $newSal = new Salary(intval($empNo), intval($salary), date('Y-m-d'),'9999-01-01');
            $statement = $this->conn->prepare("INSERT INTO salaries(emp_no, salary, from_date, to_date) value (:emp_no, :salary, :from_date, :to_date);");
            $statement->execute((array)$newSal);

            return $newSal;
        } catch (Exception $e) {
            echo "PDO statement error";
            file_put_contents("Stmterrors.txt",$e->getMessage(), FILE_APPEND);
        }
    }
    public function insertEmpDepart($empNo, $deptNo){
        try {
            if (empty($empNo) || empty($deptNo)) {
                throw new Exception("Error Processing Request, parameter is null", 1);
            }
            $newDeptEmp = new stdClass();
            $newDeptEmp->emp_no = intval($empNo);
            $newDeptEmp->dept_no = $deptNo;
            $newDeptEmp->from_date = date('Y-m-d');
            $newDeptEmp->to_date = '9999-01-01';

            $statement = $this->conn->prepare("INSERT INTO dept_emp(emp_no, dept_no, from_date, to_date) value(:emp_no, :dept_no, :from_date, :to_date);");
            $statement->execute((array)$newDeptEmp);

            return $newDeptEmp;
        } catch (Exception $e) {
            echo "PDO statement error";
            file_put_contents("Stmterrors.txt",$e->getMessage(), FILE_APPEND);
        }
    }
    public function insertTitleEmp($empNo, $title){
        try {
            if (empty($empNo) || empty($title)) {
                throw new Exception("Error Processing Request, parameter is null", 1);
            }
            $newTitle = new Title(intval($empNo),$title, date('Y-m-d'),'9999-01-01');
            $statement = $this->conn->prepare("INSERT INTO titles(emp_no, title, from_date, to_date) value(:emp_no, :title, :from_date, :to_date);");
            $statement->execute((array)$newTitle);

            return $newTitle;
        } catch (Exception $e) {
            echo "PDO statement error";
            file_put_contents("Stmterrors.txt",$e->getMessage(), FILE_APPEND);
        }
    }
}
?>