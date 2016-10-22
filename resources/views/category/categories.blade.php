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
                        <span class="input-group-btn">
                            <button
                                class="btn btn-default has-tooltip"
                                id="iconpicker"
                                name="icon"
                                data-iconset="fontawesome"
                                data-icon="fa-question"
                                role="iconpicker"
                                data-toggle="tooltip"
                                data-placement="bottom"
                                title="@lang('categories.tooltip.icon')"></button>
                        </span>
                        <input type="text" class="form-control" name="name" id="categoryname" placeholder="@lang('categories.tooltip.category')">
                        <span class="input-group-btn">
                            <button
                                type="button"
                                class="btn btn-default dropdown-toggle"
                                data-toggle="dropdown"
                                data-placement="bottom"
                                aria-haspopup="true"
                                aria-expanded="false">
                              <span id="validity-option">{{ trans_choice('categories.days', 90, ['number' => 90]) }}</span>&nbsp;<span class="caret"></span>
                            </button>
                            <div class="dropdown-menu">
                                <div class="row">
                                    <div class="input-group col-lg-8 col-lg-offset-2">
                                    <input
                                        name="validity"
                                        id="categoryvalidity"
                                        type="number"
                                        class="form-control has-tooltip"
                                        data-placement="bottom"
                                        title="@lang('categories.validity')"
                                        value="90"/>
                                    <span class="input-group-addon">{{ trans_choice('categories.days', 90, ['number' => '']) }}</span>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-default hidden" type="button" id="button-save">
                                <i class="fa fa-save"></i> @lang('categories.actions.save')
                            </button>
                            <a href="#" class="btn btn-default hidden" type="button" id="button-cancel">
                                <i class="fa fa-undo"></i> @lang('categories.actions.cancel')
                            </a>
                            <button type="submit" class="btn btn-default" type="button" id="button-add">
                                <i class="fa fa-plus"></i> @lang('categories.actions.add')
                            </button>
                        </span>
                    </div>
                    @if ($errors)
                        <span class="help-block">
                            <strong>{{ $errors->first() }}</strong>
                        </span>
                    @endif
                </div>
                <input type="hidden" name="id" id="categoryid" value="">
            </form>
        </div>
    </div>
    <script type="text/javascript" language="javascript">
        document.addEventListener("DOMContentLoaded", function() {
            $('#iconpicker').iconpicker({iconset: 'fontawesome'});
            $('#categoryvalidity').change(function() {
                $("#validity-option ").text($(this).val() + ' {{ trans_choice("categories.days", 90, ["number" => 90]) }}');
            });
        });
    </script>

    <!-- Current Categories -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title pull-left">
                {{ trans_choice('categories.categories', 2) }}
            </div>
            <div class="panel-title pull-right">
                <form class="form-inline pull-right" role="form">
                    <div class="input-group">
                        <input id="search-type" type="hidden" name="type" value="category">
                        <span class="search-box{{ session('results') ? '' : ' hidden' }}">
                            <input id="search" class="form-control" name="search" value="{{ session('search') }}" placeholder="@lang('categories.tooltip.search')">
                        </span>
                        <div id="search-button" class="search-button{{ session('results') ? ' input-group-btn' : '' }}">
                            <a href="#" class="btn btn-default has-tooltip"
                                data-toggle="tooltip"
                                data-placement="bottom"
                                title="@lang('categories.actions.search')"
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
                        <th>&nbsp;</th>
                        <th>{{ trans_choice('categories.categories', 1) }}</th>
                        <th>@lang('categories.accounts.enabled')</th>
                        <th>@lang('categories.accounts.disabled')</th>
                        <th>@lang('categories.validity')</th>
                        <th>&nbsp;</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td class="table-text">
                                    <div id="icon{{ $category->id }}"><i class="fa {{ $category->icon }}"></i></div>
                                </td>
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
                                    <div id="validity{{ $category->id }}"><span class="badge">{{ trans_choice('categories.days', $category->validity, ['number' => $category->validity]) }}</span></div>
                                </td>
                                <td class="align-right col-xs-3">
                                    <div class="btn-toolbar">
                                        <div class="btn-group">
                                            <a href="#" class="btn btn-default has-tooltip edit-category"
                                                data-toggle="tooltip"
                                                data-placement="bottom"
                                                title="@lang('categories.actions.edit')"
                                                id="edit{{ $category->id }}"><i class="fa fa-pencil"></i></a>
                                            @if ($category->countAccounts() > 0)
                                            <a href="/accounts/category/{{ $category->id }}"
                                                class="btn btn-default has-tooltip"
                                                data-toggle="tooltip"
                                                data-placement="bottom"
                                                title="@lang('categories.actions.display')"><i class="fa fa-list-alt"></i></a>
                                            @else
                                                <a href="#" class="btn btn-default disabled" disabled="true"><i class="fa fa-list-alt"></i></a>
                                            @endif
                                            @if ($category->countAccounts(1) > 0)
                                                <a href="/category/{{ $category->id }}/disable"
                                                    class="btn btn-default has-tooltip"
                                                    data-toggle="tooltip"
                                                    data-placement="bottom"
                                                    title="@lang('categories.actions.disable')"><i class="fa fa-ban"></i></a>
                                            @else
                                                <a href="#" class="btn btn-default disabled" disabled="true"><i class="fa fa-ban"></i></a>
                                            @endif
                                            @if ($category->countAccounts(0) > 0)
                                                <a href="/category/{{ $category->id }}/purge"
                                                    class="btn btn-default has-tooltip"
                                                    data-toggle="tooltip"
                                                    data-placement="bottom"
                                                    title="@lang('categories.actions.drop')"><i class="fa fa-recycle"></i></a>
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
                                                    title="@lang('categories.actions.delete')"><i class="fa fa-trash"></i></a>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                @lang('categories.message.empty')
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
                var categoryname = $('#category' + categoryid ).text();
                var validity = $('#validity' + categoryid ).text();
                var icon = $('#icon' + categoryid + ' i').attr('class').substr(3);
                console.log(icon);
                $('#categoryid').val(categoryid);
                $('#categoryname').val(categoryname);
                $('#categoryvalidity').val(parseInt(validity));
                $('#validity-option').text(validity);
                $('#iconpicker').iconpicker('setIcon', icon);
                $('#button-cancel').removeClass('hidden');
                $('#button-save').removeClass('hidden');
                $('#button-add').addClass('hidden');
                $("#categoryname").focus();
            });
            $('#button-cancel').click(function () {
                $('#categoryid').val('');
                $('#categoryname').val('');
                $('#categoryvalidity').val(90);
                $('#validity-option').text($('#categoryvalidity').val() + ' jours');
                $('#iconpicker').iconpicker('setIcon', 'fa-question');
                $('#button-cancel').addClass('hidden');
                $('#button-save').addClass('hidden');
                $('#button-add').removeClass('hidden');
            });
            $('.has-tooltip').tooltip();
        });
    </script>

{{ session()->forget(['results', 'search', 'type']) }}

@endsection
