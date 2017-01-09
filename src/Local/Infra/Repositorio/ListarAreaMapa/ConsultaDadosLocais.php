<?php
namespace Quickpeek\Local\Infra\Repositorio\ListarAreaMapa;
use Rubeus\ContenerDependencia\Conteiner;

class ConsultaDadosLocais {
    
    public function consultar($usuarioId, $latitude, $longitude, $tempoMidia, $tempoHashtag, $notIn){
        
        $query = Conteiner::get('Query', false);
        $query->select('l.id', 'localId')
                ->add('l.titulo', 'localNome')
                ->add('l.endereco', 'localEndereco')
                ->add('l.latitude', 'latitude')
                ->add('l.longitude', 'longitude')
                ->add('(6371 * acos(cos(radians(?)) * cos(radians(l.latitude)) * cos(radians(?) - radians(l.longitude)) + sin(radians(?)) * sin(radians(l.latitude))))', 'distancia')
                ->add('((count(distinct c.id) * 1) + ((m.contagem + hl.contagem) * 0.9) + (count(distinct ci.id) * 0.8)) * case
        when (6371 * acos(cos(radians(?)) * cos(radians(l.latitude)) * cos(radians(?) - radians(l.longitude)) + sin(radians(?)) * sin(radians(l.latitude)))) <= 10 then 0.6
        when (6371 * acos(cos(radians(?)) * cos(radians(l.latitude)) * cos(radians(?) - radians(l.longitude)) + sin(radians(?)) * sin(radians(l.latitude)))) <= 20 then 0.5
        when (6371 * acos(cos(radians(?)) * cos(radians(l.latitude)) * cos(radians(?) - radians(l.longitude)) + sin(radians(?)) * sin(radians(l.latitude)))) <= 40 then 0.3
		else 7/(6371 * acos(cos(radians(?)) * cos(radians(l.latitude)) * cos(radians(?) - radians(l.longitude)) + sin(radians(?)) * sin(radians(l.latitude))))
    end ', 'relevancia')
                ->add('cin.contagem', 'relevancia2')
                ->add('ifnull(chec.ativo, 0)', 'checkIn');
        $query->from('local', 'l');
        $query->join('check_in', 'c')->on('c.local_id = l.id')
                ->on('c.presente = 1')
                ->on('c.ativo = 1');
        $query->join($this->subHashtag(), 'm', 'left')
                ->on('m.local_id = l.id');
        $query->join($this->subMidia(), 'hl', 'left')
                ->on('hl.local_id = l.id');
        $query->join('check_in', 'ci', 'left')->on('ci.usuario_id = ?')
                ->on('ci.local_id = l.id')
                ->on('ci.presente = 0')
                ->on('ci.ativo = 1');
        $query->join($this->subCheckIn(), 'cin', 'left')
                ->on('cin.local_id = l.id');
        $query->join('check_in', 'chec', 'left')->on('chec.usuario_id = ?')
                ->on('chec.local_id = l.id')
                ->on('chec.presente = 1')
                ->on('chec.ativo = 1');
        $query->where('l.id not in (' . $notIn . ')');
        $query->group('l.id');
        $query->order('relevancia desc, relevancia2 desc');
        $query->limit(15);
        $query->addVariaveis([$latitude, $longitude, $latitude, 
            $latitude, $longitude, $latitude, 
            $latitude, $longitude, $latitude, 
            $latitude, $longitude, $latitude, 
            $latitude, $longitude, $latitude,
            $tempoMidia, $tempoHashtag, $usuarioId, $usuarioId, $usuarioId]);
        return $query->executar();
    }
       
    private function subHashtag(){
        
        $query = Conteiner::get('Query', false);
        $query->select('count(local_id)', 'contagem')
                ->add('local_id');
        $query->from('hashtag_local');
        $query->where('momento > date_add(now(), interval -? hour)')
                ->add('ativo = 1');
        $query->group('local_id');
        return $query;
    }
    
    private function subMidia(){
        
        $query = Conteiner::get('Query', false);
        $query->select('count(local_id)', 'contagem')
                ->add('local_id');
        $query->from('midia');
        $query->where('momento > date_add(now(), interval -? hour)')
                ->add('ativo = 1');
        $query->group('local_id');
        return $query;
    }
    
    private function subCheckIn(){
        
        $query = Conteiner::get('Query', false);
        $query->select('count(distinct cin.id)', 'contagem')
                ->add('cin.local_id');
        $query->from('seguir', 's');
        $query->join('check_in', 'cin')
                ->on('cin.usuario_id = s.usuario_seguir_id')
                ->on('cin.presente = 1')
                ->on('cin.ativo = 1');
        $query->where('s.usuario_id = ?')
                ->add('s.confirmar_seguir = 1')
                ->add('s.ativo = 1');
        $query->group('cin.local_id');
        return $query;
    }
}
