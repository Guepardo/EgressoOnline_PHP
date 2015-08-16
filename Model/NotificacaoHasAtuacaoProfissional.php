<?php
#### START AUTOCODE
/**
 * Classe generada para a tabela "notificacao_has_atuacao_profissional"
 * in 2015-08-16
 * @author Hugo Ferreira da Silva
 * @link http://www.hufersil.com.br/lumine
 * @package Model
 *
 */

class NotificacaoHasAtuacaoProfissional extends Lumine_Base {

    
    public $notificacaoId;
    public $atuacaoProfissionalId;
    
    
    
    /**
     * Inicia os valores da classe
     * @author Hugo Ferreira da Silva
     * @return void
     */
    protected function _initialize()
    {
        $this->metadata()->setTablename('notificacao_has_atuacao_profissional');
        $this->metadata()->setPackage('Model');
        
        # nome_do_membro, nome_da_coluna, tipo, comprimento, opcoes
        
        $this->metadata()->addField('notificacaoId', 'notificacao_id', 'int', 11, array('primary' => true, 'notnull' => true, 'foreign' => '1', 'onUpdate' => 'RESTRICT', 'onDelete' => 'RESTRICT', 'linkOn' => 'id', 'class' => 'Notificacao'));
        $this->metadata()->addField('atuacaoProfissionalId', 'atuacao_profissional_id', 'int', 11, array('primary' => true, 'notnull' => true, 'foreign' => '1', 'onUpdate' => 'RESTRICT', 'onDelete' => 'RESTRICT', 'linkOn' => 'id', 'class' => 'AtuacaoProfissional'));

        
    }

    #### END AUTOCODE


}
