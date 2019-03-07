<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Victima;
use App\Avatar;
use App\Perfil;
use App\Ranking;
use App\User;
use App\Liga;
use App\Gimnasio;
use App\Repositories\Pelea;
use App\Repositories\ControladorElementos;
use App\ProgresoLiga;
use App\Medalla;
use App\HistoricoMedalla;
use App\Torneo;
use App\InscritosTorneo;
use App\TorneosJugado;
use App\DetalleTorneo;
use App\Concurso;
use App\InscritoConcurso;
use App\DetalleConcurso;
use App\ReglaElemento;

use Illuminate\Http\Response;
    
use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\Ranking\RankingCollection;
use App\Http\Resources\Liga\LigaCollection;
use App\Http\Resources\Victima\VictimaResource;
use App\Http\Resources\Avatar\AvatarResource;
use App\Http\Resources\Perfil\PerfilResource;
use App\Http\Resources\Liga\LigaResource;
use App\Http\Resources\Medalla\MedallaResource;
use App\Http\Resources\Medalla\MedallaCollection;
use App\Http\Resources\HistoricoMedalla\HistoricoMedallaCollection;
use App\Http\Resources\Gimnasio\GimnasioCollection;
use App\Http\Resources\Torneo\TorneoCollection;
use App\Http\Resources\Concurso\ConcursoCollection;
use App\Http\Resources\DetalleTorneo\DetalleTorneoCollection;
use App\Http\Resources\DetalleConcurso\DetalleConcursoCollection;
use App\Http\Resources\ProgresoLiga\ProgresoLigaResource;
use App\Http\Resources\InscritoTorneo\InscritoTorneoResource;
use App\Http\Resources\TorneoJugado\TorneoJugadoResource;
use App\Http\Resources\InscritoConcurso\InscritoConcursoResource;

    class PeleaController extends Controller
    {

        protected $pelea;
        protected $elementos;

        function __construct(Pelea $pelea, ControladorElementos $ControladorElementos)
        {
            $this->pelea = $pelea;
            $this->elementos =$ControladorElementos;

        }

       /* public function elementosTest(){

            $ganador = $this->elementos->VerificarVentajaElemetoA("fuego","agua");
            return $ganador;
        }*/

        public function peleaBasica(Request $request)
        {
            
            $victimas = \App\Victima::all();
            $ganador = new User;
            $perdedor = new User;

            
           
            if($victimas->isEmpty())
            {
                /*return response()->json([
                    'errors' => 'No hay ninguna victima'
                ]);*/
                return "ERROR 1";
            }
            
            $random = $victimas->random();

            $user_victima = \App\User::where('uid_user', $random->uid_user)->first();

            $user =  \App\User::where('uid_user', $request->uid_user)->first();

            
            if($user){
                if($user->avatar->uid_avatar == $request->avatar){
                    $user->avatar->exp = $request->exp;
                    $user->avatar->save();
                }else{
                    $avatar = new Avatar;
                    $avatar->uid_avatar = $request->avatar;
                    $avatar->exp =$request->exp;
                    $avatar->save();
                    $user->avatar()->associate($avatar->id);
                    $user->save();
                    $user = \App\User::where('uid_user', $request->uid_user)->first();
                }
            }else{
                $avatar = new Avatar;
                $avatar->uid_avatar = $request->avatar;
                $avatar->exp = $request->exp;
                $avatar->save();
                $user = new User;
                $user->uid_user = $request->uid_user;
                $user->exp = 0;
                $user->avatar()->associate($avatar->id);
                $user->save();
            }

            //$poder = $request->exp;
            $peleaSimulada = $this->pelea->simularPelea($user, $user_victima);

            if($peleaSimulada === "NO VALIDO"){
                return "ERROR ".$peleaSimulada;
            }
            
            //$array = json_decode($peleaSimulada, true);
            //$ganadorPelea = $this->pelea->simularPelea($request, $random);
            $ganadorPelea = $peleaSimulada["ganador"];
            
            $usuario = $request->uid_user;

            if($ganadorPelea == $usuario){

                $ganador = \App\User::where('uid_user',$request->uid_user)->get();
                if($ganador->isEmpty()){
                    $avatar = \App\Avatar::where('uid_avatar', $request->avatar)->get();
                    if($avatar->isEmpty())
                    {
                        $avatar = new Avatar;
                        $avatar->uid_avatar = $request->avatar;
                        $avatar->exp = $request->exp;
                        $avatar->save();  
                    }else{
                       $avatar = \App\Avatar::where('uid_avatar', $request->avatar)->first(); 
                    }
                    
                    $ganador = new User;
                    $ganador->uid_user = $request->uid_user;
                    $ganador->avatar()->associate($avatar->uid_avatar);
                    $ganador->exp = $request->exp;
                    $ganador->save();

                    $ranking = new Ranking;
                    $ranking->user()->associate($request->uid_user);
                    $ranking->puntos = 3;
                    $ranking->save();

                }else{

                    $ranking = \App\Ranking::where('uid_user', $request->uid_user)->get();
                    if($ranking->isEmpty()){
                        $ranking = new Ranking;
                        $ranking->user()->associate($request->uid_user);
                        $ranking->puntos = 3;
                        $ranking->save();
                    }
                    else{
                        $ranking = \App\Ranking::where('uid_user', $request->uid_user)->first();
                        $ranking->puntos += 3;
                        $ranking->save();
                    }
                    $liga = \App\Liga::where('uid_user', $request->uid_user)->get();
                    if(!$liga->isEmpty()){
                        $liga = \App\Liga::where('uid_user', $request->uid_user)->first();
                        $liga->puntos += 3;
                        $liga->save();
                    }
                    
                }
                $perdedor = \App\User::where('uid_user', $random->uid_user)->get();
                if($perdedor->isEmpty())
                {
                    $avatar = \App\Avatar::where('uid_avatar', $random->uid_avatar)->first();
                    $perdedor = new User;
                    $perdedor->uid_user = $random->uid_user;
                    $perdedor->avatar()->associate($avatar->uid_avatar);
                    $perdedor->exp = $random->exp;
                    $perdedor->save();

                    $ranking = new Ranking;
                    $ranking->user()->associate($random->uid_user);
                    $ranking->puntos = 1;
                    $ranking->save();

                }else{

                    $ranking = \App\Ranking::where('uid_user', $random->uid_user)->get();
                    if($ranking->isEmpty()){
                        $ranking = new Ranking;
                        $ranking->user()->associate($random->uid_user);
                        $ranking->puntos = 1;
                        $ranking->save();
                    }
                    else{
                        $ranking = \App\Ranking::where('uid_user', $random->uid_user)->first();
                        $ranking->puntos += 1;
                        $ranking->save();
                    } 
                     
                    $liga = \App\Liga::where('uid_user', $random->uid_user)->get();
                    if(!$liga->isEmpty()){
                        $liga = \App\Liga::where('uid_user', $random->uid_user)->first();
                        $liga->puntos += 3;
                        $liga->save();
                    }
                }
            }
            else
            {
                 $ganador = \App\User::where('uid_user',$random->uid_user)->get();
                if($ganador->isEmpty()){
                    $avatar = \App\Avatar::where('uid_avatar', $random->uid_avatar)->first();
                    $ganador = new User;
                    $ganador->uid_user = $random->uid_user;
                    $ganador->avatar()->associate($avatar->uid_avatar);
                    $ganador->exp = $random->exp;
                    //$ganador->ranking()->puntos = 3;
                    $ganador->save();

                    $ranking = new Ranking;
                    $ranking->user()->associate($random->uid_user);
                    $ranking->puntos = 3;
                    $ranking->save();

                }else{
                
                    $ranking = \App\Ranking::where('uid_user', $random->uid_user)->get();
                    if($ranking->isEmpty()){
                        $ranking = new Ranking;
                        $ranking->user()->associate($random->uid_user);
                        $ranking->puntos = 3;
                        $ranking->save();
                    }
                    else{
                        $ranking = \App\Ranking::where('uid_user', $random->uid_user)->first();
                        $ranking->puntos += 3;
                        $ranking->save();
                    }

                     $liga = \App\Liga::where('uid_user', $random->uid_user)->get();
                    if(!$liga->isEmpty()){
                        $liga = \App\Liga::where('uid_user', $random->uid_user)->first();
                        $liga->puntos += 3;
                        $liga->save();
                    }
                    
                }
                $perdedor = \App\User::where('uid_user', $request->uid_user)->get();
                if($perdedor->isEmpty())
                {
                    $avatar = \App\Avatar::where('uid_avatar', $request->avatar)->get();
                    if($avatar->isEmpty())
                    {
                        $avatar = new Avatar;
                        $avatar->uid_avatar = $request->avatar;
                        $avatar->exp = $request->exp;
                        $avatar->save();  
                    }else{
                       $avatar = \App\Avatar::where('uid_avatar', $request->avatar)->first(); 
                    }
                    $perdedor = new User;
                    $perdedor->uid_user = $request->uid_user;
                    $perdedor->avatar()->associate($avatar->uid_avatar);
                    $perdedor->exp = $request->exp;
                   // $perdedor->ranking()->puntos = 1;
                    $perdedor->save();

                    $ranking = new Ranking;
                    $ranking->user()->associate($request->uid_user);
                    $ranking->puntos = 1;
                    $ranking->save();

                }else{

                    $ranking = \App\Ranking::where('uid_user', $request->uid_user)->get();
                    if($ranking->isEmpty()){
                        $ranking = new Ranking;
                        $ranking->user()->associate($request->uid_user);
                        $ranking->puntos = 1;
                        $ranking->save();
                    }
                    else{
                        $ranking = \App\Ranking::where('uid_user', $request->uid_user)->first();
                        $ranking->puntos += 1;
                        $ranking->save();
                    } 

                     $liga = \App\Liga::where('uid_user', $request->uid_user)->get();
                    if(!$liga->isEmpty()){
                        $liga = \App\Liga::where('uid_user', $request->uid_user)->first();
                        $liga->puntos += 3;
                        $liga->save();
                    }
                }
            }
            if($victimas->count() > 10){
                $random->delete();
            }

            return response()->json($peleaSimulada);
        
            
        }

        public function agregarVictima(Request $request)
        {
            $contVictimas = \App\Victima::where('uid_user', $request->uid)->count();
            if($contVictimas > 2) return "ERROR ya esta 3 veces ";
            
            $datoMascota = \App\DatoMascota::where('id', $request->avatar)->first();
            if(!$datoMascota) return "ERROR Mascota ".$request->avatar." no encontrada";

            $avatar = NULL;
            $user = \App\User::where('uid_user', $request->uid)->first();

            if($user){
                if($user->uid_avatar){
                    $avatar = \App\Avatar::where('id', $user->uid_avatar)->first();
                    if($avatar->uid_avatar != $request->avatar){
                        $avatar = new Avatar;
                        $avatar->uid_avatar = $request->avatar;
                    }
                }else{
                    $avatar = new Avatar;
                    $avatar->uid_avatar = $request->avatar;
                }
                $avatar->exp = $request->exp;
                $avatar->save();
            }else{
                $avatar = new Avatar;
                $avatar->uid_avatar = $request->avatar;
                $avatar->exp = $request->exp;
                $avatar->save();
                $user = new User;
                $user->uid_user = $request->uid;
            }
            $user->exp = 0;
            $user->avatar()->associate($avatar->id);
            $user->save();

            $victima = new Victima;
            $victima->user()->associate($user->uid_user);
            $victima->avatar()->associate($request->avatar);
            $victima->exp = $request->exp;
            $victima->save();

            //return $log;

        	return new VictimaResource($victima);
        }

       /* public function agregarVictima(Request $request)
        {
            $user = \App\User::where('uid_user', $request->uid)->get();
            if($user->isEmpty()){
                $avatar = \App\Avatar::where('uid_avatar', $request->avatar)->get();
                if($avatar->isEmpty()){
                    $avatar = new Avatar;
                    $avatar->uid_avatar = $request->avatar;
                    $avatar->exp = $request->exp;
                    $avatar->save();
                    $user = new User;
                    $user = new User;
                    $user->uid_user = $request->uid;
                    $user->avatar()->associate($avatar->uid_avatar);
                    $user->exp = $request->exp;
                    $user->save();
                    $victima = new Victima;
                    $victima->user()->associate($user->uid_user);
                    $victima->avatar()->associate($user->uid_avatar);
                    $victima->exp = $request->exp;
                    $victima->evolucion = $request->evolucion;
                    $victima->save();

                }else{

                    $avatar = \App\Avatar::where('uid_avatar', $request->avatar)->first();
                    $user = new User;
                    $user->uid_user = $request->uid;
                    $user->avatar()->associate($avatar->uid_avatar);
                    $user->exp = $request->exp;
                    $user->save();
                    $victima = new Victima;
                    $victima->user()->associate($user->uid_user);
                    $victima->avatar()->associate($user->uid_avatar);
                    $victima->exp = $request->exp;
                    $victima->evolucion = $request->evolucion;
                    $victima->save();
                }
                
            }else{
                $user = \App\User::where('uid_user', $request->uid)->first();
                $victima = new Victima;
                $victima->user()->associate($user->uid_user);
                $victima->avatar()->associate($user->uid_avatar);
                $victima->exp = $request->exp;
                $victima->evolucion = $request->evolucion;
                $victima->save();
            }
        	

        	return new VictimaResource($victima);
        }*/

        public function agregarAvatar(Request $request)
        {
            $avatar = new Avatar;
            $avatar->uid_avatar = $request->avatar;
            $avatar->exp = $request->exp;
            $avatar->save();
            //dd($avatar);

            return new AvatarResource($avatar);
        }

         public function consultarPerfil(Request $request){
            
            $user = \App\User::where('uid_user', $request->uid)->first();
            $perfil = \App\Perfil::where('uid_user', $request->uid)->get();
            if($perfil->isEmpty()){
                
                $perfil = new Perfil;
                $perfil->uid_user = $user->uid_user;
                $perfil->uid_avatar = $user->uid_avatar;

                $ranking = \App\Ranking::where('uid_user', $request->uid)->get();
                
                if($ranking->isEmpty()){
                
                    $perfil->puntos = 0;
                    $perfil->ranking = 0;
                
                }else{
                
                    $ranking = \App\Ranking::where('uid_user', $request->uid)->first();
                    $perfil->puntos = $ranking->puntos;
                    $perfil->ranking = $this->pelea->ranking($request->uid);
                }

            }else{
                $perfil = \App\Perfil::where('uid_user', $request->uid)->first();

                 $ranking = \App\Ranking::where('uid_user', $request->uid)->get();
                
                if($ranking->isEmpty()){
                
                    $perfil->puntos = 0;
                    $perfil->ranking = 0;
                
                }else{
                
                    $ranking = \App\Ranking::where('uid_user', $request->uid)->first();
                    $perfil->puntos = $ranking->puntos;
                    $perfil->ranking = $this->pelea->ranking($request->uid);
                }
            }

            $perfil->save();
        
            return new PerfilResource($perfil);
         }

         /*public function TodoRankingGlobal(Request $request){

            $user = $request->uid;
            $ranking = \App\Ranking::all();
            $rankingGlobal = \App\Ranking::orderBy('puntos','desc')->get();
            $position = $rankingGlobal->search(function($ranking, $key) use ($user){
                return $ranking->uid_user == $user;
            });                         

            return response()->json([
                'position'=> $position+1
            ]);
         }*/

         public function miRankingGlobal(Request $request){

            $user = $request->uid;
            $ranking = \App\Ranking::all();
            $rankingGlobal = \App\Ranking::orderBy('puntos','desc')->get();
            $position = $rankingGlobal->search(function($ranking, $key) use ($user){
                return $ranking->uid_user == $user;
            });                         

            return response()->json([
                'position'=> $position+1
            ]);
         }

         public function afiliacionGym(Request $request){

            $gym = \App\Gimnasio::where('uid_gym', $request->uid_gym)->first();
            if(!$gym) return "ERROR 7";
            $user = \App\User::where('uid_user', $request->uid_user)->first();
            $datoMascota = \App\DatoMascota::where('id', $request->uid_avatar)->first();
            if(!$datoMascota) return "ERROR 3 ".$request->avatar."";
            $ligaActual = \App\Liga::where('uid_user', $request->uid_user)->first();
            if($ligaActual) $ligaActual->delete();
            $tieneMedalla = \App\HistoricoMedalla::where('uid_user', $request->uid_user)->where('uid_gym',$gym->medal)->first();
            if(!$tieneMedalla) return "ERROR 8";
            //verificar que este en otra liga
            // debe tener la medalla
            $avatar = NULL;


            if($user){
                $avatar = \App\Avatar::where('id', $user->uid_avatar)->first();
                if(!$avatar){
                    $avatar = new Avatar;
                }
            }else{
                $avatar = new Avatar;
                $user = new User;
            }

            $avatar->uid_avatar = $request->uid_avatar;
            $avatar->exp = $request->exp;
            $avatar->save();

            $user->uid_user = $request->uid_user;
            $user->avatar()->associate($avatar->id);
            $user->exp = 0;
            $user->save();

            $liga = new Liga;
            $liga->uid_liga = $gym->uid_gym;
            $liga->user()->associate($user->uid_user);
            $liga->puntos = 0;
            $liga->uid_gym = $gym->uid_gym;
            $liga->save();

            /*if($user->isEmpty()){
                $avatar = \App\Avatar::where('uid_avatar', $request->uid_avatar)->get();
                if($avatar->isEmpty()){
                    $avatar = new Avatar;
                    $avatar->uid_avatar = $request->uid_avatar;
                    $avatar->exp = $request->exp;
                    $avatar->save();

                    $user = new User;
                    $user->uid_user = $request->uid_user;
                    $user->avatar()->associate($avatar->uid_avatar);
                    $user->exp = $request->exp;
                    $user->save();

                    $liga = new Liga;
                    $liga->uid_liga = $gym->uid_gym;
                    $liga->user()->associate($user->uid_user);
                    $liga->puntos = 0;
                    $liga->uid_gym = $gym->uid_gym;
                    $liga->save();

                }else{
                   $avatar = \App\Avatar::where('uid_avatar', $request->uid_avatar)->first();
                    
                    $user = new User;
                    $user->uid_user = $request->uid_user;
                    $user->avatar()->associate($avatar->uid_avatar);
                    $user->exp = $request->exp;
                    $user->save();

                    $liga = new Liga;
                    $liga->uid_liga = $gym->uid_gym;
                    $liga->user()->associate($user->uid_user);
                    $liga->puntos = 0;
                    $liga->uid_gym = $gym->uid_gym;
                    $liga->save();
                }
                

            }else{

                $user = \App\User::where('uid_user', $request->uid_user)->first();
                $liga = new Liga;
                $liga->uid_liga = $gym->uid_gym;
                $liga->user()->associate($user->uid_user);
                $liga->puntos = 0;
                $liga->uid_gym = $gym->uid_gym;
                $liga->save();
            }*/

            return new LigaResource($liga);
         }

         public function desafiliacionGym(Request $request)
         {
            $desafiliar = \App\Liga::where('uid_user', $request->uid_user)
                                    ->where('uid_gym', $request->uid_gym)->delete();

            return 'Exitoso';
         }


         public function topRankingGlobal()
         {
            return RankingCollection::collection(Ranking::orderBy('puntos','desc')->get());
         }

         public function topRankingLiga(Request $request)
         {
          
            return LigaCollection::collection(Liga::where('uid_liga', $request->uid_liga)
                                ->orderBy('puntos','desc')
                                ->get());                   
         }

         public function miRankingLiga(Request $request){

            $progreso   = \App\ProgresoLiga::where('uid_user', $request->uid_user)
                                             ->where('uid_liga_oponente', $request->uid_liga)
                                             ->first();
                                             if($progreso){
                                                 return "".$progreso->victorias;
                                             }else{
                                                return "0";
                                             }
         }
        

         public function inscribirLigaCombate(Request $request)
         {
            $inscribir = new ProgresoLiga;
            $inscribir->uid_liga_oponente = $request->uid_liga_oponente;
            $liga = \App\Liga::where('uid_user', $request->uid_user)
                                ->where('uid_liga', $request->uid_liga)->get();
            
            if($liga->isEmpty())
            {
                $inscribir->uid_liga = null;
                $user = \App\User::where('uid_user', $request->uid_user)->first();
                $inscribir->uid_user = $user->uid_user;
                $inscribir->victorias = 0;
                $inscribir->derrotas = 0; 
                $inscribir->save();
            }
            else
            {
                $liga = \App\Liga::where('uid_user', $request->uid_user)
                                ->where('uid_liga', $request->uid_liga)->first();
                $inscribir->liga()->associate($liga->uid_liga);
                $inscribir->ligaUser()->associate($liga->uid_user);
                $inscribir->victorias = 0;
                $inscribir->derrotas = 0;
                $inscribir->save();
            }

            return new ProgresoLigaResource($inscribir);
         }

         

         public function misDatosLiga(Request $request)
         {
            $progreso = \App\ProgresoLiga::where('uid_user', $request->uid_user)->first();

            return new ProgresoLigaResource($progreso);
         }

         public function peleaLiga(Request $request)
         {

            
            $progreso   = \App\ProgresoLiga::where('uid_user', $request->uid_user)
                                             ->where('uid_liga_oponente', $request->uid_liga_oponente)
                                             ->first();
            $user       = \App\User::where('uid_user', $request->uid_user)->first();
            if($user->avatar->uid_avatar == $request->avatar){
                $user->avatar->exp = $request->exp;
                $user->avatar->save();
            }else{
                $avatar = new Avatar;
                $avatar->uid_avatar = $request->avatar;
                $avatar->exp =$request->exp;
                $avatar->save();
                $user->avatar()->associate($avatar->id);
                $user->save();
                $user = \App\User::where('uid_user', $request->uid_user)->first();
            }

            $top = Liga::where('uid_liga', $request->uid_liga_oponente)
            ->orderBy('puntos','desc')
            ->get();

            $uid_user_oponente = "";
            if(!$progreso){
                $progreso = new ProgresoLiga;
                $progreso->victorias = 0;
                $progreso->derrotas = 0;
            }
            $oponente_actual = 9 - $progreso->victorias;
            $contTop = count($top);
            if($contTop < $oponente_actual){
                $uid_user_oponente = $top[$contTop - 1]->uid_user;
            }else{
                $uid_user_oponente = $top[$oponente_actual ]->uid_user;
            }
            
            $user_oponente  = \App\User::where('uid_user', $uid_user_oponente)->first();
            if(!$user_oponente ) return "ERROR NO EXISTE ".$uid_user_oponente;

            $resultadoPelea = $this->pelea->simularPelea($user, $user_oponente);

            if($resultadoPelea === "NO VALIDO"){
                return "ERROR ".$resultadoPelea;
            }
            

            $perdedor = NULL;
            $ganador = NULL;
            $usuario = $user;

            if($resultadoPelea["ganador"] == $user->uid_user){
                $ganador = $user;
                $perdedor = $user_oponente;
            }else{
                $ganador = $user_oponente;
                $perdedor = $user;
            }

            
            $progreso = NULL;

            if($ganador == $usuario)
            {
                $progreso = \App\ProgresoLiga::where('uid_user', $request->uid_user)->first();
                if(!$progreso){
                    $progreso = new ProgresoLiga();
                    $progreso->uid_user = $request->uid_user;
                    $progreso->derrotas = 0;
                    $progreso->victorias = 0;
                }
                $progreso->victorias += 1;
                //$progreso->save();

                $ranking = \App\Ranking::where('uid_user', $user->uid_user)->get();
             if($ranking->isEmpty())
             {
                $ranking = new Ranking;
                $ranking->user()->associate($user->uid_user);
                $ranking->puntos = 3;
                $ranking->save();

             }else{
                $ranking = \App\Ranking::where('uid_user', $user->uid_user)->first();
                $ranking->puntos += 3;
                $ranking->save();
             }
            
            }else{
                $progreso = \App\ProgresoLiga::where('uid_user', $request->uid_user)->first();
                if(!$progreso){
                    $progreso = new ProgresoLiga();
                    $progreso->uid_user = $request->uid_user;
                    $progreso->derrotas = 0;
                    $progreso->victorias = 0;
                }
                $progreso->derrotas += 1;
                //$progreso->save();

                $ranking = \App\Ranking::where('uid_user', $user->uid_user)->get();
             if($ranking->isEmpty())
             {
                $ranking = new Ranking;
                $ranking->user()->associate($user->uid_user);
                $ranking->puntos = 1;
                $ranking->save();

             }else{
                $ranking = \App\Ranking::where('uid_user', $user->uid_user)->first();
                $ranking->puntos +=1;
                $ranking->save();
             }
            }

            $progreso->uid_liga_oponente = $request->uid_liga_oponente;
            $progreso->save();

            if($progreso->victorias == 10)
            {
                $gym = \App\Gimnasio::where('uid_gym', $request->uid_liga_oponente)->first();

                $medalla = new Medalla;
                $medalla->uid_user = $progreso->uid_user;
                $medalla->uid_gym = $gym->medal;
                $medalla->save();

                $historico = new HistoricoMedalla;
                $historico->uid_user = $progreso->uid_user;
                $historico->uid_gym = $gym->medal;
                $historico->save();

                $progreso->delete();
            }

            $ligaActual = \App\Liga::where('uid_user', $request->uid_user)->first();
            
            return response()->json([
                'jugadorA' => $resultadoPelea["jugadorA"],
                'avatarA' => $resultadoPelea["avatarA"],
                'evolucionA'=> $resultadoPelea["evolucionA"],
                'experienciaA'=> $resultadoPelea["experienciaA"],
                //'experienciaPoderA'=> $resultadoPelea["experienciaA"],
                'jugadorB' => $resultadoPelea["jugadorB"],
                'avatarB' => $resultadoPelea["avatarB"],
                'evolucionB'=> $resultadoPelea["evolucionB"],
                'experienciaB'=> $resultadoPelea["experienciaB"],
                //'experienciaPoderB'=> $resultadoPelea["experienciaB"],
                'ganador' => $resultadoPelea["ganador"],
                'BonoA' => $resultadoPelea["BonoA"] ,
                'BonoB' => $resultadoPelea["BonoB"] ,
                'EvolucionaA'=>  $resultadoPelea["EvolucionaA"],
                'EvolucionaB' => $resultadoPelea["EvolucionaB"],
                'experienciaGanadador'=> 25,
                'experienciaPerdedor'=> 10,
                'LigaA'=> $ligaActual ? $ligaActual->uid_gym : "no",
                'LigaB'=> $request->uid_liga_oponente,
                'victorias'=> $progreso->victorias,
                'derrotas'=> $progreso->derrotas
			
            ]);

         }

         public function misMedallas(Request $request)
         {
        
            return MedallaResource::collection(Medalla::where('uid_user', $request->uid_user)->get());
         }

         public function todasMisMedallas(Request $request)
         {
            
            return HistoricoMedallaCollection::collection(HistoricoMedalla::where('uid_user', $request->uid_user)->get());   
            
         }

         public function inscribirTorneo(Request $request)
         {
            $torneo = \App\Torneo::where('uid_torneo', $request->uid_torneo)->first();

            $numeroMedallas = $torneo->medallas;

            $medallas =\App\Medalla::where('uid_user', $request->uid_user)->count();

            if($numeroMedallas <= $medallas)
            {
                $inscribir = new InscritosTorneo;
                $inscribir->uid_torneo = $request->uid_torneo;
                $inscribir->uid_user = $request->uid_user;
                $user = \App\User::where('uid_user', $request->uid_user)->first();
                $inscribir->uid_avatar = $user->uid_avatar;
                $inscribir->exp = $user->exp;
                $inscribir->save();
                $medallas =\App\Medalla::where('uid_user', $request->uid_user)
                                        ->where('uid_gym', $request->uid_gym)
                                        ->delete();

            }else{
                return response()->json([
                    'error'=>'no tiene las suficientes medallas'
                ]);
            }

            return new InscritoTorneoResource($inscribir);
         }

         public function torneo(){

            $ganador = $this->pelea->simularTorneo();

            return response(null, Response::HTTP_NO_CONTENT);
         }

         public function inscribirConcurso(Request $request)
         {
            $concurso = \App\Concurso::where('uid_concurso', $request->uid_concurso)->first();

            $user = \App\User::where('uid_user', $request->uid_user)->get();
            if($user->isEmpty()){
                $user = new User;
                $user->uid_user = $request->uid_user;
                $avatar = \App\Avatar::where('uid_avatar', $request->uid_avatar)->get();
                if($avatar->isEmpty()){
                    $avatar = new Avatar;
                    $avatar->uid_avatar = $request->uid_avatar;
                    $avatar->exp = $request->exp;
                    $avatar->save();
                }
                $user->avatar()->associate($avatar->uid_avatar);
                $user->exp = $request->exp;
                $user->save();

            }
            $user = \App\User::where('uid_user', $request->uid_user)->first();
            $avatar = \App\Avatar::where('uid_avatar', $user->uid_avatar)->get();

            if($avatar->isEmpty()){
                $avatar = new Avatar;
                    $avatar->uid_avatar = $user->uid_avatar;
                    $avatar->exp = $user->exp;
                    $avatar->save();
            }
            $avatar = \App\Avatar::where('uid_avatar', $user->uid_avatar)->first();
            $verificar = \App\InscritoConcurso::where('uid_user', $request->uid_user)->get();
            if($verificar->isEmpty()){
              $inscrito = new InscritoConcurso;
              $inscrito->uid_concurso = $request->uid_concurso;
              $inscrito->uid_user = $user->uid_user;
              $inscrito->id_avatar = $avatar->id;
              $inscrito->exp = $avatar->exp;
              $inscrito->save();   
            }
            else{
                return response()->json([
                    'error' => 'ya se encuentra inscrito'
                ]);
            }


            return new InscritoConcursoResource($inscrito);

         }

         public function concurso()
         {
            $participantes = $this->pelea->simularConcurso();
            return response(null, Response::HTTP_NO_CONTENT);
         }

         public function detalleTorneo(Request $request)
         {
            
            return DetalleTorneoCollection::collection(DetalleTorneo::where('uid_torneo', $request->uid_torneo)->get());
         }

         public function detalleConcurso(Request $request)
         {
            return DetalleConcursoCollection::collection(DetalleConcurso::where('uid_concurso', $request->uid_concurso)->get());
         }

         public function todosLosGimnasios(){

            return GimnasioCollection::collection(Gimnasio::all());
         }

         public function todosLosTorneos(){

            return TorneoCollection::collection(Torneo::all());

         }

         public function todosLosConcursos(){

            return ConcursoCollection::collection(Concurso::all());
         }
    }
