<div class="sidebar">
    <a href="{{ route('home') }}" class="{{ request()->routeIs('home', 'articles.filter') ? 'active' : '' }}">Home</a>
    <a href="{{ route('articles.create') }}" {{ request()->routeIs('articles.create') ? 'class=active' : '' }}>Add Article</a>
    <a href="{{ route('my.articles') }}" {{ request()->routeIs('my.articles') ? 'class=active' : '' }}>My Published Articles</a>
    <a href="{{ route('draft.articles') }}" {{ request()->routeIs('draft.articles') ? 'class=active' : '' }}>Drafts</a>
    <a href="{{ route('profile.show', Auth::user()->id) }}" {{ request()->routeIs('profile.show') ? 'class=active' : '' }}>My Profile</a>
    <a href=#>About</a>
    <a href=#>Contact</a>
</div>
