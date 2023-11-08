@foreach ($invoices as $invoice )

   <div class="modal fade" id="InvoiceModal{{ $invoice->id }}" tabindex="-1" role="dialog" aria-labelledby="InvoiceModalLabel" aria-hidden="true" >
      <div class="modal-dialog" role="document">
        <div class="modal-content bg-zinc-500">
          <div class="modal-header">
            <h5 class="modal-title text-white" id="InvoiceModalLabel">Información de la factura {{$invoice->id}}</h5>
            <button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <div class="mb-4">
                <div class="form-group">
                    <label for="id">Id:</label>
                    <input type="text" class="form-control" id="id" name="id" value="{{ $invoice->id }}" readonly>
                </div>
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $invoice->nombre }}" readonly>
                </div>
                <div class="form-group">
                    <label for="cifCliente">CIF cliente:</label>
                    <input type="text" class="form-control" id="cifCliente" name="cifCliente" value="{{ $invoice->cifCliente }}" readonly>
                </div>
                <div class="form-group">
                    <label for="fecha">Fecha:</label>
                    <input type="text" class="form-control" id="fecha" name="fecha" value="{{ $invoice->fecha }}" readonly>
                </div>
                <div class="form-group">
                    <label for="desc">Descripción:</label>
                    <input type="text" class="form-control" id="desc" name="desc" value="{{ $invoice->desc }}" readonly>
                </div>
                <div class="form-group">
                    <label for="precioUnitario">Precio unitario:</label>
                    <input type="text" class="form-control" id="precioUnitario" name="precioUnitario" value="{{ $invoice->precioUnitario }}" readonly>
                </div>
                <div class="form-group">
                    <label for="precioTotal">Precio total:</label>
                    <input type="text" class="form-control" id="precioTotal" name="precioTotal" value="{{ $invoice->precioTotal }}" readonly>
                </div>
                <div class="form-group">
                    <label for="iva">IVA:</label>
                    <input type="text" class="form-control" id="iva" name="iva" value="{{ $invoice->iva }}" readonly>
                </div>
                <div class="form-group">
                    <label for="precioFinal">Precio final:</label>
                    <input type="text" class="form-control" id="precioFinal" name="precioFinal" value="{{ $invoice->precioFinal }}" readonly>
                </div>
                <div class="form-group">
                    <label for="estado">Estado:</label>
                    <input type="text" class="form-control" id="estado" name="estado" value="{{ $invoice->estado ? 'Checked' : 'Not checked' }}" readonly>
                </div>
            </div>
            </div>
          </div>
        </div>
      </div>

@endforeach
