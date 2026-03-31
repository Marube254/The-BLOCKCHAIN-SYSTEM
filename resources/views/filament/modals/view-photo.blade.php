<div class="p-6 text-center">
    <img src="{{ $photoUrl }}" alt="{{ $candidate->display_name }}"
         class="mx-auto rounded-lg shadow-lg max-w-full h-auto" style="max-height: 400px;">
    <div class="mt-4">
        <h3 class="text-lg font-bold">{{ $candidate->display_name }}</h3>
        <p class="text-gray-600">{{ $candidate->sector }}</p>
    </div>
</div>