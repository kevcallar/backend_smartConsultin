@php
use App\Models\EmailCode;
use App\Models\Client;
        $id = mt_rand(1000, 9999);    
        $code=new EmailCode;
        $code->otp=$id;
        $code->client_id=$client->id;
        $code->save();
        @endphp
<div>
        @if ($client->status==='activo')
        <p>Si ha olvidado su contraseña y desea cambiarla deberá Introducir el código de este email para poder generar otra nueva</p>
        <p>
                <b>
                    {{$id}}
        
                </b>
        </p>
        <p>Si usted no ha pedido cambiar la contraseña no haga caso.</p>
        @else
        <p>para activar su cuenta introduzca el código siguiente</p>
<p>
        <b>
            {{$id}}

        </b>
</p>
        
        @endif
</div>
