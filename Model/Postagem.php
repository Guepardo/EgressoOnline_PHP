<?php
#### START AUTOCODE
/**
 * Classe generada para a tabela "postagem"
 * in 2015-08-16
 * @author Hugo Ferreira da Silva
 * @link http://www.hufersil.com.br/lumine
 * @package Model
 *
 */

class Postagem extends Lumine_Base {

    
    public $id;
    public $mensagem;
    public $usuarioId;
    public $dataEnvio;
    public $usuariohaspostagem = array();
    
    
    
    /**
     * Inicia os valores da classe
     * @author Hugo Ferreira da Silva
     * @return void
     */
    protected function _initialize()
    {
        $this->metadata()->setTablename('postagem');
        $this->metadata()->setPackage('Model');
        
        # nome_do_membro, nome_da_coluna, tipo, comprimento, opcoes
        
        $this->metadata()->addField('id', 'id', 'int', 11, array('primary' => true, 'notnull' => true, 'autoincrement' => true));
        $this->metadata()->addField('mensagem', 'mensagem', 'varchar', 450, array());
        $this->metadata()->addField('usuarioId', 'usuario_id', 'int', 11, array('primary' => true, 'notnull' => true, 'foreign' => '1', 'onUpdate' => 'RESTRICT', 'onDelete' => 'RESTRICT', 'linkOn' => 'id', 'class' => 'Usuario'));
        $this->metadata()->addField('dataEnvio', 'data_envio', 'datetime', null, array('notnull' => true));

        
        $this->metadata()->addRelation('usuariohaspostagem', Lumine_Metadata::ONE_TO_MANY, 'UsuarioHasPostagem', 'postagemId', null, null, null);
    }

    #### END AUTOCODE


}
