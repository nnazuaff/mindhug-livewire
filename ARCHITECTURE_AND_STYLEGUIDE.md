# ARCHITECTURE_AND_STYLEGUIDE — MindHug v2

> Audit codebase terkini per Juli 2026. Mencakup semua perubahan fitur, struktur, dan konvensi yang telah diimplementasikan.
>
> Stack: Laravel `^13.8`, Livewire `^4.3`, Tailwind CSS `^4.0`, Vite `^8.0`, Alpine.js, Cropper.js, laravolt/indonesia `^0.41.0`.

---

## 1. Warna & Tokens

### 1.1 Brand Palette

| Token | Hex | Peran |
|-------|-----|-------|
| Primary | `#a47551` | CTA, icon, active state, brand tint |
| Primary Hover | `#8f6243` | Hover/darker brand |
| Secondary Surface | `#f5e9df` | Chip, hover bg, panel lembut |
| Canvas | `#fdfaf7`, `#fffafc`, `#fcf8f5` | Background netral hangat |
| Text Primary | `#2b2b2b`, `#2b1d12` | Teks utama, judul |
| Text Secondary | `#3d2b1c` | Subheading |
| Accent | `#c19a6b` | Highlight hangat |
| Border | `#e0d0c0`, `#ede0d4` | Input, divider |
| Placeholder | `#b0a090` | Input placeholder |
| Muted | `#666`, `#888`, `#999` | Teks sekunder |

### 1.2 Role Badge Colors (CSS Custom Properties di `app.css`)

| Role | Class | Warna |
|------|-------|-------|
| Dev | `.role-dev` | Ungu (`#f3e8ff` / `#7c3aed`) |
| Admin | `.role-admin` | Biru (`#dbeafe` / `#2563eb`) |
| Free | `.role-free` | Stone (`#f5f5f4` / `#57534e`) |
| Plus | `.role-plus` | Amber (`#fef3c7` / `#b45309`) |
| Dev (dark bg) | `.role-dev-dark` | Ungu transparan |
| Admin (dark bg) | `.role-admin-dark` | Biru transparan |

---

## 2. Tipografi

### 2.1 Font

- **Body**: `Plus Jakarta Sans` (via `--font-sans`)
- **Display/Headline**: `Playfair Display` (via `--font-display`)
- **Fallback**: `Quicksand`, `Nunito` (tersedia di layout app, jarang dipakai)
- **Legacy dihapus**: `Poppins`, `Baloo 2`

### 2.2 Skala Tipografi

| Elemen | Ukuran | Weight |
|--------|--------|--------|
| Hero headline | `2.15rem` → `3.25rem` md | `font-bold` |
| Section title | `1.9rem` → `2.25rem` md | `font-bold` |
| Card title | `text-lg` | `font-semibold` |
| Body | `text-sm` / `text-[1.02rem]` | `font-normal` / `font-medium` |
| CTA button | `text-sm` | `font-semibold` |
| Form label | `text-sm` | `font-medium` |
| Meta/badge | `text-xs` | `font-semibold` / `font-medium` |

---

## 3. Struktur Proyek (Update)

