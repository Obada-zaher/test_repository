<form method="GET" action="{{ route('articles.filter') }}" class="mb-4">
    <div class="row">
        <div class="col-md-4">
            <input type="text" name="title" class="form-control" placeholder="Search by title" value="{{ request('title') }}">
        </div>
        <div class="col-md-4">
            <input type="text" name="body" class="form-control" placeholder="Search by body" value="{{ request('body') }}">
        </div>
        <div class="col-md-4">
            <select name="category_id" class="form-control">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12 d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
    </div>
