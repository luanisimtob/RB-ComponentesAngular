<?php
namespace Quickpeek\Acoes\Aplicacao\Perguntas;
use Rubeus\ContenerDependencia\Conteiner;

class VerificarLimitePerguntas {
    
    public function verificarLimitePerguntas($msg){
        
        $usuarioId = $msg->getCampoSessao('dadosUsuarioLogado,id');
        $localId = $msg->getCampo('Local::id')->get('valor');
        $tempo = Conteiner::get('ConfiguracoesQuickpeek')->consultar();
        
        $perguntas = Conteiner::get('ConsultaLimitePerguntas')->consultar($usuarioId, $localId, $tempo['limitePerguntas']);
        
        if($perguntas < 3){
            $msg->setResultadoEtapa(true);
        }else{
            $datetime1 = new \DateTime(date('Y-m-d H:i:s'));
            $datetime2 = new \DateTime($perguntas[0]);
            
            $intervalo = $datetime1->diff($datetime2);
            $minutos = ($intervalo->h * 60) + $intervalo->i;
            $tempoRestante = $minutos - (60 * $tempo['limitePerguntas']);
            $msg->setResultadoEtapa(false, false, ['dados'=>$tempoRestante]);
        }
    }
}