```text
app/
  Http/
    Controllers/
      Admin/AuthController.php
      Controller.php
    Middleware/
      AdminRole.php
      AdminSession.php
      CheckUserStatus.php
    Livewire/
      Account/
        Addresses.php, Profile.php, Security.php
      Admin/
        Admins/ (Index, Create, Edit)
        Curhats/ (Index, ChatPanel, ConversationList)
        Users/ (Index, Create, Edit)
        Products/ (Index, Create, Edit)
        Promotions/ (Index, Create, Edit)
        Categories.php, Dashboard.php, Orders.php, PaymentMethods.php
      Auth/ (Login, Register)
      Checkout/Index.php
      Curhat/ (CurhatForm, ProductRecommendation)
      Kontak/KontakForm.php
      Layouts/ (Header, AdminCurhatBadge, Footer)
      Orders/ (Index, Pay, Show)
      Shop/ (Index, ProductDetail)
      Transactions/Cart.php
  Models/
    Admin, User, UserAddress, Product, Category, Order, OrderItem,
    OrderTrackingEvent, OrderShipment, PaymentMethod, Promotion,
    Conversation, Message
  Services/
    OrderService.php
  Providers/
    AppServiceProvider.php

resources/
  css/app.css
  views/
    components/
      confirmation-dialog.blade.php
      notification-toast.blade.php (reusable toast)
      tooltip-icon.blade.php
      layouts/
        admin.blade.php (sidebar + toast container)
        app.blade.php (include toast)
        auth.blade.php
    livewire/
      account/ (addresses, profile, security)
      admin/ (admins, categories, curhats, dashboard, orders,
              payment-methods, products, promotions, users)
      auth/ (login, register)
      checkout/index.blade.php
      curhat/ (curhat-form, product-recommendation)
      kontak/kontak-form.blade.php
      layouts/ (admin-curhat-badge, footer, header)
      orders/ (index, pay, show)
      shop/ (index, product-detail)
      transactions/cart.blade.php
    account/ (_sidebar, addresses, profile, security)
    admin/login.blade.php
    auth/ (login, register)
    cart.blade.php, home.blade.php
    checkout/index.blade.php
    curhat/index.blade.php, kontak/index.blade.php
    orders/ (index, pay, show)
    shop/ (index, product-detail)

config/ (app, auth, database, livewire, dll)
routes/ (web.php, admin.php)
database/migrations/ (24 file)
```

---

## 4. Konvensi Kode

### 4.1 Livewire

- **Class**: PascalCase, namespace `App\Http\Livewire\{Domain}`
- **Blade**: kebab-case, path `livewire/{domain}/`
- **Mount**: `<livewire:domain.component />`
- **Properti**: public untuk state; method action verb (EN: `send`, `delete`, `update`)
- **Validasi**: dominan `$rules` array, beberapa `#[Rule]`
- **Notifikasi toast**: `$this->dispatch('notify', type: 'success', message: '...');`

### 4.2 Blade

- Tailwind utility-first, custom CSS minimal di `app.css`
- `wire:model`, `wire:model.defer`, `wire:model.live` sesuai kebutuhan
- `@error('field')` + border merah (`border-rose-300 bg-rose-50/50`) di semua form
- Timezone: `->setTimezone('Asia/Jakarta')` untuk `created_at`/`updated_at`
- Role badge: class CSS `.role-*`, tidak hardcoded hex

### 4.3 Alpine.js

- Micro-interactions: modal, dropdown, toggle, confirm dialog
- Toast system: komponen `notification-toast.blade.php`, reusable via `@include`
- Reset state saat navigasi: `x-on:livewire:navigated.window`

---

## 5. Fitur & Route

### 5.1 User Routes (`routes/web.php`)

| Route | Middleware |
|-------|------------|
| `/` | public |
| `/kontak` | public |
| `/login`, `/register` | guest |
| `/curhat`, `/account/*`, `/checkout`, `/transactions/*` | auth + user.active |
| `/shop`, `/product/{product}` | public |

### 5.2 Admin Routes (`routes/admin.php`)

| Route | Middleware |
|-------|------------|
| `/admin/login` | guest:admin |
| `/admin` (Dashboard) | auth:admin |
| `/admin/users`, `/admin/orders`, `/admin/curhats`, `/admin/products`, `/admin/categories`, `/admin/payment-methods`, `/admin/promotions` | auth:admin + admin.role:dev,admin |
| `/admin/admins` | auth:admin + admin.role:dev |

### 5.3 Fitur Utama

- **Order Management**: CRUD, tracking, invoice, cancel request, reject cancel, reject payment proof
- **Curhat**: real-time chat, take over, close, delete message, product recommendation
- **User Management**: CRUD, status active/inactive, auto-logout via middleware
- **Product Management**: CRUD, crop foto, dropship (Shopee), validasi conditional
- **Admin Management**: CRUD (hanya dev), role badge, filter by role
- **Payment Methods**: CRUD, icon, sort order
- **Voucher/Promo**: CRUD, validasi tanggal, max uses, perhitungan diskon
- **Toast Notifikasi**: Reusable component, 4 tipe (success/error/warning/info), max 5, animasi smootha
- **Session terpisah**: Cookie `mindhug_admin_session` untuk admin
- **Region data**: `laravolt/indonesia` (province → village)
- **Timezone**: App `Asia/Jakarta`, MySQL `+07:00`, tampilan WIB di semua view

---


*Dokumen ini akan terus diperbarui seiring development.*
