'use strict';

angular.module('Cmp.ImagePicker', [
    'RB.validacoesPadroes'
])

.factory('ImagePicker', ['VP','$timeout','$cordovaImagePicker',
    function (VP,$timeout,$cordovaImagePicker) {
        var scope;  

        function setScope(obj){
            scope = obj;
            return this;
        };
        
        function iniciar(nome,metodo,qtd){
            var n = 1;
            if(qtd)n = qtd;
            var options = {
                maximumImagesCount: n,
                width: $('body').width(),
                height:0,
                quality: 100
            };
            
            $cordovaImagePicker.getPictures(options)
            .then(function (results) {
                if(!scope[nome])scope[nome] = {};
                if(scope[nome])scope[nome].img = results[0];
                if(scope[nome])scope[nome].galeria = true;
                //document.getElementById(nome).src = scope[nome].img;
                if(scope[nome].esconder)scope[nome].esconder();
                if(metodo && !qtd)metodo(results[0]);
                if(metodo && qtd)metodo(results);
            }, function(error) {
                if(metodo)metodo(false);
                scope[nome].img = false;
            });   
        }

          return {
              setScope:setScope,
              iniciar:iniciar
          };
      }
]);