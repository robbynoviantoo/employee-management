import './bootstrap';
import 'select2';
import 'select2/dist/css/select2.min.css';

$(document).ready(function() {
    $('#nik').select2({
        placeholder: 'Pilih NIK',
        allowClear: true
    });

    // Tampilkan nama karyawan saat NIK dipilih
    $('#nik').on('change', function() {
        const selectedOption = $(this).find('option:selected');
        const employeeName = selectedOption.data('nama');
        $('#employee_name').val(employeeName || '');
    });

    filterMateri(); // Panggil fungsi filterMateri saat halaman dimuat
});
