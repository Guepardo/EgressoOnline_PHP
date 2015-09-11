<?php
#### START AUTOCODE
/**
 * Classe generada para a tabela "localidade"
 * in 2015-09-10
 * @author Hugo Ferreira da Silva
 * @link http://www.hufersil.com.br/lumine
 * @package Model
 *
 */

class Localidade extends Lumine_Base {

    
    public $id;
    public $complemento;
    public $cidadeId;
    public $paisId;
    public $egressos = array();
    public $empregos = array();
    public $oportunidades = array();
    
    
    
    /**
     * Inicia os valores da classe
     * @author Hugo Ferreira da Silva
     * @return void
     */
    protected function _initialize()
    {
        $this->metadata()->setTablename('localidade');
        $this->metadata()->setPackage('Model');
        
        # nome_do_membro, nome_da_coluna, tipo, comprimento, opcoes
        
        $this->metadata()->addField('id', 'id', 'int', 11, array('primary' => true, 'notnull' => true, 'autoincrement' => true));
        $this->metadata()->addField('complemento', 'complemento', 'varchar', 500, array());
        $this->metadata()->addField('cidadeId', 'cidade_id', 'int', 11, array('foreign' => '1', 'onUpdate' => 'RESTRICT', 'onDelete' => 'RESTRICT', 'linkOn' => 'id', 'class' => 'Cidade'));
        $this->metadata()->addField('paisId', 'pais_id', 'int', 11, array('foreign' => '1', 'onUpdate' => 'RESTRICT', 'onDelete' => 'RESTRICT', 'linkOn' => 'id', 'class' => 'Pais'));

        
        $this->metadata()->addRelation('egressos', Lumine_Metadata::ONE_TO_MANY, 'Egresso', 'localidadeId', null, null, null);
        $this->metadata()->addRelation('empregos', Lumine_Metadata::ONE_TO_MANY, 'Emprego', 'localidadeId', null, null, null);
        $this->metadata()->addRelation('oportunidades', Lumine_Metadata::ONE_TO_MANY, 'Oportunidade', 'localidadeId', null, null, null);
    }

    #### END AUTOCODE


}
