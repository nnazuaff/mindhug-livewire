# ARCHITECTURE_AND_STYLEGUIDE

> Dokumen ini adalah hasil audit codebase MindHug berdasarkan implementasi aktual di repository saat ini.
>
> Catatan versi yang terdeteksi dari dependency: Laravel `^13.8`, Livewire `^4.3`, Tailwind CSS `^4.0`, Vite `^8.0`, Alpine.js digunakan via directive di Blade (terintegrasi dengan Livewire).

---

## 1. Daftar & Tokens Warna (Visual Palette)

### 1.1 Sumber Token Warna
- `tailwind.config.js`:
  - `softBrown: #d7c6b8`
  - `darkBrown: #8b6f5c`
- `resources/css/app.css` (`@theme`):
  - `--color-soft-brown: #d7c6b8`
  - `--color-softBrown: #d7c6b8`
  - `--color-dark-brown: #8b6f5c`
  - `--color-darkBrown: #8b6f5c`

### 1.2 Warna Dominan yang Dipakai di Blade

| Tailwind/Class Token | Hex | Peruntukan Utama |
|---|---|---|
| `bg-[#a47551]`, `text-[#a47551]`, `ring-[#a47551]` | `#a47551` | Primary brand action (CTA, icon, active state, brand tint) |
| `hover:bg-[#8f6243]` | `#8f6243` | Primary hover/darker brand state |
| `bg-[#f5e9df]` | `#f5e9df` | Secondary surface (chip, hover background, panel lembut) |
| `bg-[#fdfaf7]` | `#fdfaf7` | Canvas/background warm neutral |
| `text-[#2b2b2b]` | `#2b2b2b` | Teks utama global |
| `text-[#2b1d12]` | `#2b1d12` | Judul/headline berkontras tinggi |
| `text-[#3d2b1c]` | `#3d2b1c` | Heading/subheading level 2 |
| `border-[#e0d0c0]` | `#e0d0c0` | Border input/form component |
| `border-[#ede0d4]` | `#ede0d4` | Divider / section separator |
| `bg-[#2f1f15]` | `#2f1f15` | Final CTA dark section |
| `text-[#c19a6b]` / `border-[#c19a6b]` | `#c19a6b` | Accent warm highlight |
| `text-[#b0a090]` | `#b0a090` | Placeholder text |
| `text-[#666]`, `text-[#888]`, `text-[#999]` | `#666`, `#888`, `#999` | Secondary/muted copy |

### 1.3 Ringkasan Peran Warna
- **Primary**: `#a47551`
- **Primary Hover**: `#8f6243`
- **Background utama**: `#fdfaf7`, `#fffafc`, `#fcf8f5`
- **Text utama**: `#2b2b2b`, `#2b1d12`
- **Accent**: `#c19a6b`
- **Border sistem**: `#e0d0c0`, `#ede0d4`, `#e9ddd2`

---

## 2. Sistem Tipografi (Typography & Fonts)

### 2.1 Font yang Dikonfigurasi
- `resources/views/components/layouts/app.blade.php`:
  - Google Fonts: `Playfair Display`, `Plus Jakarta Sans`
- `resources/css/app.css` (`@theme`):
  - `--font-sans: 'Plus Jakarta Sans'`
  - `--font-display: 'Playfair Display'`
- `tailwind.config.js` (legacy/extend):
  - `sans: ['Poppins', ...]`
  - `baloo: ['Baloo 2']`

> Ada jejak sistem font yang overlap: `Plus Jakarta Sans` aktif di global theme, sementara beberapa komponen masih memakai class `font-baloo` dan config menyimpan `Poppins` legacy.

### 2.2 Praktik Tipografi Aktual

