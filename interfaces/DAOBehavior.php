<?php
interface DAOBehavior{
	public function insert( $element ); 
	public function delete( $pk ); 
	public function select ( $pk ); 
	public function update ($element); 
}