@extends('layouts.admin')

@section('title', __('lang.sms'))

@section('content_header')
    <h1>@lang('lang.messages')</h1>
@stop

@section('main_content')
    {{-- @can('messages.create')
        <a class="btn btn-primary btn-flat mb-3" href="{{ action('Admin\MessageController@create') }}"><i
                class="fas fa-paper-plane"></i>
            @lang('lang.send_message')</a>
    @endcan --}}
    <x-adminlte-card title="{{ __('lang.messages') }}" theme="{{ config('adminlte.right_sidebar_theme') }}"
        theme-mode="outline" icon="fas fa-file">

        <div class="table-responsive">
            <table id="messages_table" class="table" style="width: 100%;">
                <thead>
                    <tr>
                        <th>@lang('lang.date_and_time')</th>
                        <th>@lang('lang.email')</th>
                        <th>@lang('lang.subject')</th>
                        <th class="notexport">@lang('lang.action')</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
                <tfoot>
                </tfoot>
            </table>
        </div>
    </x-adminlte-card>

@stop
@section('javascript')
    <script>
        $(document).ready(function() {
            messages_table = $('#messages_table').DataTable({
                lengthChange: true,
                paging: true,
                info: false,
                bAutoWidth: false,
                order: [],
                language: {
                    url: dt_lang_url,
                },
                lengthMenu: [
                    [10, 25, 50, 75, 100, 200, 500, -1],
                    [10, 25, 50, 75, 100, 200, 500, "All"],
                ],
                dom: "lBfrtip",
                buttons: buttons,
                processing: true,
                serverSide: true,
                aaSorting: [
                    [2, 'asc']
                ],
                "ajax": {
                    "url": "/admin/messages",
                    "data": function(d) {}
                },
                columnDefs: [{
                    "targets": [3],
                    "orderable": true,
                    "searchable": false
                }],
                columns: [
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'emails',
                        name: 'emails'
                    },
                    {
                        data: 'subject',
                        name: 'subject'
                    },

                    {
                        data: 'action',
                        name: 'action'
                    },

                ],
                createdRow: function(row, data, dataIndex) {

                },
                fnDrawCallback: function(oSettings) {
                    var intVal = function(i) {
                        return typeof i === "string" ?
                            i.replace(/[\$,]/g, "") * 1 :
                            typeof i === "number" ?
                            i :
                            0;
                    };

                    this.api()
                        .columns(".sum", {
                            page: "current"
                        })
                        .every(function() {
                            var column = this;
                            if (column.data().count()) {
                                var sum = column.data().reduce(function(a, b) {
                                    a = intVal(a);
                                    if (isNaN(a)) {
                                        a = 0;
                                    }

                                    b = intVal(b);
                                    if (isNaN(b)) {
                                        b = 0;
                                    }

                                    return a + b;
                                });
                                $(column.footer()).html(
                                    __currency_trans_from_en(sum, false)
                                );
                            }
                        });
                },
            });

        });
    </script>
@endsection
