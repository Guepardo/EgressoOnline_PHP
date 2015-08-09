<?php
#### START AUTOCODE
/**
 * Classe generada para a tabela "genero"
 * in 2015-08-09
 * @author Hugo Ferreira da Silva
 * @link http://www.hufersil.com.br/lumine
 * @package Model
 *
 */

class Genero extends Lumine_Base {

    
    public $id;
    public $des;
    public $usuarios = array();
    
    
    
    /**
     * Inicia os valores da classe
     * @author Hugo Ferreira da Silva
     * @return void
     */
    protected function _initialize()
    {
        $this->metadata()->setTablename('genero');
        $this->metadata()->setPackage('Model');
        
        # nome_do_membro, nome_da_coluna, tipo, comprimento, opcoes
        
        $this->metadata()->addField('id', 'id', 'int', 11, array('primary' => true, 'notnull' => true));
        $this->metadata()->addField('des', 'des', 'varchar', 45, array('notnull' => true));

        
        $this->metadata()->addRelation('usuarios', Lumine_Metadata::ONE_TO_MANY, 'Usuario', 'generoId', null, null, null);
    }

    #### END AUTOCODE


}
