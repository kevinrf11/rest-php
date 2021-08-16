<?php
class Employee{
    public $birth_date;
    public $emp_no;
    public $first_name;
    public $last_name;
    public $gender;
    public $hire_date;

    //Constructor for object
   /*  function __construct($emp_no = null, $first_name = null, $last_name  = null, $birth_date = null, $gender = null, $hire_date = null ){
        $this->emp_no = $emp_no;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->birth_date = $birth_date;
        $this->gender = $gender;
        $this->hire_date = $hire_date;
    } */
    //Getter 
    public function __get($name){
        if (property_exists($this, $name)) {
            return $this->$name;
        }
    }

    public function getEmpNo(){
        return $this->emp_no;
    }
    //Setter
    public function __set($name, $value){
        if (property_exists($this, $name)) {
            $this->$name= $value;
        }

        return $this;
    }

}

?>