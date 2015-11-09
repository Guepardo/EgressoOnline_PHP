<?php
#### START AUTOCODE
/**
 * Classe generada para a tabela "emails"
 * in 2015-11-09
 * @author Hugo Ferreira da Silva
 * @link http://www.hufersil.com.br/lumine
 * @package Model
 *
 */

class Emails extends Lumine_Base {

    
    public $id;
    public $conteudo;
    public $usuarioId;
    public $tipoEmailId;
    
    
    
    /**
     * Inicia os valores da classe
     * @author Hugo Ferreira da Silva
     * @return void
     */
    protected function _initialize()
    {
        $this->metadata()->setTablename('emails');
        $this->metadata()->setPackage('Model');
        
        # nome_do_membro, nome_da_coluna, tipo, comprimento, opcoes
        
        $this->metadata()->addField('id', 'id', 'int', 11, array('primary' => true, 'notnull' => true, 'autoincrement' => true));
        $this->metadata()->addField('conteudo', 'conteudo', 'varchar', 100, array());
        $this->metadata()->addField('usuarioId', 'usuario_id', 'int', 11, array('notnull' => true, 'foreign' => '1', 'onUpdate' => 'RESTRICT', 'onDelete' => 'RESTRICT', 'linkOn' => 'id', 'class' => 'Usuario'));
        $this->metadata()->addField('tipoEmailId', 'tipo_email_id', 'int', 11, array('notnull' => true, 'foreign' => '1', 'onUpdate' => 'RESTRICT', 'onDelete' => 'RESTRICT', 'linkOn' => 'id', 'class' => 'TipoEmail'));

        
    }

    #### END AUTOCODE


}
