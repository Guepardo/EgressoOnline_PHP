<?php
#### START AUTOCODE
/**
 * Classe generada para a tabela "faixa_salarial"
 * in 2015-09-13
 * @author Hugo Ferreira da Silva
 * @link http://www.hufersil.com.br/lumine
 * @package Model
 *
 */

class FaixaSalarial extends Lumine_Base {

    
    public $id;
    public $des;
    public $empregos = array();
    
    
    
    /**
     * Inicia os valores da classe
     * @author Hugo Ferreira da Silva
     * @return void
     */
    protected function _initialize()
    {
        $this->metadata()->setTablename('faixa_salarial');
        $this->metadata()->setPackage('Model');
        
        # nome_do_membro, nome_da_coluna, tipo, comprimento, opcoes
        
        $this->metadata()->addField('id', 'id', 'int', 11, array('primary' => true, 'notnull' => true));
        $this->metadata()->addField('des', 'des', 'varchar', 45, array('notnull' => true));

        
        $this->metadata()->addRelation('empregos', Lumine_Metadata::ONE_TO_MANY, 'Emprego', 'faixaSalarialId', null, null, null);
    }

    #### END AUTOCODE


}
