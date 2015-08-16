<?php
#### START AUTOCODE
/**
 * Classe generada para a tabela "notificacao_has_titulo_academico"
 * in 2015-08-16
 * @author Hugo Ferreira da Silva
 * @link http://www.hufersil.com.br/lumine
 * @package Model
 *
 */

class NotificacaoHasTituloAcademico extends Lumine_Base {

    
    public $notificacaoId;
    public $tituloAcademicoId;
    
    
    
    /**
     * Inicia os valores da classe
     * @author Hugo Ferreira da Silva
     * @return void
     */
    protected function _initialize()
    {
        $this->metadata()->setTablename('notificacao_has_titulo_academico');
        $this->metadata()->setPackage('Model');
        
        # nome_do_membro, nome_da_coluna, tipo, comprimento, opcoes
        
        $this->metadata()->addField('notificacaoId', 'notificacao_id', 'int', 11, array('primary' => true, 'notnull' => true, 'foreign' => '1', 'onUpdate' => 'RESTRICT', 'onDelete' => 'RESTRICT', 'linkOn' => 'id', 'class' => 'Notificacao'));
        $this->metadata()->addField('tituloAcademicoId', 'titulo_academico_id', 'int', 11, array('primary' => true, 'notnull' => true, 'foreign' => '1', 'onUpdate' => 'RESTRICT', 'onDelete' => 'RESTRICT', 'linkOn' => 'id', 'class' => 'TituloAcademico'));

        
    }

    #### END AUTOCODE


}
