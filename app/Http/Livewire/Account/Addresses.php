<?php

namespace App\Http\Livewire\Account;

use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Addresses extends Component
{
    public User $user;

    public array $addresses = [];

    public $address_label = 'home';

    public $address_recipient_name = '';

    public $address_phone = '';

    public $address_region = '';

    public $address_street = '';

    public $address_detail = '';

    public $address_is_primary = false;

    public bool $regionDataReady = false;

    public array $provinces = [];

    public array $cities = [];

    public array $districts = [];

    public array $villages = [];

    public ?string $selectedProvinceCode = null;

    public ?string $selectedCityCode = null;

    public ?string $selectedDistrictCode = null;

    public ?string $selectedVillageCode = null;

    public function mount(): void
    {
        $this->user = Auth::user();
        $this->loadRegionOptions();
        $this->loadAddresses();
    }

    public function loadRegionOptions(): void
    {
        $hasRegionTables = DB::getSchemaBuilder()->hasTable('indonesia_provinces')
            && DB::getSchemaBuilder()->hasTable('indonesia_cities')
            && DB::getSchemaBuilder()->hasTable('indonesia_districts')
            && DB::getSchemaBuilder()->hasTable('indonesia_villages');

        if (! $hasRegionTables) {
            $this->regionDataReady = false;
            $this->provinces = [];

            return;
        }

        $this->provinces = DB::table('indonesia_provinces')
            ->select('code', 'name')
            ->orderBy('name')
            ->get()
            ->map(fn ($province) => [
                'code' => (string) $province->code,
                'name' => (string) $province->name,
            ])
            ->all();

        $this->regionDataReady = count($this->provinces) > 0;
    }

    public function updatedSelectedProvinceCode(?string $value): void
    {
        $this->selectedCityCode = null;
        $this->selectedDistrictCode = null;
        $this->selectedVillageCode = null;
        $this->districts = [];
        $this->villages = [];

        if (! $value || ! $this->regionDataReady) {
            $this->cities = [];

            return;
        }

        $this->cities = DB::table('indonesia_cities')
            ->select('code', 'name')
            ->where('province_code', $value)
            ->orderBy('name')
            ->get()
            ->map(fn ($city) => [
                'code' => (string) $city->code,
                'name' => (string) $city->name,
            ])
            ->all();
    }

    public function updatedSelectedCityCode(?string $value): void
    {
        $this->selectedDistrictCode = null;
        $this->selectedVillageCode = null;
        $this->villages = [];

        if (! $value || ! $this->regionDataReady) {
            $this->districts = [];

            return;
        }

        $this->districts = DB::table('indonesia_districts')
            ->select('code', 'name')
            ->where('city_code', $value)
            ->orderBy('name')
            ->get()
            ->map(fn ($district) => [
                'code' => (string) $district->code,
                'name' => (string) $district->name,
            ])
            ->all();
    }

    public function updatedSelectedDistrictCode(?string $value): void
    {
        $this->selectedVillageCode = null;

        if (! $value || ! $this->regionDataReady) {
            $this->villages = [];

            return;
        }

        $this->villages = DB::table('indonesia_villages')
            ->select('code', 'name')
            ->where('district_code', $value)
            ->orderBy('name')
            ->get()
            ->map(fn ($village) => [
                'code' => (string) $village->code,
                'name' => (string) $village->name,
            ])
            ->all();
    }

    public function loadAddresses(): void
    {
        $this->addresses = $this->user->addresses()
            ->orderByDesc('is_primary')
            ->get()
            ->toArray();
    }

    public function saveAddress(): void
    {
        $rules = [
            'address_label' => ['required', 'string', 'max:20'],
            'address_recipient_name' => ['required', 'string', 'max:150'],
            'address_phone' => ['required', 'string', 'regex:/^[0-9+\-\s]{8,20}$/'],
            'address_street' => ['required', 'string', 'max:255'],
            'address_detail' => ['nullable', 'string', 'max:255'],
        ];

        if ($this->regionDataReady) {
            $rules['selectedProvinceCode'] = ['required', 'string', Rule::exists('indonesia_provinces', 'code')];
            $rules['selectedCityCode'] = ['required', 'string', Rule::exists('indonesia_cities', 'code')];
            $rules['selectedDistrictCode'] = ['required', 'string', Rule::exists('indonesia_districts', 'code')];
            $rules['selectedVillageCode'] = ['required', 'string', Rule::exists('indonesia_villages', 'code')];
        } else {
            $rules['address_region'] = ['required', 'string', 'max:255'];
        }

        $this->validate($rules, [
            'address_phone.regex' => 'The phone number may only contain numbers, spaces, +, or -.',
            'selectedProvinceCode.required' => 'Please select a province.',
            'selectedCityCode.required' => 'Please select a city or regency.',
            'selectedDistrictCode.required' => 'Please select a district.',
            'selectedVillageCode.required' => 'Please select a village or sub-district.',
        ]);

        if ($this->regionDataReady) {
            $this->address_region = $this->buildRegionLabelFromSelection();
        }

        if ($this->address_is_primary) {
            UserAddress::where('user_id', $this->user->id)->update(['is_primary' => false]);
        }

        $this->user->addresses()->create([
            'label' => $this->address_label,
            'recipient_name' => $this->address_recipient_name,
            'phone' => $this->address_phone,
            'region' => $this->address_region,
            'street' => $this->address_street,
            'detail' => $this->address_detail,
            'is_primary' => $this->address_is_primary,
        ]);

        $this->resetAddressForm();
        $this->loadAddresses();
        session()->flash('success', 'Alamat berhasil disimpan.');
    }

    public function setPrimaryAddress(int $addressId): void
    {
        $address = UserAddress::where('user_id', $this->user->id)->find($addressId);

        if (! $address) {
            return;
        }

        UserAddress::where('user_id', $this->user->id)->update(['is_primary' => false]);
        $address->update(['is_primary' => true]);

        $this->loadAddresses();
        session()->flash('success', 'Alamat utama berhasil diperbarui.');
    }

    public function deleteAddress(int $addressId): void
    {
        $address = UserAddress::where('user_id', $this->user->id)->find($addressId);

        if (! $address) {
            return;
        }

        $address->delete();
        $this->loadAddresses();
        session()->flash('success', 'Alamat berhasil dihapus.');
    }

    protected function resetAddressForm(): void
    {
        $this->address_label = 'home';
        $this->address_recipient_name = '';
        $this->address_phone = '';
        $this->address_region = '';
        $this->address_street = '';
        $this->address_detail = '';
        $this->address_is_primary = false;

        $this->selectedProvinceCode = null;
        $this->selectedCityCode = null;
        $this->selectedDistrictCode = null;
        $this->selectedVillageCode = null;

        $this->cities = [];
        $this->districts = [];
        $this->villages = [];
    }

    protected function buildRegionLabelFromSelection(): string
    {
        $provinceName = DB::table('indonesia_provinces')
            ->where('code', $this->selectedProvinceCode)
            ->value('name');

        $cityName = DB::table('indonesia_cities')
            ->where('code', $this->selectedCityCode)
            ->value('name');

        $districtName = DB::table('indonesia_districts')
            ->where('code', $this->selectedDistrictCode)
            ->value('name');

        $villageName = DB::table('indonesia_villages')
            ->where('code', $this->selectedVillageCode)
            ->value('name');

        return collect([$villageName, $districtName, $cityName, $provinceName])
            ->filter(fn ($value) => filled($value))
            ->implode(', ');
    }

    public function render()
    {
        return view('livewire.account.addresses');
    }
}
