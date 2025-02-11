<x-guest-layout>
    <x-slot name="title">Keranjang Belanja</x-slot>

    <x-slot name="head">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </x-slot>

    <div class="mx-auto  w-full px-1 2xl:px-0">
        <div class="flex gap-3 items-center">
            <a href="{{ url()->previous() }}">
                <i class="fa-solid fa-arrow-left text-lg px-3"></i>
            </a>
            <h2 class="text-xl font-semibold text-gray-900 sm:text-2xl">Keranjang Belanja</h2>
        </div>

        @if (count($carts) == 0)
            <div class=" text-center">
                <p class="text-2xl font-semibold text-gray-800">Keranjang Produk Kosong</p>
                <p class="text-xl font-normal text-gray-500">Silahkan tambahkan produk ke keranjang</p>
            </div>
        @else
            <div class="mt-2 sm:mt-4 md:gap-3 lg:flex lg:items-start xl:gap-3">
                <div class="mx-auto w-full flex-none lg:max-w-[70%] xl:max-w-[70%]">
                    <div class="space-y-6">
                        @foreach ($carts as $cart)
                            <div x-data="CartCounter({{ $cart->id }}, {{ $cart->quantity }}, {{ $cart->product->data_produck->harga_satuan }}, '{{ route('user.cart.update') }}', {{ $cart->product->data_produck->stok }}, {{ $cart->product->data_produck->minimal_grosir ?? 1 }}, {{ request()->query('cart_id') == $cart->id ? 'true' : 'false' }})"
                                class="rounded-xl border border-gray-200 bg-white md:px-6 px-3 py-3 shadow-sm">
                                <div class="flex  items-start justify-between md:gap-6 gap-3 space-y-0">

                                    <button type="button" class="h-6 aspect-square border rounded-sm"
                                        :disabled="disabled" @click="toggleSelection()">
                                        <i x-show="selected" class="fa-solid fa-check text-blue-600"></i>
                                        <i x-show="!selected" class="fa-solid"></i>
                                    </button>

                                    <div class="shrink-0">
                                        <img class="md:w-32 w-24 rounded-xl aspect-square object-cover"
                                            src="{{ $cart->product->img_produck->count() > 0 ? asset('storage/img_produck/' . $cart->product->img_produck[0]->img) : asset('static/img/default_product.png') }}"
                                            alt="product image" />
                                    </div>

                                    <div class="w-full min-w-0 flex-1 space-y-4">
                                        <p class="text-2xl font-bold text-gray-900">{{ $cart->product->name }}</p>
                                        <p class="text-base font-medium text-gray-800">
                                            Estimasi Pengerjaan 1-14 Hari
                                        </p>
                                        <p class="text-base font-light text-red-500" x-show="minimal">
                                            Minimal Pemesanan {{ $cart->product->data_produck->minimal_grosir ?? 1 }}
                                        </p>

                                        <div class="flex items-center gap-4">
                                            <div class="hidden md:flex gap-3">
                                                <a href="{{ route('guest.product.show', $cart->product->id) }}"
                                                    type="button"
                                                    class="inline-flex gap-2 items-center text-sm font-medium text-black hover:underline pb-3 md:pb-0">
                                                    <i class="fa-solid fa-eye"></i>
                                                    Detail
                                                </a>

                                                <a href="{{ route('user.cart.delete', $cart->id) }}" type="button"
                                                    class="inline-flex gap-2 items-center text-sm font-medium text-red-600 hover:underline">
                                                    <i class="fa-solid fa-trash"></i>
                                                    Hapus
                                                </a>

                                            </div>
                                            <div class="px-3 hidden md:block">
                                                <p class="font-bold text-base">Harga Barang</p>
                                                <p class="text-blue-600 text-base font-medium">Rp
                                                    Rp. <span
                                                        x-text="productPrice.toLocaleString('id-ID', {minimumFractionDigits: 0, maximumFractionDigits: 0})"></span>
                                                </p>
                                            </div>

                                            <div class="px-3">
                                                <p class="font-bold text-base">Jumlah</p>
                                                <div class="flex items-center">
                                                    <button type="button"
                                                        class="inline-flex h-5 w-5 items-center justify-center rounded-md border border-gray-300 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700"
                                                        @click="decrement">
                                                        <i class="fa-solid fa-minus text-white"></i>
                                                    </button>

                                                    <!-- Input quantity -->
                                                    <input type="number" min="1" x-model="quantity"
                                                        @input="triggerDebounceUpdate()"
                                                        class="w-24 border-0 bg-transparent text-center text-sm font-medium text-gray-900 focus:outline-none focus:ring-0 "
                                                        required />

                                                    <!-- Tombol Plus -->
                                                    <button type="button"
                                                        class="inline-flex h-5 w-5 items-center justify-center rounded-md border border-gray-300 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700"
                                                        @click="increment">
                                                        <i class="fa-solid fa-plus text-white"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <p class="md:hidden text-end mb-4">Stok :
                                                {{ $cart->product->data_produck->stok }}</p>
                                        </div>
                                    </div>

                                    <div class="hidden md:block">
                                        <p class="text-end mb-4">Stok : {{ $cart->product->data_produck->stok }}</p>
                                        <div class="text-end md:order-4 md:w-32">
                                            <p class="font-medium text-base">Total Harga :</p>
                                            <p class="text-base font-bold text-blue-600">
                                                Rp <span
                                                    x-text="(productPrice * quantity).toLocaleString('id-ID', {minimumFractionDigits: 0, maximumFractionDigits: 0})"></span>
                                            </p>
                                        </div>
                                    </div>


                                </div>
                                <div class="flex md:hidden items-centermd:order-3 justify-between px-5 py-5">

                                    <div class="flex gap-3 items-center">
                                        <a href="{{ route('guest.product.show', $cart->product->id) }}" type="button"
                                            class="inline-flex gap-2 items-center text-sm font-medium text-black hover:underline pb-3 md:pb-0">
                                            <i class="fa-solid fa-eye"></i>
                                            Detail
                                        </a>

                                        <a href="{{ route('user.cart.delete', $cart->id) }}" type="button"
                                            class="inline-flex gap-2 items-center text-sm font-medium text-red-600 hover:underline pb-3 md:pb-0">
                                            <i class="fa-solid fa-trash"></i>
                                            Hapus
                                        </a>

                                    </div>
                                    <div class="text-end md:order-4 md:w-32">
                                        <p class="font-medium text-base">Total Harga :</p>
                                        <p class="text-base font-bold text-blue-600">
                                            Rp <span
                                                x-text="(productPrice * quantity).toLocaleString('id-ID', {minimumFractionDigits: 0, maximumFractionDigits: 0})"></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mx-auto mt-6 max-w-lg min-w-96 flex-1 space-y-6 lg:mt-0 lg:w-full">
                    <div class="space-y-4 rounded-lg border bg-white p-4 shadow-sm sm:p-6">
                        <p class="text-xl font-semibold text-gray-900  ">Ringkasan Pesanan</p>

                        <div class="space-y-4">
                            <div class="space-y-2">
                                <dl class="flex items-center justify-between gap-4">
                                    <dt class="text-base font-normal text-gray-500">Sub Total
                                    </dt>
                                    <dd class="text-base font-medium text-gray-900  ">Rp. <span
                                            id="total_Harga">0</span>
                                    </dd>
                                </dl>
                            </div>
                        </div>

                        <div id="checkout-form" class="flex items-center justify-center gap-2">
                            <form action="{{ route('user.checkout.store') }}" method="POST" x-data="{ loading: false }"
                                @submit="loading = true">
                                @csrf
                                <input type="hidden" id="item-details" name="items">

                                <template x-if="!loading">
                                    <button type="submit" id="checkout-button" x-ref="checkoutButton"
                                        class="flex w-full items-center justify-center rounded-lg px-5 py-2.5 text-sm font-medium bg-gray-300 text-white">
                                        Check Out
                                    </button>
                                </template>

                                <template x-if="loading">
                                    <button type="button" disabled
                                        class="flex w-full items-center justify-center rounded-lg px-5 py-2.5 text-sm font-medium bg-gray-400 text-white">
                                        Loading...
                                    </button>
                                </template>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <x-slot name="scripts">
        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
        <script src="https://cdn.datatables.net/2.1.7/js/dataTables.js"></script>
        <script>
            var itemSelected = [];
            const totalHargaElement = document.getElementById('total_Harga');
            const itemDetailsInput = document.getElementById('item-details');
            var isInitialized = false;

            function ToggleButton() {
                var checkoutButton = document.querySelector('[x-ref="checkoutButton"]');

                if (itemSelected.length > 0) {
                    checkoutButton.removeAttribute('disabled');
                    checkoutButton.classList.remove('bg-gray-300');
                    checkoutButton.classList.add('bg-blue-600');
                } else {
                    checkoutButton.setAttribute('disabled', 'disabled');
                    checkoutButton.classList.remove('bg-blue-600');
                    checkoutButton.classList.add('bg-gray-300');
                }
            }

            function renderTotalHarga() {
                itemDetailsInput.value = JSON.stringify(itemSelected);
                if (!isInitialized) {
                    document.addEventListener('DOMContentLoaded', function() {
                        ToggleButton();
                        isInitialized = true;
                    });
                } else {
                    ToggleButton();
                }
                const totalHarga = itemSelected.reduce((acc, item) => acc + item.totalHarga, 0);
                totalHargaElement.innerText = totalHarga.toLocaleString('id-ID', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                });
            }

            function addSelected(total, harga, id) {
                if (itemSelected.includes(id)) {
                    itemSelected = itemSelected.filter(item =>
                        item.id !== id
                    );
                } else {
                    itemSelected.push({
                        id: id,
                        jumlah: total,
                        hargaBarag: harga,
                        totalHarga: total * harga
                    });
                }
                renderTotalHarga();
            }

            function removeSelected(id) {
                itemSelected = itemSelected.filter(item =>
                    item.id !== id
                );
                renderTotalHarga();
            }

            document.addEventListener('alpine:init', () => {
                Alpine.data('CartCounter', (cartId, initialQuantity = 1, productPrice, updateUrl, stockAvailable,
                    minialOrder, selected = false) => ({
                    cartId: cartId,
                    productPrice: productPrice,
                    quantity: initialQuantity,
                    updateUrl: updateUrl,
                    totalPrice: initialQuantity * productPrice,
                    stok: stockAvailable,
                    minimalOrder: minialOrder,
                    debounceTimer: null,
                    selected: selected,
                    disabled: false,
                    minimal: false,

                    init() {
                        this.updateDisabledBtn();
                        if (this.selected) {
                            addSelected(this.quantity, this.productPrice, this.cartId);
                        }
                    },

                    increment() {
                        this.quantity++;
                        if (this.quantity > this.stok) {
                            this.quantity = this.stok;
                        }
                        this.updateProductQuantity();
                    },
                    decrement() {
                        if (this.quantity > 0) this.quantity--;
                        if (this.quantity < 1) {
                            this.quantity = 1;
                        }
                        this.updateProductQuantity();
                    },
                    triggerDebounceUpdate() {
                        clearTimeout(this.debounceTimer);
                        this.debounceTimer = setTimeout(() => {
                            if (this.quantity < 1) {
                                this.quantity = 1;
                            } else if (this.quantity > this.stok) {
                                this.quantity = this.stok;
                            }
                            this.updateProductQuantity();
                        }, 1000);
                    },
                    updateDisabledBtn() {
                        this.minimal = this.quantity < this.minimalOrder;
                        this.disabled = this.quantity >= this.stok || this.quantity < this.minimalOrder;
                        if (this.disabled) {
                            this.selected = false;
                            removeSelected(this.cartId);
                        }
                    },
                    toggleSelection() {
                        this.selected = !this.selected;
                        this.selected ? addSelected(this.quantity, this.productPrice, this.cartId) :
                            removeSelected(this.cartId);
                    },
                    updateProductQuantity() {
                        this.updateDisabledBtn();
                        axios.post(this.updateUrl, {
                                cart_id: this.cartId,
                                quantity: this.quantity
                            })
                            .then(response => {
                                console.log(`cart ${this.cartId} updated successfully.`);
                                this.updateTotalPrice();
                            })
                            .catch(error => {
                                console.error(`Failed to update cart ${this.cartId}: `, error);
                            });
                    },
                    updateTotalPrice() {
                        const exssitingIndex = itemSelected.findIndex(item => item.id === this.cartId);
                        if (exssitingIndex !== -1) {
                            jumlah = this.quantity;
                            itemSelected[exssitingIndex].totalHarga = this.quantity * this.productPrice;
                        }
                        renderTotalHarga();
                    }
                }));
            });

            var carts = @json($carts);
            var paramCartid = @json(request()->query('cart_id'));
            if (paramCartid) {
                carts.forEach(cart => {
                    if (cart.id == paramCartid) {
                        addSelected(cart.quantity, cart.product.data_produck.harga_satuan, cart.id)
                    }
                });
            } else {
                isInitialized = true
            }
        </script>
    </x-slot>
</x-guest-layout>