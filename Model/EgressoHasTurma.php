<?php
#### START AUTOCODE
/**
 * Classe generada para a tabela "egresso_has_turma"
 * in 2015-08-16
 * @author Hugo Ferreira da Silva
 * @link http://www.hufersil.com.br/lumine
 * @package Model
 *
 */

class EgressoHasTurma extends Lumine_Base {

    
    public $egressoUsuarioId;
    public $turmaId;
    
    
    
    /**
     * Inicia os valores da classe
     * @author Hugo Ferreira da Silva
     * @return void
     */
    protected function _initialize()
    {
        $this->metadata()->setTablename('egresso_has_turma');
        $this->metadata()->setPackage('Model');
        
        # nome_do_membro, nome_da_coluna, tipo, comprimento, opcoes
        
        $this->metadata()->addField('egressoUsuarioId', 'egresso_usuario_id', 'int', 11, array('primary' => true, 'notnull' => true, 'foreign' => '1', 'onUpdate' => 'RESTRICT', 'onDelete' => 'RESTRICT', 'linkOn' => 'usuarioId', 'class' => 'Egresso'));
        $this->metadata()->addField('turmaId', 'turma_id', 'int', 11, array('primary' => true, 'notnull' => true, 'foreign' => '1', 'onUpdate' => 'RESTRICT', 'onDelete' => 'RESTRICT', 'linkOn' => 'id', 'class' => 'Turma'));

        
    }

    #### END AUTOCODE


}
