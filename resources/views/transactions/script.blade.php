<!-- resources/views/transactions/scripts.blade.php -->

<script>
	$(function () {
			let loadingAlert = $('.modal-body #loading-alert');

			$('#datatable').DataTable({
					processing: true,
					serverSide: true,
					ajax: "{{ route('transactions.index') }}",
					columns: [
							{ data: 'DT_RowIndex', name: 'DT_RowIndex' },
							{ data: 'amount', name: 'amount' },
							{ data: 'description', name: 'description' },
							{ data: 'date', name: 'date' },
							{ data: 'action', name: 'action' },
					]
			});

			$('#datatable').on('click', '.transaction-detail', function () {
				$('#showTransactionModal').on('show.bs.modal', function(event) {
					var button = $(event.relatedTarget);
					var date = button.data('date');
					var description = button.data('description');
					var amount = button.data('amount');

					var modal = $(this);
					modal.find('#date').val(date);
					modal.find('#description').val(description);
					modal.find('#amount').val(amount);
			});
			});

			$('#datatable').on('click', '.transaction-edit', function () {
					// Your logic for editing transactions goes here
			});

			$('#filter').click(function () {
			let start_date = $('#start_date').val();
			let end_date = $('#end_date').val();

			$.ajax({
					url: "transactions/filter", // Ganti dengan route yang sesuai untuk filter di halaman Data Pengeluaran
					type: 'POST',
					cache: false,
					data: {
							'start_date': start_date,
							'end_date': end_date,
							'_token' : '{{csrf_token()}}'
					},
					success: function (res) {
							$('#datatable').DataTable().clear().destroy();
							$('#datatable').DataTable({
									data: res.data,
									columns: [
											{ data: 'DT_RowIndex', name: 'DT_RowIndex' },
											{ data: 'amount', name: 'amount' },
											{ data: 'description', name: 'description' },
											{ data: 'date', name: 'date' },
											{ data: 'action', name: 'action' },
									]
							});

							Toastify({
									text: "Berhasil mengambil data",
									duration: 3000,
									close: true,
									backgroundColor: "#4fbe87",
							}).showToast();
					},
					error: function () {
						$('#datatable-wrap').css('display', 'none');

                    Toastify({
                        text: "Kesalahan internal!",
                        duration: 3000,
                        close: true,
                        backgroundColor: "#f3616d",
                    }).showToast()
					}
			});
	});

	});
</script>
