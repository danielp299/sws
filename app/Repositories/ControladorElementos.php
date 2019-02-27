<?php

namespace App\Repositories;

use Illuminate\Http\Request;

use Carbon\Carbon;
use App\ReglaElemento;

    class ControladorElementos{

        public function VerificarVentajaElemetoA($NombreElementoA,$NombreElementoB){


            $reglasElemento = \App\ReglaElemento::where('nombre',$NombreElementoA)->get();
            
            foreach ($reglasElemento as $regla) {
                if(strtoupper($regla->venceA) === strtoupper( $NombreElementoB ) ){
                    
                    return 1;
                }
            }

            $reglasElemento = \App\ReglaElemento::where('nombre',$NombreElementoB)->get();
            
            foreach ($reglasElemento as $regla) {
                if(strtoupper ($regla->venceA) === strtoupper($NombreElementoA) ){
                    return -1;
                }
            }

            return 0;
        }
	
	}
