//crédito: ayuda con chatGPT
$(document).ready(function() {
    
    // añadir listener
    $('.form-check-input').on('change', function() {
      var expenseId = $(this).data('expense-id');
      var newState = $(this).is(':checked') ? 1 : 0;
  
      // Petición AJAX para cambiar el estado del gasto
      $.ajax({
        url: '/api/putExpenseState/' + expenseId,
        type: 'PUT',
        data: { state: newState },
        success: function(response) {
          // si es success
          console.log(response);
          location.reload();
        },
        error: function(xhr, status, error) {
          // si es error
          console.error(error);
        }
      });
    });
  });

  $(document).ready(function() {
    // añadir listener
    $('.form-check-input').on('change', function() {
      var invoiceId = $(this).data('invoice-id');
      var newState = $(this).is(':checked') ? 1 : 0;
  
      // petición AJAX para cambiar el estado del ticket
      $.ajax({
        url: '/api/putInvoiceState/' + invoiceId,
        type: 'PUT',
        data: { estado: newState },
        success: function(response) {
          // si es success
          console.log(response);
          location.reload();
        },
        error: function(xhr, status, error) {
          // para el error
          console.error(error);
        }
      });
    });
  });

