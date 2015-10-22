<?php
#### START AUTOCODE
/**
 * Classe generada para a tabela "emprego"
 * in 2015-10-22
 * @author Hugo Ferreira da Silva
 * @link http://www.hufersil.com.br/lumine
 * @package Model
 *
 */

class Emprego extends Lumine_Base {

    
    public $id;
    public $nomeEmpresa;
    public $localidadeId;
    public $atuacaoProfissionalId;
    public $faixaSalarialId;
    public $publico;
    public $areaTi;
    public $hasEmprego;
    public $egressos = array();
    
    
    
    /**
     * Inicia os valores da classe
     * @author Hugo Ferreira da Silva
     * @return void
     */
    protected function _initialize()
    {
        $this->metadata()->setTablename('emprego');
        $this->metadata()->setPackage('Model');
        
        # nome_do_membro, nome_da_coluna, tipo, comprimento, opcoes
        
        $this->metadata()->addField('id', 'id', 'int', 11, array('primary' => true, 'notnull' => true, 'autoincrement' => true));
        $this->metadata()->addField('nomeEmpresa', 'nome_empresa', 'varchar', 150, array());
        $this->metadata()->addField('localidadeId', 'localidade_id', 'int', 11, array('primary' => true, 'notnull' => true, 'foreign' => '1', 'onUpdate' => 'RESTRICT', 'onDelete' => 'RESTRICT', 'linkOn' => 'id', 'class' => 'Localidade'));
        $this->metadata()->addField('atuacaoProfissionalId', 'atuacao_profissional_id', 'int', 11, array('foreign' => '1', 'onUpdate' => 'RESTRICT', 'onDelete' => 'RESTRICT', 'linkOn' => 'id', 'class' => 'AtuacaoProfissional'));
        $this->metadata()->addField('faixaSalarialId', 'faixa_salarial_id', 'int', 11, array('foreign' => '1', 'onUpdate' => 'RESTRICT', 'onDelete' => 'RESTRICT', 'linkOn' => 'id', 'class' => 'FaixaSalarial'));
        $this->metadata()->addField('publico', 'publico', 'boolean', 1, array('default' => '0'));
        $this->metadata()->addField('areaTi', 'area_ti', 'boolean', 1, array('default' => '0'));
        $this->metadata()->addField('hasEmprego', 'has_emprego', 'boolean', 1, array('default' => '0'));

        
        $this->metadata()->addRelation('egressos', Lumine_Metadata::ONE_TO_MANY, 'Egresso', 'empregoId', null, null, null);
    }

    #### END AUTOCODE


}
