'use strict';

angular.module('QuickPeek.Estrutura.Seguidores', [
    'RB.gcs',
    'RB.config',
    'RB.pagina',
    'RB.validacoesPadroes'
])

.factory('SeguidoresEstrutura', ['GCS','Config','Pagina','VP',
    function(GCS,Config,Pagina,VP) {
    var scope;  
    
    function setScope(obj){
        scope = obj;
        return this;
    }
    
    function popular(){
        scope.dados = {
            seguidores:new Array()};
        
        if(DGlobal.seguidores && DGlobal.seguidores.success){
            scope.dados.seguidores = DGlobal.seguidores.dados;
        }
    };
  
    return {
        setScope:setScope,
        popular:popular
    };
 }]);
