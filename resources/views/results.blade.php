<div class="row">
    <div class="col-12 my-2">
        @if (empty($data['error']) && Request::isMethod('post'))
            <table class="table table-dark table-bordered">
                <thead>
                <tr>
                    @foreach (array_keys($data['file_info']) as $name_property)
                        <th>{{ $name_property }}</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                <tr>
                    @foreach ($data['file_info'] as $property)
                        <td>{{ $property }}</td>
                    @endforeach
                </tr>
                </tbody>
            </table>
        @elseif (Request::isMethod('post'))
            <div class="alert alert-danger my-3">{{ $data['error'] }}</div>
        @endif
    </div>

    @if (!empty($data['items']))
        <div class="col my-2" id="results">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    @foreach ($data['keys'] as $key)
                        <th scope="col">{{ $key }}</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @foreach ($data['items'] as $key => $item)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ $item->year }}</td>
                        <td>{{ $item->industry_code }}</td>
                        <td>{{ $item->industry_name }}</td>
                        <td>{{ $item->rme_size_grp }}</td>
                        <td>{{ $item->variable }}</td>
                        <td>{{ $item->value }}</td>
                        <td>{{ $item->unit }}</td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="8" class="ajax_pager">
                        <div class="">
                            {{ $data['items']->links() }}
                        </div>
                        <div class="">
                            Total: {{ $data['items']->total() }}
                        </div>
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
    @endif
</div>
