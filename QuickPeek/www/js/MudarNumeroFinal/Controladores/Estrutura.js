'use strict';

angular.module('QuickPeek.Estrutura.MudarNumeroFinal', [
    'RB.gcs',
    'RB.config',
    'RB.pagina',
    'RB.validacoesPadroes'
])

.factory('MudarNumeroFinalEstrutura', ['GCS','Config','Pagina','VP',
    function(GCS,Config,Pagina,VP) {
    var scope;  
    
    function setScope(obj){
        scope = obj;
        return this;
    }
    
    function popular(){
        scope.dados = {
            ddiAntigo:'',
            ddiNovo:'',
            telNovo:'',
            telAntigo:''
        };
    };
  
    return {
        setScope:setScope,
        popular:popular
    };
 }]);
