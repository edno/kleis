@extends('layouts.app')

@section('content')

@if (session('status') || session('results'))
    <div class="alert alert-success alert-dismissable">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        {{ session('status') }}{{ session('results') }}
    </div>
    <script type="text/javascript" language="javascript">
        document.addEventListener("DOMContentLoaded", function(event) {
            $(".alert-dismissable").fadeTo(2000, 500).slideUp(500, function(){
                $(".alert-dismissable").alert('close');
            });
        });
    </script>
@endif

    <!-- Add/Edit Category -->
    <div class="panel panel-default">
        <div class="panel-body">
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/categories') }}">
                {{ csrf_field() }}
                <div class="col-lg-12">
                    <div class="input-group">
                        <input type="text" class="form-control" name="name" id="categoryname" placeholder="Nom de la cat&eacute;gorie">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-default hidden" type="button" id="button-save">
                                <i class="fa fa-save"></i> Enregister
                            </button>
                            <a href="#" class="btn btn-default hidden" type="button" id="button-cancel">
                                <i class="fa fa-undo"></i> Annuler
                            </a>
                            <button type="submit" class="btn btn-default" type="button" id="button-add">
                                <i class="fa fa-plus"></i> Ajouter
                            </button>
                        </span>
                    </div>
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
                <input type="hidden" name="id" id="categoryid" value="">
            </form>
        </div>
    </div>

    <!-- Current Categories -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title pull-left">
                Cat&eacute;gories
            </div>
            <div class="panel-title pull-right">
                <form class="form-inline pull-right" role="form">
                    <div class="input-category">
                        <input id="search-type" type="hidden" name="type" value="category">
                        <span class="search-box{{ session('results') ? '' : ' hidden' }}">
                            <input id="search" class="form-control" name="search" value="{{ session('search') }}" placeholder="Jokers * et %">
                        </span>
                        <div id="search-button" class="search-button{{ session('results') ? ' input-category-btn' : '' }}">
                            <a href="#" class="btn btn-default has-tooltip"
                                data-toggle="tooltip"
                                data-placement="bottom"
                                title="Rechercher"
                                role="button">
                                <i class="fa fa-search"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="clearfix"></div>
        </div>
        <script type="text/javascript" language="javascript">
            document.addEventListener("DOMContentLoaded", function() {
                $("#search-button").click(function() {
                    if ($(this).hasClass('input-group-btn')) {
                        $(this).parents('form:first').submit();
                    } else {
                        $(this).addClass('input-group-btn');
                        $(".search-box").removeClass('hidden');
                        $("#search").focus();
                    }
                });
                $(".search-option").click(function() {
                    $("#search-option").text($(this).text());
                    $("#search-type").val($(this).attr('value'));
                });
            });
        </script>

        <div class="panel-body">
            @if (count($categories) > 0)
                <table class="table table table-hover categories-table">

                    <!-- Table Headings -->
                    <thead>
                        <th>Cat&eacute;gorie</th>
                        <th>Comptes actifs</th>
                        <th>Comptes inactifs</th>
                        <th>Validit&eacute;</th>
                        <th>&nbsp;</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td class="table-text col-xs-3">
                                    <div id="category{{ $category->id }}">{{ $category->name }}</div>
                                </td>
                                <td class="table-text">
                                    <div><span class="badge">{{ $category->countAccounts(1) }}</span></div>
                                </td>
                                <td class="table-text">
                                    <div><span class="badge">{{ $category->countAccounts(0) }}</span></div>
                                </td>
                                <td class="table-text">
                                    <div><span class="badge">{{ $category->maxValidity }} jours</span></div>
                                </td>
                                <td class="align-right col-xs-3">
                                    <div class="btn-toolbar">
                                        <div class="btn-category">
                                            <a href="#" class="btn btn-default has-tooltip edit-category"
                                                data-toggle="tooltip"
                                                data-placement="bottom"
                                                title="Editer"
                                                id="edit{{ $category->id }}"><i class="fa fa-pencil"></i></a>
                                            @if ($category->countAccounts() > 0)
                                            <a href="/accounts/category/{{ $category->id }}"
                                                class="btn btn-default has-tooltip"
                                                data-toggle="tooltip"
                                                data-placement="bottom"
                                                title="Afficher tous les comptes"><i class="fa fa-list-alt"></i></a>
                                            @else
                                                <a href="#" class="btn btn-default disabled" disabled="true"><i class="fa fa-list-alt"></i></a>
                                            @endif
                                            @if ($category->countAccounts(1) > 0)
                                                <a href="/category/{{ $category->id }}/disable"
                                                    class="btn btn-default has-tooltip"
                                                    data-toggle="tooltip"
                                                    data-placement="bottom"
                                                    title="Désactiver tous les comptes"><i class="fa fa-ban"></i></a>
                                            @else
                                                <a href="#" class="btn btn-default disabled" disabled="true"><i class="fa fa-ban"></i></a>
                                            @endif
                                            @if ($category->countAccounts(0) > 0)
                                                <a href="/category/{{ $category->id }}/purge"
                                                    class="btn btn-default has-tooltip"
                                                    data-toggle="tooltip"
                                                    data-placement="bottom"
                                                    title="Supprimer tous les comptes désactivés"><i class="fa fa-recycle"></i></a>
                                            @else
                                                <a href="#" class="btn btn-default disabled" disabled="true"><i class="fa fa-recycle"></i></a>
                                            @endif
                                            @if ($category->countAccounts() > 0)
                                                <a href="#" class="btn btn-default disabled" disabled="true"><i class="fa fa-trash"></i></a>
                                            @else
                                                <a href="/category/{{ $category->id }}/delete"
                                                    class="btn btn-default has-tooltip"
                                                    data-toggle="tooltip"
                                                    data-placement="bottom"
                                                    title="Supprimer"><i class="fa fa-trash"></i></a>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                Aucune cat&eacute;gorie.
            @endif
        </div>
    </div>

    <div class="text-center">
        {{ $categories->links() }}
    </div>

    <script type="text/javascript" language="javascript">
        document.addEventListener("DOMContentLoaded", function(event) {
            $('.edit-category').click(function () {
                var categoryid = $(this).attr('id').substr(4);
                var categoryname = document.getElementById( 'category' + categoryid ).innerText;
                $('#categoryid').val(categoryid);
                $('#categoryname').val(categoryname);
                $('#button-cancel').removeClass('hidden');
                $('#button-save').removeClass('hidden');
                $('#button-add').addClass('hidden');
                $("#categoryname").focus();
            });
            $('#button-cancel').click(function () {
                $('#categoryid').val('');
                $('#categoryname').val('');
                $('#button-cancel').addClass('hidden');
                $('#button-save').addClass('hidden');
                $('#button-add').removeClass('hidden');
            });
            $('.has-tooltip').tooltip();
        });
    </script>

{{ session()->forget(['results', 'search', 'type']) }}

@endsection
