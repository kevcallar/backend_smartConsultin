<form method="POST" action="{{ route('advisers.update',$adviser) }}">
    @csrf
    @method('PUT')
  <div class="modal fad" id="ModalEdit{{$adviser->id}}" tabindex="-1" role="dialog" aria-labelledby="ModalEditLabel" aria-hidden="true" >
      <div class="modal-dialog" role="document">
        <div class="modal-content bg-zinc-700">
          <div class="modal-header">
            <h5 class="modal-title text-white" id="ModalEditLabel">Editar asesor</h5>
            <button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
                <div class="mb-4">
                    <div class="form-group text-white">
                        <label for="id">id:</label>
                        <input type="text" class="form-control" id="id" name="id" value="{{ $adviser->id }}" readonly>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-white font-bold mb-2" for="name">
                        {{ __('Nombre') }}
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-black leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror" id="name" type="text" placeholder="{{ __('Nombre') }}" name="name" value="{{ old('name', $adviser->name) }}" required>
                    @error('name')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-white font-bold mb-2" for="surname">
                        {{ __('Apellido') }}
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-black leading-tight focus:outline-none focus:shadow-outline @error('surname') border-red-500 @enderror" id="surname" type="text" placeholder="{{ __('Apellidos') }}" name="surname" value="{{ old('surname', $adviser->surname) }}" required>
                    @error('surname')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-white font-bold mb-2" for="email">
                        {{ __('Email') }}
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-black leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror" id="email" type="email" placeholder="{{ __('Email') }}" name="email" value="{{ old('email', $adviser->email) }}" required>
                    @error('email')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex items-center justify-between">
                    <button class="bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                        Actualizar
                    </button>
                    
                    <a href="{{ route('backoffice') }}" class="inline-block align-baseline font-bold text-sm text-teal-500 hover:text-teal-800">
                        Cancelar
                    </a>
                </div>
            </div>
          </div>
        </div>
      </div>
    </form>
