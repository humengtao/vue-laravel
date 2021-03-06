<div class="container sidenav-container"
     @if(Auth::check())
     data-src="{{ Auth::user()->background_url }}"
     @else
     data-src="{{ elixir('images/bg12.jpg') }}"
        @endif
>
    <div class="floating" style="position: absolute;width: 100%;height: 100%;background-color: rgba(0,0,0,0.1)"></div>
    <span class="btn btn-link btn-lg glyphicon glyphicon-menu-hamburger toggle"></span>
    <div class="sidenav-info text-center">
        @if(Auth::check())
            <a href="/setting"><img src="{{ Auth::user()->avatar_url }}"></a>
            <h1>{{ Auth::user()->name }}</h1>
            <h4 style="font-family: 'Playfair Display', serif">
                {{ Auth::user()->description }}
            </h4>
        @else
            <h2>论塘</h2>
            <h4>交流·分享·进步</h4>
            <h4>一个可以让你畅所欲言的地方</h4>
        @endif
        <a href="/add-article" class="btn btn-lg btn-success" target="_blank">写点东西 <span class="glyphicon glyphicon-pencil"></span></a>
    </div>
</div>
