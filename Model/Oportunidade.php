<?php
#### START AUTOCODE
/**
 * Classe generada para a tabela "oportunidade"
 * in 2015-09-10
 * @author Hugo Ferreira da Silva
 * @link http://www.hufersil.com.br/lumine
 * @package Model
 *
 */

class Oportunidade extends Lumine_Base {

    
    public $id;
    public $telefone;
    public $email;
    public $site;
    public $infoAdicionais;
    public $dataDivulgacao;
    public $localidadeId;
    public $usuarioId;
    public $opempregos = array();
    public $opposgraduacoes = array();
    
    
    
    /**
     * Inicia os valores da classe
     * @author Hugo Ferreira da Silva
     * @return void
     */
    protected function _initialize()
    {
        $this->metadata()->setTablename('oportunidade');
        $this->metadata()->setPackage('Model');
        
        # nome_do_membro, nome_da_coluna, tipo, comprimento, opcoes
        
        $this->metadata()->addField('id', 'id', 'int', 11, array('primary' => true, 'notnull' => true, 'autoincrement' => true));
        $this->metadata()->addField('telefone', 'telefone', 'varchar', 15, array());
        $this->metadata()->addField('email', 'email', 'varchar', 150, array());
        $this->metadata()->addField('site', 'site', 'varchar', 500, array());
        $this->metadata()->addField('infoAdicionais', 'info_adicionais', 'varchar', 5000, array());
        $this->metadata()->addField('dataDivulgacao', 'data_divulgacao', 'datetime', null, array());
        $this->metadata()->addField('localidadeId', 'localidade_id', 'int', 11, array('primary' => true, 'notnull' => true, 'foreign' => '1', 'onUpdate' => 'RESTRICT', 'onDelete' => 'RESTRICT', 'linkOn' => 'id', 'class' => 'Localidade'));
        $this->metadata()->addField('usuarioId', 'usuario_id', 'int', 11, array('primary' => true, 'notnull' => true, 'foreign' => '1', 'onUpdate' => 'RESTRICT', 'onDelete' => 'RESTRICT', 'linkOn' => 'id', 'class' => 'Usuario'));

        
        $this->metadata()->addRelation('opempregos', Lumine_Metadata::ONE_TO_MANY, 'OpEmprego', 'oportunidadeId', null, null, null);
        $this->metadata()->addRelation('opposgraduacoes', Lumine_Metadata::ONE_TO_MANY, 'OpPosGraduacao', 'oportunidadeId', null, null, null);
    }

    #### END AUTOCODE


}
