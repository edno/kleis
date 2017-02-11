@if ($enable)
<div class="content">
    <a data-toggle="modal" data-target="#legal" href="#legal">@lang('auth.legal')</a>
</div>

<!-- Modal -->
<div id="legal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{ $title }}</h4>
            </div>
            <div class="modal-body text-justify">
                {!! $contents !!}
            </div>
        </div>

    </div>
</div>
@endif
