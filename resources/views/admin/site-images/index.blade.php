@extends('layouts.admin')
@section('title', 'Website Images')

@section('content')
<div class="data-card-header" style="margin-bottom:1.5rem;">
    <div>
        <h2 style="font-size:1.3rem; font-weight:700; color:var(--dark);">🖼️ Website Images</h2>
        <p style="color:#888; font-size:0.88rem; margin-top:0.3rem;">Upload images to customise key sections of the website. If no image is set, the emoji fallback will show instead.</p>
    </div>
</div>

<div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(280px, 1fr)); gap:1.5rem;">
    @foreach($images as $img)
    <div class="data-card" style="padding:1.5rem;">
        <p style="font-size:0.7rem; color:var(--saffron); font-weight:700; text-transform:uppercase; letter-spacing:1px; margin-bottom:0.5rem;">{{ $img->key }}</p>
        <h3 style="font-size:1rem; font-weight:700; color:var(--dark); margin-bottom:1rem;">{{ $img->label }}</h3>

        <!-- Current image preview -->
        <div style="background:#f5f0ea; border-radius:12px; height:160px; display:flex; align-items:center; justify-content:center; margin-bottom:1rem; overflow:hidden;">
            @if($img->image)
                <img src="{{ asset('storage/' . $img->image) }}" alt="{{ $img->label }}"
                     style="max-height:160px; max-width:100%; object-fit:contain; border-radius:8px;">
            @else
                <div style="text-align:center; color:#bbb;">
                    <i class="fas fa-image" style="font-size:2.5rem; display:block; margin-bottom:0.4rem;"></i>
                    <span style="font-size:0.8rem;">No image uploaded</span>
                </div>
            @endif
        </div>

        <!-- Upload form -->
        <form method="POST" action="{{ route('admin.site-images.update', $img->id) }}" enctype="multipart/form-data" class="js-crud-ajax" data-loading="Updating website image..." data-success="Image updated successfully.">
            @csrf
            <div style="display:flex; gap:0.5rem; flex-wrap:wrap; align-items:center;">
                <label style="flex:1; min-width:0;">
                    <input type="file" name="image" accept="image/*" required
                           style="width:100%; font-size:0.8rem; border:1.5px solid #ddd; border-radius:8px; padding:0.4rem 0.6rem; cursor:pointer;"
                           onchange="document.getElementById('save-{{ $img->id }}').style.display='inline-flex'">
                </label>
                <button type="submit" id="save-{{ $img->id }}" class="btn btn-primary btn-sm"
                        style="display:none; white-space:nowrap;">
                    <i class="fas fa-upload"></i> Save
                </button>
            </div>
        </form>

        @if($img->image)
        <!-- Remove button -->
        <form method="POST" action="{{ route('admin.site-images.destroy', $img->id) }}" style="margin-top:0.6rem;" class="js-crud-delete" data-confirm="Remove this image?" data-success="Image removed successfully.">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-sm" style="background:transparent; border:1.5px solid #ddd; color:#aaa; width:100%;"
                    >
                <i class="fas fa-trash"></i> Remove Image
            </button>
        </form>
        @endif
    </div>
    @endforeach
</div>

<hr style="margin:3rem 0; border:0; border-top:1px solid #dee2e6;">

<div class="data-card-header" style="margin-bottom:1.5rem; display:flex; justify-content:space-between; align-items:flex-end;">
    <div>
        <h2 style="font-size:1.3rem; font-weight:700; color:var(--dark);">📸 Gallery Images</h2>
        <p style="color:#888; font-size:0.88rem; margin-top:0.3rem;">Upload multiple images at once to display on the Gallery page. Images will be displayed in a varied masonry grid layout.</p>
    </div>
    <form method="POST" action="{{ route('admin.site-images.gallery.upload') }}" enctype="multipart/form-data" style="display:flex; gap:0.5rem; align-items:center;" class="js-crud-ajax" data-loading="Uploading gallery images..." data-success="Gallery images uploaded.">
        @csrf
        <input type="file" name="images[]" accept="image/*" multiple required
               style="font-size:0.8rem; border:1.5px solid #ddd; border-radius:8px; padding:0.4rem 0.6rem; cursor:pointer;"
               onchange="document.getElementById('save-gallery').style.display='inline-flex'">
        <button type="submit" id="save-gallery" class="btn btn-primary btn-sm"
                style="display:none; white-space:nowrap;">
            <i class="fas fa-upload"></i> Upload Selection
        </button>
    </form>
</div>

<div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(200px, 1fr)); gap:1.5rem;">
    @forelse($galleryImages as $gImg)
    <div class="data-card" style="padding:1rem; text-align:center;">
        <div style="background:#f5f0ea; border-radius:12px; height:140px; display:flex; align-items:center; justify-content:center; margin-bottom:1rem; overflow:hidden;">
            <img src="{{ asset('storage/' . $gImg->image) }}" alt="Gallery Image {{ $gImg->id }}"
                 style="max-height:140px; max-width:100%; object-fit:contain; border-radius:8px;">
        </div>
        <form method="POST" action="{{ route('admin.site-images.gallery.destroy', $gImg->id) }}" class="js-crud-delete" data-confirm="Remove this gallery image?" data-success="Gallery image removed.">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-sm" style="background:transparent; border:1.5px solid #ddd; color:#aaa; width:100%;"
                    >
                <i class="fas fa-trash"></i> Remove
            </button>
        </form>
    </div>
    @empty
    <div style="grid-column: 1 / -1; padding:3rem; text-align:center; background:#f5f0ea; border-radius:16px; color:#999;">
        <i class="fas fa-images" style="font-size:3rem; margin-bottom:1rem; opacity:0.5;"></i>
        <p>No gallery images uploaded yet.<br>Select multiple files and hit upload to build your gallery.</p>
    </div>
    @endforelse
</div>
@push('scripts')
<script>
// Auto-show save button when a file is selected (fallback for any input missed)
document.querySelectorAll('input[type=file]').forEach(function(input) {
    input.addEventListener('change', function() {
        var btn = this.closest('form').querySelector('button[type=submit]');
        if (btn) { btn.style.display = 'inline-flex'; }
    });
});
</script>
@endpush
@endsection
