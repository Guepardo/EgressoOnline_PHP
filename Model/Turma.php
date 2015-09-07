<?php
#### START AUTOCODE
/**
 * Classe generada para a tabela "turma"
 * in 2015-09-07
 * @author Hugo Ferreira da Silva
 * @link http://www.hufersil.com.br/lumine
 * @package Model
 *
 */

class Turma extends Lumine_Base {

    
    public $id;
    public $foto;
    public $ano;
    public $egressos = array();
    
    
    
    /**
     * Inicia os valores da classe
     * @author Hugo Ferreira da Silva
     * @return void
     */
    protected function _initialize()
    {
        $this->metadata()->setTablename('turma');
        $this->metadata()->setPackage('Model');
        
        # nome_do_membro, nome_da_coluna, tipo, comprimento, opcoes
        
        $this->metadata()->addField('id', 'id', 'int', 11, array('primary' => true, 'notnull' => true, 'autoincrement' => true));
        $this->metadata()->addField('foto', 'foto', 'varchar', 45, array());
        $this->metadata()->addField('ano', 'ano', 'int', 11, array('notnull' => true));

        
        $this->metadata()->addRelation('egressos', Lumine_Metadata::ONE_TO_MANY, 'Egresso', 'turmaId', null, null, null);
    }

    #### END AUTOCODE


}
