function formatDate(dateString) {
    var date = new Date(dateString);
    var day = ("0" + date.getDate()).slice(-2);
    var month = ("0" + (date.getMonth() + 1)).slice(-2);
    var year = date.getFullYear();
    return `${day}-${month}-${year}`;
}

function createContent(data, format) {
    let content =
        "<table style='width: 100%; border-collapse: collapse;'><thead><tr>";

    // Menambahkan header
    content += "<th style='border: 1px solid #ddd; padding: 8px;'>Field</th>";
    content += "<th style='border: 1px solid #ddd; padding: 8px;'>Value</th>";
    content += "</tr></thead><tbody>";

    // Menambahkan baris data
    content += format
        .map((item) => {
            // Ambil nilai dari data berdasarkan kunci
            let value = data[item.key];

            // Format tanggal jika key adalah "datein"
            if (item.key === "datein" && value) {
                value = formatDate(value);
            }
            if (item.key === "tanggallahir" && value) {
                value = formatDate(value);
            }

            // Tambahkan elemen gambar jika key adalah "photo"
            if (item.key === "photo" && value) {
                // Pastikan URL gambar lengkap
                value = `<img src="${imageBaseUrl}/${value}" alt="Photo" style="width: 100px; height: auto; max-width: 100%;">`;
            }

            return `
            <tr>
                <td style='border: 1px solid #ddd; padding: 8px;'><strong>${
                    item.label
                }</strong></td>
                <td style='border: 1px solid #ddd; padding: 8px;'>${
                    value || "N/A"
                }</td>
            </tr>
        `;
        })
        .join("");

    content += "</tbody></table>";
    return content;
}

$(document).on("click", ".btn-info", function (e) {
    e.preventDefault();

    var url = $(this).attr("href");
    var format = $(this).data("format"); // Ambil format dari data atribut

    $.ajax({
        url: url,
        type: "GET",
        dataType: "json",
        success: function (data) {

            var phone = data.phone || ""; // Sesuaikan dengan field yang sesuai

            // Buat URL WhatsApp dengan nomor telepon
            var whatsappUrl = `https://wa.me/${phone}?text=Hello, I need help with the details`;

            var content = createContent(data, format);

            Swal.fire({
                title: "Detail",
                html: content,
                icon: "info",
                confirmButtonText: "OK",
                footer: `
                    <a href="${whatsappUrl}" target="_blank" class="swal2-footer-button">
                        <button class="swal2-confirm swal2-styled">Chat with WhatsApp</button>
                    </a>
                `,
                customClass: {
                    container: "my-swal-container", // Kelas khusus jika diperlukan untuk styling
                    footer: "my-swal-footer" // Kelas khusus untuk styling footer
                },
            });
        },
        error: function () {
            Swal.fire({
                title: "Error",
                text: "Gagal memuat data.",
                icon: "error",
                confirmButtonText: "OK",
            });
        },
    });
});