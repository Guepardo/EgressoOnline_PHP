<?php
#### START AUTOCODE
################################################################################
#  Lumine - Database Mapping for PHP
#  Copyright (C) 2005  Hugo Ferreira da Silva
#  
#  This program is free software: you can redistribute it and/or modify
#  it under the terms of the GNU General Public License as published by
#  the Free Software Foundation, either version 3 of the License, or
#  (at your option) any later version.
#  
#  This program is distributed in the hope that it will be useful,
#  but WITHOUT ANY WARRANTY; without even the implied warranty of
#  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#  GNU General Public License for more details.
#  
#  You should have received a copy of the GNU General Public License
#  along with this program.  If not, see <http://www.gnu.org/licenses/>
################################################################################
/**
 * Created by Lumine_Reverse
 * in 2015-09-10
 * @author Hugo Ferreira da Silva
 * @link http://www.hufersil.com.br/lumine
 *
 * Arquivo de configuração para "mydb"
 */

$lumineConfig = array(
    'dialect' => 'MySQLi', 
    'database' => 'mydb', 
    'user' => 'root', 
    'password' => '', 
    'port' => '3306', 
    'host' => 'localhost', 
    'class_path' => 'C:/wamp/www/EgressoOnline_PHP', 
    'package' => 'Model', 
    'addons_path' => '', 
    'acao' => 'gerar', 

	
    'options' => array(
        'configID' => '', 
        'tipo_geracao' => '1', 
        'classMapping' => 'default', 
        'cache' => 'APC', 
        'remove_prefix' => '', 
        'remove_count_chars_start' => '0', 
        'remove_count_chars_end' => '0', 
        'format_classname' => '%s', 
        'schema_name' => '', 
        'many_to_many_style' => '%s_%s', 
        'plural' => '', 
        'create_controls' => 'White', 
        'class_sufix' => '', 
        'keep_foreign_column_name' => '1', 
        'camel_case' => '1', 
        'usar_dicionario' => '1', 
        'create_paths' => '1', 
        'dto_format' => '%sDTO', 
        'dto_package' => array(
            '0' => 'entidades',
        ), 
        'model_path' => '', 
        'model_format' => '%sModel', 
        'model_context_path' => '', 
        'classDescriptor' => '', 
        'overwrite' => '0', 
        'create_dtos' => '', 
        'generateAccessors' => '', 
        'create_entities_for_many_to_many' => '', 
        'generate_files' => '1', 
        'generate_zip' => '0'
    )
);



?>