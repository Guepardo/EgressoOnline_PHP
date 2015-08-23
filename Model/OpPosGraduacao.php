<?php
#### START AUTOCODE
/**
 * Classe generada para a tabela "op_pos_graduacao"
 * in 2015-08-23
 * @author Hugo Ferreira da Silva
 * @link http://www.hufersil.com.br/lumine
 * @package Model
 *
 */

class OpPosGraduacao extends Lumine_Base {

    
    public $titulo;
    public $area;
    public $dataInscrInicio;
    public $dataInscrFim;
    public $tituloAcademicoId;
    public $oportunidadeId;
    
    
    
    /**
     * Inicia os valores da classe
     * @author Hugo Ferreira da Silva
     * @return void
     */
    protected function _initialize()
    {
        $this->metadata()->setTablename('op_pos_graduacao');
        $this->metadata()->setPackage('Model');
        
        # nome_do_membro, nome_da_coluna, tipo, comprimento, opcoes
        
        $this->metadata()->addField('titulo', 'titulo', 'varchar', 140, array());
        $this->metadata()->addField('area', 'area', 'varchar', 150, array());
        $this->metadata()->addField('dataInscrInicio', 'data_inscr_inicio', 'date', null, array());
        $this->metadata()->addField('dataInscrFim', 'data_inscr_fim', 'date', null, array());
        $this->metadata()->addField('tituloAcademicoId', 'titulo_academico_id', 'int', 11, array('primary' => true, 'notnull' => true, 'foreign' => '1', 'onUpdate' => 'RESTRICT', 'onDelete' => 'RESTRICT', 'linkOn' => 'id', 'class' => 'TituloAcademico'));
        $this->metadata()->addField('oportunidadeId', 'oportunidade_id', 'int', 11, array('primary' => true, 'notnull' => true, 'foreign' => '1', 'onUpdate' => 'RESTRICT', 'onDelete' => 'RESTRICT', 'linkOn' => 'id', 'class' => 'Oportunidade'));

        
    }

    #### END AUTOCODE


}
