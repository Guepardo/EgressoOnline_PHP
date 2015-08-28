<?php
#### START AUTOCODE
/**
 * Classe generada para a tabela "notificacao"
 * in 2015-08-28
 * @author Hugo Ferreira da Silva
 * @link http://www.hufersil.com.br/lumine
 * @package Model
 *
 */

class Notificacao extends Lumine_Base {

    
    public $id;
    public $usuarioId;
    public $tituloAcademicoId;
    public $notificacaohasatuacaoprofissionais = array();
    
    
    
    /**
     * Inicia os valores da classe
     * @author Hugo Ferreira da Silva
     * @return void
     */
    protected function _initialize()
    {
        $this->metadata()->setTablename('notificacao');
        $this->metadata()->setPackage('Model');
        
        # nome_do_membro, nome_da_coluna, tipo, comprimento, opcoes
        
        $this->metadata()->addField('id', 'id', 'int', 11, array('primary' => true, 'notnull' => true, 'autoincrement' => true));
        $this->metadata()->addField('usuarioId', 'usuario_id', 'int', 11, array('primary' => true, 'notnull' => true, 'foreign' => '1', 'onUpdate' => 'RESTRICT', 'onDelete' => 'RESTRICT', 'linkOn' => 'id', 'class' => 'Usuario'));
        $this->metadata()->addField('tituloAcademicoId', 'titulo_academico_id', 'int', 11, array('foreign' => '1', 'onUpdate' => 'RESTRICT', 'onDelete' => 'RESTRICT', 'linkOn' => 'id', 'class' => 'TituloAcademico'));

        
        $this->metadata()->addRelation('notificacaohasatuacaoprofissionais', Lumine_Metadata::ONE_TO_MANY, 'NotificacaoHasAtuacaoProfissional', 'notificacaoId', null, null, null);
    }

    #### END AUTOCODE


}
