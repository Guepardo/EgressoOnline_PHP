<?php
#### START AUTOCODE
/**
 * Classe generada para a tabela "rede_social"
 * in 2015-08-31
 * @author Hugo Ferreira da Silva
 * @link http://www.hufersil.com.br/lumine
 * @package Model
 *
 */

class RedeSocial extends Lumine_Base {

    
    public $id;
    public $des;
    public $egressohasredesociais = array();
    
    
    
    /**
     * Inicia os valores da classe
     * @author Hugo Ferreira da Silva
     * @return void
     */
    protected function _initialize()
    {
        $this->metadata()->setTablename('rede_social');
        $this->metadata()->setPackage('Model');
        
        # nome_do_membro, nome_da_coluna, tipo, comprimento, opcoes
        
        $this->metadata()->addField('id', 'id', 'int', 11, array('primary' => true, 'notnull' => true));
        $this->metadata()->addField('des', 'des', 'varchar', 45, array('notnull' => true));

        
        $this->metadata()->addRelation('egressohasredesociais', Lumine_Metadata::ONE_TO_MANY, 'EgressoHasRedeSocial', 'redeSocialId', null, null, null);
    }

    #### END AUTOCODE


}
