<?php
require_once './model/Employee.php';
require_once './connection/DBConnection.php';

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
            $sql = 'SELECT * FROM employees';
            $statement = $this->conn->query($sql);
            $statement->setFetchMode(PDO::FETCH_CLASS, "Employee");
            $listUsers = array();
            while ($statement->fetch()) {
                $row = $statement->fetch();
                array_push($listUsers, $row);
            }
            
            return $listUsers;
        } catch (Exception $e) {
            //Show errors
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
            //Show errors
            echo "PDO statement error";
            file_put_contents("Stmterrors.txt",$e->getMessage(), FILE_APPEND);
        }
    }

    public function getDataEmp($emp_no){
        try {
            if (empty($emp_no)) {
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
            AND employees.emp_no = '.$emp_no.'
            LIMIT 1;';
            $statement = $this->conn->query($sql);
            $result = $statement->fetch(PDO::FETCH_ASSOC);

            return $result;
        } catch (Exception $e) {
            //Show errors
            echo "PDO statement error";
            file_put_contents("Stmterrors.txt",$e->getMessage(), FILE_APPEND);
        }
    }
}
?>