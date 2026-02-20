if (successMessage) {
	Swal.fire({
		icon: 'success',
		title: 'Berhasil!',
		text: successMessage,
		timer: 3000,
		showConfirmButton: false
	});
}

if (errorMessage) {
	Swal.fire({
		icon: 'error',
		title: 'Error!',
		text: errorMessage,
		timer: 3000,
		showConfirmButton: false
	});
}
