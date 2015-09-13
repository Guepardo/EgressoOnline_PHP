<?php
#### START AUTOCODE
/**
 * Classe generada para a tabela "estado"
 * in 2015-09-13
 * @author Hugo Ferreira da Silva
 * @link http://www.hufersil.com.br/lumine
 * @package Model
 *
 */

class Estado extends Lumine_Base {

    
    public $id;
    public $des;
    public $paisId;
    public $cidades = array();
    
    
    
    /**
     * Inicia os valores da classe
     * @author Hugo Ferreira da Silva
     * @return void
     */
    protected function _initialize()
    {
        $this->metadata()->setTablename('estado');
        $this->metadata()->setPackage('Model');
        
        # nome_do_membro, nome_da_coluna, tipo, comprimento, opcoes
        
        $this->metadata()->addField('id', 'id', 'int', 11, array('primary' => true, 'notnull' => true));
        $this->metadata()->addField('des', 'des', 'varchar', 45, array('notnull' => true));
        $this->metadata()->addField('paisId', 'pais_id', 'int', 11, array('primary' => true, 'notnull' => true, 'foreign' => '1', 'onUpdate' => 'RESTRICT', 'onDelete' => 'RESTRICT', 'linkOn' => 'id', 'class' => 'Pais'));

        
        $this->metadata()->addRelation('cidades', Lumine_Metadata::ONE_TO_MANY, 'Cidade', 'estadoId', null, null, null);
    }

    #### END AUTOCODE


}
