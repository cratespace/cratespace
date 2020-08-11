<div>
    <span class="text-gray-700 text-sm font-semibold">Ships to destination</span>

    <div class="mt-2">
        @foreach (config('defaults.spaces.types') as $type)
            <label class="inline-flex items-center mr-3">
                <input type="radio" class="form-radio h-4 w-4" name="type" id="type" value="{{ $type }}"
                {{ $type == ($editableType ?? 'Local') ? 'checked' : '' }}>
                <span class="ml-2">{{ $type }}</span>
            </label>
        @endforeach
    </div>
</div>

@error('type')
    <div class="mt-1" role="alert">
        <span class="text-xs text-red-500 font-semibold">{{ $message }}</span>
    </div>
@enderror
