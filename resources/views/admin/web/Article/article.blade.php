@extends('admin.layout.dashboard')
@section('page_heading','Articles')
@section('section')
    <div class="col-md-12" id="list-article">
        <table class="table table-hover table-striped">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>Collection</th>
                <th>Date</th>
                <th></th>
            </tr>
            <tr>
                <th colspan="5">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="input-group">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-primary dropdown-toggle search-input-select"
                                            data-toggle="dropdown" onkeyup="search()"
                                            aria-haspopup="true" aria-expanded="false">ID
                                    </button>
                                    <ul class="dropdown-menu search-input">
                                        <li><a href="javascript:void(0)" data-key="id">ID</a></li>
                                        {{--<li><a href="javascript:void(0)" data-key="title">Title</a></li>--}}
                                        {{--<li><a href="javascript:void(0)">Author</a></li>--}}
                                        {{--<li><a href="javascript:void(0)" data-key="collection">Collection</a></li>--}}
                                    </ul>
                                </div>
                                <input type="text" class="form-control search-input" aria-label="..."
                                       placeholder="Search for ...">
                            </div>
                        </div>
                    </div>
                </th>
                <th></th>
            </tr>
            {{--@foreach($articles as $article)--}}
            {{--<tr>--}}
            {{--<td>{{ $article->id }}</td>--}}
            {{--<td><a href="/content/{{ $article->id }}" target="_blank">{{ $article->title }}</a></td>--}}
            {{--<td>{{ $article->user->name }}</td>--}}
            {{--<td>{{ $article->collection ? $article->collection : 'None' }}</td>--}}
            {{--<td>{{ $article->created_at }}</td>--}}
            {{--<td>--}}
            {{--<a href="categories/edit/{{ $article->id }}" class="btn btn-danger"><span--}}
            {{--class="glyphicon glyphicon-remove"></span> Remove</a>--}}
            {{--</td>--}}
            {{--</tr>--}}
            {{--@endforeach--}}
            <tr v-for="article in articles">
                <td>@{{ article.id }}</td>
                <td><a href="/content/@{{ article.id }}" target="_blank">@{{ article.title }}</a></td>
                <td>@{{ article.user_id}}</td>
                <td>@{{ article.collection@ ? article.collection : 'None' }}</td>
                <td>@{{ article.created_at }}</td>
                <td>
                    <a href="categories/edit/@{{ article.id }}" class="btn btn-danger"><span
                                class="glyphicon glyphicon-remove"></span> Remove</a>
                </td>
            </tr>
        </table>
        <nav aria-label="...">
            <ul class="pagination">
                <li>
                    <button title="@{{ previous }}" aria-label="Previous" class="api-btn"><span
                                aria-hidden="true">&laquo;</span></button>
                </li>
                <li>
                    <button title="@{{ next }}" aria-label="Next" class="api-btn"><span
                                aria-hidden="true">&raquo;</span></button>
                </li>
            </ul>
        </nav>
    </div>

    <div class="modal fade" id="reply-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <p id="reply-info" class="text-center"></p>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <script>
        var articleArr = [];

        var current = 1;
        var total;

        var articleList = new Vue({
            el: '#list-article',
            data: {
                articles: '',
                next: '',
                previous: ''
            },
            methods: {
                setData: function (data) {
                    this.articles = data;
                },
                setUrl: function (data) {
                    this.next = data.next_page_url;
                    this.previous = data.prev_page_url;
                    this.current = data.current_page;
                },
                getCurrentPage: function () {
                    return this.current;
                }
            }
        });

        $('.search-input').keyup(function () {
            var val = $(this).val();
            getArticle(val);

        });

        $('.api-btn').click(function () {
            getArticlePage($(this)[0].title)
        });
        var getArticle = function (url, val) {
            $.ajax(url, {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'get',
                data: {
                    key: 'id',
                    val: val
                },
                success: function (data) {
                    console.log(data);
                    articleList.setData(data);
                },
            });
        };
        var getArticlePage = function (url) {
            if (!!articleArr[url.split('=')[1]-1]) {
                articleList.setData(articleArr[url.split('=')[1]-1].data);
                articleList.setUrl(articleArr[url.split('=')[1]-1]);
            } else {
                if (!!url.split('=')[1]) {
                    $.ajax(url, {
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'get',
                        success: function (data) {
                            articleList.setData(data.data);
                            articleList.setUrl(data);
                            articleArr[data.current_page-1] = data;
                            total = data.last_page;
                            current = data.current_page;
                        }
                    });
                }
                else
                    return ;

            }
        };

        getArticlePage('/api/articles-page?page=1')
    </script>
@endsection