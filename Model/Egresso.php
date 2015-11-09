<?php
#### START AUTOCODE
/**
 * Classe generada para a tabela "egresso"
 * in 2015-11-09
 * @author Hugo Ferreira da Silva
 * @link http://www.hufersil.com.br/lumine
 * @package Model
 *
 */

class Egresso extends Lumine_Base {

    
    public $usuarioId;
    public $anoIngresso;
    public $anoConclusao;
    public $qtdFilhos;
    public $telefone;
    public $endereco;
    public $isDadoPublico;
    public $empregoId;
    public $localidadeId;
    public $turmaId;
    public $estadoCivilId;
    public $alterouDado;
    public $egressohasredesociais = array();
    
    
    
    /**
     * Inicia os valores da classe
     * @author Hugo Ferreira da Silva
     * @return void
     */
    protected function _initialize()
    {
        $this->metadata()->setTablename('egresso');
        $this->metadata()->setPackage('Model');
        
        # nome_do_membro, nome_da_coluna, tipo, comprimento, opcoes
        
        $this->metadata()->addField('usuarioId', 'usuario_id', 'int', 11, array('primary' => true, 'notnull' => true, 'foreign' => '1', 'onUpdate' => 'RESTRICT', 'onDelete' => 'RESTRICT', 'linkOn' => 'id', 'class' => 'Usuario'));
        $this->metadata()->addField('anoIngresso', 'ano_ingresso', 'int', 11, array('notnull' => true));
        $this->metadata()->addField('anoConclusao', 'ano_conclusao', 'int', 11, array('notnull' => true));
        $this->metadata()->addField('qtdFilhos', 'qtd_filhos', 'int', 11, array('default' => '0'));
        $this->metadata()->addField('telefone', 'telefone', 'varchar', 15, array());
        $this->metadata()->addField('endereco', 'endereco', 'varchar', 500, array());
        $this->metadata()->addField('isDadoPublico', 'is_dado_publico', 'boolean', 1, array('notnull' => true, 'default' => '1'));
        $this->metadata()->addField('empregoId', 'emprego_id', 'int', 11, array('primary' => true, 'notnull' => true, 'foreign' => '1', 'onUpdate' => 'RESTRICT', 'onDelete' => 'RESTRICT', 'linkOn' => 'id', 'class' => 'Emprego'));
        $this->metadata()->addField('localidadeId', 'localidade_id', 'int', 11, array('primary' => true, 'notnull' => true, 'foreign' => '1', 'onUpdate' => 'RESTRICT', 'onDelete' => 'RESTRICT', 'linkOn' => 'id', 'class' => 'Localidade'));
        $this->metadata()->addField('turmaId', 'turma_id', 'int', 11, array('primary' => true, 'notnull' => true, 'foreign' => '1', 'onUpdate' => 'RESTRICT', 'onDelete' => 'RESTRICT', 'linkOn' => 'id', 'class' => 'Turma'));
        $this->metadata()->addField('estadoCivilId', 'estado_civil_id', 'int', 11, array('notnull' => true, 'foreign' => '1', 'onUpdate' => 'RESTRICT', 'onDelete' => 'RESTRICT', 'linkOn' => 'id', 'class' => 'EstadoCivil'));
        $this->metadata()->addField('alterouDado', 'alterou_dado', 'boolean', 1, array('default' => '1'));

        
        $this->metadata()->addRelation('egressohasredesociais', Lumine_Metadata::ONE_TO_MANY, 'EgressoHasRedeSocial', 'usuarioId', null, null, null);
    }

    #### END AUTOCODE


}
