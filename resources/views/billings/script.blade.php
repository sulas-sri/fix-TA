<script>
	$(function () {
			let loadingAlert = $('.modal-body #loading-alert');

			$('#datatable').DataTable({
					processing: true,
					serverSide: true,
					ajax: "{{ route('billings.index') }}",
					columns: [
							{ data: 'DT_RowIndex', name: 'DT_RowIndex' },
							{ data: 'students.name', name: 'students.name' },
							{ data: 'id_telegram', name: 'id_telegram' },
							{ data: 'bill', name: 'bill' },
							{ data: 'kategori_tagihan', name: 'kategori_tagihan' },
							{ data: 'date', name: 'date' },
							{ data: 'action', name: 'action' },
					]
			});

			$('#datatable').on('click', '.billing-detail', function () {
					loadingAlert.show();

					let id = $(this).data('id');
					let url = "{{ route('api.billings.show', ':param') }}";
					url = url.replace(':param', id);

					$('#showBillingModal :input').val('Sedang mengambil data..');

					$.ajax({
							url: url,
							headers: {
									'Authorization': 'Bearer ' + localStorage.getItem('token'),
									'Accept': 'application/json',
							},
							success: function (response) {
									loadingAlert.slideUp();

									$('#showBillingModal #user_id').val(response.data.users.name);
									$('#showBillingModal #student_id').val(response.data.students.name);
									$('#showBillingModal #bill').val(response.data.bill);
									$('#showBillingModal #id_telegram').val(response.data.id_telegram);
									$('#showBillingModal #date').val(response.data.date);
									$('#showBillingModal #kategori_tagihan').val(response.data.kategori_tagihan);
							}
					});
			});

			$('#datatable').on('click', '.billing-edit', function () {
					loadingAlert.show();

					let id = $(this).data('id');
					let url = "{{ route('api.billings.edit', ':param') }}";
					url = url.replace(':param', id);

					let formActionURL = "{{ route('billings.update', ':param') }}";
					formActionURL = formActionURL.replace(':param', id);

					let editBillingModalEveryInput = $('#editBillingModal :input').not('button[type=button], input[name=_token], input[name=_method]')
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

									$('#editBillingModal .modal-body #billing-edit-form').attr('action', formActionURL);
									editBillingModalEveryInput.prop('disabled', false);

									$('#editBillingModal #student_name').val(response.data.students.name);
									$('#editBillingModal #student_id').val(response.data.student_id);
									$('#editBillingModal #bill').val(response.data.bill);
									$('#editBillingModal #id_telegram').val(response.data.id_telegram);
									$('#editBillingModal #date').val(response.data.date);
									$('#editBillingModal #kategori_tagihan').val(response.data.kategori_tagihan);
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

		// 	$('#datatable').on('click', '.send-notification', function () {
    //     let id = $(this).data('id');
    //     let url = "{{ route('billings.sendNotification', ':param') }}";
    //     url = url.replace(':param', id);

    //     $.ajax({
    //         url: url,
    //         method: 'POST',
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         success: function (response) {
    //             console.log(response);
    //         },
    //         error: function (xhr, status, error) {
    //             console.log(xhr.responseText);
    //         }
    //     });
    // });

</script>
