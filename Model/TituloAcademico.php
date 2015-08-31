<?php
#### START AUTOCODE
/**
 * Classe generada para a tabela "titulo_academico"
 * in 2015-08-31
 * @author Hugo Ferreira da Silva
 * @link http://www.hufersil.com.br/lumine
 * @package Model
 *
 */

class TituloAcademico extends Lumine_Base {

    
    public $id;
    public $des;
    public $cursos = array();
    public $notificacoes = array();
    public $opempregos = array();
    public $opposgraduacoes = array();
    
    
    
    /**
     * Inicia os valores da classe
     * @author Hugo Ferreira da Silva
     * @return void
     */
    protected function _initialize()
    {
        $this->metadata()->setTablename('titulo_academico');
        $this->metadata()->setPackage('Model');
        
        # nome_do_membro, nome_da_coluna, tipo, comprimento, opcoes
        
        $this->metadata()->addField('id', 'id', 'int', 11, array('primary' => true, 'notnull' => true));
        $this->metadata()->addField('des', 'des', 'varchar', 45, array('notnull' => true));

        
        $this->metadata()->addRelation('cursos', Lumine_Metadata::ONE_TO_MANY, 'Curso', 'tituloAcademicoId', null, null, null);
        $this->metadata()->addRelation('notificacoes', Lumine_Metadata::ONE_TO_MANY, 'Notificacao', 'tituloAcademicoId', null, null, null);
        $this->metadata()->addRelation('opempregos', Lumine_Metadata::ONE_TO_MANY, 'OpEmprego', 'tituloAcademicoId', null, null, null);
        $this->metadata()->addRelation('opposgraduacoes', Lumine_Metadata::ONE_TO_MANY, 'OpPosGraduacao', 'tituloAcademicoId', null, null, null);
    }

    #### END AUTOCODE


}
