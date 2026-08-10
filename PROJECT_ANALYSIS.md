# PROJECT_ANALYSIS — MindHug (Laravel + Livewire v2)

> Dokumen analisis menyeluruh: struktur kode, flow aplikasi, dan progress proyek `mindhug-livewire`.
> Audit dilakukan per **10 Agustus 2026**. Branch `master`, 78 commit (commit terakhir `bd33894`).
> Produk: **MindHug — Peluk Emosi, Tenangkan Hati** (platform kesehatan mental Indonesia).

---

## 1. Ringkasan Proyek

Aplikasi dua sisi:

- **Website User** — landing, shop produk, keranjang, checkout + pembayaran Midtrans, tracking pesanan,
  curhat/chat real-time dengan tim MindHug, manajemen akun/alamat, dan upgrade ke paket **MindHug Plus** (berlangganan).
- **Panel Admin** — dashboard, kelola user/order/curhat/produk/kategori/voucher/paket langganan/pemasukan-pengeluaran/admin, konfirmasi pembayaran & upgrade.

### Stack Teknologi

| Komponen | Versi | Keterangan |
|----------|-------|------------|
| PHP | `^8.3` | - |
| Laravel | `^13.8` | Framework |
| Livewire | `^4.3` | SPA-like, `wire:navigate` aktif |
| Tailwind CSS | `^4.0` | Utility-first, custom palette di `resources/css/app.css` |
| Vite | `^8.0` | Build asset |
| Alpine.js | bundled Livewire | Micro-interaksi, modal, cropper |
| midtrans/midtrans-php | `^2.6` | Payment gateway (Snap) |
| laravolt/indonesia | `^0.41.0` | Data wilayah (provinsi → kelurahan) |
| DB | MySQL (`mindhug`) | `.env: DB_CONNECTION=mysql` |
| Session/Queue/Cache | database | - |

- **Real-time** TIDAK pakai websocket/Pusher. Semua memakai **polling** (`wire:poll.1s/2s/3s`).
- Midtrans saat ini mode **sandbox** (`MIDTRANS_IS_PRODUCTION=false`, merchant `M148081650`).

---

## 2. Struktur Proyek

```text
app/
  Console/Commands/
    DowngradeExpiredPlus.php          # cron downgrade user Plus yang expired
  Http/
    Controllers/
      Admin/AuthController.php        # login/logout admin
      MidtransWebhookController.php   # webhook pembayaran
    Middleware/
      AdminRole.php                   # filter role admin (dev/admin)
      AdminSession.php                # cookie session admin terpisah
      CheckUserStatus.php             # auto-logout user non-active
    Livewire/
      Account/        Addresses, Profile, Security
      Admin/
        Admins/            Index, Create, Edit
        Categories/        Index, Create, Edit
        Curhats/           Index, ConversationList, ChatPanel
        Dashboard.php
        IncomeExpenses/    Index, Create, Edit
        Orders.php
        Products/          Index, Create, Edit
        Promotions/        Index, Create, Edit
        SubscriptionOrders/ Index, Detail
        SubscriptionPlans/  Index, Create, Edit
        Users/             Index, Create, Edit
      Auth/           Login, Register
      Checkout/Index.php
      Curhat/         CurhatForm, ProductRecommendation
      Kontak/KontakForm.php
      Layouts/        Header, AdminCurhatBadge, Footer(view)
      Orders/         Index, Show
      Shop/           Index, ProductDetail
      Transactions/Cart.php
      Upgrade/        Index, Checkout, Orders, OrderDetail
  Models/             User, Admin, UserAddress, Product, Category, Order, OrderItem,
                      OrderTrackingEvent, OrderShipment, Promotion, Conversation,
                      Message, SubscriptionPlan, SubscriptionOrder, IncomeExpense
  Services/           OrderService, MidtransService, SubscriptionService

routes/
  web.php            # user side
  admin.php          # panel admin
  console.php        # default

config/midtrans.php
database/migrations/ (37 file, 2026-06-19 s.d. 2026-07-21)
database/seeders/   DatabaseSeeder, SubscriptionPlanSeeder
resources/
  css/app.css       # palette brand + role badge (role-dev/admin/free/plus)
  views/
    components/     # layouts (app/admin/auth), notification-toast, confirmation-dialog, tooltip-icon
    livewire/       # semua view komponen Livewire
    account/, admin/, auth/, checkout/, curhat/, kontak/, orders/, shop/, cart, home
tests/              # masih default (2 contoh, belum ada tes fungsional)
```

