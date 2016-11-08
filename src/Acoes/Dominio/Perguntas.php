<?php
        
namespace Quickpeek\Acoes\Dominio;
use Rubeus\ORM\Persistente as Persistente;

    class Perguntas extends Persistente{
        private $id = false;
        private $titulo = false;
        private $respondida = false;
        private $usuarioId = false;
        private $localId = false;
        private $ativo = false;
        private $momento = false; 
                
        public function getId() {
            return $this->id;
        }

        public function setId($id) {
            $this->id = $id;
        } 
                
        public function getTitulo() {
            return $this->titulo;
        }

        public function setTitulo($titulo) {
            $this->titulo = $titulo;
        } 
                
        public function getRespondida() {
            return $this->respondida;
        }

        public function setRespondida($respondida) {
            $this->respondida = $respondida;
        } 
            
        public function getUsuarioId() {
            if(!$this->usuarioId)
                    $this->usuarioId = new \Quickpeek\Usuario\Dominio\Usuario(); 
            return $this->usuarioId;
        }

        public function setUsuarioId($usuarioId) {
            if($usuarioId instanceof \Quickpeek\Usuario\Dominio\Usuario)
                $this->usuarioId = $usuarioId;
            else $this->getUsuarioId()->setId($usuarioId);
        } 
            
        public function getLocalId() {
            if(!$this->localId)
                    $this->localId = new \Quickpeek\Local\Dominio\Local(); 
            return $this->localId;
        }

        public function setLocalId($localId) {
            if($localId instanceof \Quickpeek\Local\Dominio\Local)
                $this->localId = $localId;
            else $this->getLocalId()->setId($localId);
        } 
                
        public function getAtivo() {
            return $this->ativo;
        }

        public function setAtivo($ativo) {
            $this->ativo = $ativo;
        } 
                
        public function getMomento() {
            return $this->momento;
        }

        public function setMomento($momento) {
            $this->momento = $momento;
        }
        
    }