<form method="POST" action="{{ route('advisers.store') }}">
  @csrf
<div class="modal fade" id="ModalCreate" tabindex="-1" role="dialog" aria-labelledby="ModalCreateLabel" aria-hidden="true" >
    <div class="modal-dialog" role="document">
      <div class="modal-content bg-zinc-700">
        <div class="modal-header">
          <h5 class="modal-title text-white" id="ModalCreateLabel">Crear asesor</h5>
          <button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="flex flex-wrap mb-6">
                <div class="w-full">
                    <label class="block font-bold mb-2 text-white" for="name">
                        {{ __('Nombre') }}
                    </label>
                    <input id="name" type="text" class="form-input w-full @error('name') border-red-500 @enderror" name="name" value="{{ old('name') }}" required>

                    @error('name')
                        <span class="text-red-500 text-sm mt-2" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>

            <div class="flex flex-wrap mb-6">
                <div class="w-full">
                    <label class="block font-bold mb-2 text-white" for="surname">
                        {{ __('Apellidos') }}
                    </label>
                    <input id="surname" type="text" class="form-input w-full @error('surname') border-red-500 @enderror" name="surname" value="{{ old('surname') }}" required>

                    @error('surname')
                        <span class="text-red-500 text-sm mt-2" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>

            <div class="flex flex-wrap mb-6">
                <div class="w-full">
                    <label class="block font-bold mb-2 text-white" for="email">
                        {{ __('Email') }}
                    </label>
                    <input id="email" type="email" class="form-input w-full @error('email') border-red-500 @enderror" name="email" value="{{ old('email') }}" required>

                    @error('email')
                        <span class="text-red-500 text-sm mt-2" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-between">
                <button class="bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Crear
                </button>
                
                <a href="{{ route('backoffice') }}" class="inline-block align-baseline font-bold text-sm text-teal-500 hover:text-teal-800">
                    Cancelar
                </a>
          </div>
        </div>
      </div>
    </div>
  </form>