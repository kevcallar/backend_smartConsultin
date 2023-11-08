@foreach ($expenses as $expense )

   <div class="modal fade" id="ExpenseModal{{ $expense->id }}" tabindex="-1" role="dialog" aria-labelledby="ExpenseModalLabel" aria-hidden="true" >
      <div class="modal-dialog" role="document">
        <div class="modal-content bg-zinc-500">
          <div class="modal-header">
            <h5 class="modal-title text-white" id="ExpenseModalLabel">Imagen del gasto {{$expense->id}}</h5>
            <button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <img src="{{ url('/api/getExpense', ['id' => $expense->id])}}" alt="Expense image">
            </div>
          </div>
        </div>
      </div>

@endforeach
 
