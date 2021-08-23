<?php
class Employee{
    public $birth_date;
    public $emp_no;
    public $first_name;
    public $last_name;
    public $gender;
    public $hire_date;

    function __construct($emp_no = null, $first_name = null, $last_name  = null, $birth_date = null, $gender = null, $hire_date = null ){
        if(isset($emp_no)){
            $this->emp_no = $emp_no;
        }
        if (isset($first_name)) {
            $this->first_name = $first_name;
        }
        if (isset($last_name)) {
            $this->last_name = $last_name;
        }
        if (isset($birth_date)) {
            $this->birth_date = $birth_date;
        }
        if (isset($gender)) {
            $this->gender = $gender;
        }
        if (isset($hire_date)) {
            $this->hire_date = $hire_date;
        }
    }
    public function __get($name){
        if (property_exists($this, $name)) {
            return $this->$name;
        }
    }
    public function __set($name, $value){
        if (property_exists($this, $name)) {
            $this->$name= $value;
        }

        return $this;
    }
}

?>