---

## 3. Arsitektur & Konvensi

### 3.1 Auth & Session

| Guard | Route Middleware | Catatan |
|-------|------------------|---------|
| `web` (User) | `auth`, `user.active` (CheckUserStatus) | user `status != active` auto logout |
| `admin` (Admin) | `auth:admin`, `admin.role:dev,admin`, `guest:admin` | cookie `mindhug_admin_session` dipisah via AdminSession |

- Route admin `role:dev` khusus halaman **Admins**; halaman lain `dev,admin`.
- Login admin: `AuthController` (POST `/admin/login`), login user: Livewire `Auth/Login` (bisa email **atau** username).

### 3.2 Pola Kode

- **Dominate pola modal CRUD**: komponen Create/Edit dipanggil via `Livewire.dispatch('openXxx')` dari komponen Index; Index refresh via listener `xxxCreated`/`xxxUpdated`.
- Filter Index: pola `$queryString` + `updatingXxx()` → `resetPage()`.
- Toast: `$this->dispatch('notify', type: 'success', message: '...')` → komponen `notification-toast.blade.php`.
- Validasi: mix `protected $rules` dan `#[Rule]` (dengan pesan custom Bahasa Indonesia).
- Notifikasi lintas komponen: event `cart-updated`, `order-updated`, `product-selected`, `conversation-loaded`, `refreshSubscriptionOrders`.
- Desain: palette `#a47551` (primary), warna hangat; role badge via custom CSS (`.role-dev`, `.role-admin`, `.role-free`, `.role-plus`).

### 3.3 Env Terisi (lokal)

`APP_URL=http://localhost:8000`, `DB mysql/mindhug`, `SESSION_DRIVER=database`, `QUEUE_CONNECTION=database`, Midtrans sandbox.

---

## 4. Model, Migration & Fitur per Modul

### 4.1 Modul User

| Modul | Komponen | Fitur |
|-------|----------|-------|
| Auth | Login, Register | login email/username, cek status aktif, register langsung login (role `free`) |
| Akun | Profile | edit profil + **crop avatar Cropper.js** (300x300 webp), hapus avatar, info role/trial read-only |
| Akun | Security | ganti password (cek hash lama), **soft delete akun** (status inactive + deleted_at + reason) |
| Akun | Addresses | CRUD alamat, **dropdown provinsi→kota→kecamatan→kelurahan** (laravolt), fallback teks jika tabel wilayah kosong, logika is_primary |
| Curhat | CurhatForm | chat 1 percakapan aktif/user (`firstOrCreate`, status open), kirim pesan, **poll 2s**, kartu rekomendasi produk |
| Curhat | ProductRecommendation | pencarian produk utk admin, kirim via event `product-selected` |
| Shop | Index / ProductDetail | katalog publik (filter q, sort, paginate 20), galeri gambar, add-to-cart session, buy-now langsung ke checkout |
| Cart | Transactions/Cart | **cart di session** (`product_id => qty`), pisah item aktif/inaktif, increment/decrement, counter `cart-updated` |
| Checkout | Checkout/Index | alamat primary, ongkir tetap 15000, **voucher (Promotion)**, buat Order + Snap token Midtrans |
| Orders | Index / Show | daftar pesanan (filter status/search), detail + timeline tracking, **request pembatalan** (cancel di Midtrans) |
| Upgrade | Index / Checkout / Orders / OrderDetail | landing `/plus`, pilih plan (session `upgrade_plan`), buat SubscriptionOrder, **bayar via Midtrans Snap**, riwayat "Plus Saya" |
| Kontak | KontakForm | form kontak (belum integrasi mail, ada TODO) |
| Layout | Header | nav + badge cart + link Plus Saya; poll 1s; AdminCurhatBadge terpisah utk admin |

