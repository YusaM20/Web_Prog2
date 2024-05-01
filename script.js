let dataBuku = [ {
    "id": 1,
    "judul": "Belajar Pemrograman Web dengan PHP",
    "penulis": "John Doe",
    "status": "Tersedia"
  },
  {
    "id": 2,
    "judul": "Panduan Membuat Desain Web Modern",
    "penulis": "Jane Smith",
    "status": "Dipinjam"
  },
  {
    "id": 3,
    "judul": "Memahami Jaringan Komputer",
    "penulis": "Michael Lee",
    "status": "Tersedia"
  },
  {
    "id": 4,
    "judul": "Dasar-Dasar Bahasa Pemrograman Python",
    "penulis": "Alice Young",
    "status": "Dipinjam"
  },
  {
    "id": 5,
    "judul": "Menguasai Teknik SEO",
    "penulis": "David Kim",
    "status": "Tersedia"
  }]; // Array untuk menyimpan data buku

// Memuat data buku dari file JSON saat halaman dimuat
window.onload = function() {
    muatDataBuku();
    tampilDataBuku();
};

// Fungsi untuk memuat data buku dari file JSON
function muatDataBuku() {
    // Membaca file JSON menggunakan AJAX
    fetch('data/data.json')
        .then(response => response.json())
        .then(json => {
            dataBuku = json;
            tampilDataBuku();
        })
        .catch(error => console.error('Error loading data:', error));
}

// Fungsi untuk menampilkan data buku ke tabel
function tampilDataBuku() {
    const tbody = document.getElementById('tabel-buku').getElementsByTagName('tbody')[0];
    tbody.innerHTML = '';

    dataBuku.forEach(buku => {
        const row = tbody.insertRow();
        row.insertCell().textContent = buku.judul;
        row.insertCell().textContent = buku.penulis;
        row.insertCell().textContent = buku.status;
        const aksiCell = row.insertCell();
        if (buku.status === 'Dipinjam') {
            const kembalikanButton = document.createElement('button');
            kembalikanButton.textContent = 'Kembalikan';
            kembalikanButton.onclick = () => kembalikanBuku(buku.id);
            aksiCell.appendChild(kembalikanButton);
        } else {
            const pinjamButton = document.createElement('button');
            pinjamButton.textContent = 'Pinjam';
            pinjamButton.onclick = () => pinjamBuku(buku.id);
            aksiCell.appendChild(pinjamButton);
        }
    });
}

// Fungsi untuk menambahkan buku baru
function tambahBuku() {
    const modalTambahBuku = document.getElementById('modal-tambah-buku');
    modalTambahBuku.style.display = 'block';

    const formTambahBuku = document.getElementById('form-tambah-buku');
    formTambahBuku.addEventListener('submit', function(event) {
        event.preventDefault();

        const judul = document.getElementById('judul').value;
        const penulis = document.getElementById('penulis').value;
        const status = document.getElementById('status').value;

        const bukuBaru = {
            id: dataBuku.length + 1,
            judul: judul,
            penulis: penulis,
            status: status
        };

        dataBuku.push(bukuBaru);
        simpanDataBuku();
        tampilDataBuku();
        modalTambahBuku.style.display = 'none';
    });
}

// Fungsi untuk menyimpan data buku ke file JSON
function simpanDataBuku() {
    // Menyimpan data buku ke file JSON menggunakan AJAX
    fetch('data/data.json', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(dataBuku)
    })
        .then(response => response.json())
        .then(json => console.log('Data buku disimpan'))
        .catch(error => console.error('Error saving data:', error));
}

// Fungsi untuk meminjam buku
function pinjamBuku(idBuku) {
    const buku = dataBuku.find(buku => buku.id === idBuku);
    if (buku) {
        buku.status = 'Dipinjam';
        simpanDataBuku();
        tampilDataBuku();
    } else {
        console.error('Buku tidak ditemukan');
    }
}

// Fungsi untuk mengembalikan buku
function kembalikanBuku(idBuku) {
    const buku = dataBuku.find(buku => buku.id === idBuku);
    if (buku) {
        buku.status = 'Tersedia';
        simpanDataBuku();
        tampilDataBuku();
    } else {
        console.error('Buku tidak ditemukan');
    }
}
