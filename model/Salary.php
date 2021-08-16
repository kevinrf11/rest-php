<?php
class Salary{
    public $emp_no;
    public $salary;
    public $from_date;
    public $to_date;

    //Constructor for object
    function __construct($emp_no = null, $salary = null, $from_date  = null, $to_date = null ){
        if(isset($emp_no)){
            $this->emp_no = $emp_no;
        }
        if (isset($salary)) {
            $this->salary = $salary;
        }
        if (isset($from_date)) {
            $this->from_date = $from_date;
        }
        if (isset($to_date)) {
            $this->to_date = $to_date;
        }
    }
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