**STACK & PACKAGES**

Teknologi Utama:

  - Backend: Laravel
  - Database: MySQL
  - Caching: Redis

Package yang Digunakan:

  - `maatwebsite/excel`
  - `predis/predis`

-----

**INSTALASI & MENJALANKAN PROYEK**

1.  Clone Repository

2.  Install Dependencies:
    `composer install`

3.  Setup Environment:
    `cp .env.example .env`
    `php artisan key:generate`

4.  Migrasi Database:
    `php artisan migrate`

5.  Jalankan Server:
    `php artisan serve`

-----

**LIST API ENDPOINT**

Berikut adalah endpoint yang tersedia.

**1. Create a To-Do**
Membuat item tugas baru.

  - Method: POST
  - Endpoint: /api/todos
  - Body Request:
      - `title` (string, wajib): Judul tugas.
      - `assignee` (string, opsional): Nama orang yang ditugaskan.
      - `due_date` (date, wajib): Batas waktu tugas (format: YYYY-MM-DD).
      - `priority` (string, wajib): Prioritas tugas (`low`, `medium`, `high`).
      - `status` (string, optional): Status (`pending`, `open`, `in_progress`, `completed`), default `pending`.
      - `time_tracked` (numeric, optional): default 0.

**2. Generate Excel Report**
Mengunduh laporan tugas dalam format Excel dengan filter.

  - Method: GET
  - Endpoint: /api/todos/report/excel
  - Query Parameters (semua opsional):
      - `title` (string): Filter berdasarkan judul (pencocokan parsial).
      - `assignee` (string): Filter berdasarkan satu atau lebih nama, dipisah koma.
      - `status` (string): Filter berdasarkan satu atau lebih status, dipisah koma.
      - `priority` (string): Filter berdasarkan satu atau lebih prioritas, dipisah koma.
      - `start` & `end` (date): Filter rentang tanggal untuk `due_date`.
      - `min` & `max` (numeric): Filter rentang angka untuk `time_tracked`.

**3. Get Chart Data**
Mengambil data agregat untuk ditampilkan dalam bentuk chart.

  - Method: GET
  - Endpoint: /api/chart
  - Query Parameters:
      - `type` (string, wajib): Jenis data yang diinginkan. Nilai yang valid adalah 'status', 'priority', atau 'assignee'.
          - 'status': Untuk mendapatkan ringkasan jumlah tugas per status.
          - 'priority': Untuk mendapatkan ringkasan jumlah tugas per prioritas.
          - 'assignee': Untuk mendapatkan ringkasan detail tugas per assignee.
