async function startScan() {
    if (!('NDEFReader' in window)) {
        alert('Web NFC tidak didukung di browser ini. Gunakan Chrome di Android.');
        return;
    }

    try {
        const ndef = new NDEFReader();
        await ndef.scan();
        
        document.getElementById('nfc-idle').classList.add('hidden');
        document.getElementById('nfc-scanning').classList.remove('hidden');
        document.getElementById('nfc-status').classList.replace('border-gray-200', 'border-indigo-200');

        ndef.addEventListener("readingerror", () => {
            alert("Gagal membaca NFC. Coba lagi.");
        });

        ndef.addEventListener("reading", ({ serialNumber }) => {
            // Success
            document.getElementById('nfc-scanning').classList.add('hidden');
            document.getElementById('nfc-success').classList.remove('hidden');
            document.getElementById('nfc-status').classList.replace('border-indigo-200', 'border-emerald-200');
            
            document.getElementById('scanned-uid').innerText = serialNumber;
            document.getElementById('nfc_uid_input').value = serialNumber;
            
            // Enable save button
            const btnSave = document.getElementById('btn-save');
            btnSave.disabled = false;
            btnSave.classList.replace('bg-gray-100', 'bg-indigo-600');
            btnSave.classList.replace('text-gray-400', 'text-white');
            btnSave.classList.add('shadow-lg', 'shadow-indigo-200', 'hover:bg-indigo-700');
            btnSave.classList.remove('cursor-not-allowed');
        });

    } catch (error) {
        console.error(error);
        alert("Error: " + error);
    }
}
