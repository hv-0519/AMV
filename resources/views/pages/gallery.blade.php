@extends('layouts.app')
@section('title', 'Gallery - AMV Amdavadi Misal and Vadapav')

@push('styles')
    <style>
        /* ─── HERO ─────────────────────────────────────── */
        .gallery-hero {
            background: linear-gradient(135deg, #1A0A00, #3D1A00);
            padding: 4rem 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .gallery-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 50% 50%, rgba(255, 107, 0, 0.13), transparent 70%);
        }

        .gallery-hero h1 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2.2rem, 5vw, 3.8rem);
            font-weight: 900;
            color: #fff;
            position: relative;
            z-index: 1;
        }

        .gallery-hero h1 span {
            color: var(--saffron);
        }

        .gallery-hero p {
            color: #ccc;
            font-size: 1.05rem;
            margin-top: 0.8rem;
            position: relative;
            z-index: 1;
        }

        /* ─── PAGE WRAPPER ──────────────────────────────── */
        .gallery-page {
            max-width: 1300px;
            margin: 0 auto;
            padding: 3rem 1.5rem 5rem;
        }

        /* ─── COLLAGE GRID ──────────────────────────────── */
        /*
            Pattern (repeating block of 10 cells, 4 columns):
            Row 1 : [tall-left 2r] [med  1r] [sm   1r] [tall-right 2r]
            Row 2 : [tall-left   ] [sm   1r] [med  1r] [tall-right   ]
            Row 3 : [wide 1r]      [wide 1r] [sm   1r] [wide 1r]
        */
        .collage-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            grid-auto-rows: 180px;
            gap: 12px;
        }

        /* ── size helpers ── */
        .span-r2 {
            grid-row: span 2;
        }

        /* tall  — 21×30 */
        .span-r1 {
            grid-row: span 1;
        }

        /* normal */

        /* ── every cell ── */
        .gallery-cell {
            position: relative;
            border-radius: 14px;
            overflow: hidden;
            background: #2a1500;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.18);
            cursor: pointer;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .gallery-cell:hover {
            transform: scale(1.025);
            box-shadow: 0 10px 30px rgba(255, 107, 0, 0.25);
            z-index: 2;
        }

        .gallery-cell img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.5s;
        }

        .gallery-cell:hover img {
            transform: scale(1.07);
        }

        /* overlay on hover */
        .gallery-cell .overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(26, 10, 0, 0.65) 0%, transparent 55%);
            opacity: 0;
            transition: opacity 0.3s;
            display: flex;
            align-items: flex-end;
            padding: 1rem;
        }

        .gallery-cell:hover .overlay {
            opacity: 1;
        }

        .overlay-text {
            color: #fff;
            font-size: 0.82rem;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .overlay-icon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 44px;
            height: 44px;
            background: rgba(255, 107, 0, 0.85);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            color: #fff;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .gallery-cell:hover .overlay-icon {
            opacity: 1;
        }

        /* placeholder when no image */
        .gallery-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #2a1500, #3d1a00);
            color: rgba(255, 255, 255, 0.3);
            font-size: 2rem;
        }

        /* ─── EMPTY STATE ───────────────────────────────── */
        .empty-state {
            text-align: center;
            padding: 5rem 2rem;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 3px 20px rgba(0, 0, 0, 0.06);
        }

        .empty-state .emoji {
            font-size: 4rem;
            margin-bottom: 1rem;
        }

        .empty-state h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            color: #888;
        }

        /* ─── LIGHTBOX ──────────────────────────────────── */
        .lightbox {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.92);
            z-index: 9999;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        .lightbox.open {
            display: flex;
        }

        .lightbox img {
            max-width: 90vw;
            max-height: 85vh;
            border-radius: 12px;
            object-fit: contain;
            box-shadow: 0 10px 60px rgba(0, 0, 0, 0.6);
            animation: lbIn 0.25s ease;
        }

        @keyframes lbIn {
            from {
                opacity: 0;
                transform: scale(0.9)
            }

            to {
                opacity: 1;
                transform: scale(1)
            }
        }

        .lb-close {
            position: absolute;
            top: 1.2rem;
            right: 1.5rem;
            width: 42px;
            height: 42px;
            background: rgba(255, 107, 0, 0.85);
            border: none;
            border-radius: 50%;
            color: #fff;
            font-size: 1.2rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s;
        }

        .lb-close:hover {
            background: var(--deep-red);
        }

        .lb-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 44px;
            height: 44px;
            background: rgba(255, 255, 255, 0.12);
            border: none;
            border-radius: 50%;
            color: #fff;
            font-size: 1.2rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s;
        }

        .lb-nav:hover {
            background: var(--saffron);
        }

        .lb-prev {
            left: 1.2rem;
        }

        .lb-next {
            right: 1.2rem;
        }

        .lb-counter {
            position: absolute;
            bottom: 1.2rem;
            left: 50%;
            transform: translateX(-50%);
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.85rem;
        }

        /* ─── CTA ───────────────────────────────────────── */
        .gallery-cta {
            text-align: center;
            margin-top: 4rem;
            padding: 3rem 2rem;
            background: linear-gradient(135deg, #1A0A00, #3D1A00);
            border-radius: 20px;
        }

        .gallery-cta h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 900;
            color: #fff;
            margin-bottom: 0.5rem;
        }

        .gallery-cta h2 span {
            color: var(--saffron);
        }

        .gallery-cta p {
            color: #aaa;
            margin-bottom: 1.5rem;
        }

        .btn-cta {
            display: inline-block;
            background: var(--saffron);
            color: #fff;
            padding: 0.9rem 2.5rem;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(255, 107, 0, 0.35);
        }

        .btn-cta:hover {
            background: var(--deep-red);
            transform: translateY(-2px);
        }

        /* ─── RESPONSIVE ────────────────────────────────── */
        @media (max-width: 900px) {
            .collage-grid {
                grid-template-columns: repeat(3, 1fr);
                grid-auto-rows: 150px;
            }
        }

        @media (max-width: 600px) {
            .gallery-page {
                padding: 2rem 1rem 3rem;
            }
            .collage-grid {
                grid-template-columns: repeat(2, 1fr);
                grid-auto-rows: 130px;
                gap: 8px;
            }

            .lb-nav {
                display: none;
            }
            .gallery-cta {
                padding: 2rem 1rem;
            }
            .btn-cta {
                width: 100%;
                text-align: center;
                margin-bottom: 0.75rem;
            }
        }
    </style>
