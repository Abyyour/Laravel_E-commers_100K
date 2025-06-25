<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="{{asset('output.css')}}" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
    </head>
    <body>
        <div class="relative flex flex-col w-full max-w-[640px] min-h-screen gap-5 mx-auto bg-[#F5F5F0]">
            <div id="top-bar" class="flex justify-between items-center px-4 mt-[60px]">
                <a href="{{route('front.index')}}">
                    <img src="assets/images/icons/back.svg" class="w-10 h-10" alt="icon">
                </a>
                <p class="font-bold text-lg leading-[27px]">Search Result</p>
                <div class="dummy-btn w-10"></div>
            </div>
            <form action="{{route('front.search')}}" class="flex justify-between items-center mx-4">
                <div class="relative flex items-center w-full rounded-l-full px-[14px] gap-[10px] bg-white transition-all duration-300 focus-within:ring-2 focus-within:ring-[#FFC700]">
                    <img src="assets/images/icons/search-normal.svg" class="w-6 h-6" alt="icon">
                    <input type="text" name="keyword" class="w-full py-[14px] appearance-none bg-white outline-none font-bold leading-5 placeholder:font-normal placeholder:text-[#878785]" placeholder="Search product...">
                </div>
                <button type="submit" class="h-full rounded-r-full py-[14px] px-5 bg-[#C5F277]">
                    <span class="font-semibold">Explore</span>
                </button>
            </form>
            <section id="result" class="flex flex-col gap-4 px-4 mb-[111px] mt-[10px]">


                {{-- <a href="details.html">
                    <div class="flex items-center rounded-3xl p-[10px_16px_16px_10px] gap-[14px] bg-white transition-all duration-300 hover:ring-2 hover:ring-[#FFC700]">
                        <div class="w-20 h-20 flex shrink-0 rounded-2xl bg-[#D9D9D9] overflow-hidden">
                            <img src="assets/images/thumbnails/photo5.png" class="w-full h-full object-cover" alt="thumbnail">
                        </div>
                        <div class="flex w-full items-center justify-between gap-[14px]">
                            <div class="flex flex-col gap-[6px]">
                                <h3 class="font-bold leading-[20px]">Hello Kity Sandal Lite</h3>
                                <p class="text-sm leading-[21px] text-[#878785]">Sandal</p>
                            </div>
                            <div class="flex flex-col gap-1 items-end shrink-0">
                                <div class="flex">
                                    <img src="assets/images/icons/Star 1.svg" class="w-[18px] h-[18px] flex shrink-0" alt="star">
                                    <img src="assets/images/icons/Star 1.svg" class="w-[18px] h-[18px] flex shrink-0" alt="star">
                                    <img src="assets/images/icons/Star 1.svg" class="w-[18px] h-[18px] flex shrink-0" alt="star">
                                    <img src="assets/images/icons/Star 1.svg" class="w-[18px] h-[18px] flex shrink-0" alt="star">
                                    <img src="assets/images/icons/Star 1.svg" class="w-[18px] h-[18px] flex shrink-0" alt="star">
                                </div>
                                <p class="font-semibold text-sm leading-[21px]">4.5</p>
                            </div>
                        </div>
                    </div>
                </a> --}}


                @forelse ($shoes as $itemShoe)
                    <a href="{{route('front.details', $itemShoe->slug)}}">
                        <div class="flex items-center rounded-3xl p-[10px_16px_16px_10px] gap-[14px] bg-white transition-all duration-200">
                            <div class="w-20 h-20 flex shrink-0 rounded-2xl overflow-hidden">
                                <img src="{{Storage::url($itemShoe->thumbnail)}}" class="w-full h-full object-cover" alt="thumbnail" />
                            </div>
                            <div class="flex w-full items-center justify-between gap-[14px]">
                                <div class="flex flex-col gap-[6px]">
                                    <h3 class="font-bold leading-[20px]">
                                        {{$itemShoe->name}}
                                    </h3>
                                    <p class="text-sm leading-[21px] text-[#878785]">
                                        {{$itemShoe->category->name}}
                                    </p>
                                </div>
                                <div class="flex flex-col gap-1 items-end shrink-0">
                                    <div class="flex">
                                        <img src="assets/images/icons/Star 1.svg" class="w-[18px] h-[18px] flex shrink-0" alt="" />
                                        <img src="assets/images/icons/Star 1.svg" class="w-[18px] h-[18px] flex shrink-0" alt="" />
                                        <img src="assets/images/icons/Star 1.svg" class="w-[18px] h-[18px] flex shrink-0" alt="" />
                                        <img src="assets/images/icons/Star 1.svg" class="w-[18px] h-[18px] flex shrink-0" alt="" />
                                        <img src="assets/images/icons/Star 1.svg" class="w-[18px] h-[18px] flex shrink-0" alt="" />
                                    </div>
                                    <p class="font-semibold text-sm leading-[21px]">4.5</p>
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <p>Belum ada produk sesuai "{{ $keyword }}"</p>
                @endforelse

                

            </section>
        </div>
    </body>
</html>