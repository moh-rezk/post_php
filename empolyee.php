<?php
class Employee{
 
   public $name;
   public $salary;
   public $tax;
   public $address;
   public $age;
 

       public function __construct($name,$salary,$tax,$age,$address)
       {
           $this->name=$name;
           $this->salary=$salary;
           $this->tax=$tax;
           $this->address=$address;
           $this->age=$age;
       }

   public function salary(){

   return  $this->salary= $this->salary - ($this->salary*($this->tax/100));
   }









}