@endpush

@section('content')

    {{-- HERO --}}
    <div class="gallery-hero">
        <h1>Our <span>Gallery</span> 📸</h1>
        <p>A visual feast of authentic Ahamdabadi street food — warning: severe cravings ahead! 🌶️</p>
    </div>

    <div class="gallery-page">

        @php
            /*
             * COLLAGE PATTERN — repeats every 10 images across 4 columns
             * Index  Col-span  Row-span  Label
             *   0      1         2       tall-left   (21×30)
             *   1      1         1       medium      (13×18)
             *   2      1         1       small       (10×15)
             *   3      1         2       tall-right  (21×30)
             *   4      1         1       small       (10×15)
             *   5      1         1       medium      (13×18)
             *   6      1         1       wide        (15×20)
             *   7      1         1       wide        (15×20)
             *   8      1         1       small       (10×15)
             *   9      1         1       wide        (15×20)
             */
            $patterns = [
                ['rs' => 2, 'label' => 'Amdavadi Misal Pav'],
                ['rs' => 1, 'label' => 'Signature Dish'],
                ['rs' => 1, 'label' => 'Fresh & Spicy'],
                ['rs' => 2, 'label' => 'Vadapav Special'],
                ['rs' => 1, 'label' => 'Street Food Vibes'],
                ['rs' => 1, 'label' => 'Made with Love'],
                ['rs' => 1, 'label' => 'AMV Experience'],
                ['rs' => 1, 'label' => 'Authentic Flavors'],
                ['rs' => 1, 'label' => 'Dil Bole Wow'],
                ['rs' => 1, 'label' => 'Our Kitchen'],
            ];

            // Demo placeholder images using picsum (replace with real $galleryImages)
            $demoImages = [
                'https://picsum.photos/seed/misal1/600/800',
                'https://picsum.photos/seed/misal2/600/480',
                'https://picsum.photos/seed/misal3/400/400',
                'https://picsum.photos/seed/misal4/600/800',
                'https://picsum.photos/seed/misal5/400/400',
                'https://picsum.photos/seed/misal6/600/480',
                'https://picsum.photos/seed/misal7/600/400',
                'https://picsum.photos/seed/misal8/600/400',
                'https://picsum.photos/seed/misal9/400/400',
                'https://picsum.photos/seed/misal10/600/400',
                'https://picsum.photos/seed/misal11/600/800',
                'https://picsum.photos/seed/misal12/600/480',
                'https://picsum.photos/seed/misal13/400/400',
                'https://picsum.photos/seed/misal14/600/800',
                'https://picsum.photos/seed/misal15/400/400',
                'https://picsum.photos/seed/misal16/600/480',
                'https://picsum.photos/seed/misal17/600/400',
                'https://picsum.photos/seed/misal18/600/400',
                'https://picsum.photos/seed/misal19/400/400',
                'https://picsum.photos/seed/misal20/600/400',
            ];

            // Use real images if available, else demo
            $images = isset($galleryImages) && $galleryImages->count() > 0
                ? $galleryImages->map(fn($img) => asset('storage/' . $img->image))->toArray()
                : $demoImages;

            $total = count($images);
        @endphp

        @if($total > 0)
            <div class="collage-grid" id="galleryGrid">
                @foreach($images as $i => $src)
                    @php
                        $p = $patterns[$i % count($patterns)];
                    @endphp
                    <div class="gallery-cell span-r{{ $p['rs'] }}" onclick="openLightbox({{ $i }})" data-index="{{ $i }}">
                        <img src="{{ $src }}" alt="{{ $p['label'] }}" loading="lazy">
                        <div class="overlay">
                            <div class="overlay-icon"><i class="fas fa-expand"></i></div>
                            <span class="overlay-text">{{ $p['label'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

        @else
            <div class="empty-state">
                <div class="emoji">📷</div>
                <h3>Gallery Coming Soon!</h3>
                <p>We're curating our finest food moments. Check back soon!</p>
            </div>
        @endif

        {{-- CTA --}}
        <div class="gallery-cta">
            <h2>Craving <span>Already?</span> 😋</h2>
            <p>Come experience the real taste of Ahamdabad — fresh, spicy, and made with love.</p>
            <a href="{{ route('menu') }}" class="btn-cta">🍽️ Explore Our Menu</a>
            &nbsp;&nbsp;
            <a href="{{ url('/order') }}" class="btn-cta"
                style="background:transparent; border:2px solid rgba(255,255,255,0.4); box-shadow:none;">Order Now →</a>
        </div>
    </div>

    {{-- LIGHTBOX --}}
    <div class="lightbox" id="lightbox" onclick="closeLightboxOnBg(event)">
        <button class="lb-close" onclick="closeLightbox()"><i class="fas fa-times"></i></button>
        <button class="lb-nav lb-prev" onclick="changeImage(-1)"><i class="fas fa-chevron-left"></i></button>
        <img src="" alt="Gallery Image" id="lightboxImg">
        <button class="lb-nav lb-next" onclick="changeImage(1)"><i class="fas fa-chevron-right"></i></button>
        <div class="lb-counter" id="lbCounter"></div>
    </div>

    @push('scripts')
        <script>
            // Build image list for lightbox
            const galleryImages = @json($images);
            let currentIndex = 0;

            function openLightbox(index) {
                currentIndex = index;
                updateLightbox();
                document.getElementById('lightbox').classList.add('open');
                document.body.style.overflow = 'hidden';
            }

            function closeLightbox() {
                document.getElementById('lightbox').classList.remove('open');
                document.body.style.overflow = '';
            }

            function closeLightboxOnBg(e) {
                if (e.target === document.getElementById('lightbox')) closeLightbox();
            }

            function changeImage(dir) {
                currentIndex = (currentIndex + dir + galleryImages.length) % galleryImages.length;
                updateLightbox();
            }

            function updateLightbox() {
                const img = document.getElementById('lightboxImg');
                img.style.opacity = 0;
                setTimeout(() => {
                    img.src = galleryImages[currentIndex];
                    img.style.opacity = 1;
                    img.style.transition = 'opacity 0.25s';
                }, 150);
                document.getElementById('lbCounter').textContent =
                    (currentIndex + 1) + ' / ' + galleryImages.length;
            }

            // Keyboard navigation
            document.addEventListener('keydown', (e) => {
                const lb = document.getElementById('lightbox');
                if (!lb.classList.contains('open')) return;
                if (e.key === 'ArrowRight') changeImage(1);
                if (e.key === 'ArrowLeft') changeImage(-1);
                if (e.key === 'Escape') closeLightbox();
            });
        </script>
    @endpush

@endsection
