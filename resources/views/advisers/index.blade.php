@extends('layouts.app')

@section('content')
      @if ($clients->isEmpty())
        <div class="flex flex-col items-center justify-center h-64">
          <p class="text-white text-2xl mb-4">No se han encontrado clientes</p>
        </div>
        @else

<div class="py-6">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between mb-4">
      <h2 class="text-2xl font-bold leading-tight text-white">Clientes</h2>
      <form method="post" action="{{ route('send-reminder') }}">
        @csrf
        <button type="submit" class="inline-flex items-center px-4 py-2 bg-teal-500  rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-teal-600 active:bg-teal-700 focus:outline-none disabled:opacity-25 transition ease-in-out duration-150">Enviar recordatorio</button>
      </form>  

    </div>

    @if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
      <span class="block sm:inline">{{session('success')}}</span>
    </div>
@endif
    <div class="overflow-x-auto">
      
<table class="min-w-full bg-zinc-700  divide-y divide-zinc-500">
          <thead class="bg-zinc-400">
              <tr>
                  <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">CIF</th>
                  <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Nombre</th>
                  <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Email</th>
                  <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Teléfono</th>
                  <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Acciones</th>
                  <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Descargar</th>
              </tr>
          </thead>
          <tbody class="divide-y divide-zinc-500">
            @foreach ($clients as $client)
            <tr>
              <td class="px-6 py-4 whitespace-nowrap text-white">{{ $client->cif }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-white">{{ $client->name }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-white">{{ $client->email }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-white">{{ $client->phone }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-white">
                <a href="{{route('client.invoices',$client->id)}}" class="text-teal-600 hover:text-teal-900">Ver Facturas</a>
                <a href="{{route('client.expenses',$client->id)}}" class="text-teal-600 hover:text-teal-900">Ver gastos</a>
              </td>
              <td> 
                <form method="GET" action="{{ route('clients.download', $client->id) }}">
                    @csrf
                    <button type="submit" class="px-4 py-2 text-black bg-teal-500 rounded-md hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                        Descargar como ZIP
                    </button>
                </form>
            </td>
            </tr>
          @endforeach
          </tbody>
        </table>
        {{$clients->links()}}
      @endif
    </div>
  </div>
</div>
@endsection

