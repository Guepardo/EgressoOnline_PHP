<?php
#### START AUTOCODE
/**
 * Classe generada para a tabela "curso"
 * in 2015-08-28
 * @author Hugo Ferreira da Silva
 * @link http://www.hufersil.com.br/lumine
 * @package Model
 *
 */

class Curso extends Lumine_Base {

    
    public $id;
    public $instituicao;
    public $areaNome;
    public $anoConclusao;
    public $usuarioId;
    public $tituloAcademicoId;
    
    
    
    /**
     * Inicia os valores da classe
     * @author Hugo Ferreira da Silva
     * @return void
     */
    protected function _initialize()
    {
        $this->metadata()->setTablename('curso');
        $this->metadata()->setPackage('Model');
        
        # nome_do_membro, nome_da_coluna, tipo, comprimento, opcoes
        
        $this->metadata()->addField('id', 'id', 'int', 11, array('primary' => true, 'notnull' => true, 'autoincrement' => true));
        $this->metadata()->addField('instituicao', 'instituicao', 'varchar', 160, array());
        $this->metadata()->addField('areaNome', 'area_nome', 'varchar', 160, array());
        $this->metadata()->addField('anoConclusao', 'ano_conclusao', 'int', 11, array());
        $this->metadata()->addField('usuarioId', 'usuario_id', 'int', 11, array('primary' => true, 'notnull' => true, 'foreign' => '1', 'onUpdate' => 'RESTRICT', 'onDelete' => 'RESTRICT', 'linkOn' => 'id', 'class' => 'Usuario'));
        $this->metadata()->addField('tituloAcademicoId', 'titulo_academico_id', 'int', 11, array('primary' => true, 'notnull' => true, 'foreign' => '1', 'onUpdate' => 'RESTRICT', 'onDelete' => 'RESTRICT', 'linkOn' => 'id', 'class' => 'TituloAcademico'));

        
    }

    #### END AUTOCODE


}
