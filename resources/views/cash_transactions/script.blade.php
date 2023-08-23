<script>
	$(function () {
		let loadingAlert = $('.modal-body #loading-alert');

		$('#datatable').DataTable({
			processing: true,
			serverSide: true,
			ajax: "{{ route('cash-transactions.index') }}",
			columns: [
				{ data: 'DT_RowIndex', name: 'DT_RowIndex' },
				{ data: 'students.name', name: 'students.name' },
				{ data: 'amount', name: 'amount' },
				{ data: 'category', name: 'category' },
				{ data: 'date', name: 'date' },
				{ data: 'action', name: 'action' },
			]
		});

		$('#datatable').on('click', '.cash-transaction-detail', function () {
			loadingAlert.show();

			let id = $(this).data('id');
			let url = "{{ route('api.cash-transaction.show', ':param') }}";
			url = url.replace(':param', id);

			$('#showCashTransactionModal :input').val('Sedang mengambil data..');

			$.ajax({
				url: url,
				headers: {
					'Authorization': 'Bearer ' + localStorage.getItem('token'),
					'Accept': 'application/json',
				},
				success: function (response) {
					loadingAlert.slideUp();

					$('#showCashTransactionModal #user_id').val(response.data.users.name);
					$('#showCashTransactionModal #student_id').val(response.data.students.name);
					$('#showCashTransactionModal #amount').val(response.data.amount);
					$('#showCashTransactionModal #category').val(response.data.category);
					$('#showCashTransactionModal #is_paid').val(response.data.is_paid);
					$('#showCashTransactionModal #date').val(response.data.date);
					$('#showCashTransactionModal #note').val(response.data.note);
				}
			});
		});

		$('#datatable').on('click', '.cash-transaction-edit', function () {
			loadingAlert.show();

			let id = $(this).data('id');
			let url = "{{ route('api.cash-transaction.edit', ':param') }}";
			url = url.replace(':param', id);

			let formActionURL = "{{ route('cash-transactions.update', ':param') }}";
			formActionURL = formActionURL.replace(':param', id);

			let editSchoolClassModalEveryInput = $('#editCashTransactionModal :input').not('button[type=button], input[name=_token], input[name=_method]')
				.each(function () {
					$(this).not('select').val('Sedang mengambil data..');
					$(this).prop('disabled', true);
				});

			$.ajax({
				url: url,
				headers: {
					'Authorization': 'Bearer ' + localStorage.getItem('token'),
					'Accept': 'application/json',
				},
				success: function (response) {
					loadingAlert.slideUp();

					$('#editCashTransactionModal .modal-body #cash-transaction-edit-form').attr('action', formActionURL);
					editSchoolClassModalEveryInput.prop('disabled', false);

					$('#editCashTransactionModal #student_name').val(response.data.students.name);
					$('#editCashTransactionModal #student_id').val(response.data.student_id);
					$('#editCashTransactionModal #amount').val(response.data.amount);
					$('#editCashTransactionModal #category').val(response.data.category);
					$('#editCashTransactionModal #is_paid').val(response.data.is_paid);
					$('#editCashTransactionModal #date').val(response.data.date);
					$('#editCashTransactionModal #note').val(response.data.note);
				}
			});
		});

		const checkbox = document.getElementById('lain_lain_checkbox');
        const inputField = document.getElementById('lain_lain_value');
        const hiddenInput = document.getElementById('lain_lain_hidden');

        checkbox.addEventListener('change', function() {
            inputField.disabled = !this.checked;
            if (!this.checked) {
                inputField.value = ''; // Clear input value when unchecked
                hiddenInput.value = '';
            }
        });

        inputField.addEventListener('input', function() {
            hiddenInput.value = this.value;
        });
	});
	
	$('#filter').click(function () {
			let start_date = $('#start_date').val();
			let end_date = $('#end_date').val();

			$.ajax({
					url: "cashTransactions/filter", // Ganti dengan route yang sesuai untuk filter di halaman Data Pengeluaran
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
										{ data: 'students.name', name: 'students.name' },
										{ data: 'amount', name: 'amount' },
										{ data: 'category', name: 'category' },
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
</script>
