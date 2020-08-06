<label for="price" class="block">
    <span class="text-gray-700 text-sm font-semibold">Price</span>

    <div class="mt-1 relative rounded-lg shadow-sm">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <span class="text-gray-500">$</span>
        </div>

        <input id="price" class="form-input block w-full pl-10 pr-12" placeholder="0.00" name="price" value="{{ old('price') ?? ($price ?? null) }}" />

        <div class="absolute inset-y-0 right-0 flex items-center">
            <select aria-label="Currency" readonly class="form-select h-full py-0 pl-2 pr-7 border-transparent bg-transparent text-gray-500 focus:outline-none focus:border-transparent focus:bg-transparent focus:shadow-none">
                <option selected>USD</option>
            </select>
        </div>
    </div>
</label>

@error('price')
    <div class="mt-1" role="alert">
        <span class="text-xs text-red-500 font-semibold">{{ $message }}</span>
    </div>
@enderror
