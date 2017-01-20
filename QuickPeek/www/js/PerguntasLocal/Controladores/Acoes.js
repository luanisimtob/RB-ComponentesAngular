'use strict';

angular.module('QuickPeek.Acoes.PerguntasLocal', [ 
    'RB.pagina',
    'QuickPeek.Requisicao.PerguntasLocal',
    'RB.validacoesPadroes'
])

.factory('PerguntasLocalAcoes', ['Pagina','PerguntasLocalRequisicoes','VP','Websocket',
    function(Pagina,PessoasLocalRequisicoes,VP,Websocket){
    var scope,conn;  
    
    function setScope(obj){
        scope = obj;
        return this;
    };
    
    function configConexao(){
        if(DGlobal.acaoCliente && DGlobal.acaoCliente.idPagina)
            var idPagina = DGlobal.acaoCliente.idPagina;
        
        if(DGlobal.idLocal)
            var idLocal = DGlobal.idLocal;
        
        scope.conn = Websocket.setarPagina(idPagina,idLocal,executarResposta);
    }
    
    function voltarLocais(){
        Pagina.navegar({idPage:24,paramAdd:'?latitude='+DGlobal.coordenadasAtual.latitude+'&longitude='+DGlobal.coordenadasAtual.longitude+'&localId='+DGlobal.localAtual+'&atualizando=0'});
    }
    
    function executarResposta(resposta){
        console.log('resposta');
        console.log(resposta);
        if(resposta && resposta.pergunta == 0){
            editarPergunta(resposta);
        }
        
        if(resposta && resposta.pergunta == 1){
            addPergunta(resposta);
        }
    }
    
    function addPergunta(pergunta){
        scope.dados.perguntas.unshift(pergunta);
        scope.$apply();
    }
    
    function editarPergunta(resposta){
        for(var i = 0; i < scope.dados.perguntas.length; i++){
            if(scope.dados.perguntas[i].id == resposta.perguntaId){
                scope.dados.perguntas[i].respostas++;
            }
        }
        scope.$apply();
    }
    
    function responder(id){
        DGlobal.idPergunta = id;
        Pagina.navegar({idPage:34,paramAdd:'?perguntasId='+id});
    }
    
    return {
        setScope:setScope,
        voltarLocais:voltarLocais,
        configConexao:configConexao,
        responder:responder
    };
    
 }]);
