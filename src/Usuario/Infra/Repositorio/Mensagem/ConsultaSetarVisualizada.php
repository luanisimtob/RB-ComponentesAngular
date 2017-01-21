<?php
namespace Quickpeek\Usuario\Infra\Repositorio\Mensagem;
use Rubeus\ContenerDependencia\Conteiner;

class ConsultaSetarVisualizada {
    
    public function consultar($usuarioId, $usuarioMensagemId, $visibilidadeMensagensId, $visibilidadeUsuarioId){
        
        $query = Conteiner::get('Query', false);
        $query->select('id');
        $query->from('mensagens');
        $query->where('usuario_id = ?')
                ->add('usuario_mensagem_id = ?')
                ->add('status_mensagem_id in(1,2)')
                ->add('visibilidade_usuario_id = ?')
                ->add('visibilidade_mensagens_id = ?')
                ->add('ativo = 1');
        $query->addVariaveis([$usuarioMensagemId, $usuarioId, $visibilidadeMensagensId, $visibilidadeUsuarioId]);
        return $query->executar('AA1', false, 'id');
    }
}
