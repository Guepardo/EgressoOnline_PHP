<?php
#### START AUTOCODE
/**
 * Classe generada para a tabela "egresso_has_rede_social"
 * in 2015-08-31
 * @author Hugo Ferreira da Silva
 * @link http://www.hufersil.com.br/lumine
 * @package Model
 *
 */

class EgressoHasRedeSocial extends Lumine_Base {

    
    public $usuarioId;
    public $redeSocialId;
    public $linkAcesso;
    
    
    
    /**
     * Inicia os valores da classe
     * @author Hugo Ferreira da Silva
     * @return void
     */
    protected function _initialize()
    {
        $this->metadata()->setTablename('egresso_has_rede_social');
        $this->metadata()->setPackage('Model');
        
        # nome_do_membro, nome_da_coluna, tipo, comprimento, opcoes
        
        $this->metadata()->addField('usuarioId', 'usuario_id', 'int', 11, array('primary' => true, 'notnull' => true, 'foreign' => '1', 'onUpdate' => 'RESTRICT', 'onDelete' => 'RESTRICT', 'linkOn' => 'usuarioId', 'class' => 'Egresso'));
        $this->metadata()->addField('redeSocialId', 'rede_social_id', 'int', 11, array('primary' => true, 'notnull' => true, 'foreign' => '1', 'onUpdate' => 'RESTRICT', 'onDelete' => 'RESTRICT', 'linkOn' => 'id', 'class' => 'RedeSocial'));
        $this->metadata()->addField('linkAcesso', 'link_acesso', 'varchar', 500, array());

        
    }

    #### END AUTOCODE


}
