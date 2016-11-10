<?php
namespace Quickpeek\Usuario\Aplicacao\Editar;
use Rubeus\ContenerDependencia\Conteiner;

class EditarContato {
    
    public function editarContato($msg){
        
        $usuarioId = $msg->getCampoSessao('dadosUsuarioLogado,id');
        $query = Conteiner::get('ConsultaVerificarConfiguracoes')->consultar($usuarioId);
        
        if($query){
            $msg->setCampo('Configuracoes::id', $query['id']);
            $msg->setCampo('entidade', 'Configuracoes');
            Conteiner::get('Cadastro')->cadastrar($msg);
        }else{
            $msg->setResultadoEtapa(false);
        }
    }
}