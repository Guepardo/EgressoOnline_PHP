<?php
#### START AUTOCODE
/**
 * Classe generada para a tabela "atuacao_profissional"
 * in 2015-08-19
 * @author Hugo Ferreira da Silva
 * @link http://www.hufersil.com.br/lumine
 * @package Model
 *
 */

class AtuacaoProfissional extends Lumine_Base {

    
    public $id;
    public $des;
    public $empregos = array();
    public $notificacaohasatuacaoprofissionais = array();
    public $opempregos = array();
    
    
    
    /**
     * Inicia os valores da classe
     * @author Hugo Ferreira da Silva
     * @return void
     */
    protected function _initialize()
    {
        $this->metadata()->setTablename('atuacao_profissional');
        $this->metadata()->setPackage('Model');
        
        # nome_do_membro, nome_da_coluna, tipo, comprimento, opcoes
        
        $this->metadata()->addField('id', 'id', 'int', 11, array('primary' => true, 'notnull' => true, 'autoincrement' => true));
        $this->metadata()->addField('des', 'des', 'varchar', 45, array('notnull' => true));

        
        $this->metadata()->addRelation('empregos', Lumine_Metadata::ONE_TO_MANY, 'Emprego', 'atuacaoProfissionalId', null, null, null);
        $this->metadata()->addRelation('notificacaohasatuacaoprofissionais', Lumine_Metadata::ONE_TO_MANY, 'NotificacaoHasAtuacaoProfissional', 'atuacaoProfissionalId', null, null, null);
        $this->metadata()->addRelation('opempregos', Lumine_Metadata::ONE_TO_MANY, 'OpEmprego', 'atuacaoProfissionalId', null, null, null);
    }

    #### END AUTOCODE


}
