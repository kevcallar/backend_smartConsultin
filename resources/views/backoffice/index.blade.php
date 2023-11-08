@extends('layouts.app')

@section('content')
          @if ($advisers->isEmpty())
          <div class="flex flex-col items-center justify-center h-64">
            <p class="text-white text-2xl mb-4">No se han encontrado asesores</p>
            <a href="#" data-bs-toggle="modal" data-bs-target="#ModalCreate" class="bg-teal-500 hover:bg-teal-600 text-black font-bold py-2 px-4 rounded">Crear</a> 
        </div>
        @else
<div class="py-6">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between mb-4">
      <h2 class="text-2xl font-bold leading-tight text-white">Asesores</h2>
      <a href="#" data-bs-toggle="modal" data-bs-target="#ModalCreate" class="inline-block bg-teal-500 text-black py-2 px-4 rounded-md hover:bg-teal-600">Añadir</a>
    </div>
    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
    @if (session('success'))
    <div class="success alert-success">
        {{ session('success') }}
    </div>
@endif
    <div class="overflow-x-auto">
      <table class="min-w-full bg-zinc-700 divide-y divide-zinc-500">
        <thead class="bg-zinc-400">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">ID</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Nombre</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Email</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-zinc-500">
          @foreach ($advisers as $adviser)
            <tr>
              <td class="px-6 py-4 whitespace-nowrap text-white">{{ $adviser->id }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-white">{{ $adviser->name }}</td>          
              <td class="px-6 py-4 whitespace-nowrap text-white">{{ $adviser->email }}</td>
              <td class="px-6 py-4 whitespace-nowrap">
                <a href="#" data-bs-toggle="modal" data-bs-target="#ModalEdit{{$adviser->id}}" class="text-teal-600 hover:text-teal-900 mr-2">Editar</a>
    
                <form action="{{ route('advisers.destroy', $adviser) }}" method="POST" class="inline-block">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                </form>
              </td>
            </tr>
            <livewire:edit-modal :adviser="$adviser">
          @endforeach
          </tbody>
        </table>
      @endif
    </div>
  </div>
</div>
<x-create-modal-view></x-create-modal-view>
@endsection