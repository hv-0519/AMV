@extends('layouts.app')
@section('title', 'Careers')

@push('styles')
<style>
    .about-hero {
        background: linear-gradient(135deg, #1A0A00, #3D1A00);
        padding: 5rem 2rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .about-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 50% 50%, rgba(255,107,0,0.12), transparent 70%);
    }
    .about-hero h1 {
        font-family: 'Playfair Display', serif;
        font-size: clamp(2.5rem, 5vw, 4rem);
        font-weight: 900;
        color: #fff;
        position: relative;
        z-index: 1;
    }
    .about-hero h1 span { color: var(--saffron); }
    .about-hero p { color: #ccc; font-size: 1.1rem; margin-top: 1rem; position: relative; z-index: 1; max-width: 600px; margin-left: auto; margin-right: auto; }

    section { padding: 5rem 2rem; }
    .section-inner { max-width: 1200px; margin: 0 auto; text-align: center; }
</style>
@endpush

@section('content')

<div class="about-hero">
    <h1>Join Our <span>Team</span></h1>
    <p>Become a part of the AMV family and help us bring authentic flavors to the world.</p>
</div>

<section style="background:#fff;">
    <div class="section-inner">
        <h2>We are always looking for passionate people!</h2>
        <p style="margin-top: 1rem; color: #555; font-size: 1.1rem; line-height: 1.6;">
            Currently, we do not have any specific open positions, but we'd love to hear from you.<br>
            Please send your resume to <a href="mailto:careers@AMVAmdavadi.com" style="color: var(--saffron); text-decoration: none; font-weight: bold;">careers@AMVAmdavadi.com</a> and we will get in touch when an opportunity arises.
        </p>
    </div>
</section>

@endsection
