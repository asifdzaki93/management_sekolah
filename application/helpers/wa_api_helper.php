<?php

function formatIndonesianPhoneNumber($number) {
    // Menghapus karakter non-numerik
    $cleanedNumber = preg_replace('/\D+/', '', $number);

    // Cek apakah nomor sudah diawali dengan '62'
    if (substr($cleanedNumber, 0, 2) === "62") {
        return $cleanedNumber;
    }
    
    // Cek apakah nomor diawali dengan '0' (misal, 08123456789 menjadi 628123456789)
    if (substr($cleanedNumber, 0, 1) === "0") {
        return '62' . substr($cleanedNumber, 1);
    }

    // Jika tidak ada '0' di depan dan tidak ada '62', tambahkan '62' di depan
    return '62' . $cleanedNumber;
}



function wa_api($number, $message) {
    // Data payload untuk API
    $body = array(
        "api_key" => "f4fc3c06d7c09712af448b735421d8079db74a29", // Gantikan dengan API key Anda
        "receiver" => formatIndonesianPhoneNumber($number),  // Nomor penerima
        "data" => array("message" => $message)  // Pesan yang akan dikirim
    );

    // Inisialisasi cURL
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => "https://web.watchapp.my.id/api/send-message",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode($body),
        CURLOPT_HTTPHEADER => [
            "Accept: */*",
            "Content-Type: application/json",
        ],
    ]);

    // Eksekusi cURL dan simpan hasilnya
    $response = curl_exec($curl);
    $err = curl_error($curl);

    // Tutup sesi cURL
    curl_close($curl);

    // Periksa jika terdapat error, jika tidak cetak responsenya
    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        echo $response;
    }
}


