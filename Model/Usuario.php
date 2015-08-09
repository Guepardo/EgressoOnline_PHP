<?php
#### START AUTOCODE
/**
 * Classe generada para a tabela "usuario"
 * in 2015-08-09
 * @author Hugo Ferreira da Silva
 * @link http://www.hufersil.com.br/lumine
 * @package Model
 *
 */

class Usuario extends Lumine_Base {

    
    public $id;
    public $nome;
    public $cpf;
    public $email;
    public $senha;
    public $generoId;
    public $egressos = array();
    public $oportunidades = array();
    public $professores = array();
    
    
    
    /**
     * Inicia os valores da classe
     * @author Hugo Ferreira da Silva
     * @return void
     */
    protected function _initialize()
    {
        $this->metadata()->setTablename('usuario');
        $this->metadata()->setPackage('Model');
        
        # nome_do_membro, nome_da_coluna, tipo, comprimento, opcoes
        
        $this->metadata()->addField('id', 'id', 'int', 11, array('primary' => true, 'notnull' => true, 'autoincrement' => true));
        $this->metadata()->addField('nome', 'nome', 'varchar', 160, array('notnull' => true));
        $this->metadata()->addField('cpf', 'cpf', 'varchar', 14, array('notnull' => true));
        $this->metadata()->addField('email', 'email', 'varchar', 150, array('notnull' => true));
        $this->metadata()->addField('senha', 'senha', 'varchar', 35, array('notnull' => true));
        $this->metadata()->addField('generoId', 'genero_id', 'int', 11, array('primary' => true, 'notnull' => true, 'foreign' => '1', 'onUpdate' => 'RESTRICT', 'onDelete' => 'RESTRICT', 'linkOn' => 'id', 'class' => 'Genero'));

        
        $this->metadata()->addRelation('egressos', Lumine_Metadata::ONE_TO_MANY, 'Egresso', 'usuarioId', null, null, null);
        $this->metadata()->addRelation('oportunidades', Lumine_Metadata::ONE_TO_MANY, 'Oportunidade', 'usuarioId', null, null, null);
        $this->metadata()->addRelation('professores', Lumine_Metadata::ONE_TO_MANY, 'Professor', 'usuarioId', null, null, null);
    }

    #### END AUTOCODE


}
