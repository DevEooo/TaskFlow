    Jadi hari ini (08/12) sembari saya menunggu review & revisi, ini yang saya lakukan untuk project ini pada hari ini: 

        1. Clean-up code di panel User [x]
        2. Clean-up code di panel Admin [x]
    
    Dan ada beberapa tambahan/masukan dari saya personal untuk project ini kedepannya dengan:
        
        1. Menambahkan fitur deadline - Fitur yang berguna untuk mengatur kapan sebuah tugas dikatakan/diklasifikasikan tidak terpenuhi apabila melampaui   date yang ditentukan.
        2. Beberapa enhancement dari setiap fitur yang bertujuan untuk meningkatkan Experience dari pengunaan aplikasi ini, baik itu secara UX (User Experience) & AdminX (Admin Experience) yang berguna untuk mengurangi experience yang relatif "Boring" dan "Repetitif" (Saran dan bersifat opsional untuk enhancement kedepannya.)
            -> User's Perspective:
                - Quick Select Notes Shortcut (Shortcut Pesan Cepat), Dengan menyediakan shortcut seperti: [Tisu Habis], [Sabun Habis], [Keran Bocor], [Lampu Mati]. Dengan ini, user tidak perlu repot" untuk mengetik. Karena bisa saja tangan si OB ini entah basah atau kotor. jadi ini bisa jadi solusi.
                - Menambahkan Gamifikasi yang simple. Mungkin, melihat daftar tugas biasa itu relatif monoton. Jadi, saya berencana menambahkan widget untuk Progress bar harian. contoh: "4/5 Tugas hari ini selesai". Karena dengan menambahkan ini, dapat memberikan kepuasan secara Psikologis (Sense of Completion) yang berguna untuk meningkatkan motivasi untuk menyelesaikan semua tugas. 
            -> Admin's Perspective: 
                - Fitur "Task Templates"
                Masalah: Admin harus input "Bersihkan Toilet" setiap hari Senin-Jumat secara manual atau Bulk. Ini sangat membosankan.
                Solusi:
                Buat Resource Template Tugas. Admin mendefinisikan tugas sekali ("Bersihkan Lobby"), lalu set jadwalnya: Setiap Hari Kerja, Jam 07:00.
                Sistem (via Scheduler/Cron Job) yang akan otomatis men-generate DailyTaskLog setiap pagi.
                Benefit: Admin tidak perlu login setiap hari hanya untuk membuat tugas. Admin hanya login untuk monitoring dan menangani insiden.
                - Dashboard Gallery: Buat widget khusus yang menampilkan Grid Foto terbaru (seperti Instagram feed) dari bukti kerja yang masuk hari ini. Admin bisa scroll cepat untuk melihat kebersihan tanpa buka satu-satu.
                - Bulk Approval / Review (Meng-approve tugas dengan sekaligus), 
                Masalah: Membuka form edit satu per satu untuk memverifikasi tugas selesai.
                Solusi:
                Tambahkan Bulk Action di tabel Admin: Pilih 10 tugas -> Klik "Verifikasi/Approve".
