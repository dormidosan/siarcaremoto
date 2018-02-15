
<div class="modal fade" id="@yield("idModal")" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog @yield("size")" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">@yield("EncabezadoModal") </h4>
            </div>
            <div class="modal-body">
                @yield("bodyModal")
            </div>
            <div class="modal-footer">
                @yield("footerModal")
            </div>
        </div>
    </div>
</div>