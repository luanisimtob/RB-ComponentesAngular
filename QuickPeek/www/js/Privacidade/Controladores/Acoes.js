'use strict';

angular.module('QuickPeek.Acoes.Privacidade', [ 
    'RB.pagina',
    'QuickPeek.Requisicao.Privacidade'
])

.factory('PrivacidadeAcoes', ['Pagina','PrivacidadeRequisicoes','$cordovaFacebook',
    function(Pagina,PrivacidadeRequisicoes,$cordovaFacebook){
    var scope;  
    
    function setScope(obj){
        scope = obj;
        return this;
    };
    
    function inicializar(){
        $('ion-side-menu-content').addClass('background-chekin');
    };
    
    function voltar(){
        Pagina.rollBack();
    }
    
    function editarAvatar(){
        DGlobal.veioCadastro = scope.dados;
        if(scope.dadosUser)
            DGlobal.veioCadastro.avataresId = scope.dadosUser.avatarId;
        else
            DGlobal.veioCadastro.avataresId = 1;
        DGlobal.veioCadastro.executarReqPrivacidade = true;
        Pagina.navegar({idPage:7});
    }
    
    function fazerCheckin(){
        PrivacidadeRequisicoes.set({dados:scope.dados,scope:scope,acaoSuccess:PrivacidadeRequisicoes.successFazerCheckIn}).fazerCheckIn();
    }
    
    function compartilharFB(local){
        console.log(local);
        
        var accessToken;
        
//        $cordovaFacebook.login(["public_profile", "email", "user_friends"]
//            ,function(success){
//                console.log('success');
//                console.log(success);
//                StatusBar.hide();
//                StatusBar.show();
//                enviaDadosLogin(success.authResponse);
//            }, function (error) {
//                console.log('error');
//                console.log(error);
//                StatusBar.hide();
//                StatusBar.show();
//                $cordovaFacebook.logout();
//                OpenToast("Não foi possível receber suas informações a partir do Facebook. Por favor, tente novamente.");
//        });
        
        $cordovaFacebook.getLoginStatus(function (response){
            console.log('response');
            console.log(response);
            if (response.status === 'connected') {
                accessToken = response.authResponse.accessToken;
                pesquisarLocalFB();
            }
        },function(e){console.log('e')});
//
//        
//        function pesquisarLocalFB(){
//            var urlCall = "/search?q=Sesc&type=page&center=&"+lat+","+long+"access_token="+accessToken;
//            facebookConnectPlugin.api(urlCall, function(response) {
//                console.log('response');   
//                console.log(response);   
//            });
//        }
//            
//        function publicarFB(){
//            FB.api(
//                "/me/feed",
//                "POST",
//                {
//                    "message": "This is a test message",
//                    "place":259820197522765,
//                    "access_token":"EAACEdEose0cBAGnReZALNAZARNzdKdleGPdGxYppkC8ZBAQtCIH8n6YjbDNraM2aoX5KZCSr2fZBIxgI6VRroNzy2ZB0faB1yIMaHMWz5l1kKzjAzUnrjvJJqZCghjMjH2vZCvL3dfBRzbobLzqaxZAPGnuyfp0x5nvfV6hDFcHFPIMkjxNjzWBu9bwMer3qXwMQZD"
//                },
//                function (response){
//                    console.log(response);
//                  if (response && !response.error) {
//                    /* handle the result */
//                  }
//                }
//            );
//        }
    }
    
    return {
        setScope:setScope,
        inicializar:inicializar,
        voltar:voltar,
        editarAvatar:editarAvatar,
        fazerCheckin:fazerCheckin,
        compartilharFB:compartilharFB
    };
    
 }]);
