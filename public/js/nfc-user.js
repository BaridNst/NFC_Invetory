async function startScanningUser(processUrl, dashboardUrl) {
    const idleState = document.getElementById('state-idle');
    const scanningState = document.getElementById('state-scanning');
    
    if (!('NDEFReader' in window)) {
        Swal.fire({
            icon: 'error',
            title: 'Browser Tidak Mendukung',
            text: 'Web NFC API hanya tersedia di Google Chrome Android.',
            confirmButtonColor: '#4f46e5'
        });
        return;
    }

    try {
        const ndef = new NDEFReader();
        await ndef.scan();
        
        idleState.classList.add('hidden');
        scanningState.classList.remove('hidden');

        ndef.addEventListener("readingerror", () => {
            Swal.fire({
                icon: 'warning',
                title: 'Gagal Membaca',
                text: 'Tag tidak terbaca dengan baik. Coba dekatkan lagi.',
                confirmButtonColor: '#4f46e5'
            });
        });

        ndef.addEventListener("reading", ({ serialNumber }) => {
            handleNfcReadUser(serialNumber, processUrl, dashboardUrl);
        });

    } catch (error) {
        console.error(error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: error.message,
            confirmButtonColor: '#4f46e5'
        });
    }
}

function handleNfcReadUser(uid, processUrl, dashboardUrl) {
    const scanningState = document.getElementById('state-scanning');
    const processingState = document.getElementById('state-processing');

    scanningState.classList.add('hidden');
    processingState.classList.remove('hidden');

    fetch(processUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ nfc_uid: uid })
    })
    .then(response => response.json())
    .then(data => {
        processingState.classList.add('hidden');
        
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: data.type === 'borrow' ? 'Berhasil Pinjam!' : 'Berhasil Kembali!',
                text: data.message,
                confirmButtonText: 'Kembali ke Dashboard',
                confirmButtonColor: '#4f46e5'
            }).then(() => {
                window.location.href = dashboardUrl;
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: data.message,
                confirmButtonColor: '#4f46e5'
            }).then(() => {
                location.reload();
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        processingState.classList.add('hidden');
        Swal.fire({
            icon: 'error',
            title: 'Server Error',
            text: 'Terjadi kesalahan pada sistem.',
            confirmButtonColor: '#ef4444'
        }).then(() => {
            location.reload();
        });
    });
}
