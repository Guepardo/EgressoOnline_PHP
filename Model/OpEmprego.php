<?php
#### START AUTOCODE
/**
 * Classe generada para a tabela "op_emprego"
 * in 2015-08-27
 * @author Hugo Ferreira da Silva
 * @link http://www.hufersil.com.br/lumine
 * @package Model
 *
 */

class OpEmprego extends Lumine_Base {

    
    public $empresa;
    public $salario;
    public $tituloAcademicoId;
    public $atuacaoProfissionalId;
    public $oportunidadeId;
    
    
    
    /**
     * Inicia os valores da classe
     * @author Hugo Ferreira da Silva
     * @return void
     */
    protected function _initialize()
    {
        $this->metadata()->setTablename('op_emprego');
        $this->metadata()->setPackage('Model');
        
        # nome_do_membro, nome_da_coluna, tipo, comprimento, opcoes
        
        $this->metadata()->addField('empresa', 'empresa', 'varchar', 150, array());
        $this->metadata()->addField('salario', 'salario', 'double', null, array());
        $this->metadata()->addField('tituloAcademicoId', 'titulo_academico_id', 'int', 11, array('primary' => true, 'notnull' => true, 'foreign' => '1', 'onUpdate' => 'RESTRICT', 'onDelete' => 'RESTRICT', 'linkOn' => 'id', 'class' => 'TituloAcademico'));
        $this->metadata()->addField('atuacaoProfissionalId', 'atuacao_profissional_id', 'int', 11, array('primary' => true, 'notnull' => true, 'foreign' => '1', 'onUpdate' => 'RESTRICT', 'onDelete' => 'RESTRICT', 'linkOn' => 'id', 'class' => 'AtuacaoProfissional'));
        $this->metadata()->addField('oportunidadeId', 'oportunidade_id', 'int', 11, array('primary' => true, 'notnull' => true, 'foreign' => '1', 'onUpdate' => 'RESTRICT', 'onDelete' => 'RESTRICT', 'linkOn' => 'id', 'class' => 'Oportunidade'));

        
    }

    #### END AUTOCODE


}