### 4.2 Modul Admin

| Modul | Fitur |
|-------|-------|
| Dashboard | statistik user/order/income-expense/pending upgrade/curhat terbuka |
| Users | CRUD, toggle aktif/inaktif, filter role, view detail (alamat + 6 order) |
| Orders | filter invoice/kustomer/status/rentang tanggal; aksi: update status → processing/shipped/delivered, cancel (ke Midtrans + tracking), tolak request batal |
| Curhats | daftar conversation, **take over / take over paksa / close**, balas pesan, hapus pesan admin sendiri, kirim rekomendasi produk (metadata JSON) |
| Products | CRUD + **crop foto canvas custom (500x500)**, min 1 max 8 foto, **mode dropship Shopee** (`price = shopee_price + markup` otomatis), filter dropship |
| Categories | CRUD, slug otomatis, withCount products |
| Promotions | CRUD voucher: `fixed`/`percent`, min_order, max_discount, max_uses, jendela waktu, `used_count` auto-increment |
| SubscriptionPlans | CRUD paket (features sebagai array dari textarea) |
| SubscriptionOrders | daftar + detail modal; **confirm** (aktifkan Plus + perpanjang `plus_expires_at` + catat income otomatis) / **reject** (hapus bukti bayar) |
| IncomeExpenses | catat manual income/expense (source, date, admin_id), ringkasan total income vs expense |
| Admins | CRUD (hanya dev), filter role, tidak bisa hapus diri sendiri |

### 4.3 Skema DB Penting

```text
users                (role: free|plus, plus_expires_at, is_trial_active, status, deleted_at, avatar...)
admins               (role: dev|admin)
categories, products (shopee_price, markup, shopee_link, is_active...)
orders               (invoice INV-YYYYMMDD-00001, status: awaiting_payment|awaiting_confirmation|
                     cancel_requested|processing|shipped|delivered|cancelled + snap_token,
                     midtrans_transaction_id, payment_type, payment_channel)
order_items, order_shipments, order_tracking_events
promotions           (type fixed|percent, value, min_order, max_discount, max_uses, used_count)
conversations, messages (sender_role user|admin, metadata JSON)
user_addresses
subscription_plans   (price, duration_days, features JSON)
subscription_orders  (invoice UPG-YYYYMMDD-00001, status: awaiting_payment|awaiting_confirmation|
                     completed|cancelled, payment_proof, snap_token, midtrans_transaction_id)
income_expenses      (type income|expense, source: upgrade|manual, subscription_order_id, admin_id)
```

---

## 5. Alur (Flow) Aplikasi

### 5.1 Flow User — Belanja + Pembayaran Midtrans

```text
Home/Shop → Detail Produk
  ├─ "Masuk Keranjang" → cart (session) → Checkout
  └─ "Beli Sekarang"   → Checkout langsung (product=id&quantity=)
        ↓
Checkout: pilih alamat primary + voucher (opsional) → placeOrder()
  → OrderService::createOrder (DB transaction: cek stok lockForUpdate, decrement stok,
     increment promo used_count, buat order + items + tracking "Pesanan Dibuat")
  → MidtransService::createSnapToken (item + ongkir) → simpan snap_token
  → redirect orders.show
        ↓
Orders Show: Auto-open Snap (session flag snap_auto_order_{id}, sekali saja)
  ├─ snap.pay → onSuccess/onPending → reload → status dicek ulang
  ├─ tombol "Bayar Sekarang" (openSnap, reset flag)
  └─ tombol cek status (checkPaymentStatus → Transaction::status)
        ↓
Midtrans update status:
  ├─ Webhook POST /api/midtrans/webhook → handleNotification
  │    settlement/capture+accept → processing ; deny/cancel/expire/failure → cancelled
  └─ checkAndUpdateStatus (pengganti webhook saat reload)
        ↓
Order masuk admin → processing → shipped → delivered (tracking event tiap langkah)
User bisa request batal (cancel_requested) → admin tolak (kembali awaiting_payment) 
atau admin cancel langsung (Midtrans cancel + cancelled)
```

