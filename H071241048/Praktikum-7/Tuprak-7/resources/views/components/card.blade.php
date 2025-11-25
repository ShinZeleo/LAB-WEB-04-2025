<div class="bg-white rounded-xl shadow-lg overflow-hidden h-full flex flex-col transition-all duration-300 hover:shadow-xl hover:-translate-y-2">
    @if(isset($image))
        <img src="{{ $image }}" class="w-full h-60 object-cover" alt="{{ $title ?? '' }}">
    @endif
    <div class="p-6 grow">
        <h5 class="text-xl font-bold mb-3">{{ $title ?? '' }}</h5>
        <p class="text-gray-600">{{ $description ?? '' }}</p>
    </div>
</div>