| Elemen | Pola Ukuran | Ketebalan | Catatan |
|---|---|---|---|
| Hero headline landing | `text-[2.15rem]` → `md:text-[3.25rem]` | `font-bold` | Tone direct-response, kontras tinggi |
| Section title | `text-[1.9rem]` → `md:text-[2.25rem]` | `font-bold` | Digunakan di “How it Works” |
| Card title | `text-lg` | `font-semibold` | Konsisten untuk 3-step/features |
| Body paragraph | `text-sm` / `text-[1.02rem]` | `font-normal`/`font-medium` | Leading cenderung long-form (`leading-7`, `leading-8`) |
| CTA button text | `text-sm` | `font-semibold` | Semua tombol utama konsisten semibold |
| Label form | `text-sm` | `font-medium` | Form login/register/kontak |
| Meta text | `text-xs` | `font-semibold` / `font-medium` | badge, helper, keterangan |

### 2.3 Pedoman Konsistensi yang Terbaca
- Body default: `font-sans` (`Plus Jakarta Sans`).
- Headline: `font-bold` + warna gelap coklat (`#2b1d12`).
- CTA selalu `font-semibold` dengan primary background `#a47551`.
- Placeholder input konsisten `#b0a090`.

---

## 3. Struktur Folder & Arsitektur Proyek

### 3.1 Pohon Struktur Relevan

```text
app/
  Http/
    Controllers/
      Controller.php
    Livewire/
      Auth/
        Login.php
        Register.php
      Curhat/
        CurhatForm.php
      Kontak/
        KontakForm.php
      Layouts/
        Header.php
      Shop/
        Index.php
        ProductDetail.php
  Models/
    User.php
    Product.php
    Category.php
    Conversation.php
    Message.php
  Providers/
    AppServiceProvider.php

resources/
  css/
    app.css
  js/
    app.js
  views/
    home.blade.php
    auth/
      login.blade.php
      register.blade.php
    curhat/
      index.blade.php
    kontak/
      index.blade.php
    shop/
      index.blade.php
    components/
      layouts/
        app.blade.php
        auth.blade.php
    livewire/
      auth/
        login.blade.php
        register.blade.php
      curhat/
        curhat-form.blade.php
      kontak/
        kontak-form.blade.php
      layouts/
        header.blade.php
        footer.blade.php
      shop/
        index.blade.php
        product-detail.blade.php

config/
  app.php
  auth.php
  database.php
  livewire.php
  ...

routes/
  web.php

database/
  factories/
  migrations/
  seeders/
```

### 3.2 Fungsi Folder Utama
- `app/Http/Livewire/*`: logic interaktif per domain (`Auth`, `Curhat`, `Kontak`, `Shop`, `Layouts`).
- `resources/views/livewire/*`: presentational layer untuk komponen Livewire.
- `resources/views/components/layouts/*`: shell layout global (`app`) dan shell auth (`auth`).
- `resources/views/*/index.blade.php`: page entry yang me-mount komponen Livewire.
- `routes/web.php`: mapping route ke view wrapper (dan closure untuk shop detail).
- `resources/css/app.css`: global utility tambahan + animation + custom theme token.
- `database/migrations`: skema domain e-commerce + curhat (conversation/message).

---

## 4. Standar Penulisan Kode (Coding Conventions)

### 4.1 Naming Convention Livewire
- **Class PHP**: PascalCase (`CurhatForm`, `KontakForm`, `ProductDetail`).
- **Namespace berdasarkan domain**: `App\Http\Livewire\{Domain}`.
- **Blade component path**: kebab-case (`curhat-form.blade.php`, `product-detail.blade.php`).
- **Mounting tag**: kebab + namespace (`<livewire:curhat.curhat-form />`).

### 4.2 Pemisahan Backend vs Frontend
- **Backend (Class Livewire)**:
  - validasi (`$rules` atau `#[Rule]`)
  - orchestration data (`Eloquent query`, `session`, `Auth`)
  - action method (`login`, `register`, `send`, `kirim`, `addToCart`)
- **Frontend (Blade Livewire)**:
  - markup UI + utility classes Tailwind
  - binding (`wire:model.defer`, `wire:model.live.debounce.300ms`)
  - event/form (`wire:submit.prevent`, `wire:click`)
  - loading/error state (`wire:loading`, `@error`)

### 4.3 Pola Properti, Method, dan Data Transfer
- Properti publik untuk state komponen (`public string $message`, `public $q = ''`).
- Method action bernama verb sesuai use-case (`send`, `kirim`, `register`, `addToCart`).
- Data ke Blade dikirim via `render()` array:
  - contoh: `CurhatForm::render()` mengirim `conversation`, `messages`, `charCount`.
