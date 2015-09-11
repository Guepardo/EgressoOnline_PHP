<?php
#### START AUTOCODE
/**
 * Classe generada para a tabela "estado_civil"
 * in 2015-09-10
 * @author Hugo Ferreira da Silva
 * @link http://www.hufersil.com.br/lumine
 * @package Model
 *
 */

class EstadoCivil extends Lumine_Base {

    
    public $id;
    public $des;
    public $egressos = array();
    
    
    
    /**
     * Inicia os valores da classe
     * @author Hugo Ferreira da Silva
     * @return void
     */
    protected function _initialize()
    {
        $this->metadata()->setTablename('estado_civil');
        $this->metadata()->setPackage('Model');
        
        # nome_do_membro, nome_da_coluna, tipo, comprimento, opcoes
        
        $this->metadata()->addField('id', 'id', 'int', 11, array('primary' => true, 'notnull' => true, 'autoincrement' => true));
        $this->metadata()->addField('des', 'des', 'varchar', 45, array('notnull' => true));

        
        $this->metadata()->addRelation('egressos', Lumine_Metadata::ONE_TO_MANY, 'Egresso', 'estadoCivilId', null, null, null);
    }

    #### END AUTOCODE


}
