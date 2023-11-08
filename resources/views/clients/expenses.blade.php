@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <div class="bg-zinc-700 p-6 rounded-lg shadow-md mb-6 mt-4"> {{--Esto es la card con la información del cliente--}}
            <h2 class="text-2xl font-semibold mb-2 text-white">{{ $client->name }}</h2>
            <div class="text-gray-300">
                <p class="mb-2"><strong>CIF:</strong> {{ $client->cif }}</p>
                <p class="mb-2"><strong>Teléfono:</strong> {{ $client->phone }}</p>
                <p><strong>Email:</strong> {{ $client->email }}</p>
            </div>
        </div>
@if ($expenses->isEmpty())
<div class="flex flex-col items-center justify-center h-64">
    <p class="text-gray-200 text-2xl mb-4">No se han encontrado documentos</p>
</div>
    @else

        <table class="min-w-full bg-zinc-700 divide-y divide-zinc-500">
            <thead class="bg-zinc-400">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-200 uppercase tracking-wider">Fecha</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-200 uppercase tracking-wider">Tipo</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-200 uppercase tracking-wider">
                        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Cambia el estado del documento">Estado
                          </span></th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-200 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-500">
                @foreach ($expenses as $expense )
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-white">{{ $expense->created_at->format('d-m-Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-white">{{ $expense->type }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                              <div class="form-check form-switch">
                                <span tabindex="0" data-toggle="tooltip" title="Cambia el estado del documento">
                                    <input class="form-check-input checked:bg-teal-500 checked:hover:text-teal-500 checked:focus:bg-teal-500 checked:focus:border-teal-500 focus:ring-teal-500 dark:focus:ring-teal-600 dark:focus:ring-offset-teal-800" type="checkbox" id="ExpenseToggle" name="state" value="1" data-expense-id="{{ $expense->id }}" @if($expense->state == 1) checked @endif>
                                </span> 
                              </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                          <a href="#" data-bs-toggle="modal" data-bs-target="#ExpenseModal{{ $expense->id }}" class="text-teal-500 hover:text-teal-200">Ver</a>
                        </td> 
                      </tr>
                      @endforeach
                    </tbody>
                </table>
                {{$expenses->links()}}
    
@endif
                    </div>

                    <livewire:expense-modal :expenses="$client->expenses" />
                    {{--He tenido que añadir $client->expenses/invoices porque si no hay conflicto con el modal y la paginación--}}
                    
                    <script>
                        
$(function () {
    $('[data-toggle=tooltip]').tooltip()
  })
                    </script>
                  @endsection