### 5.2 Flow User — Upgrade MindHug Plus (Midtrans)

```text
/plus (Index) → klik "Upgrade Sekarang"
  ├─ sudah Plus aktif → blok hijau "sudah berlangganan"
  └─ ada pending upgrade → blok amber, link lanjutkan pembayaran
        ↓
POST /plus/start → simpan plan ke session `upgrade_plan` → redirect /plus/checkout
        ↓
Checkout Plus → "Bayar Sekarang" → SubscriptionService::createOrder
  (invoice UPG-..., status awaiting_payment) → redirect plus.orders.show
        ↓
OrderDetail Plus: auto-open Snap (snap_auto_upgrade_{id}) / tombol Bayar
  → MidtransService::createSnapTokenForUpgrade (plan → item_details)
        ↓
Webhook/polling update status → admin SubscriptionOrders
  ├─ confirmOrder (DB transaction): status completed + confirmed_at,
  │    perpanjang plus_expires_at (stacking), role → plus,
  │    otomatis catat IncomeExpense (source: upgrade)
  └─ rejectOrder: hapus payment_proof, status cancelled
        ↓
Cron mindhug:downgrade-expired-plus: user role plus yg expired → free + plus_expires_at null
```

### 5.3 Flow Admin — Chat Curhat

```text
Admin Curhats → ConversationList (filter open/closed, poll 1s)
  → klik percakapan → ChatPanel (poll 1s, auto scroll via 'conversation-loaded')
      ├─ belum ada penangan → "Ambil Alih" (assigned_to = saya)
      ├─ dipegang admin lain → "Ambil Alih Paksa" (konfirmasi)
      ├─ dipegang saya      → balas pesan / hapus pesan admin sendiri / "Tutup"
      └─ ProductRecommendation modal: cari produk → "Kirim Rekomendasi"
           → event product-selected → ChatPanel kirim pesan dengan metadata
             type=product_recommendation (nama, harga, gambar, url)
           → user lihat kartu produk di chat (poll 2s)
```

### 5.4 Flow Pembayaran — Ringkas (Order & Subscription sama)

```text
Order dibuat (snap_token kosong) 
  → createSnapToken saat view/bayar (order_id = invoice-uniqid)
  → snap.js popup pembayaran (sandbox)
  → Midtrans kirim webhook ke /api/midtrans/webhook
  → update order (midtrans_transaction_id, payment_type) + status
Gagal/ditolak/expired → status cancelled. Bila user close popup & order tetap
awaiting_payment → bisa "Bayar Sekarang" ulang.
```

### 5.5 Flow Voucher

```text
Checkout: isi kode → Promotion::isValid (aktif + jendela waktu Asia/Jakarta + max_uses)
  → subtotal >= min_order → calculateDiscount:
       percent → subtotal*value/100 ; fixed → value ; diterapkan min(max_discount)
  → OrderService: increment used_count saat order dibuat
```

---

## 6. Progress Proyek (per 10 Agustus 2026)

### 6.1 Timeline Ringkas (78 commit, 19 Jun – 22 Jul 2026)

```text
19 Jun  setup awal, Tailwind, layout header/footer, DB schema awal
Jul-1  landing page & shop, pesanan pertama, middleware, chat
Jul-2  CRUD produk/category/user/admin, dropship Shopee, crop foto, curhat realtime
Jul-3  dashboard admin, order management (filter, tracking), voucher/promo
Jul-4  region Indonesia, upload avatar + Cropper, security & soft delete akun
      (modifikasi terakhir: 22 Jul 2026)
      ├─ income/expense + subscription plan/order + upgrade Flow (manual, payment proof)
      ├─ refactor upgrade → komponen baru (Upgrade/*), hapus OrderPay & IncomeExpenses lama
      ├─ upgrade payment → Midtrans (hapus sistem payment method)
      └─ checkout order juga pindah ke Midtrans (hapus OrderPay, order pakai snap_token)
```

Commit utama terbaru (bagian paling relevan):

