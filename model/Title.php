<?php
class Title{
    public $emp_no;
    public $title;
    public $from_date;
    public $to_date;

    function __construct($emp_no = null, $title = null, $from_date  = null, $to_date = null ){
        if(isset($emp_no)){
            $this->emp_no = $emp_no;
        }
        if (isset($title)) {
            $this->title = $title;
        }
        if (isset($from_date)) {
            $this->from_date = $from_date;
        }
        if (isset($to_date)) {
            $this->to_date = $to_date;
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