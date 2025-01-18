<form action="{{ route('movies.store') }}" method="POST">
    @csrf
    <div>
        <label for="name">Movie Name:</label>
        <input type="text" id="name" name="name" value="{{ old('name') }}" required>
        @error('name')
            <div>{{ $message }}</div>
        @enderror
    </div>
    <div>
        <label for="director">Director:</label>
        <input type="text" id="director" name="director" value="{{ old('director') }}" required>
        @error('director')
            <div>{{ $message }}</div>
        @enderror
    </div>
    <div>
        <label for="poster">Poster URL:</label>
        <input type="url" id="poster" name="poster" value="{{ old('poster') }}" required>
        @error('poster')
            <div>{{ $message }}</div>
        @enderror
    </div>
    <div>
        <label for="price">Price:</label>
        <input type="number" id="price" name="price" value="{{ old('price') }}" step="0.01" min="0" required>
        @error('price')
            <div>{{ $message }}</div>
        @enderror
    </div>
    <button type="submit">Add Movie</button>
</form>
