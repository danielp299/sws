<?php

namespace App\Repositories;

use Illuminate\Http\Request;

use Carbon\Carbon;
use App\Ranking;
use App\Torneo;
use App\InscritosTorneo;
use App\TorneosJugado;
use App\DetalleTorneo;
use App\Concurso;
use App\InscritoConcurso;
use App\Regla;
use App\DetalleConcurso;
use App\ConfiguracionGlobalJuego2;
use App\DatoMascota;
use App\ReglaElemento;
use App\Repositories\ControladorElementos;


	class Pelea
	{

		protected $elementos;

        function __construct( ControladorElementos $ControladorElementos)
        {
            $this->elementos =$ControladorElementos;

        }

	public function ranking($uid)
	     {
	        $user = $uid;
	        $ranking = \App\Ranking::all();
	        $rankingGlobal = \App\Ranking::orderBy('puntos','desc')->get();
	        $position = $rankingGlobal->search(function($ranking, $key) use ($user){
	            return $ranking->uid_user == $user;
	        });  

	        return $position + 1;
	     }

	 public function simularPelea($user, $user_oponente)
	 {
		$configuracion = $rankingGlobal = \App\ConfiguracionGlobalJuego2::orderBy('nombre','base')->first();

	 	//esto se debe leer de una tabla
	 	$const_probabilidad_evolucion = $configuracion->probabilidad_evolucion; // (1/10)
	 	$const_probabilidad_bono = $configuracion->probabilidad_bono;  // (3/10)
		
		$efecto_ventaja_evolucion = $configuracion->efecto_ventaja_evolucion;
		$efecto_ventaja_elemento = $configuracion->efecto_ventaja_elemento;
		$efecto_ventaja_bono = $configuracion->efecto_ventaja_bono;


	 	$bonoA = 0;
	 	$bonoB = 0;
	 	$evolucionaA = 0;
		$evolucionaB = 0;
		$ventajaA = 0;
		$ventajaB = 0;
		$mascotaA =  \App\DatoMascota::where('id',$user->avatar->uid_avatar)->first();
		
		$mascotaB =  \App\DatoMascota::where('id',$user_oponente->avatar->uid_avatar)->first();
		
		if($mascotaA == NULL ){
			return "ERROR 4 ";
			//return "ERROR 4 ".$user." Intenta usar el id ".$user->avatar->uid_avatar." pero no existe ".Carbon::now()." Registrar esto en un log";
		}else if($mascotaB == NULL ){
			return "ERROR 5 ";
			//return "ERROR 5 ".$user_oponente." Intenta usar el id ".$user_oponente->uid_avatar." pero no existe ".Carbon::now()." Registrar esto en un log";
		}


		$ventaja = $this->elementos->VerificarVentajaElemetoA($mascotaA->elemento,$mascotaB->elemento);

		//$ventaja =$this->elementos->VerificarVentajaElemetoA("fuego","agua");
		
		if($ventaja > 0){
			$ventajaA = $efecto_ventaja_elemento;
		}else if($ventaja < 0){
			$ventajaB = $efecto_ventaja_elemento;
		}


	 	if(rand(0,10) < $const_probabilidad_bono){
	 		$bonoA = 1.0;
	 	}
	 	if(rand(0,10) < $const_probabilidad_bono){
	 		$bonoB = 1.0;
	 	}
	 	if(rand(0,10) < $const_probabilidad_evolucion){
	 		$evolucionaA = 1.0;
	 	}
	 	if(rand(0,10) < $const_probabilidad_evolucion){
	 		$evolucionB = 1.0;
	 	}

	 	$usuarioExpTotal = ($mascotaA->poder_base * $user->avatar->exp * $efecto_ventaja_evolucion)  +  ($bonoA * $efecto_ventaja_bono * $user->avatar->exp)+ ($ventajaA * $user->avatar->exp);
		// $oponente = $user_oponente->exp + ($bonoB * $efecto_ventaja_bono * $user_oponente->exp);
		$oponenteExpTotal = ($mascotaB->poder_base * $user_oponente->avatar->exp * $efecto_ventaja_evolucion)  +  ($bonoB * $efecto_ventaja_bono * $user_oponente->avatar->exp)+ ($ventajaB * $user_oponente->avatar->exp);
		 $ganador = "";
	 	if($usuarioExpTotal > $oponenteExpTotal){
			$ganador  = $user->uid_user;
	 	}else{
			$ganador = $user_oponente->uid_user;
		 }

		 //return $ganador;
		 
		 return [
			'jugadorA' => $user->nombre,
			'avatarA' => $user->avatar->uid_avatar,
			'evolucionA'=> 1,
			'experienciaA'=> number_format($usuarioExpTotal, 2, '.', ''),
			//'experienciaPoderA'=> "".$usuarioExpTotal,
			'jugadorB' => $user_oponente->nombre,
			'avatarB' => $user_oponente->avatar->uid_avatar,
			'evolucionB'=> 1,
			'experienciaB'=> number_format($oponenteExpTotal, 2, '.', ''),
			//'experienciaPoderB'=> "".$oponenteExpTotal,
			'ganador' => $ganador,
			'BonoA' => $bonoA > 0  ? "si":"no" ,
			'BonoB' => $bonoB > 0  ? "si":"no" ,
			'EvolucionaA' => $evolucionaA > 0  ? "si":"no" ,
			'EvolucionaB' => $evolucionaB > 0  ? "si":"no" ,
			'experienciaGanadador'=> 100,
			'experienciaPerdedor'=> 20
			
		 ];

	 }  

	 public function simularTorneo()
	 {
		 $date = Carbon::now();
		 
	 	$day = $date->format('l');
	 	//dd($day);
	 	$torneo = \App\Torneo::where('fecha', $day)->get();
	 	$numero = 0;
	 	$tamanioTorneo = 0;
	 	$numeroParticipantesCompletar = 0;
	 	$participantes = null;
	 	$ganadores = null;
	 	
	 	foreach ($torneo as $t) {
	 		$inscritos = \App\InscritosTorneo::where('uid_torneo', $t->uid_torneo)->get();
	 		$numero = $inscritos->count();
	 		$exp =  $this->calcularTamanioTorneo($numero);
	 		$tamanioTorneo = pow(2, $exp);

	 		$numeroParticipantesCompletar = $this->calcularParticipantesCompletar($numero, $tamanioTorneo);

	 		if($numeroParticipantesCompletar == 0){
	 			$participantes = \App\InscritosTorneo::where('uid_torneo', $t->uid_torneo)
	 												  ->get()
	 												  ->shuffle();
	 	        $ganadores = $this->iniciarTorneo($participantes, $exp, $t->uid_torneo);


	 		}else{
	 			$this->completarParticipantes($numeroParticipantesCompletar, $t->uid_torneo);
	 			$participantes = \App\InscritosTorneo::where('uid_torneo', $t->uid_torneo)
	 												  ->get()
	 												  ->shuffle();
	 			$ganadores = $this->iniciarTorneo($participantes, $exp, $t->uid_torneo);
	 		}
	 	}
         
       
         
	 	return $ganadores;
	 	
	 }

	 public function calcularTamanioTorneo($participantesInscritos)
	 {
	 	$exp = 0;


	 	while(pow(2, $exp) < $participantesInscritos ){
	 		$exp = $exp + 1;
	 	}

	 	return $exp;
	 }

	public function calcularParticipantesCompletar($numeroParticipantes, $exponenteParticipantes)
	{
		return $exponenteParticipantes - $numeroParticipantes;
	}

	public function completarParticipantes($participantesCompletar, $uid_torneo)
	{
		
		for($i = 0; $i < $participantesCompletar; $i ++)
		{
			$torneo = new InscritosTorneo;
			$torneo->uid_torneo = $uid_torneo;
			$torneo->uid_user = 'robot';
			$torneo->uid_avatar = 'robot';
			$torneo->exp = rand(0,50);
			$torneo->save();
		}
		

	}

	public function iniciarTorneo($participantes, $exp, $uid_torneo)
	{
		$ganadores = $participantes;

	foreach ($participantes as $p) {
		 $torneoJugado = new TorneosJugado;
		 $torneoJugado->uid_user = $p->uid_user;
		 $torneoJugado->uid_torneo = $p->uid_torneo;
	     $torneoJugado->posicion = $exp;
		 $torneoJugado->save();

		 $inscrito = \App\InscritosTorneo::where('uid_user', $p->uid_user)
		 								 ->delete();
	}
		 
		
		while($ganadores->count() > 1)
		{
			$ganadores = null;
			$ganadores = collect();
			$cont = 0;
			$oponenteA = null;
			$oponenteB = null;
			
			$exp -= 1;
			foreach ($participantes as $p) {

				
				if($cont % 2 == 0)
				{
					$oponenteA = $p;
				}else{
					//$exp -= 1;
					$oponenteB = $p;
					$ganador = $this->peleaTorneo($oponenteA, $oponenteB);
					$detalleTorneo = new DetalleTorneo;
					$detalleTorneo->uid_torneo = $uid_torneo;
					$detalleTorneo->uid_user = $oponenteA->uid_user;
					$detalleTorneo->uid_oponente = $oponenteB->uid_user;
					$detalleTorneo->ganador = $ganador->uid_user;
					$detalleTorneo->evolucionA = false;
					$detalleTorneo->evolucionB = false;
					$detalleTorneo->boosterA = false;
					$detalleTorneo->boosterB = false;
					$detalleTorneo->save();
					
					$torneo = \App\TorneosJugado::where('uid_user', $ganador->uid_user)
													  ->where('uid_torneo', $uid_torneo)
													  ->first();

					$torneo->posicion = $exp;
					$torneo->save();
					
					$ganadores->push($ganador);

				}

				
			$cont += 1;
			}
			
			$participantes = null;
			$participantes = collect();
		 	$participantes = $ganadores->all();
		 	
		 }
		 	
			return $ganadores;
	}

	public function peleaTorneo($oponenteA, $oponenteB)
	{
		$expA = $oponenteA->exp;
		$expB = $oponenteB->exp;
		if($expA > $expB)
		{
			return $oponenteA;
		}else{
			return $oponenteB;
		}
	}

	public function simularConcurso()
	{
		
		$date = Carbon::now();
	 	$day = $date->format('l');
	 	$re = null;

	 	$concurso = \App\Concurso::where('fecha', $day)->get();
	 	$inscritoCollection = collect([['uid_user' => 'null', 'id' => 0, 'exp' => null, 'puntuacion' => 0]]);
	 	
	 	foreach ($concurso as $c) {
	 		$inscritos = \App\InscritoConcurso::where('uid_concurso', $c->uid_concurso)->get();
	 		foreach ($inscritos as $i) {
	 			$inscritoCollection->push(['uid_user' => $i->uid_user, 'id' => $i->id_avatar, 'exp' => $i->exp, 'puntuacion' => 0]);
	 		}
	 		
	 		$collection = $inscritoCollection->whereNotIn('uid_user', 'null')->all();

	 		$re = $this->reglasConcurso($collection, $c); 
	 		
	 	}
	 	dd($re);
	 	return $re;
	}

	public function reglasConcurso($inscritos, $c)
	{
		$reglas = \App\Regla::all();
		$inscritosOrdenados = collect($inscritos)->sortByDesc('exp');
		$totalInscritos = collect($inscritos)->count()/2;
		//dd($inscritosOrdenados);
		$resultados = collect();
		$exp = 0;
		$i = 1;
		foreach ($inscritosOrdenados as $inscrito) {
			if((int)$totalInscritos == $i){
				$exp = $inscrito['exp'];
			}
			$i += 1;
		}
		//dd($exp);
		foreach ($inscritosOrdenados as $inscrito) {

			foreach ($reglas as $regla) {
				
				if($inscrito['id'] === $regla->id){
					
					if($regla->tipo == $c->tipo){
						$puntos = rand(0,120);
						$inscrito['puntuacion'] += $puntos;
					}
					else{
						$puntos = rand(0,100);
						$inscrito['puntuacion'] += $puntos;
					}
					if($regla->evolucion == $c->evolucion){
						$puntos = rand(0,120);
						$inscrito['puntuacion'] += $puntos;
					}
					else{
						$puntos = rand(0,100);
						$inscrito['puntuacion'] += $puntos;
					}
					}
			}
			if($inscrito['exp'] >= $exp){
				if($c->exp == 0){
					$puntos = rand(0,100);
					$inscrito['puntuacion'] += $puntos;
				}
				else{
					$puntos = rand(0,120);
					$inscrito['puntuacion'] += $puntos;
				}
			}else{
				if($c->exp == 0){
					$puntos = rand(0,100);
					$inscrito['puntuacion'] += $puntos;
				}
				else{
					$puntos = rand(0,120);
					$inscrito['puntuacion'] += $puntos;
				}
			}

			$resultados->push($inscrito);
		   
		}
		$uid_concurso = $c->uid_concurso;
		$resultadosOrdenados = $this->ordenarPosicionesConcurso($resultados, $uid_concurso);
		//dd($resultadosOrdenados);
		return $resultadosOrdenados;

	}

	public function ordenarPosicionesConcurso($resultados, $uid_concurso)
	{	
		$detalleConcurso = new DetalleConcurso;

		$resultadosOrdenados = collect($resultados)->sortByDesc('puntuacion');
		$i = 1;
		foreach ($resultadosOrdenados as $resultado) {
			$detalleConcurso = new DetalleConcurso;
			$detalleConcurso->uid_user = $resultado['uid_user'];
			$detalleConcurso->uid_concurso = $uid_concurso;
			$detalleConcurso->puntuacion = $resultado['puntuacion'];
			$detalleConcurso->posicion = $i;
			$detalleConcurso->save();
			$i += 1;	

			$inscrito = \App\InscritoConcurso::where('uid_user', $resultado['uid_user'])
		 								 ->delete();
		}
		
		return $resultadosOrdenados;
	}
	}
