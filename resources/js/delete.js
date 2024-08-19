function confirmDelete(event) {
    event.preventDefault(); // Mencegah form dari pengiriman default

    Swal.fire({
        title: "Apa Anda yakin?",
        text: "Cek kembali karena inputan tidak dapat dikembalikan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Hapus",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            // Kirim formulir setelah konfirmasi
            event.target.closest("form").submit();
        }
    });
}

// Daftarkan event handler untuk tombol hapus
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll("form.delete-form").forEach(function (form) {
        form.addEventListener("submit", confirmDelete);
    });
});