- Query state untuk URL dipakai di shop list (`$queryString = ['q', 'sort']`).
- Event listening antar komponen dipakai via attribute:
  - `#[On('cart-updated')]` di `Layouts\Header`.

### 4.4 Variasi Konvensi yang Perlu Dicatat
- Validasi memakai dua style sekaligus:
  - classic `$rules`
  - PHP attribute `#[Rule]`
- Style penamaan method campuran bahasa Inggris + Indonesia (`send` vs `kirim`).

---

## 5. Standar Styling & Animasi (UI Constraints)

### 5.1 Pendekatan Styling
- Mayoritas UI dibangun dengan **Tailwind utility class** langsung di Blade.
- Ada **custom CSS global ringan** di `resources/css/app.css` untuk:
  - helper (`[x-cloak]`, `.page-enter`, `.auto-grow`)
  - keyframes reusable (`fadeSlideIn`, `blob-drift`, `hero-float`).
- Inline style hampir tidak dipakai kecuali kasus data dinamis tertentu.

### 5.2 State & Interaksi UI
- Anti flicker Alpine: `[x-cloak] { display:none !important; }`.
- Transisi umum:
  - `duration-150` / `duration-200` untuk hover/menu/dropdown.
  - `duration-300+` untuk panel mobile/overlay.
- Hover pattern:
  - `hover:bg-*`, `hover:text-*`, `hover:-translate-y-0.5`.
- Responsive pattern:
  - mobile-first (`hidden md:flex`, `grid md:grid-cols-*`, `lg:*`).

### 5.3 Konsistensi Komponen
- Radius besar (`rounded-xl`, `rounded-2xl`, `rounded-3xl`) untuk gaya lembut.
- Border netral coklat muda (`#e0d0c0`/`#ede0d4`) sebagai sistem surface.
- Shadow halus dengan tint brand (`shadow-[#a47551]/...`) untuk depth ringan.

---

## 6. Alur Integrasi Livewire & Alpine.js

### 6.1 Pola Integrasi yang Digunakan
- Alpine dipakai untuk **micro-interaction lokal**, bukan global store kompleks:
  - toggle navbar mobile
  - dropdown user menu
  - show/hide password
  - carousel quote auth panel
- Livewire tetap menangani source of truth server state (auth, form submit, cart).

### 6.2 Kompatibilitas dengan `wire:navigate`
- Di header, ada reset state Alpine saat navigasi Livewire:
  - `x-on:livewire:navigated.window="menu = false; userDropdown = false"`
- Ini mencegah state UI lama “nyangkut” setelah route berpindah tanpa full reload.

### 6.3 Batas Tanggung Jawab yang Sehat
- **Alpine**: state ephemeral UI (`menu`, `scrolled`, `showPassword`).
- **Livewire**: state data bisnis (`message`, `products`, `cartCount`, auth flow).
- **Blade**: glue layer untuk event dan rendering condition.

### 6.4 Risiko & Rekomendasi Arsitektural
> Risiko minor:
> - Variasi style validation + naming method bilingual dapat menurunkan konsistensi tim.
>
> Rekomendasi:
> 1. Tetapkan satu standar validasi per layer (`#[Rule]` atau `$rules`).
> 2. Tetapkan konvensi naming method tunggal (EN-only atau ID-only).
> 3. Konsolidasikan sistem font (hapus token legacy yang tidak dipakai).
> 4. Dokumentasikan token warna ke satu source of truth (Tailwind theme tokens), kurangi hardcoded hex berulang.

---

## Lampiran Singkat: Snapshot Routing

```php
/
/kontak
/login (guest)
/register (guest)
/curhat (auth)
/shop
/product/{product}
```

---

## Status Audit
- Audit ini berbasis pembacaan langsung file source (config, class, view, route, dependency manifests) pada workspace aktif.
- Dokumen ini bisa dijadikan baseline untuk refactor desain sistem berikutnya (tokenisasi warna, harmonisasi typography, dan standardisasi coding conventions).