| Commit | Isi |
|--------|-----|
| `bd33894` | Implementasi Midtrans di checkout (order produk) |
| `164b71b` | Hapus sistem payment method, upgrade payment via Midtrans |
| `ee1afca` | CRUD subscription plans |
| `311809b` | Refactor payment: hapus OrderPay, integrasi Midtrans |
| `8ff6fdc` / `85b08b3` | config Midtrans + install midtrans-php |
| `b122a3a` | Income/expense + subscription order detail & history |
| `ff846fd` | Hapus IncomeExpenses/SubscriptionOrders lama → komponen Upgrade baru |

### 6.2 Status Per Modul

| Modul | Status | Catatan |
|-------|--------|---------|
| Auth & Akun (profil, avatar, security, addresses) | ✅ Selesai | - |
| Shop, Cart, Checkout, Orders | ✅ Selesai | pembayaran Midtrans aktif (sandbox) |
| Curhat + rekomendasi produk | ✅ Selesai | polling-based |
| Voucher/Promo | ✅ Selesai | - |
| Panel admin (dashboard, users, orders, products, categories, promotions, admins, curhats) | ✅ Selesai | - |
| Subscription plans & orders (upgrade Plus) | ✅ Selesai | bayar via Midtrans + confirm/reject admin |
| Income/expense tracking | ✅ Selesai | otomatis dari upgrade + manual |
| Downgrade Plus expired | ✅ Selesai | command `mindhug:downgrade-expired-plus` (perlu scheduler) |
| Landing/Home, Kontak | 🟡 Sebagian | form kontak belum kirim email (TODO) |
| Trial (is_trial_active) | 🟡 Belum aktif | kolom DB ada, UI read-only, belum ada logika aktivasi |
| Tests | ❌ Belum | hanya test default Laravel (Pest) |
| Scheduler untuk downgrade + cek status Midtrans berkala | 🟡 Belum terjadwal | - |

### 6.3 Catatan / Perhatian (dari audit kode)

1. **File mati (dead code)**: `resources/views/orders/pay.blade.php` masih merujuk `<livewire:orders.pay>` namun komponen `Orders/Pay.php` sudah dihapus → halaman ini akan error bila diakses (route tak ada, jadi tidak bisa diakses, aman tapi sampah).
2. **Dokumentasi `ARCHITECTURE_AND_STYLEGUIDE.md` kadaluarsa**: masih mencantumkan `PaymentMethods.php`, route `/admin/payment-methods`, dan direktori lama (Checkout/Index, Orders/Pay) yang sudah dihapus/diubah.
3. **Belum ada listener webhook verifikasi signature Midtrans** (`SignatureKey::verify`/notification key). Webhook saat ini hanya log + proses payload — disarankan verifikasi keamanan sebelum produksi.
4. `Order::checkAndUpdateStatus` hanya menangani `awaiting_payment`; order `cancel_requested`/`awaiting_confirmation` tidak diupdate webhook.
5. OrderId Midtrans memakai `invoice-uniqid`; `handleNotification` memakai `explode('-')[0]` + `like` → potensi salah match bila invoice berubah format; disarankan simpan `order_id` penuh di DB.
6. Cart berbasis session — hilang bila user pindah device; belum ada persistence DB.
7. `SubscriptionService::rejectOrder` hanya untuk status `awaiting_confirmation` dan menghapus `payment_proof` (alur lama); alur bayar sekarang lewat Midtrans sehingga reject sebaiknya juga membatalkan transaksi Midtrans.

### 6.4 Rancangan Potensi Lanjutan (roadmap)

- Verifikasi signature webhook Midtrans + persist `midtrans order_id` penuh.
- Jadwalkan command downgrade via scheduler (tiap hari).
- Kirim email kontak & notifikasi order (Mail belum dipakai).
- Tambah tes Pest untuk OrderService, SubscriptionService, MidtransService, Promotion.
- Persist cart ke DB + opsi sembulan "lanjutkan pembayaran" untuk order expired-close.
- Aktifkan fitur trial (migrasi is_trial_active → logika aktivasi).
- Bersihkan dead code `orders/pay.blade.php` dan perbarui ARCHITECTURE_AND_STYLEGUIDE.md.

---

*Dokumen dibuat otomatis dari audit kode; perbarui seiring development.*