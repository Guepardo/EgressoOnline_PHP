<?php
#### START AUTOCODE
/**
 * Classe generada para a tabela "professor_has_disciplina"
 * in 2015-08-19
 * @author Hugo Ferreira da Silva
 * @link http://www.hufersil.com.br/lumine
 * @package Model
 *
 */

class ProfessorHasDisciplina extends Lumine_Base {

    
    public $id;
    public $professorUsuarioId;
    public $disciplinaId;
    public $anoLecionou;
    
    
    
    /**
     * Inicia os valores da classe
     * @author Hugo Ferreira da Silva
     * @return void
     */
    protected function _initialize()
    {
        $this->metadata()->setTablename('professor_has_disciplina');
        $this->metadata()->setPackage('Model');
        
        # nome_do_membro, nome_da_coluna, tipo, comprimento, opcoes
        
        $this->metadata()->addField('id', 'id', 'int', 11, array('primary' => true, 'notnull' => true, 'autoincrement' => true));
        $this->metadata()->addField('professorUsuarioId', 'professor_usuario_id', 'int', 11, array('notnull' => true, 'foreign' => '1', 'onUpdate' => 'RESTRICT', 'onDelete' => 'RESTRICT', 'linkOn' => 'usuarioId', 'class' => 'Professor'));
        $this->metadata()->addField('disciplinaId', 'disciplina_id', 'int', 11, array('notnull' => true, 'foreign' => '1', 'onUpdate' => 'RESTRICT', 'onDelete' => 'RESTRICT', 'linkOn' => 'id', 'class' => 'Disciplina'));
        $this->metadata()->addField('anoLecionou', 'ano_lecionou', 'int', 11, array());

        
    }

    #### END AUTOCODE


}
