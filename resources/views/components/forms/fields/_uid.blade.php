<label class="block">
    <span class="text-gray-700 text-sm font-semibold">Unique Identification Code</span>

    <div class="relative">
        <input type="text" name="uid" id="uid" class="form-input mt-1 block w-full @error('uid') placeholder-red-500 border-red-300 bg-red-100 @enderror" placeholder="WA52M" value="{{ old('uid') ?? ($uid ?? null) }}">

        <div class="absolute dropdown top-0 right-0 bottom-0 flex items-center px-3">
            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <x-heroicon-o-question-mark-circle class="w-4 h-4 text-blue-500"/>
            </a>

            <div class="dropdown-menu dropdown-menu-right p-4 rounded-lg shadow-lg" style="max-width: 200px;">
                <p class="text-xs text-gray-700">
                    Unique Identification Codes are used to index and track spaces. Each space is required to have a Unique Identification Code. You can either provide an Unique Identification Code of your own or you can leave it blank for the system to generate one for you.
                </p>
            </div>
        </div>
    </div>
</label>

<div class="mt-1">
    <span class="text-sm text-gray-500">Leave blank to automatically generate UID.</span>
</div>

@error('uid')
    <div class="mt-1" role="alert">
        <span class="text-xs text-red-500 font-semibold">{{ $message }}</span>
    </div>
@enderror
