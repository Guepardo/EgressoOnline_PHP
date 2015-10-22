<?php
#### START AUTOCODE
/**
 * Classe generada para a tabela "pais"
 * in 2015-10-22
 * @author Hugo Ferreira da Silva
 * @link http://www.hufersil.com.br/lumine
 * @package Model
 *
 */

class Pais extends Lumine_Base {

    
    public $id;
    public $des;
    public $estados = array();
    public $localidades = array();
    
    
    
    /**
     * Inicia os valores da classe
     * @author Hugo Ferreira da Silva
     * @return void
     */
    protected function _initialize()
    {
        $this->metadata()->setTablename('pais');
        $this->metadata()->setPackage('Model');
        
        # nome_do_membro, nome_da_coluna, tipo, comprimento, opcoes
        
        $this->metadata()->addField('id', 'id', 'int', 11, array('primary' => true, 'notnull' => true));
        $this->metadata()->addField('des', 'des', 'varchar', 45, array('notnull' => true));

        
        $this->metadata()->addRelation('estados', Lumine_Metadata::ONE_TO_MANY, 'Estado', 'paisId', null, null, null);
        $this->metadata()->addRelation('localidades', Lumine_Metadata::ONE_TO_MANY, 'Localidade', 'paisId', null, null, null);
    }

    #### END AUTOCODE


}
