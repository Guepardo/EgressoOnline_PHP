<?php
#### START AUTOCODE
/**
 * Classe generada para a tabela "professor"
 * in 2015-10-29
 * @author Hugo Ferreira da Silva
 * @link http://www.hufersil.com.br/lumine
 * @package Model
 *
 */

class Professor extends Lumine_Base {

    
    public $isCoordenador;
    public $usuarioId;
    public $professorhasdisciplinas = array();
    
    
    
    /**
     * Inicia os valores da classe
     * @author Hugo Ferreira da Silva
     * @return void
     */
    protected function _initialize()
    {
        $this->metadata()->setTablename('professor');
        $this->metadata()->setPackage('Model');
        
        # nome_do_membro, nome_da_coluna, tipo, comprimento, opcoes
        
        $this->metadata()->addField('isCoordenador', 'is_coordenador', 'boolean', 1, array('notnull' => true, 'default' => '0'));
        $this->metadata()->addField('usuarioId', 'usuario_id', 'int', 11, array('primary' => true, 'notnull' => true, 'foreign' => '1', 'onUpdate' => 'RESTRICT', 'onDelete' => 'RESTRICT', 'linkOn' => 'id', 'class' => 'Usuario'));

        
        $this->metadata()->addRelation('professorhasdisciplinas', Lumine_Metadata::ONE_TO_MANY, 'ProfessorHasDisciplina', 'professorUsuarioId', null, null, null);
    }

    #### END AUTOCODE


}
