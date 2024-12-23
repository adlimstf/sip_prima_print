<footer class="bg-gray-50 w-full mt-5">
    <div class="container mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 justify-around py-5 px-5">
        <div class="profile">
            <Span class="font-bold border-s-4 border-black px-3">Percetakan Prima Printing </Span>
            <div class="flex gap-5 py-6">
                <img src="{{ asset('static/img/prima_logo.png') }}" class="w-[90px] h-[90px]" alt="logo">
                <div class="text-sm">
                    <span class="font-bold">Jam Oprasional</span>
                    <table class="block pb-5">
                        <tr>
                            <td class="whitespace-nowrap">Senin - Jum'at</td>
                            <td class="whitespace-nowrap">: 08.00 - 22.00</td>
                        </tr>
                        <tr>
                            <td class="whitespace-nowrap">Sabtu</td>
                            <td class="whitespace-nowrap">: 09.00 - 19.00</td>
                        </tr>
                        <tr>
                            <td>Minggu</td>
                            <td>libur</td>
                        </tr>
                    </table>

                    <span class="font-bold">Ikuti Kami</span>
                    <div class="flex gap-2 pt-2">
                        {{-- <a target="_blank" href="https://www.facebook.com" class="mr-2">
                            <i class="fab fa-facebook text-2xl"></i>
                        </a> --}}
                        <a target="_blank" href="https://www.instagram.com/perc.primaprinting?igsh=MWlheWJxZjl0Z2twMA=="
                            class="mr-2">
                            <i class="fab fa-instagram text-2xl"></i>
                        </a>
                        {{-- <a target="_blank" href="https://www.tiktok.com">
                            <i class="fab fa-tiktok text-2xl"></i>
                        </a> --}}
                        <a target="_blank" href="https://wa.me/+628127964966">
                            <i class="fab fa-whatsapp text-2xl"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="contact ">
            <Span class="font-bold border-s-4 border-black px-3">Hubungi Kami </Span>
            <div class="py-6">
                <table>
                    <tr>
                        <td class="align-top">
                            <i class="fa-solid fa-angle-right"></i>
                        </td>
                        <td class="align-top">Jl. Tabak No.09, Madukoro, Kec. Kotabumi Utara, Kabupaten Lampung Utara,
                            Lampung 34511</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="align-top">
                            <a href="mailto:perc.primaprinting@gmail.com"
                                class="">perc.primaprinting@gmail.com</a>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="align-top">
                            <a href="https://wa.me/+628127964966" target="_blank" class="">0812-7964-966</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="align-top">
                            <i class="fa-solid fa-angle-right"></i>
                        </td>
                        <td class="align-top">Pasar Cempaka, Cempaka, Kec. Sungkai Jaya, Kabupaten Lampung Utara,
                            Lampung 34554</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="align-top">
                            <a href="https://wa.me/+6282374873888" target="_blank" class="">0823-7487-3888</a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="help">
            <Span class="font-bold border-s-4 border-black px-3">Tentang Kami</Span>

            <div class="py-6">
                <a href="{{ route('guest.about') }}" class="block">Tentang Perusahaan</a>
                <a href="{{ route('guest.faq', ['q' => 'cara_pemesanan']) }}" class="block">Cara Pemesanan</a>
                <a href="{{ route('guest.about') }}#contak" class="block">Kontak Kami</a>
                <a href="{{ route('guest.faq', ['q' => 'waktu_cetak']) }}" class="block">Pengiriman</a>
                <a href="{{ route('guest.faq') }}" class="block">FAQ</a>
            </div>
        </div>
    </div>
    <p class="text-center py-3 bg-blue-950 text-gray-200">&copy; {{ date('Y') }} Percetakan Prima Printing. All
        rights reserved.</p>
</footer>
