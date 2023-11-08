<p>Estimado {{$client->name}},</p>

<p>Para poder acceder a la app, es necesario verificar tu cuenta</p>

<form method="PUT">
  Pulse
  <a href="{{url('/api/putActivateUser',$client->cif)}}">aqui</a>
  </form>